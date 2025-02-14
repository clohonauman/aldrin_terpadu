<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\web\UploadedFile;
use yii\db\ActiveRecord;

class Rombel extends ActiveRecord
{

    public $nama_rombel;
    public $tingkat_pendidikan;
    public $ptk;
    public $kurikulum;
    public $jumlah_pembelajaran;
    public $jumlah_anggota_rombel;
    public $semester;
    public $mata_pelajaran;
    
    public static function tableName()
    {
        return 'rombongan_belajar';
    }

    public function rules()
    {
        return [
            [['ptk', 'nama_rombel', 'semester', 'tingkat_pendidikan', 'jumlah_pembelajaran','mata_pelajaran'], 'required', 'message' => '{attribute} wajib diisi.'],
            [['tingkat_pendidikan', 'jumlah_pembelajaran', 'jumlah_anggota_rombel'], 'integer', 'message' => '{attribute} harus berupa angka.'],
            [['nama'], 'string', 'max' => 30, 'message' => '{attribute} maksimal 30 karakter.'],
            [['semester'], 'string', 'max' => 10],
        ];
    }
}