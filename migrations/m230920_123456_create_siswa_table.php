<?php
use yii\db\Migration;

class m230920_123456_create_siswa_table extends Migration
{
    public function safeUp()
    {
        $this->createTable('siswa', [
            'siswa_id' => $this->char(36)->notNull()->unique(),
            'sekolah_id' => $this->char(36)->notNull(),
            'nisn' => $this->string(20)->notNull()->unique(),
            'nik' => $this->string(16)->null(),
            'no_kk' => $this->string(16)->null(),
            'nama' => $this->string(255)->notNull(),
            'desa_kelurahan' => $this->string(255)->null(),
            'kecamatan' => $this->string(255)->null(),
            'kabupaten' => $this->string(255)->null(),
            'provinsi' => $this->string(255)->notNull(),
            'nama_ibu_kandung' => $this->string(255)->null(),
            'tanggal_lahir' => $this->date()->notNull(),
            'tempat_lahir' => $this->string(255)->null(),
            'jenis_kelamin' => "ENUM('L', 'P') NOT NULL",
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
        ]);
        
        $this->addPrimaryKey('pk_siswa', 'siswa', 'siswa_id');
        $this->addForeignKey('fk_siswa_sekolah', 'siswa', 'sekolah_id', 'sekolah', 'sekolah_id', 'CASCADE', 'CASCADE');
    }

    public function safeDown()
    {
        $this->dropForeignKey('fk_siswa_sekolah', 'siswa');
        $this->dropTable('siswa');
    }
}

