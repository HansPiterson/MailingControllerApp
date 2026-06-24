<?php

namespace common\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "sync_log".
 *
 * @property int $id
 * @property int $user_id
 * @property string|null $device_id
 * @property string $sync_type
 * @property int $records_count
 * @property string $status
 * @property string|null $error_message
 * @property string|null $synced_at
 *
 * @property User $user
 */
class SyncLog extends ActiveRecord
{
    public static function tableName()
    {
        return '{{%sync_log}}';
    }

    public function rules()
    {
        return [
            [['user_id', 'sync_type', 'records_count', 'status'], 'required'],
            [['user_id', 'records_count'], 'integer'],
            [['sync_type', 'status', 'error_message'], 'string'],
            [['synced_at'], 'safe'],
        ];
    }

    public function getUser()
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }
}
