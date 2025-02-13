<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;

class Akun extends ActiveRecord
{
    public static function tableName()
    {
        return 'akun';
    }

    public function getPeran()
    {
        return $this->hasOne(Peran::class, ['id_akun' => 'id_akun']);
    }
}
