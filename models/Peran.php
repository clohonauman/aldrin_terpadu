<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "peran".
 *
 * @property int $id
 * @property string $id_akun
 * @property int $kode_akses
 * @property string|null $id_sekolah
 * @property string|null $nama_sekolah
 * @property string|null $bentuk_pendidikan
 * @property string|null $kabupaten
 * @property string|null $cabdin
 * @property string $waktu
 */
class Peran extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'peran';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_akun', 'kode_akses', 'waktu'], 'required'],
            [['kode_akses'], 'integer'],
            [['id_sekolah', 'nama_sekolah', 'bentuk_pendidikan', 'kabupaten', 'cabdin', 'waktu'], 'string'],
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
            'kode_akses' => 'Kode Akses',
            'id_sekolah' => 'Id Sekolah',
            'nama_sekolah' => 'Nama Sekolah',
            'bentuk_pendidikan' => 'Bentuk Pendidikan',
            'kabupaten' => 'Kabupaten',
            'cabdin' => 'Cabdin',
            'waktu' => 'Waktu',
        ];
    }
}
