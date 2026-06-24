<?php

namespace common\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "refresh_tokens".
 *
 * @property int $id
 * @property int $user_id
 * @property string $token
 * @property string|null $device_id
 * @property string $expires_at
 * @property string|null $created_at
 *
 * @property User $user
 */
class RefreshToken extends ActiveRecord
{
    public static function tableName()
    {
        return '{{%refresh_tokens}}';
    }

    public function rules()
    {
        return [
            [['user_id', 'token', 'expires_at'], 'required'],
            [['user_id'], 'integer'],
            [['expires_at', 'created_at'], 'safe'],
            [['token', 'device_id'], 'string', 'max' => 255],
            [['token'], 'unique'],
        ];
    }

    public function getUser()
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }
}
