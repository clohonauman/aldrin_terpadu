<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "session".
 *
 * @property int $id
 * @property string $token
 * @property string $refresh_token
 * @property string $app_id
 * @property string|null $ip_address
 * @property string|null $device_type
 * @property string|null $browser_info
 * @property string $device_id
 * @property string|null $location
 * @property string $id_akun
 * @property string $kode_akses
 * @property string $waktu
 */
class Session extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'session';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['token', 'refresh_token', 'app_id', 'device_id', 'id_akun', 'kode_akses', 'waktu'], 'required'],
            [['token', 'refresh_token', 'app_id', 'ip_address', 'device_type', 'browser_info', 'device_id', 'location', 'waktu'], 'string'],
            [['id_akun'], 'string', 'max' => 10],
            [['kode_akses'], 'string', 'max' => 5],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'token' => 'Token',
            'refresh_token' => 'Refresh Token',
            'app_id' => 'App ID',
            'ip_address' => 'Ip Address',
            'device_type' => 'Device Type',
            'browser_info' => 'Browser Info',
            'device_id' => 'Device ID',
            'location' => 'Location',
            'id_akun' => 'Id Akun',
            'kode_akses' => 'Kode Akses',
            'waktu' => 'Waktu',
        ];
    }
}
