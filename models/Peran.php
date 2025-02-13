<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;

class Peran extends ActiveRecord
{
    public static function tableName()
    {
        return 'peran';
    }
}
