<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%surat_ekspedisi}}`.
 * Has foreign keys to tables `{{%divisi}}` and `{{%users}}`.
 */
class m260623_000003_create_surat_ekspedisi_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%surat_ekspedisi}}', [
            'id' => $this->primaryKey(),
            'uuid' => $this->char(36)->notNull()->unique(),
            'nomor_surat' => $this->string(50),
            'divisi_pengirim_id' => $this->integer()->notNull(),
            'divisi_tujuan_id' => $this->integer()->notNull(),
            'nama_tujuan_orang' => $this->string(100),
            'tanggal_surat' => $this->date()->notNull(),
            'perihal' => $this->text()->notNull(),
            'nama_penerima' => $this->string(100),
            'tanggal_penerimaan' => $this->dateTime(),
            'foto_bukti' => $this->string(255),
            'foto_bukti_original' => $this->string(255),
            'foto_latitude' => $this->decimal(10, 8),
            'foto_longitude' => $this->decimal(11, 8),
            'foto_alamat' => $this->string(255),
            'foto_hash' => $this->string(64),
            'status' => $this->string(20)->notNull()->defaultValue('draft'),
            'is_synced' => $this->boolean()->notNull()->defaultValue(false),
            'needs_upload' => $this->boolean()->notNull()->defaultValue(false),
            'created_by' => $this->integer()->notNull(),
            'updated_by' => $this->integer(),
            'created_at' => $this->dateTime(),
            'updated_at' => $this->dateTime(),
        ]);

        $this->createIndex('idx-surat_ekspedisi-uuid', '{{%surat_ekspedisi}}', 'uuid', true);
        $this->createIndex('idx-surat_ekspedisi-divisi_pengirim_id', '{{%surat_ekspedisi}}', 'divisi_pengirim_id');
        $this->createIndex('idx-surat_ekspedisi-divisi_tujuan_id', '{{%surat_ekspedisi}}', 'divisi_tujuan_id');
        $this->createIndex('idx-surat_ekspedisi-created_by', '{{%surat_ekspedisi}}', 'created_by');
        $this->createIndex('idx-surat_ekspedisi-updated_by', '{{%surat_ekspedisi}}', 'updated_by');

        $this->addForeignKey(
            'fk-surat_ekspedisi-divisi_pengirim_id',
            '{{%surat_ekspedisi}}',
            'divisi_pengirim_id',
            '{{%divisi}}',
            'id',
            'RESTRICT',
            'CASCADE'
        );

        $this->addForeignKey(
            'fk-surat_ekspedisi-divisi_tujuan_id',
            '{{%surat_ekspedisi}}',
            'divisi_tujuan_id',
            '{{%divisi}}',
            'id',
            'RESTRICT',
            'CASCADE'
        );

        $this->addForeignKey(
            'fk-surat_ekspedisi-created_by',
            '{{%surat_ekspedisi}}',
            'created_by',
            '{{%users}}',
            'id',
            'RESTRICT',
            'CASCADE'
        );

        $this->addForeignKey(
            'fk-surat_ekspedisi-updated_by',
            '{{%surat_ekspedisi}}',
            'updated_by',
            '{{%users}}',
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
        $this->dropForeignKey('fk-surat_ekspedisi-updated_by', '{{%surat_ekspedisi}}');
        $this->dropForeignKey('fk-surat_ekspedisi-created_by', '{{%surat_ekspedisi}}');
        $this->dropForeignKey('fk-surat_ekspedisi-divisi_tujuan_id', '{{%surat_ekspedisi}}');
        $this->dropForeignKey('fk-surat_ekspedisi-divisi_pengirim_id', '{{%surat_ekspedisi}}');
        $this->dropTable('{{%surat_ekspedisi}}');
    }
}
