<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\web\UploadedFile;

class UploadForm extends Model
{
    public $file;

    public $nik;
    public $nokk;
    public $nama;
    public $jenis_kelamin;
    public $tanggal_lahir;
    public $tempat_lahir;
    public $agama;
    public $kewarganegaraan;
    public $no_hp;
    public $email;

    public $provinsi;
    public $kecamatan;
    public $kabupaten;
    public $alamat_jalan;
    public $rt;
    public $rw;
    public $desa_kelurahan;

    public $nip;
    public $nuptk;
    public $status_kepegawaian;
    public $jabatan;
    public $npsn;
    public $sk_cpns;
    public $tgl_cpns;
    public $jenis_ptk;
    public $sk_pengangkatan;
    public $tmt_pengangkatan;
    public $pangkat_golongan;
    public $lembaga_pengangkat;
    public $sumber_gaji;
    public $nama_ibu_kandung;
    public $data_status;

    public function rules()
    {
        return [
            [['file'], 'file','skipOnEmpty' => false, 'extensions' => 'xlsx', 'maxSize' => 5 * 1024 * 1024],

            [[
                'nik', 
                'nama',
                'tempat_lahir',
                'tanggal_lahir',
                'jenis_kelamin',
                'agama',
                'kewarganegaraan',
                'no_hp',
                'email',

                'kabupaten', 
                'kecamatan', 
                'alamat_jalan',
                'desa_kelurahan',
                'rt',
                'rw',

                'status_kepegawaian',
                'jabatan',
                'npsn', 
                'jenis_ptk',
                'lembaga_pengangkat',
                'sumber_gaji',
                'nama_ibu_kandung',
                'data_status',
            ], 'required', 'message' => '* {attribute} wajib diisi.'],

            [['nama', 'nuptk', 'tempat_lahir', 'jabatan','jenis_kelamin'], 'string', 'max' => 255],
            [['nip'], 'string', 'max' => 20],
            [['nik','nuptk','nokk'], 'string', 'max' => 16],
            [['tanggal_lahir','tmt_pengangkatan','tgl_cpns'], 'date', 'format' => 'php:Y-m-d'],
        ];
    }
}
