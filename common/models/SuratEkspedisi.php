<?php

declare(strict_types=1);

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\db\Expression;

/**
 * Model untuk tabel "surat_ekspedisi".
 *
 * @property int $id
 * @property string $uuid
 * @property string|null $nomor_surat
 * @property int $divisi_pengirim_id
 * @property int $divisi_tujuan_id
 * @property string|null $nama_tujuan_orang
 * @property string $tanggal_surat
 * @property string $perihal
 * @property string|null $nama_penerima
 * @property string|null $tanggal_penerimaan
 * @property string|null $foto_bukti
 * @property string|null $foto_bukti_original
 * @property string|null $foto_latitude
 * @property string|null $foto_longitude
 * @property string|null $foto_alamat
 * @property string|null $foto_hash
 * @property string $status
 * @property int $created_by
 * @property int|null $updated_by
 * @property string|null $created_at
 * @property string|null $updated_at
 */
class SuratEkspedisi extends ActiveRecord
{
    public const STATUS_DRAFT = 'draft';
    public const STATUS_TERKIRIM = 'terkirim';
    public const STATUS_DITERIMA = 'diterima';
    public const STATUS_BATAL = 'batal';
    public const STATUS_PERLU_DIULAS = 'perlu_diulas';

    public static function tableName(): string
    {
        return '{{%surat_ekspedisi}}';
    }

    public function behaviors(): array
    {
        return [
            [
                'class' => TimestampBehavior::class,
                'value' => new Expression('NOW()'),
            ],
        ];
    }

    public static function statuses(): array
    {
        return [
            self::STATUS_DRAFT,
            self::STATUS_TERKIRIM,
            self::STATUS_DITERIMA,
            self::STATUS_BATAL,
            self::STATUS_PERLU_DIULAS,
        ];
    }

    public function rules(): array
    {
        return [
            [['uuid', 'divisi_pengirim_id', 'divisi_tujuan_id', 'tanggal_surat', 'perihal'], 'required'],
            [['divisi_pengirim_id', 'divisi_tujuan_id', 'created_by', 'updated_by'], 'integer'],
            [['perihal'], 'string'],
            [['tanggal_surat'], 'date', 'format' => 'php:Y-m-d'],
            [['tanggal_penerimaan'], 'datetime', 'format' => 'php:Y-m-d H:i:s'],
            [['uuid'], 'string', 'max' => 36],
            [['nomor_surat', 'nama_tujuan_orang', 'nama_penerima', 'foto_bukti', 'foto_bukti_original', 'foto_alamat'], 'string', 'max' => 255],
            [['status'], 'in', 'range' => self::statuses()],
            [['status'], 'default', 'value' => self::STATUS_DRAFT],
        ];
    }

    public function attributeLabels(): array
    {
        return [
            'id' => 'ID',
            'uuid' => 'UUID',
            'nomor_surat' => 'Nomor Surat',
            'divisi_pengirim_id' => 'Divisi Pengirim',
            'divisi_tujuan_id' => 'Divisi Tujuan',
            'nama_tujuan_orang' => 'Tujuan Perorangan',
            'tanggal_surat' => 'Tanggal Surat',
            'perihal' => 'Perihal',
            'nama_penerima' => 'Nama Penerima',
            'tanggal_penerimaan' => 'Tanggal Penerimaan',
            'status' => 'Status',
        ];
    }

    public static function find()
    {
        return new SuratEkspedisiQuery(get_called_class());
    }

    public function getDivisiPengirim()
    {
        return $this->hasOne(Divisi::class, ['id' => 'divisi_pengirim_id']);
    }

    public function getDivisiTujuan()
    {
        return $this->hasOne(Divisi::class, ['id' => 'divisi_tujuan_id']);
    }

    public function getPembuat()
    {
        return $this->hasOne(User::class, ['id' => 'created_by']);
    }
}
