<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\web\UploadedFile;
use yii\db\ActiveRecord;

class Rombel extends ActiveRecord
{

    public $nama_rombel;
    public static function tableName()
    {
        return 'rombongan_belajar';
    }

    public function rules()
    {
        return [
            [
                [
                    'nama_rombel', 
                ], 'required'
            ],
        ];
    }
}