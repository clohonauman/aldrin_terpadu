<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "mata_pelajaran".
 *
 * @property int $id
 * @property string $mata_pelajaran
 * @property string $created_at
 * @property string $updated_at
 */
class MataPelajaran extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'mata_pelajaran';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['mata_pelajaran', 'jam_pelajaran'], 'required'], // Tambahkan required untuk jam_pelajaran
            [['created_at', 'updated_at'], 'safe'],
            [['mata_pelajaran'], 'string', 'max' => 255],
            [['jam_pelajaran'], 'integer', 'min' => 0] // Perbaikan disini
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'mata_pelajaran' => 'Mata Pelajaran',
            'jam_pelajaran' => 'Jam Pelajaran',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }
}
