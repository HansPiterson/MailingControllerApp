<?php

declare(strict_types=1);

namespace common\models;

use common\components\JwtHelper;
use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;
use yii\db\Expression;
use yii\web\IdentityInterface;

/**
 * Model untuk tabel `users` (user aplikasi ekspedisi surat / mobile).
 *
 * Berbeda dari {@see User} bawaan template yang dipakai untuk login web.
 *
 * @property int $id
 * @property int|null $divisi_id
 * @property string $username
 * @property string $email
 * @property string $password_hash
 * @property string $nama_lengkap
 * @property string $role
 * @property bool $is_active
 * @property string|null $created_at
 * @property string|null $updated_at
 *
 * @property Divisi|null $divisi
 * @property SuratEkspedisi[] $suratDibuat
 */
class Users extends ActiveRecord implements IdentityInterface
{
    public const ROLE_ADMIN = 'admin';
    public const ROLE_DIVISI = 'divisi';

    /**
     * {@inheritdoc}
     */
    public static function tableName(): string
    {
        return '{{%users}}';
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
            [['username', 'email', 'nama_lengkap'], 'required'],
            [['divisi_id'], 'integer'],
            [['username'], 'string', 'max' => 50],
            [['email'], 'string', 'max' => 100],
            [['email'], 'email'],
            [['nama_lengkap'], 'string', 'max' => 100],
            [['username', 'email'], 'unique'],
            [['role'], 'in', 'range' => [self::ROLE_ADMIN, self::ROLE_DIVISI]],
            [['role'], 'default', 'value' => self::ROLE_DIVISI],
            [['is_active'], 'boolean'],
            [['is_active'], 'default', 'value' => true],
            [
                ['divisi_id'],
                'exist',
                'skipOnError' => true,
                'targetClass' => Divisi::class,
                'targetAttribute' => ['divisi_id' => 'id'],
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
            'divisi_id' => 'Divisi',
            'username' => 'Username',
            'email' => 'Email',
            'nama_lengkap' => 'Nama Lengkap',
            'role' => 'Role',
            'is_active' => 'Aktif',
        ];
    }

    /* ====================== IdentityInterface ====================== */

    /**
     * {@inheritdoc}
     */
    public static function findIdentity($id): Users|null
    {
        return static::findOne(['id' => $id, 'is_active' => true]);
    }

    /**
     * Cari identitas berdasarkan JWT access token (Bearer).
     *
     * {@inheritdoc}
     */
    public static function findIdentityByAccessToken($token, $type = null): Users|null
    {
        $payload = JwtHelper::decode((string) $token);
        if ($payload === null || !isset($payload['uid'])) {
            return null;
        }

        return static::findIdentity((int) $payload['uid']);
    }

    /**
     * {@inheritdoc}
     */
    public function getId(): int
    {
        return (int) $this->getPrimaryKey();
    }

    /**
     * {@inheritdoc}
     *
     * Tidak dipakai untuk auth JWT (stateless), tapi wajib ada.
     */
    public function getAuthKey(): string|null
    {
        return null;
    }

    /**
     * {@inheritdoc}
     */
    public function validateAuthKey($authKey): bool
    {
        return false;
    }

    /* ====================== Password ====================== */

    /**
     * Cari user aktif berdasarkan username atau email (untuk login).
     */
    public static function findByUsernameOrEmail(string $login): Users|null
    {
        return static::find()
            ->where(['is_active' => true])
            ->andWhere(['or', ['username' => $login], ['email' => $login]])
            ->one();
    }

    /**
     * Validasi password terhadap hash tersimpan.
     */
    public function validatePassword(string $password): bool
    {
        return Yii::$app->security->validatePassword($password, $this->password_hash);
    }

    /**
     * Set password (di-hash).
     */
    public function setPassword(string $password): void
    {
        $this->password_hash = Yii::$app->security->generatePasswordHash($password);
    }

    public function isAdmin(): bool
    {
        return $this->role === self::ROLE_ADMIN;
    }

    /* ====================== Relasi ====================== */

    public function getDivisi(): ActiveQuery
    {
        return $this->hasOne(Divisi::class, ['id' => 'divisi_id']);
    }

    public function getSuratDibuat(): ActiveQuery
    {
        return $this->hasMany(SuratEkspedisi::class, ['created_by' => 'id']);
    }

    /**
     * Representasi user untuk respons API (tanpa data sensitif).
     *
     * @return array<string,mixed>
     */
    public function toProfile(): array
    {
        return [
            'id' => $this->id,
            'username' => $this->username,
            'email' => $this->email,
            'nama_lengkap' => $this->nama_lengkap,
            'role' => $this->role,
            'divisi_id' => $this->divisi_id,
            'divisi' => $this->divisi !== null ? [
                'id' => $this->divisi->id,
                'kode_divisi' => $this->divisi->kode_divisi,
                'nama_divisi' => $this->divisi->nama_divisi,
            ] : null,
        ];
    }
}
