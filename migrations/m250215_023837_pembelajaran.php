<?php

use yii\db\Migration;

/**
 * Class m250215_023837_pembelajaran
 */
class m250215_023837_pembelajaran extends Migration
{

    public function safeUp()
    {
        $this->createTable('pembelajaran', [
            'pembelajaran_id' => $this->char(36)->notNull()->unique(),
            'semester' => $this->char(10)->null(),
            'sekolah_id' => $this->char(36)->null(),
            'rombongan_belajar_id' => $this->char(36)->null(),
            'mata_pelajaran_id' => $this->integer(11)->null(),
            'ptk_id' => $this->char(36)->null(),
            'nama_ptk' => $this->string(255)->null(),
            'sk_mengajar' => $this->string(100)->null(),
            'tanggal_sk_mengajar' => $this->char(10)->null(),
            'jam_mengajar_per_minggu' => $this->integer(11)->null(),
            'createdAt' => $this->dateTime()->notNull(),
            'updatedAt' => $this->dateTime()->notNull(),
        ]);

        $this->addPrimaryKey('pk_pembelajaran', 'pembelajaran', 'pembelajaran_id');
    }

    public function safeDown()
    {
        $this->dropTable('pembelajaran');
    }
}
