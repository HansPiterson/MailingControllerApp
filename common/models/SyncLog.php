<?php

declare(strict_types=1);

namespace common\models;

use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * Model untuk tabel `sync_log`.
 *
 * @property int $id
 * @property int $user_id
 * @property string $device_id
 * @property string $sync_type
 * @property int $records_count
 * @property string $status
 * @property string|null $error_message
 * @property string $synced_at
 *
 * @property User $user
 */
class SyncLog extends ActiveRecord
{
    /** Sinkronisasi dari device ke server (upload). */
    public const TYPE_PUSH = 'push';
    /** Sinkronisasi dari server ke device (download). */
    public const TYPE_PULL = 'pull';

    public const STATUS_SUCCESS = 'success';
    public const STATUS_FAILED = 'failed';
    public const STATUS_PARTIAL = 'partial';

    /**
     * {@inheritdoc}
     */
    public static function tableName(): string
    {
        return '{{%sync_log}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            [['user_id', 'device_id', 'sync_type', 'status', 'synced_at'], 'required'],
            [['user_id', 'records_count'], 'integer'],
            [['records_count'], 'default', 'value' => 0],
            [['device_id'], 'string', 'max' => 100],
            [['sync_type'], 'in', 'range' => [self::TYPE_PUSH, self::TYPE_PULL]],
            [['status'], 'in', 'range' => [self::STATUS_SUCCESS, self::STATUS_FAILED, self::STATUS_PARTIAL]],
            [['error_message'], 'string'],
            [['synced_at'], 'datetime', 'format' => 'php:Y-m-d H:i:s'],
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

    /**
     * Catat satu peristiwa sinkronisasi.
     *
     * @return bool berhasil disimpan atau tidak
     */
    public static function record(
        int $userId,
        string $deviceId,
        string $syncType,
        int $recordsCount,
        string $status,
        ?string $errorMessage = null
    ): bool {
        $log = new self();
        $log->user_id = $userId;
        $log->device_id = $deviceId;
        $log->sync_type = $syncType;
        $log->records_count = $recordsCount;
        $log->status = $status;
        $log->error_message = $errorMessage;
        $log->synced_at = date('Y-m-d H:i:s');

        return $log->save(false);
    }
}
