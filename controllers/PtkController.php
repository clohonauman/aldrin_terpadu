<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use yii\web\UploadedFile;
use app\models\UploadForm;
use app\models\Ptk;
use moonland\phpexcel\Excel;

class PtkController extends Controller
{
    public function actionIndex()
    {
        $query = (new \yii\db\Query())
            ->select([
                'ptk.*',
                'sekolah.nama AS nama_sekolah',
                'sekolah.bentuk_pendidikan',
                'sekolah.status_sekolah',
                'sekolah.kecamatan',
                'TIMESTAMPDIFF(YEAR, ptk.tanggal_lahir, CURDATE()) AS usia_sekarang' // Menghitung usia saat ini
            ])
            ->from('ptk')
            ->leftJoin('sekolah', 'sekolah.npsn = ptk.sekolah_id');
    
        // Filter berdasarkan bentuk_pendidikan
        if (!empty($_GET['bentuk_pendidikan'])) {
            $query->andWhere(['sekolah.bentuk_pendidikan' => $_GET['bentuk_pendidikan']]);
        }
    
        // Filter berdasarkan kecamatan
        if (!empty($_GET['kecamatan'])) {
            $query->andWhere(['sekolah.kecamatan' => $_GET['kecamatan']]);
        }
    
        // Filter berdasarkan waktu pensiun
        if (!empty($_GET['pensiun'])) {
            $tahun_ke_depan = (int)$_GET['pensiun'];
            $usia_pensiun = 60; // Misalnya usia pensiun adalah 60 tahun
            $tahun_sekarang = date('Y');
    
            // Menghitung tahun lahir minimum yang akan mencapai usia pensiun dalam X tahun
            $tahun_lahir_maks = $tahun_sekarang - ($usia_pensiun - $tahun_ke_depan);
    
            $query->andWhere(['<=', 'YEAR(ptk.tanggal_lahir)', $tahun_lahir_maks]);
        }
    
        $data = $query->all();
    
        return $this->render('index', ['data' => $data]);
    }
    
    public function actionUpload()
    {
        $model = new UploadForm();

        if (Yii::$app->request->isPost) {
            $model->file = UploadedFile::getInstance($model, 'file');
            
            if ($model->file) {
                // Proses langsung tanpa menyimpan file
                return $this->importExcel($model->file->tempName);
            }
        }

        return $this->render('upload', ['model' => $model]);
    }

    protected function importExcel($tempFilePath)
    {
        $data = Excel::import($tempFilePath, [
            'setFirstRecordAsKeys' => true,
        ]);

        foreach ($data as $row) {
            // Cek apakah NIK sudah ada di database
            if (isset($row['NIK']) && Ptk::find()->where(['nik' => $row['NIK']])->exists()) {
                continue; // Skip jika NIK sudah ada
            }

            $ptk = new Ptk();
            $ptk->ptk_id = $this->generateUuid(); // Tambahkan UUID sebagai ptk_id
            $ptk->nama = $row['Nama'] ?? null;
            $ptk->nik = $row['NIK'] ?? null;
            $ptk->nuptk = isset($row['NUPTK']) ? trim($row['NUPTK']) : null;
            $ptk->nip = $row['NIP'] ?? null;
            $ptk->jenis_kelamin = $row['L/P'] ?? null;
            $ptk->tempat_lahir = $row['Tempat Lahir'] ?? null;
            $ptk->tanggal_lahir = isset($row['Tanggal Lahir']) ? date('Y-m-d', strtotime($row['Tanggal Lahir'])) : null;
            $ptk->status_keaktifan = $row['Status Tugas'] ?? null;
            $ptk->sekolah_id = $row['NPSN'] ?? null;
            $ptk->kecamatan = $row['Kecamatan'] ?? null;
            $ptk->kabupaten = $row['Kabupaten/Kota'] ?? null;
            $ptk->no_hp = $row['Nomor HP'] ?? null;
            $ptk->sk_cpns = $row['SK CPNS'] ?? null;
            $ptk->tgl_cpns = isset($row['Tanggal CPNS']) ? date('Y-m-d', strtotime($row['Tanggal CPNS'])) : null;
            $ptk->sk_pengangkatan = $row['SK Pengangkatan'] ?? null;
            $ptk->tmt_pengangkatan = isset($row['TMT Pengangkatan']) ? date('Y-m-d', strtotime($row['TMT Pengangkatan'])) : null;
            $ptk->jenis_ptk = $row['Jenis PTK'] ?? null;
            $ptk->jabatan = $row['Jabatan PTK'] ?? null;
            $ptk->status_kepegawaian = $row['Status Kepegawaian'] ?? null;
            $ptk->pangkat_golongan = $row['Pangkat/Gol'] ?? null;
            $ptk->save(false);
        }

        Yii::$app->session->setFlash('success', 'Data berhasil diunggah!');
        return $this->redirect(['upload']);
    }

    private function generateUuid()
    {
        return sprintf(
            '%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
            mt_rand(0, 0xffff), mt_rand(0, 0xffff),
            mt_rand(0, 0xffff),
            mt_rand(0, 0x0fff) | 0x4000,
            mt_rand(0, 0x3fff) | 0x8000,
            mt_rand(0, 0xffff), mt_rand(0, 0xffff), mt_rand(0, 0xffff)
        );
    }
}
