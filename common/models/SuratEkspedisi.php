<?php

declare(strict_types=1);

namespace common\models;

use yii\behaviors\TimestampBehavior;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;
use yii\db\Expression;

/**
 * Model untuk tabel `surat_ekspedisi`.
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
 * @property bool $is_synced
 * @property bool $needs_upload
 * @property int $created_by
 * @property int|null $updated_by
 * @property string|null $created_at
 * @property string|null $updated_at
 *
 * @property Divisi $divisiPengirim
 * @property Divisi $divisiTujuan
 * @property Users $pembuat
 * @property Users|null $pengubah
 */
class SuratEkspedisi extends ActiveRecord
{
    /** Surat dibuat, belum dikirim. */
    public const STATUS_DRAFT = 'draft';
    /** Surat sudah dikirim, menunggu diterima. */
    public const STATUS_TERKIRIM = 'terkirim';
    /** Surat sudah diterima (ada bukti penerimaan). */
    public const STATUS_DITERIMA = 'diterima';
    /** Surat dibatalkan. */
    public const STATUS_BATAL = 'batal';

    /**
     * {@inheritdoc}
     */
    public static function tableName(): string
    {
        return '{{%surat_ekspedisi}}';
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
     * Daftar status yang valid.
     *
     * @return string[]
     */
    public static function statuses(): array
    {
        return [
            self::STATUS_DRAFT,
            self::STATUS_TERKIRIM,
            self::STATUS_DITERIMA,
            self::STATUS_BATAL,
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            [['uuid', 'divisi_pengirim_id', 'divisi_tujuan_id', 'tanggal_surat', 'perihal'], 'required'],
            [['divisi_pengirim_id', 'divisi_tujuan_id', 'created_by', 'updated_by'], 'integer'],
            [['perihal'], 'string'],
            [['tanggal_surat'], 'date', 'format' => 'php:Y-m-d'],
            [['tanggal_penerimaan'], 'datetime', 'format' => 'php:Y-m-d H:i:s'],
            [['uuid'], 'string', 'max' => 36],
            [['uuid'], 'unique'],
            [['nomor_surat', 'nama_tujuan_orang', 'nama_penerima', 'foto_bukti', 'foto_bukti_original', 'foto_alamat'], 'string', 'max' => 255],
            [['foto_hash'], 'string', 'max' => 64],
            [['foto_latitude'], 'number', 'min' => -90, 'max' => 90],
            [['foto_longitude'], 'number', 'min' => -180, 'max' => 180],
            [['status'], 'in', 'range' => self::statuses()],
            [['status'], 'default', 'value' => self::STATUS_DRAFT],
            [['is_synced', 'needs_upload'], 'boolean'],
            [['is_synced'], 'default', 'value' => false],
            [['needs_upload'], 'default', 'value' => false],
            [
                ['divisi_pengirim_id'],
                'exist',
                'skipOnError' => true,
                'targetClass' => Divisi::class,
                'targetAttribute' => ['divisi_pengirim_id' => 'id'],
            ],
            [
                ['divisi_tujuan_id'],
                'exist',
                'skipOnError' => true,
                'targetClass' => Divisi::class,
                'targetAttribute' => ['divisi_tujuan_id' => 'id'],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels(): array
    {
        return [
            'id' => 'ID',
            'uuid' => 'UUID',
            'nomor_surat' => 'Nomor Surat',
            'divisi_pengirim_id' => 'Divisi Pengirim',
            'divisi_tujuan_id' => 'Divisi Tujuan',
            'nama_tujuan_orang' => 'Nama Tujuan (Orang)',
            'tanggal_surat' => 'Tanggal Surat',
            'perihal' => 'Perihal',
            'nama_penerima' => 'Nama Penerima',
            'tanggal_penerimaan' => 'Tanggal Penerimaan',
            'foto_bukti' => 'Foto Bukti',
            'status' => 'Status',
            'created_by' => 'Dibuat Oleh',
        ];
    }

    /* ====================== Relasi ====================== */

    public function getDivisiPengirim(): ActiveQuery
    {
        return $this->hasOne(Divisi::class, ['id' => 'divisi_pengirim_id']);
    }

    public function getDivisiTujuan(): ActiveQuery
    {
        return $this->hasOne(Divisi::class, ['id' => 'divisi_tujuan_id']);
    }

    public function getPembuat(): ActiveQuery
    {
        return $this->hasOne(Users::class, ['id' => 'created_by']);
    }

    public function getPengubah(): ActiveQuery
    {
        return $this->hasOne(Users::class, ['id' => 'updated_by']);
    }

    /**
     * Representasi surat untuk respons API.
     *
     * @return array<string,mixed>
     */
    public function toApi(): array
    {
        return [
            'id' => $this->id,
            'uuid' => $this->uuid,
            'nomor_surat' => $this->nomor_surat,
            'divisi_pengirim_id' => $this->divisi_pengirim_id,
            'divisi_tujuan_id' => $this->divisi_tujuan_id,
            'nama_tujuan_orang' => $this->nama_tujuan_orang,
            'tanggal_surat' => $this->tanggal_surat,
            'perihal' => $this->perihal,
            'nama_penerima' => $this->nama_penerima,
            'tanggal_penerimaan' => $this->tanggal_penerimaan,
            'foto_bukti' => $this->foto_bukti,
            'foto_latitude' => $this->foto_latitude,
            'foto_longitude' => $this->foto_longitude,
            'foto_alamat' => $this->foto_alamat,
            'foto_hash' => $this->foto_hash,
            'status' => $this->status,
            'is_synced' => (bool) $this->is_synced,
            'needs_upload' => (bool) $this->needs_upload,
            'created_by' => $this->created_by,
            'updated_by' => $this->updated_by,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
