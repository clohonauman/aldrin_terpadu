<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\web\UploadedFile;

class UploadForm extends Model
{
    public $file;

    public $nik;
    public $nama;
    public $jenis_kelamin;
    public $tanggal_lahir;
    public $tempat_lahir;

    public $nip;
    public $nuptk;
    public $status_kepegawaian;
    public $jabatan;
    public $npsn;
    public $sk_cpns;

    public function rules()
    {
        return [
            [['file'], 'file','skipOnEmpty' => false, 'extensions' => 'xlsx', 'maxSize' => 4 * 1024 * 1024],
            [['npsn', 'nik', 'tanggal_lahir'], 'required'],

            [['nama', 'nuptk', 'tempat_lahir', 'jabatan','jenis_kelamin'], 'string', 'max' => 255],
            [['nik','nuptk','nip'], 'string', 'length' => [16, 16]],
            [['tanggal_lahir'], 'date', 'format' => 'php:Y-m-d'],
        ];
    }
    

    public function upload()
    {
        if ($this->validate()) {
            $filePath = 'uploads/' . $this->file->baseName . '.' . $this->file->extension;
            $this->file->saveAs($filePath);
            return $filePath;
        }
        return false;
    }
}
