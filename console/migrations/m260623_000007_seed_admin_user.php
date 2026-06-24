<?php

use yii\db\Migration;
use common\models\User;
use common\models\Divisi;

/**
 * Class m260623_000007_seed_admin_user
 */
class m260623_000007_seed_admin_user extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        // 1. Buat Divisi Pusat
        $divisi = new Divisi();
        $divisi->kode_divisi = 'PST';
        $divisi->nama_divisi = 'Pusat';
        $divisi->is_active = true;
        $divisi->save();

        // 2. Buat User Admin
        $user = new User();
        $user->username = 'admin';
        $user->email = 'admin@example.com';
        $user->nama_lengkap = 'Administrator'; // Tambahkan ini
        $user->setPassword('admin123');
        $user->generateAuthKey();
        $user->generateEmailVerificationToken();
        $user->status = User::STATUS_ACTIVE;
        
        $user->setAttribute('divisi_id', $divisi->id);
        $user->setAttribute('role', 'admin');
        
        if (!$user->save(false)) {
            throw new \Exception("Gagal menyimpan user admin: " . json_encode($user->errors));
        }
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $adminUser = User::findOne(['username' => 'admin']);
        if ($adminUser) {
            $this->delete('{{%user}}', ['id' => $adminUser->id]);
        }
        
        $this->delete('{{%divisi}}', ['kode_divisi' => 'PST']);
    }
}
