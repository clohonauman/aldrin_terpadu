<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "akun".
 *
 * @property string $id_akun
 * @property string|null $nama_pengguna
 * @property string|null $kata_sandi
 * @property string|null $nama_lengkap
 * @property int|null $session
 * @property string|null $status
 * @property string|null $email
 */
class Akun extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'akun';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_akun'], 'required'],
            [['nama_pengguna', 'nama_lengkap', 'status', 'email'], 'required', 'message'=> '* {attribute} tidak bisa kosong.'],
            [['nama_pengguna', 'kata_sandi', 'nama_lengkap', 'status', 'email'], 'string'],
            [['session'], 'integer'],
            [['id_akun'], 'string', 'max' => 10],
            [['id_akun'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_akun' => 'Id Akun',
            'nama_pengguna' => 'Nama pengguna',
            'kata_sandi' => 'Kata sandi',
            'nama_lengkap' => 'Nama lengkap',
            'session' => 'Session',
            'status' => 'Status',
            'email' => 'Email',
        ];
    }

    public function getPeran()
    {
        return $this->hasOne(Peran::class, ['id_akun' => 'id_akun'])
            ->orderBy(['kode_akses' => SORT_ASC]);
    }

}
