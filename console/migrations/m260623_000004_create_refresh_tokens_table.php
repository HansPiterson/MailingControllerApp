<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%refresh_tokens}}`.
 * Has foreign key to table `{{%users}}`.
 */
class m260623_000004_create_refresh_tokens_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%refresh_tokens}}', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->notNull(),
            'token' => $this->string(255)->notNull()->unique(),
            'device_id' => $this->string(100)->notNull(),
            'expires_at' => $this->dateTime()->notNull(),
            'created_at' => $this->dateTime(),
        ]);

        $this->createIndex('idx-refresh_tokens-token', '{{%refresh_tokens}}', 'token', true);
        $this->createIndex('idx-refresh_tokens-user_id', '{{%refresh_tokens}}', 'user_id');

        $this->addForeignKey(
            'fk-refresh_tokens-user_id',
            '{{%refresh_tokens}}',
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
        $this->dropForeignKey('fk-refresh_tokens-user_id', '{{%refresh_tokens}}');
        $this->dropTable('{{%refresh_tokens}}');
    }
}
