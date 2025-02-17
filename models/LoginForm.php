<?php

namespace app\models;

use Yii;
use yii\base\Model;
use app\models\Akun;
use yii\web\Session;

class LoginForm extends Model
{
    public $nama_pengguna;
    public $kata_sandi;
    private $_user = false;

    public function rules()
    {
        return [
            [['nama_pengguna'], 'required', 'message' => '* Nama pengguna wajib diisi.'],
            [['kata_sandi'], 'required', 'message' => '* Kata sandi wajib diisi.'],
            ['nama_pengguna', 'string', 'max' => 50],
            ['kata_sandi', 'validatePassword'],
        ];
    }

    public function validatePassword($attribute, $params)
    {
        if (!$this->hasErrors()) {
            $user = $this->getUser();

            // Check if user exists and validate the password
            if (!$user || !Yii::$app->security->validatePassword($this->kata_sandi, $user['kata_sandi'])) {
                $this->addError($attribute, 'Nama pengguna atau kata sandi salah.');
            }
        }
    }

    public function login()
    {
        if ($this->validate()) {
            $user = $this->getUser();
            if ($user && Yii::$app->session->has('id_akun')) {
                return true;
            }
            $session = Yii::$app->session;
            $session->open();

            $session->set('id_akun', $user['id_akun']);
            $session->set('nama_lengkap', $user['nama_lengkap']);
            $session->set('id_sekolah', $user['id_sekolah']);
    
            $kode_akses = $user['kode_akses'];
    
            if (!in_array($kode_akses, [0, 2, 3])) {
                Yii::$app->session->destroy();
                return Yii::$app->response->redirect(Yii::$app->urlManager->createUrl('/login/logout'));
            }
    
            $session->set('kode_akses', $kode_akses);
    
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
            $command = Yii::$app->db->createCommand($sql, $params);
            $result = $command->queryOne();
            if ($result) {
                $this->_user = $result;
            }
        }
    
        return $this->_user;
    }
}
