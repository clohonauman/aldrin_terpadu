<?php

use yii\db\Migration;

/**
 * Class m250213_001336_ptk
 */
class m250213_001336_ptk extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('ptk', [
            'ptk_id' => $this->char(36)->notNull()->append('PRIMARY KEY'),
            'semester_id' => $this->string(5),
            'sekolah_id' => $this->char(36),
            'ptk_terdaftar_id' => $this->char(36),
            'jabatan' => $this->string(255)->notNull(),
            'nama' => $this->string(255),
            'nip' => $this->string(255),
            'jenis_kelamin' => $this->char(1),
            'tempat_lahir' => $this->string(50),
            'tanggal_lahir' => $this->date(),
            'nik' => $this->string(20),
            'no_kk' => $this->string(20),
            'niy_nigk' => $this->string(50),
            'nuptk' => $this->string(20),
            'nuks' => $this->string(30),
            'status_kepegawaian' => $this->string(50),
            'jenis_ptk_id' => $this->char(3),
            'jenis_ptk' => $this->string(50),
            'pengawas_bidang_studi' => $this->string(50),
            'agama' => $this->string(50),
            'kewarganegaraan' => $this->string(5),
            'alamat_jalan' => $this->string(255),
            'rt' => $this->integer(),
            'rw' => $this->integer(),
            'nama_dusun' => $this->string(80),
            'desa_kelurahan' => $this->string(50),
            'kode_kecamatan' => $this->string(8),
            'kecamatan' => $this->string(50),
            'kode_kabupaten' => $this->string(8),
            'kabupaten' => $this->string(50),
            'kode_provinsi' => $this->string(8),
            'provinsi' => $this->string(50),
            'kode_pos' => $this->string(6),
            'lintang' => $this->double(),
            'bujur' => $this->double(),
            'no_telepon_rumah' => $this->string(20),
            'no_hp' => $this->string(20),
            'email' => $this->string(50),
            'status_keaktifan' => $this->string(25),
            'sk_cpns' => $this->string(80),
            'tgl_cpns' => $this->date(),
            'sk_pengangkatan' => $this->string(80),
            'tmt_pengangkatan' => $this->date(),
            'lembaga_pengangkat' => $this->string(50),
            'pangkat_golongan' => $this->string(10),
            'keahlian_laboratorium' => $this->string(50),
            'sumber_gaji' => $this->string(50),
            'nama_ibu_kandung' => $this->string(255),
            'status_perkawinan' => $this->string(2),
            'nama_suami_istri' => $this->string(255),
            'nip_suami_istri' => $this->string(18),
            'pekerjaan_suami_istri' => $this->integer(),
            'tmt_pns' => $this->date(),
            'sudah_lisensi_kepala_sekolah' => $this->boolean(),
            'jumlah_sekolah_binaan' => $this->integer(),
            'pernah_diklat_kepengawasan' => $this->boolean(),
            'npwp' => $this->string(20),
            'bank' => $this->string(25),
            'rekening_bank' => $this->string(30),
            'rekening_atas_nama' => $this->string(255),
            'tahun_ajaran' => $this->string(10),
            'nomor_surat_tugas' => $this->string(80),
            'tanggal_surat_tugas' => $this->date(),
            'tmt_tugas' => $this->date(),
            'ptk_induk' => $this->boolean(),
            'jenis_keluar' => $this->string(30),
            'tgl_ptk_keluar' => $this->date(),
            'data_status' => $this->boolean()->notNull()->defaultValue(1),
            'data_synced' => $this->boolean(),
            'createdAt' => $this->dateTime()->defaultExpression('CURRENT_TIMESTAMP'),
            'updatedAt' => $this->dateTime()->defaultExpression('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('ptk');
        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m250213_001336_ptk cannot be reverted.\n";

        return false;
    }
    */
}
