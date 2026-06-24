<?php

declare(strict_types=1);

namespace common\models;

use Yii;
use yii\base\NotSupportedException;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

/**
 * User model
 *
 * @property int $id
 * @property int|null $divisi_id
 * @property string $username
 * @property string $password_hash
 * @property string $email
 * @property string $auth_key
 * @property int $status
 * @property string $role
 * @property string $nama_lengkap
 * @property int $created_at
 * @property int $updated_at
 * @property string $password write-only password
 *
 * @property Divisi $divisi
 */
class User extends ActiveRecord implements IdentityInterface
{
    public const STATUS_DELETED = 0;
    public const STATUS_INACTIVE = 9;
    public const STATUS_ACTIVE = 10;
    
    public const ROLE_ADMIN = 'admin';
    public const ROLE_OPERATOR = 'operator';
    public const ROLE_DIVISI = 'divisi';
    public const ROLE_KURIR = 'kurir';

    /**
     * {@inheritdoc}
     */
    public static function tableName(): string
    {
        return '{{%users}}'; // Menggunakan tabel 'users'
    }

    /**
     * {@inheritdoc}
     */
    public function behaviors(): array
    {
        return [
            TimestampBehavior::class,
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            [['username', 'email', 'password_hash', 'nama_lengkap'], 'required'],
            ['status', 'default', 'value' => self::STATUS_ACTIVE],
            ['status', 'in', 'range' => [self::STATUS_ACTIVE, self::STATUS_INACTIVE, self::STATUS_DELETED]],
            [['divisi_id'], 'integer'],
            [['divisi_id'], 'exist', 'skipOnError' => true, 'targetClass' => Divisi::class, 'targetAttribute' => ['divisi_id' => 'id']],
            ['role', 'required'],
            ['role', 'in', 'range' => [self::ROLE_ADMIN, self::ROLE_OPERATOR, self::ROLE_DIVISI, self::ROLE_KURIR]],
        ];
    }

    // ... (sisa model tetap sama) ...
    
    /**
     * {@inheritdoc}
     */
    public static function findIdentity($id)
    {
        return static::findOne(['id' => $id, 'status' => self::STATUS_ACTIVE]);
    }

    /**
     * {@inheritdoc}
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        try {
            $decoded = JWT::decode($token, new Key(Yii::$app->params['jwtSecret'], 'HS256'));
            return static::findOne($decoded->sub);
        } catch (\Exception $e) {
            return null;
        }
    }
    
    public static function findByUsername(string $username)
    {
        return static::findOne(['username' => $username, 'status' => self::STATUS_ACTIVE]);
    }

    public function getId()
    {
        return $this->getPrimaryKey();
    }

    public function getAuthKey()
    {
        // Kolom auth_key tidak ada di tabel 'users', kita bisa generate on-the-fly atau mock
        // Untuk sekarang, kita kembalikan string statis agar tidak error
        return 'test-auth-key';
    }

    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }

    public function validatePassword(string $password): bool
    {
        return Yii::$app->security->validatePassword($password, $this->password_hash);
    }

    public function setPassword(string $password): void
    {
        $this->password_hash = Yii::$app->security->generatePasswordHash($password);
    }
    
    public function generateAuthKey(): void
    {
        // Tidak melakukan apa-apa karena kolomnya tidak ada
    }
    
    public function generateEmailVerificationToken(): void
    {
        // Tidak melakukan apa-apa karena kolomnya tidak ada
    }

    public function getDivisi(): ActiveQuery
    {
        return $this->hasOne(Divisi::class, ['id' => 'divisi_id']);
    }
}
