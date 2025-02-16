<?php

namespace app\components;

use Yii;
use yii\web\Controller;
use yii\web\Response;
use app\models\Akun;

class BaseController extends Controller
{
    public function beforeAction($action)
    {
        $session = Yii::$app->session;
        $idAkun = $session->get('id_akun');
        $kodeAkses = $session->get('kode_akses');
        if ($idAkun === null || !in_array($kodeAkses, [0, 2, 3])) {
            $session->removeAll();
            Yii::$app->session->setFlash('error', 'Maaf, anda tidak dapat mengakses aplikasi ini. Silahkan login kembali atau hubungi Admin Aldrin Terpadu. Terima kasih.');
            return $this->redirect(['/login'])->send();
        }
        $akun = Akun::findOne(['id_akun' => $idAkun]);
        if (!$akun || $akun->status !== 'aktif') {
            $session->removeAll();
            Yii::$app->session->setFlash('error', 'Maaf, akun ada sedang di non-aktifkan. Silahkan menghubungi Admin Aldrin Terpadu. Terima kasih.');
            return $this->redirect(['/login'])->send();
        }

        return parent::beforeAction($action);
    }
}
