<?php
use yii\db\Migration;

class m230920_123456_create_siswa_table extends Migration
{

    public function safeUp()
    {
        $this->createTable('{{%siswa}}', [
            'siswa_id' => $this->char(36)->notNull()->unique()->comment('Primary Key UUID'),
            'sekolah_id' => $this->char(36)->notNull()->comment('ID Sekolah'),
            'tingkat_pendidikan' => $this->string(15)->null()->comment('Tingkat Pendidikan'),
            'nisn' => $this->string(20)->notNull()->unique()->comment('Nomor Induk Siswa Nasional'),
            'nik' => $this->string(20)->null()->comment('Nomor Induk Kependudukan'),
            'no_kk' => $this->string(20)->null()->comment('Nomor Kartu Keluarga'),
            'nama' => $this->string(255)->notNull()->comment('Nama Lengkap'),
            'desa_kelurahan' => $this->string(255)->null()->comment('Desa/Kelurahan'),
            'kecamatan' => $this->string(255)->null()->comment('Kecamatan'),
            'kabupaten' => $this->string(255)->null()->comment('Kabupaten'),
            'provinsi' => $this->string(255)->notNull()->comment('Provinsi'),
            'nama_ibu_kandung' => $this->string(255)->null()->comment('Nama Ibu Kandung'),
            'tanggal_lahir' => $this->date()->notNull()->comment('Tanggal Lahir'),
            'tempat_lahir' => $this->string(255)->null()->comment('Tempat Lahir'),
            'jenis_kelamin' => "ENUM('L', 'P') NOT NULL COMMENT 'Jenis Kelamin (L/P)'",
            'created_at' => $this->integer(11)->notNull()->comment('Timestamp Created'),
            'updated_at' => $this->integer(11)->notNull()->comment('Timestamp Updated'),
            'status' => $this->integer(11)->notNull()->comment('Status Siswa'),
        ]);

        $this->addPrimaryKey('pk_siswa', '{{%siswa}}', 'siswa_id');
        $this->createIndex('idx_siswa_nisn', '{{%siswa}}', 'nisn');
    }

    public function safeDown()
    {
        $this->dropTable('{{%siswa}}');
    }
}

