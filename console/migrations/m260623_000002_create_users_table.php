<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%users}}`.
 * Has foreign key to table `{{%divisi}}`.
 */
class m260623_000002_create_users_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%users}}', [
            'id' => $this->primaryKey(),
            'divisi_id' => $this->integer(),
            'username' => $this->string(50)->notNull()->unique(),
            'email' => $this->string(100)->notNull()->unique(),
            'password_hash' => $this->string(255)->notNull(),
            'nama_lengkap' => $this->string(100)->notNull(),
            'role' => $this->string(20)->defaultValue('divisi'),
            'status' => $this->smallInteger()->notNull()->defaultValue(10),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
        ]);

        $this->createIndex('idx-users-username', '{{%users}}', 'username', true);
        $this->createIndex('idx-users-email', '{{%users}}', 'email', true);
        $this->createIndex('idx-users-divisi_id', '{{%users}}', 'divisi_id');

        $this->addForeignKey(
            'fk-users-divisi_id',
            '{{%users}}',
            'divisi_id',
            '{{%divisi}}',
            'id',
            'SET NULL',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk-users-divisi_id', '{{%users}}');
        $this->dropTable('{{%users}}');
    }
}
