<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "pembelajaran".
 *
 * @property string $pembelajaran_id
 * @property string|null $semester
 * @property string|null $sekolah_id
 * @property string|null $rombongan_belajar_id
 * @property int|null $mata_pelajaran_id
 * @property string|null $ptk_id
 * @property string|null $nama_ptk
 * @property string|null $sk_mengajar
 * @property string|null $tanggal_sk_mengajar
 * @property int|null $jam_mengajar_per_minggu
 * @property int $created_at
 * @property int $updated_at
 */
class Pembelajaran extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'pembelajaran';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['pembelajaran_id', 'created_at', 'updated_at','jam_mengajar_per_minggu','ptk_id','rombongan_belajar_id'], 'required', 'message' => '* {attribute} tidak boleh kosong.'],
            [['mata_pelajaran_id', 'jam_mengajar_per_minggu', 'created_at', 'updated_at'], 'integer'],
            [['pembelajaran_id', 'sekolah_id', 'rombongan_belajar_id', 'ptk_id'], 'string', 'max' => 36],
            [['semester', 'tanggal_sk_mengajar'], 'string', 'max' => 10],
            [['sk_mengajar'], 'string', 'max' => 100],
            [['pembelajaran_id'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'pembelajaran_id' => 'Pembelajaran ID',
            'semester' => 'Semester',
            'sekolah_id' => 'Sekolah',
            'rombongan_belajar_id' => 'Rombel',
            'mata_pelajaran_id' => 'Mata Pelajaran',
            'ptk_id' => 'PTK',
            'sk_mengajar' => 'SK Mengajar',
            'tanggal_sk_mengajar' => 'Tanggal Sk Mengajar',
            'jam_mengajar_per_minggu' => 'Jam Mengajar Per Minggu',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }
}
