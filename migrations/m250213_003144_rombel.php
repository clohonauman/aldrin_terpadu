<?php

use yii\db\Migration;

/**
 * Class m250213_003144_rombel
 */
class m250213_003144_rombel extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp(){
        $this->createTable('rombongan_belajar', [
            'rombongan_belajar_id' => $this->char(36)->notNull()->append('PRIMARY KEY'),
            'semester_id' => $this->char(5)->null(),
            'sekolah_id' => $this->char(36)->null(),
            'ptk_id' => $this->char(36)->null(),
            'tingkat_pendidikan_id' => $this->integer(11)->null(),
            'tingkat_pendidikan' => $this->string(20)->null(),
            'nama_ptk' => $this->string(255)->null(),
            'kurikulum' => $this->string(255)->null(),
            'nama' => $this->string(30)->null(),
            'jumlah_pembelajaran' => $this->integer(11)->null(),
            'jumlah_anggota_rombel' => $this->integer(11)->null(),
            'createdAt' => $this->dateTime()->notNull(),
            'updatedAt' => $this->dateTime()->notNull(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('rombongan_belajar');
        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m250213_003144_rombel cannot be reverted.\n";

        return false;
    }
    */
}
