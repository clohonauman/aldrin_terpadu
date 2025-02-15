<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "sekolah".
 *
 * @property string $sekolah_id
 * @property string|null $semester_id
 * @property string|null $nama
 * @property string|null $nama_nomenklatur
 * @property string|null $nss
 * @property string $npsn
 * @property int|null $bentuk_pendidikan_id
 * @property string|null $bentuk_pendidikan
 * @property string|null $alamat_jalan
 * @property int|null $rt
 * @property int|null $rw
 * @property string|null $nama_dusun
 * @property string|null $kode_wilayah
 * @property string|null $kode_desa_kelurahan
 * @property string|null $desa_kelurahan
 * @property string|null $kode_kecamatan
 * @property string|null $kecamatan
 * @property string|null $kode_kabupaten
 * @property string|null $kabupaten
 * @property string|null $kode_provinsi
 * @property string|null $provinsi
 * @property string|null $kode_pos
 * @property float|null $lintang
 * @property float|null $bujur
 * @property string|null $nomor_telepon
 * @property string|null $nomor_fax
 * @property string|null $email
 * @property string|null $website
 * @property int|null $kebutuhan_khusus_id
 * @property string|null $kebutuhan_khusus
 * @property string|null $status_sekolah_id
 * @property string|null $status_sekolah
 * @property string|null $sk_pendirian_sekolah
 * @property string|null $tanggal_sk_pendirian
 * @property int|null $status_kepemilikan_id
 * @property string|null $status_kepemilikan
 * @property string|null $yayasan_id
 * @property string|null $yayasan
 * @property string|null $sk_izin_operasional
 * @property string|null $tanggal_sk_izin_operasional
 * @property string|null $no_rekening
 * @property string|null $nama_bank
 * @property string|null $cabang_kcp_unit
 * @property string|null $rekening_atas_nama
 * @property int|null $mbs
 * @property int|null $luas_tanah_milik
 * @property int|null $luas_tanah_bukan_milik
 * @property string|null $kode_registrasi
 * @property string|null $npwp
 * @property string|null $nm_wp
 * @property string|null $keaktifan
 * @property string|null $flag
 * @property int|null $daya_listrik
 * @property string|null $kontinuitas_listrik
 * @property int|null $jarak_listrik
 * @property string|null $wilayah_terpencil
 * @property string|null $wilayah_perbatasan
 * @property string|null $wilayah_transmigrasi
 * @property string|null $wilayah_adat_terpencil
 * @property string|null $wilayah_bencana_alam
 * @property string|null $wilayah_bencana_sosial
 * @property string|null $partisipasi_bos
 * @property int|null $waktu_penyelenggaraan_id
 * @property string|null $waktu_penyelenggaraan
 * @property int|null $sumber_listrik_id
 * @property string|null $sumber_listrik
 * @property int|null $sertifikasi_iso_id
 * @property string|null $sertifikasi_iso
 * @property int|null $akses_internet_id
 * @property string|null $akses_internet
 * @property int|null $akses_internet_2_id
 * @property string|null $akses_internet_2
 * @property string|null $akreditasi
 * @property string|null $create_date
 * @property string|null $last_update
 * @property int|null $data_status
 * @property string $createdAt
 * @property string $updatedAt
 */
class Sekolah extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'sekolah';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['sekolah_id', 'npsn', 'createdAt', 'updatedAt'], 'required'],
            [['bentuk_pendidikan_id', 'rt', 'rw', 'kebutuhan_khusus_id', 'status_kepemilikan_id', 'mbs', 'luas_tanah_milik', 'luas_tanah_bukan_milik', 'daya_listrik', 'jarak_listrik', 'waktu_penyelenggaraan_id', 'sumber_listrik_id', 'sertifikasi_iso_id', 'akses_internet_id', 'akses_internet_2_id', 'data_status'], 'integer'],
            [['lintang', 'bujur'], 'number'],
            [['createdAt', 'updatedAt'], 'safe'],
            [['sekolah_id'], 'string', 'max' => 36],
            [['semester_id', 'flag'], 'string', 'max' => 5],
            [['nama', 'nama_nomenklatur', 'nss', 'bentuk_pendidikan', 'alamat_jalan', 'nama_dusun', 'kode_wilayah', 'kode_desa_kelurahan', 'desa_kelurahan', 'kecamatan', 'kabupaten', 'provinsi', 'nomor_telepon', 'nomor_fax', 'email', 'website', 'kebutuhan_khusus', 'status_sekolah_id', 'status_sekolah', 'sk_pendirian_sekolah', 'tanggal_sk_pendirian', 'status_kepemilikan', 'yayasan_id', 'yayasan', 'sk_izin_operasional', 'tanggal_sk_izin_operasional', 'no_rekening', 'nama_bank', 'cabang_kcp_unit', 'rekening_atas_nama', 'kode_registrasi', 'nm_wp', 'waktu_penyelenggaraan', 'sumber_listrik', 'sertifikasi_iso', 'akses_internet', 'akses_internet_2', 'akreditasi', 'create_date', 'last_update'], 'string', 'max' => 255],
            [['npsn', 'kode_kecamatan', 'kode_kabupaten', 'kode_provinsi'], 'string', 'max' => 8],
            [['kode_pos'], 'string', 'max' => 6],
            [['npwp'], 'string', 'max' => 30],
            [['keaktifan', 'kontinuitas_listrik'], 'string', 'max' => 3],
            [['wilayah_terpencil', 'wilayah_perbatasan', 'wilayah_transmigrasi', 'wilayah_adat_terpencil', 'wilayah_bencana_alam', 'wilayah_bencana_sosial', 'partisipasi_bos'], 'string', 'max' => 1],
            [['sekolah_id'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'sekolah_id' => 'Sekolah ID',
            'semester_id' => 'Semester ID',
            'nama' => 'Nama',
            'nama_nomenklatur' => 'Nama Nomenklatur',
            'nss' => 'Nss',
            'npsn' => 'Npsn',
            'bentuk_pendidikan_id' => 'Bentuk Pendidikan ID',
            'bentuk_pendidikan' => 'Bentuk Pendidikan',
            'alamat_jalan' => 'Alamat Jalan',
            'rt' => 'Rt',
            'rw' => 'Rw',
            'nama_dusun' => 'Nama Dusun',
            'kode_wilayah' => 'Kode Wilayah',
            'kode_desa_kelurahan' => 'Kode Desa Kelurahan',
            'desa_kelurahan' => 'Desa Kelurahan',
            'kode_kecamatan' => 'Kode Kecamatan',
            'kecamatan' => 'Kecamatan',
            'kode_kabupaten' => 'Kode Kabupaten',
            'kabupaten' => 'Kabupaten',
            'kode_provinsi' => 'Kode Provinsi',
            'provinsi' => 'Provinsi',
            'kode_pos' => 'Kode Pos',
            'lintang' => 'Lintang',
            'bujur' => 'Bujur',
            'nomor_telepon' => 'Nomor Telepon',
            'nomor_fax' => 'Nomor Fax',
            'email' => 'Email',
            'website' => 'Website',
            'kebutuhan_khusus_id' => 'Kebutuhan Khusus ID',
            'kebutuhan_khusus' => 'Kebutuhan Khusus',
            'status_sekolah_id' => 'Status Sekolah ID',
            'status_sekolah' => 'Status Sekolah',
            'sk_pendirian_sekolah' => 'Sk Pendirian Sekolah',
            'tanggal_sk_pendirian' => 'Tanggal Sk Pendirian',
            'status_kepemilikan_id' => 'Status Kepemilikan ID',
            'status_kepemilikan' => 'Status Kepemilikan',
            'yayasan_id' => 'Yayasan ID',
            'yayasan' => 'Yayasan',
            'sk_izin_operasional' => 'Sk Izin Operasional',
            'tanggal_sk_izin_operasional' => 'Tanggal Sk Izin Operasional',
            'no_rekening' => 'No Rekening',
            'nama_bank' => 'Nama Bank',
            'cabang_kcp_unit' => 'Cabang Kcp Unit',
            'rekening_atas_nama' => 'Rekening Atas Nama',
            'mbs' => 'Mbs',
            'luas_tanah_milik' => 'Luas Tanah Milik',
            'luas_tanah_bukan_milik' => 'Luas Tanah Bukan Milik',
            'kode_registrasi' => 'Kode Registrasi',
            'npwp' => 'Npwp',
            'nm_wp' => 'Nm Wp',
            'keaktifan' => 'Keaktifan',
            'flag' => 'Flag',
            'daya_listrik' => 'Daya Listrik',
            'kontinuitas_listrik' => 'Kontinuitas Listrik',
            'jarak_listrik' => 'Jarak Listrik',
            'wilayah_terpencil' => 'Wilayah Terpencil',
            'wilayah_perbatasan' => 'Wilayah Perbatasan',
            'wilayah_transmigrasi' => 'Wilayah Transmigrasi',
            'wilayah_adat_terpencil' => 'Wilayah Adat Terpencil',
            'wilayah_bencana_alam' => 'Wilayah Bencana Alam',
            'wilayah_bencana_sosial' => 'Wilayah Bencana Sosial',
            'partisipasi_bos' => 'Partisipasi Bos',
            'waktu_penyelenggaraan_id' => 'Waktu Penyelenggaraan ID',
            'waktu_penyelenggaraan' => 'Waktu Penyelenggaraan',
            'sumber_listrik_id' => 'Sumber Listrik ID',
            'sumber_listrik' => 'Sumber Listrik',
            'sertifikasi_iso_id' => 'Sertifikasi Iso ID',
            'sertifikasi_iso' => 'Sertifikasi Iso',
            'akses_internet_id' => 'Akses Internet ID',
            'akses_internet' => 'Akses Internet',
            'akses_internet_2_id' => 'Akses Internet 2 ID',
            'akses_internet_2' => 'Akses Internet 2',
            'akreditasi' => 'Akreditasi',
            'create_date' => 'Create Date',
            'last_update' => 'Last Update',
            'data_status' => 'Data Status',
            'createdAt' => 'Created At',
            'updatedAt' => 'Updated At',
        ];
    }
}
