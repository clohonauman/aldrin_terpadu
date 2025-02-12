<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\web\UploadedFile;

class UploadForm extends Model
{
    public $file;
    public $nama;
    public $nik;
    public $nuptk;
    public $tempat_lahir;
    public $tanggal_lahir;
    public $jabatan;

    public function rules()
    {
        return [
            [['file'], 'file', 'skipOnEmpty' => true, 'extensions' => 'xlsx', 'maxSize' => 4 * 1024 * 1024],
            [['nik'], 'required'],
            [['nama', 'nuptk', 'tempat_lahir', 'jabatan'], 'string', 'max' => 255],
            [['nik'], 'string', 'length' => [16, 16]],
            [['nuptk'], 'string', 'length' => [16, 16]],
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
