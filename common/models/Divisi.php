<?php

declare(strict_types=1);

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\db\Expression;

/**
 * This is the model class for table "divisi".
 *
 * @property int $id
 * @property string $kode_divisi
 * @property string $nama_divisi
 * @property bool $is_active
 * @property string|null $created_at
 * @property string|null $updated_at
 */
class Divisi extends ActiveRecord
{
    public static function tableName(): string
    {
        return '{{%divisi}}';
    }

    public function behaviors(): array
    {
        return [
            [
                'class' => TimestampBehavior::class,
                // Menggunakan Expression('NOW()') agar cocok dengan tipe data dateTime di PostgreSQL
                'value' => new Expression('NOW()'),
            ],
        ];
    }

    public function rules(): array
    {
        return [
            [['kode_divisi', 'nama_divisi'], 'required'],
            [['is_active'], 'boolean'],
            [['created_at', 'updated_at'], 'safe'],
            [['kode_divisi'], 'string', 'max' => 20],
            [['nama_divisi'], 'string', 'max' => 100],
            [['kode_divisi'], 'unique'],
        ];
    }

    public function attributeLabels(): array
    {
        return [
            'id' => 'ID',
            'kode_divisi' => 'Kode Divisi',
            'nama_divisi' => 'Nama Divisi',
            'is_active' => 'Aktif',
            'created_at' => 'Dibuat Pada',
            'updated_at' => 'Diperbarui Pada',
        ];
    }
}
