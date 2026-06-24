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
        $user->setPassword('admin123'); // Password di-hash secara otomatis
        $user->generateAuthKey();
        $user->generateEmailVerificationToken();
        $user->status = User::STATUS_ACTIVE;
        $user->divisi_id = $divisi->id;
        $user->role = 'admin'; 
        
        // Simpan user tanpa validasi email, karena ini adalah seeder
        if (!$user->save(false)) {
            throw new \Exception("Gagal menyimpan user admin: " . json_encode($user->errors));
        }
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->delete('{{%user}}', ['username' => 'admin']);
        $this->delete('{{%divisi}}', ['kode_divisi' => 'PST']);
    }
}
