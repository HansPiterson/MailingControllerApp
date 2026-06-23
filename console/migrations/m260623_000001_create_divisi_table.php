<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%divisi}}`.
 */
class m260623_000001_create_divisi_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%divisi}}', [
            'id' => $this->primaryKey(),
            'kode_divisi' => $this->string(20)->notNull()->unique(),
            'nama_divisi' => $this->string(100)->notNull(),
            'is_active' => $this->boolean()->notNull()->defaultValue(true),
            'created_at' => $this->dateTime(),
            'updated_at' => $this->dateTime(),
        ]);

        $this->createIndex('idx-divisi-kode_divisi', '{{%divisi}}', 'kode_divisi', true);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%divisi}}');
    }
}
