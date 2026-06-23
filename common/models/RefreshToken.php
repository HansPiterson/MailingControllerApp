<?php

declare(strict_types=1);

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;
use yii\db\Expression;

/**
 * Model untuk tabel `refresh_tokens`.
 *
 * @property int $id
 * @property int $user_id
 * @property string $token
 * @property string $device_id
 * @property string $expires_at
 * @property string|null $created_at
 *
 * @property User $user
 */
class RefreshToken extends ActiveRecord
{
    public static function tableName(): string
    {
        return '{{%refresh_tokens}}';
    }

    public function behaviors(): array
    {
        return [
            [
                'class' => TimestampBehavior::class,
                'updatedAtAttribute' => false,
                'value' => new Expression('NOW()'),
            ],
        ];
    }

    public function rules(): array
    {
        return [
            [['user_id', 'token', 'device_id', 'expires_at'], 'required'],
            [['user_id'], 'integer'],
            [['token'], 'string', 'max' => 255],
            [['device_id'], 'string', 'max' => 100],
            [['token'], 'unique'],
            [['expires_at'], 'datetime', 'format' => 'php:Y-m-d H:i:s'],
            [
                ['user_id'],
                'exist',
                'skipOnError' => true,
                'targetClass' => User::class,
                'targetAttribute' => ['user_id' => 'id'],
            ],
        ];
    }

    public function getUser(): ActiveQuery
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }

    public function isExpired(): bool
    {
        return strtotime($this->expires_at) < time();
    }

    public static function issue(int $userId, string $deviceId, int $ttlSeconds): self
    {
        static::deleteAll(['user_id' => $userId, 'device_id' => $deviceId]);

        $model = new self();
        $model->user_id = $userId;
        $model->device_id = $deviceId;
        $model->token = Yii::$app->security->generateRandomString(64);
        $model->expires_at = date('Y-m-d H:i:s', time() + $ttlSeconds);
        $model->save(false);

        return $model;
    }
}
