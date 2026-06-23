<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%surat_ekspedisi}}`.
 */
class m260623_000006_add_status_column_to_surat_ekspedisi_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%surat_ekspedisi}}', 'status', $this->string()->notNull()->defaultValue('BARU'));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%surat_ekspedisi}}', 'status');
    }
}
