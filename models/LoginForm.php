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
            if (!$user || !Yii::$app->security->validatePassword($this->kata_sandi, $user->kata_sandi)) {
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

            $session->set('id_akun', $user->id_akun);
            $session->set('nama_lengkap', $user->nama_lengkap);
            $session->set('kode_akses', $user->peran->kode_akses);
            $session->set('id_sekolah', $user->peran->id_sekolah);
            $kode_akses = $session->get('kode_akses');

            if (!in_array($kode_akses, [0, 2, 3])) {
                $session->destroy();
                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, base_url('/login/logout'));
                curl_setopt($ch, CURLOPT_POST, 1);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_exec($ch);
                curl_close($ch);
            
                return redirect()->to('/login');
            }
            

            return true;
        }
        return false;
    }

    protected function getUser()
    {
        if ($this->_user === false) {
            $this->_user = Akun::find()->where(['nama_pengguna' => $this->nama_pengguna])->with('peran')->one();
        }
        return $this->_user;
    }
}
