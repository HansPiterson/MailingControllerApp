<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%sync_log}}`.
 * Has foreign key to table `{{%users}}`.
 */
class m260623_000005_create_sync_log_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%sync_log}}', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->notNull(),
            'device_id' => $this->string(100)->notNull(),
            'sync_type' => $this->string(20)->notNull(),
            'records_count' => $this->integer()->notNull()->defaultValue(0),
            'status' => $this->string(20)->notNull(),
            'error_message' => $this->text(),
            'synced_at' => $this->dateTime()->notNull(),
        ]);

        $this->createIndex('idx-sync_log-user_id', '{{%sync_log}}', 'user_id');

        $this->addForeignKey(
            'fk-sync_log-user_id',
            '{{%sync_log}}',
            'user_id',
            '{{%users}}',
            'id',
            'CASCADE',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk-sync_log-user_id', '{{%sync_log}}');
        $this->dropTable('{{%sync_log}}');
    }
}
