<?php

namespace app\components;

use Yii;
use yii\web\Controller;
use yii\web\Response;
use app\models\Akun;
use app\models\LogAktivitasTerpadu;
use app\models\Session;

class BaseController extends Controller
{
    public function beforeAction($action)
    {
        $session = Yii::$app->session;
        $idAkun = $session->get('id_akun');
        $kodeAkses = $session->get('kode_akses');
        $token = $session->get('token');

        // Cek apakah sesi valid berdasarkan tabel session
        $sessionExists = Session::find()
            ->where(['id_akun' => $idAkun, 'token' => $token])
            ->exists();

        if (!$sessionExists || $idAkun === null || !in_array($kodeAkses, [0, 2, 3])) {
            $session->removeAll();
            Yii::$app->session->setFlash('error', 'Maaf, anda tidak dapat mengakses aplikasi ini. Silahkan login kembali atau hubungi Admin Aldrin Terpadu. Terima kasih.');
            return $this->redirect(['/login'])->send();
        }

        // Cek apakah akun masih aktif
        $akun = Akun::findOne(['id_akun' => $idAkun]);
        if (!$akun || $akun->status !== 'aktif') {
            $session->removeAll();
            Yii::$app->session->setFlash('error', 'Maaf, akun anda sedang dinonaktifkan. Silahkan menghubungi Admin Aldrin Terpadu. Terima kasih.');
            return $this->redirect(['/login'])->send();
        }

        return parent::beforeAction($action);
    }
    
    public function saveLogAktivitasTerpadu($action)
    {
        // Ambil ID akun dari session
        $idAkun = Yii::$app->session->get('id_akun');
        
        // Jika id_akun tidak ditemukan, kembalikan false
        if (!$idAkun) {
            return false;
        }
        
        // Buat objek model untuk log aktivitas
        $log = new LogAktivitasTerpadu();
        
        // Isi data log aktivitas
        $log->id_akun = $idAkun;
        $log->action = $action;
        $log->created_at = time(); // Menyimpan waktu sekarang
        
        // Simpan log ke database
        return $log->save();
    }
}
