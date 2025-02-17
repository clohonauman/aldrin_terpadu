<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "log_aktivitas_terpadu".
 *
 * @property int $id
 * @property string $id_akun
 * @property string $action
 * @property int $created_at
 */
class LogAktivitasTerpadu extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'log_aktivitas_terpadu';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_akun', 'action', 'created_at'], 'required'],
            [['action'], 'string'],
            [['created_at'], 'integer'],
            [['id_akun'], 'string', 'max' => 10],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_akun' => 'Id Akun',
            'action' => 'Action',
            'created_at' => 'Created At',
        ];
    }
}
