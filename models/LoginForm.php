<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\web\Session;

class LoginForm extends Model
{
    public $nama_pengguna;
    public $kata_sandi;
    private $_user = false;

    public function rules()
    {
        return [
            [['nama_pengguna', 'kata_sandi'], 'required', 'message' => '* Wajib diisi.'],
            ['nama_pengguna', 'string', 'max' => 50],
            ['kata_sandi', 'validatePassword'],
        ];
    }

    public function validatePassword($attribute, $params)
    {
        if (!$this->hasErrors()) {
            $user = $this->getUser();
            if (!$user || !Yii::$app->security->validatePassword($this->kata_sandi, $user['kata_sandi'])) {
                $this->addError($attribute, 'Nama pengguna atau kata sandi salah.');
            }
        }
    }

    public function login()
    {
        if ($this->validate()) {
            $user = $this->getUser();
            
            $session = Yii::$app->session;
            $session->open();
            
            $sessionDataInsert = [
                'id_akun' => $user['id_akun'],
                'app_id' => 'ALDRIN_TERPADU-01234',
                'ip_address' => Yii::$app->request->userIP,
                'device_type' => $this->getDeviceType(),
                'browser_info' => Yii::$app->request->userAgent,
                'device_id' => $this->getDeviceId(),
                'token' => Yii::$app->security->generateRandomString(50),
                'refresh_token' => Yii::$app->security->generateRandomString(50),
                'kode_akses' => $user['kode_akses'],
                'waktu' => time()
            ];
            $sessionData = [
                'id_akun' => $sessionDataInsert['id_akun'],
                'nama_lengkap' => $user['nama_lengkap'],
                'id_sekolah' => $user['id_sekolah'],
                'app_id' => 'ALDRIN_TERPADU-01234',
                'ip_address' => Yii::$app->request->userIP,
                'device_type' => $this->getDeviceType(),
                'browser_info' => Yii::$app->request->userAgent,
                'device_id' => $this->getDeviceId(),
                'token' => $sessionDataInsert['token'],
                'refresh_token' => $sessionDataInsert['refresh_token'],
                'kode_akses' => $user['kode_akses'],
                'waktu' => time()
            ];
            foreach ($sessionData as $key => $value) {
                $session->set($key, $value);
            }
            Yii::$app->db->createCommand()->insert('session', $sessionDataInsert)->execute();
            
            if (!in_array($user['kode_akses'], [0, 2, 3])) {
                Yii::$app->session->destroy();
                return Yii::$app->response->redirect(Yii::$app->urlManager->createUrl('/login/logout'));
            }
            return true;
        }
        return false;
    }

    protected function getUser($conditions = [])
    {
        if ($this->_user === false) {
            $sql = 'SELECT * FROM akun a INNER JOIN peran p ON a.id_akun = p.id_akun WHERE a.nama_pengguna = :nama_pengguna AND a.status = :status AND p.kode_akses IN (0,2,3) ORDER BY p.kode_akses ASC';
            $params = [
                ':nama_pengguna' => $this->nama_pengguna,
                ':status' => 'aktif'
            ];
            if (!empty($conditions)) {
                foreach ($conditions as $key => $value) {
                    $sql .= ' AND ' . $key . ' = :' . $key;
                    $params[':' . $key] = $value;
                }
            }
            $this->_user = Yii::$app->db->createCommand($sql, $params)->queryOne();
        }
        return $this->_user;
    }

    private function getDeviceType()
    {
        $userAgent = Yii::$app->request->userAgent;
        if (preg_match('/mobile/i', $userAgent)) {
            return 'Mobile';
        } elseif (preg_match('/tablet/i', $userAgent)) {
            return 'Tablet';
        }
        return 'Desktop';
    }

    private function getDeviceId()
    {
        return md5(Yii::$app->request->userIP . Yii::$app->request->userAgent);
    }
}