<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use app\models\Pembelajaran;
use app\models\MataPelajaran as Mapel;
use app\models\RombonganBelajar;
use app\models\Ptk;

class AkgController extends Controller
{
    public function actionIndex()
    {
        if(Yii::$app->session->get('kode_akses')!=3){
            $sekolahId = Yii::$app->request->get('id');
        }else{
            $sekolahId = Yii::$app->session->get('id_sekolah');
        }

        // Ambil bentuk pendidikan sekolah (SD atau SMP)
        $sekolah = Yii::$app->db->createCommand("
            SELECT bentuk_pendidikan FROM sekolah WHERE npsn = :id
        ")->bindValue(':id', $sekolahId)->queryOne();

        $bentukPendidikan = $sekolah['bentuk_pendidikan'] ?? '';

        // Tentukan tingkat pendidikan berdasarkan bentuk sekolah
        $tingkatPendidikan = (stripos($bentukPendidikan, 'SD') !== false) ? range(1, 6) : range(7, 9);

        // Ambil data pembelajaran
        $data = Pembelajaran::find()
            ->select([
                'mapel.mata_pelajaran AS nama_mapel',
                'pembelajaran.mata_pelajaran_id',
                'pembelajaran.jam_mengajar_per_minggu'
            ])
            ->distinct()
            ->alias('pembelajaran')
            ->leftJoin('mata_pelajaran AS mapel', 'mapel.id = pembelajaran.mata_pelajaran_id')
            ->where(['pembelajaran.sekolah_id' => $sekolahId])
            ->asArray()
            ->all();

        // Ambil jumlah rombel berdasarkan tingkat pendidikan
        $rombelData = [];
        foreach ($tingkatPendidikan as $tingkat) {
            $rombelData[$tingkat] = Pembelajaran::find()
                ->select([
                    'pembelajaran.mata_pelajaran_id',
                    'COUNT(DISTINCT pembelajaran.rombongan_belajar_id) AS jumlah_rombel'
                ])
                ->alias('pembelajaran')
                ->leftJoin('rombongan_belajar AS rb', 'rb.rombongan_belajar_id = pembelajaran.rombongan_belajar_id')
                ->where([
                    'rb.tingkat_pendidikan' => $tingkat,
                    'pembelajaran.sekolah_id' => $sekolahId
                ])
                ->groupBy('pembelajaran.mata_pelajaran_id')
                ->indexBy('mata_pelajaran_id')
                ->asArray()
                ->all();
        }

        // Ambil jumlah PTK berdasarkan status kepegawaian
        $ptkData = Pembelajaran::find()
                ->select([
                    'pembelajaran.mata_pelajaran_id',
                    'COUNT(DISTINCT CASE WHEN ptk.status_kepegawaian = "PNS" THEN pembelajaran.ptk_id END) AS pns',
                    'COUNT(DISTINCT CASE WHEN ptk.status_kepegawaian = "PPPK" THEN pembelajaran.ptk_id END) AS pppk',
                    'COUNT(DISTINCT CASE WHEN ptk.status_kepegawaian NOT IN ("PNS","PPPK") THEN pembelajaran.ptk_id END) AS non_asn',
                    'COUNT(DISTINCT pembelajaran.ptk_id) AS total_ptk'
                ])
                ->alias('pembelajaran')
                ->leftJoin('ptk', 'ptk.ptk_id = pembelajaran.ptk_id')
                ->where(['pembelajaran.sekolah_id' => $sekolahId])
                ->groupBy('pembelajaran.mata_pelajaran_id')
                ->indexBy('mata_pelajaran_id')
                ->asArray()
                ->all();
    

        // Total PTK tanpa duplikasi di seluruh sekolah
        $totalPtk = Pembelajaran::find()
            ->select(['COUNT(DISTINCT pembelajaran.ptk_id) AS total_ptk'])
            ->alias('pembelajaran')
            ->where(['pembelajaran.sekolah_id' => $sekolahId])
            ->scalar();

        return $this->render('index', [
            'data' => $data,
            'rombelData' => $rombelData,
            'ptkData' => $ptkData,
            'totalPtk' => $totalPtk
        ]);
    }
}
