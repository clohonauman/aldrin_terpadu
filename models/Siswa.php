<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "siswa".
 *
 * @property string $siswa_id
 * @property string $sekolah_id
 * @property string $nisn
 * @property string|null $nik
 * @property string|null $no_kk
 * @property string $nama
 * @property string|null $desa_kelurahan
 * @property string|null $kecamatan
 * @property string|null $kabupaten
 * @property string $provinsi
 * @property string|null $nama_ibu_kandung
 * @property string $tanggal_lahir
 * @property string|null $tempat_lahir
 * @property string $jenis_kelamin
 * @property int $created_at
 * @property int $updated_at
 */
class Siswa extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'siswa';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['siswa_id', 'sekolah_id', 'nisn', 'nama', 'provinsi', 'tanggal_lahir', 'jenis_kelamin', 'created_at', 'updated_at'], 'required'],
            [['tanggal_lahir'], 'safe'],
            [['jenis_kelamin'], 'string'],
            [['created_at', 'updated_at'], 'integer'],
            [['siswa_id', 'sekolah_id'], 'string', 'max' => 36],
            [['nisn'], 'string', 'max' => 20],
            [['nik', 'no_kk'], 'string', 'max' => 16],
            [['nama', 'desa_kelurahan', 'kecamatan', 'kabupaten', 'provinsi', 'nama_ibu_kandung', 'tempat_lahir'], 'string', 'max' => 255],
            [['nisn'], 'unique'],
            [['siswa_id'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'siswa_id' => 'Siswa ID',
            'sekolah_id' => 'Sekolah ID',
            'nisn' => 'Nisn',
            'nik' => 'Nik',
            'no_kk' => 'No Kk',
            'nama' => 'Nama',
            'desa_kelurahan' => 'Desa Kelurahan',
            'kecamatan' => 'Kecamatan',
            'kabupaten' => 'Kabupaten',
            'provinsi' => 'Provinsi',
            'nama_ibu_kandung' => 'Nama Ibu Kandung',
            'tanggal_lahir' => 'Tanggal Lahir',
            'tempat_lahir' => 'Tempat Lahir',
            'jenis_kelamin' => 'Jenis Kelamin',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }
}
