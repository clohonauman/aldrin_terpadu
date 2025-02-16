<?php

namespace app\controllers;

use Yii;
use app\models\Akun;
use app\models\Peran;
use app\components\BaseController;

class ProfilController extends BaseController
{
    public function actionIndex()
    {
        $idAkun = Yii::$app->session->get('id_akun');
        if (!$idAkun) {
            return $this->redirect(['/']);
        }
        $data = Akun::find()
            ->where(['id_akun' => $idAkun])
            ->with('peran')
            ->asArray()
            ->one();

        return $this->render('index', [
            'data' => $data
        ]);
    }
    public function actionUpdate()
    {
        $idAkun = Yii::$app->session->get('id_akun');
        if (!$idAkun) {
            return $this->redirect(['/']);
        }
        if (Yii::$app->request->isPost) {
            $postData = Yii::$app->request->post('Akun');
            $email = $postData['email'];
            $cekEmail = Akun::find()
                ->where(['email' => $email])
                ->andWhere(['!=', 'id_akun', $idAkun])
                ->exists();
        
            if ($cekEmail) {
                Yii::$app->session->setFlash('error', 'Email sudah digunakan oleh akun lain.');
                return $this->redirect(['profil/index']);
            }
            return $this->updatedManual($postData, $idAkun);
        } else {
            $akun = new Akun;
            $peran = new Peran;

            $data = Akun::find()
                ->where(['id_akun' => $idAkun])
                ->with('peran')
                ->asArray()
                ->one();
    
            return $this->render('update', [
                'data' => $data,
                'akun' => $akun,
                'peran' => $peran,
            ]);
        }
    }    
    
    protected function updatedManual($postData, $idAkun)
    {
        if (isset($postData['email']) && AKun::find()->where(['email' => $postData['email']])->andWhere(['!=', 'id_akun', $idAkun])->exists()) {
            Yii::$app->session->setFlash('error', 'Email sudah pernah terdaftar.');
            return $this->redirect(['profil']);
        }
        $akun = Akun::findOne($idAkun);
        if (!$akun) {
            Yii::$app->session->setFlash('error', 'Data pengguna tidak ditemukan.');
            return $this->redirect(['index']);
        }
    
        // Update data PTK
        $akun->nama_pengguna = $postData['nama_pengguna'] ?? $akun->nama_pengguna;
        $akun->email = $postData['email'] ?? $akun->email;
        $akun->kata_sandi = isset($postData['kata_sandi']) && !empty($postData['kata_sandi']) 
                            ? Yii::$app->security->generatePasswordHash($postData['kata_sandi']) 
                            : $akun->kata_sandi;
    
        if ($akun->save()) {
            Yii::$app->session->setFlash('success', 'Data berhasil diperbarui.');
        } else {
            Yii::$app->session->setFlash('error', 'Terjadi kesalahan saat menyimpan data.');
        }
        
        return $this->redirect(['index']);
    } 
}
