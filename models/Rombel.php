<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\web\UploadedFile;
use yii\db\ActiveRecord;

class Rombel extends ActiveRecord
{

    public $nama;
    public $tingkat_pendidikan;
    public $ptk;
    public $kurikulum;
    public $jumlah_pembelajaran;
    public $jumlah_anggota_rombel;
    
    public static function tableName()
    {
        return 'rombongan_belajar';
    }

    public function rules()
    {
        return [
            [['ptk', 'nama'], 'required', 'message' => '{attribute} wajib diisi.'],
            [['semester_id', 'sekolah_id', 'kurikulum'], 'safe'], // Optional fields
            [['tingkat_pendidikan_id', 'jumlah_pembelajaran', 'jumlah_anggota_rombel'], 'integer', 'message' => '{attribute} harus berupa angka.'],
            [['nama'], 'string', 'max' => 30, 'message' => '{attribute} maksimal 30 karakter.'],
            [['nama_ptk'], 'string', 'max' => 255, 'message' => '{attribute} maksimal 255 karakter.'],
        ];
    }
}