<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;

class Ptk extends ActiveRecord
{
    public static function tableName()
    {
        return 'ptk'; // Nama tabel di database
    }

    public function rules()
    {
        return [
            [['nama', 'nik'], 'required'],
            [['tanggal_lahir', 'tgl_cpns', 'tmt_pengangkatan'], 'safe'],
            [['nik'], 'unique'],
            [['nama', 'tempat_lahir', 'status_keaktifan', 'kecamatan', 'kabupaten'], 'string', 'max' => 255],
            
            [['no_hp'], 'string', 'max' => 15], // Tetap string agar nol di depan tidak hilang
            [['nip'], 'string', 'max' => 20], // Menggunakan string agar nol di depan tidak hilang
            [['nuptk'], 'string', 'max' => 20], // Menggunakan string agar nol di depan tidak hilang
        ];
    }
}
