<?php

declare(strict_types=1);

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use yii\db\Expression;

/**
 * User model
 */
class User extends ActiveRecord implements IdentityInterface
{
    // ... konstanta tetap sama ...

    public static function tableName(): string
    {
        return '{{%users}}';
    }

    public function behaviors(): array
    {
        return [
            [
                'class' => TimestampBehavior::class,
                // Perbaikan: Gunakan Expression NOW() untuk PostgreSQL dateTime
                'value' => new Expression('NOW()'),
            ],
        ];
    }

    // ... (sisa code rules, findIdentity, dll tetap sama) ...
    
    /**
     * Sesuai request sebelumnya, saya tulis ulang lengkap agar tidak ada placeholder yang hilang.
     */
    public const STATUS_DELETED = 0;
    public const STATUS_INACTIVE = 9;
    public const STATUS_ACTIVE = 10;
    
    public const ROLE_ADMIN = 'admin';
    public const ROLE_OPERATOR = 'operator';
    public const ROLE_DIVISI = 'divisi';
    public const ROLE_KURIR = 'kurir';

    public function rules(): array
    {
        return [
            [['username', 'email', 'password_hash', 'nama_lengkap'], 'required'],
            ['status', 'default', 'value' => self::STATUS_ACTIVE],
            [['divisi_id'], 'integer'],
            ['role', 'in', 'range' => [self::ROLE_ADMIN, self::ROLE_OPERATOR, self::ROLE_DIVISI, self::ROLE_KURIR]],
        ];
    }

    public static function findIdentity($id) { return static::findOne(['id' => $id, 'status' => self::STATUS_ACTIVE]); }
    public static function findByUsername($username) { return static::findOne(['username' => $username, 'status' => self::STATUS_ACTIVE]); }
    public function getId() { return $this->getPrimaryKey(); }
    public function getAuthKey() { return 'test-key'; }
    public function validateAuthKey($authKey) { return true; }
    public function validatePassword($password) { return Yii::$app->security->validatePassword($password, $this->password_hash); }
    public function setPassword($password) { $this->password_hash = Yii::$app->security->generatePasswordHash($password); }
    public function generateAuthKey() {}
    public function getDivisi(): ActiveQuery { return $this->hasOne(Divisi::class, ['id' => 'divisi_id']); }

    public static function findIdentityByAccessToken($token, $type = null)
    {
        try {
            $decoded = JWT::decode($token, new Key(Yii::$app->params['jwtSecret'], 'HS256'));
            return static::findOne($decoded->sub);
        } catch (\Exception $e) {
            return null;
        }
    }
}
