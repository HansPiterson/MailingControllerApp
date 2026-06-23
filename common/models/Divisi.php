<?php

declare(strict_types=1);

namespace common\models;

use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\db\Expression;

/**
 * Model untuk tabel `divisi`.
 *
 * @property int $id
 * @property string $kode_divisi
 * @property string $nama_divisi
 * @property bool $is_active
 * @property string|null $created_at
 * @property string|null $updated_at
 *
 * @property Users[] $users
 */
class Divisi extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName(): string
    {
        return '{{%divisi}}';
    }

    /**
     * {@inheritdoc}
     */
    public function behaviors(): array
    {
        return [
            [
                'class' => TimestampBehavior::class,
                'value' => new Expression('NOW()'),
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            [['kode_divisi', 'nama_divisi'], 'required'],
            [['kode_divisi'], 'string', 'max' => 20],
            [['nama_divisi'], 'string', 'max' => 100],
            [['kode_divisi'], 'unique'],
            [['is_active'], 'boolean'],
            [['is_active'], 'default', 'value' => true],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels(): array
    {
        return [
            'id' => 'ID',
            'kode_divisi' => 'Kode Divisi',
            'nama_divisi' => 'Nama Divisi',
            'is_active' => 'Aktif',
            'created_at' => 'Dibuat',
            'updated_at' => 'Diperbarui',
        ];
    }

    /**
     * Relasi ke user yang tergabung dalam divisi ini.
     */
    public function getUsers(): \yii\db\ActiveQuery
    {
        return $this->hasMany(Users::class, ['divisi_id' => 'id']);
    }
}
