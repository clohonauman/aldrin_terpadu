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
        if (Yii::$app->session->get('kode_akses') != 3) {
            $sekolahId = Yii::$app->request->get('id');
        } else {
            $sekolahId = Yii::$app->session->get('id_sekolah');
        }
    
        $mapelList = (new \yii\db\Query())
            ->select([
                'mapel.mata_pelajaran AS nama_mapel',
                'pembelajaran.mata_pelajaran_id',
                'pembelajaran.ptk_id'
            ])
            ->from('pembelajaran')
            ->leftJoin('mata_pelajaran AS mapel', 'mapel.id = pembelajaran.mata_pelajaran_id')
            ->where(['pembelajaran.sekolah_id' => $sekolahId])
            ->groupBy(['mapel.mata_pelajaran', 'pembelajaran.mata_pelajaran_id'])
            ->orderBy(['mapel.mata_pelajaran' => SORT_ASC]) // Urutkan berdasarkan nama_mapel (mata pelajaran)
            ->all();
    
        $data = [];
    
        foreach ($mapelList as $mapel) {
            $mapelData = [
                'mata_pelajaran_id' => $mapel['mata_pelajaran_id'],
                'nama_mapel' => $mapel['nama_mapel'],
                'tingkat_pendidikan' => [],
                'total_hasil' => 0,
                'rasio' => 0
            ];
    
            for ($tingkat = 1; $tingkat <= 9; $tingkat++) {
                $result = (new \yii\db\Query())
                    ->select([
                        'SUM(pembelajaran.jam_mengajar_per_minggu) AS total_jam_mengajar',
                    ])
                    ->from('pembelajaran')
                    ->innerJoin('rombongan_belajar AS rb', 'rb.rombongan_belajar_id = pembelajaran.rombongan_belajar_id')
                    ->where([
                        'pembelajaran.sekolah_id' => $sekolahId,
                        'pembelajaran.mata_pelajaran_id' => $mapel['mata_pelajaran_id'],
                        'rb.tingkat_pendidikan' => $tingkat
                    ])
                    ->one();
                    
                if ($result['total_jam_mengajar'] > 0) {
                    $result2 = (new \yii\db\Query())
                        ->select([
                            'COUNT(DISTINCT rombongan_belajar.rombongan_belajar_id) AS jumlah_rombel'
                        ])
                        ->from('rombongan_belajar')
                        ->where([
                            'rombongan_belajar.sekolah_id' => $sekolahId,
                            'rombongan_belajar.mata_pelajaran_id' => $mapel['mata_pelajaran_id'],
                            'rombongan_belajar.tingkat_pendidikan' => $tingkat
                        ])
                        ->one();
                } else {
                    $result2['jumlah_rombel'] = 0;
                }

                $pns = (new \yii\db\Query())
                        ->select([
                            'COUNT(DISTINCT pembelajaran.ptk_id) AS pns'
                        ])
                        ->from('pembelajaran')
                        ->innerJoin('ptk', 'ptk.ptk_id = pembelajaran.ptk_id')
                        ->where([
                            'ptk.status_kepegawaian' => 'PNS',
                            'pembelajaran.sekolah_id' => $sekolahId,
                            'pembelajaran.mata_pelajaran_id' => $mapel['mata_pelajaran_id']
                        ])
                        ->one();
                $pppk = (new \yii\db\Query())
                        ->select([
                            'COUNT(DISTINCT pembelajaran.ptk_id) AS pppk'
                        ])
                        ->from('pembelajaran')
                        ->innerJoin('ptk', 'ptk.ptk_id = pembelajaran.ptk_id')
                        ->where([
                            'ptk.status_kepegawaian' => 'PPPK',
                            'pembelajaran.sekolah_id' => $sekolahId,
                            'pembelajaran.mata_pelajaran_id' => $mapel['mata_pelajaran_id']
                        ])
                        ->one();
                $non_asn = (new \yii\db\Query())
                        ->select([
                            'COUNT(DISTINCT pembelajaran.ptk_id) AS non_asn'
                        ])
                        ->from('pembelajaran')
                        ->innerJoin('ptk', 'ptk.ptk_id = pembelajaran.ptk_id')
                        ->where([
                            'pembelajaran.sekolah_id' => $sekolahId,
                            'pembelajaran.mata_pelajaran_id' => $mapel['mata_pelajaran_id']
                        ])
                        ->andWhere(['NOT IN', 'ptk.status_kepegawaian', ['PNS', 'PPPK']])
                        ->one();
            
                $mapelData['pns'] = $pns['pns'];
                $mapelData['pppk'] = $pppk['pppk'];
                $mapelData['non_asn'] = $non_asn['non_asn'];
                $mapelData['total_ptk'] = $pns['pns']+$pppk['pppk']+$non_asn['non_asn'];
            
                $hasil = $result['total_jam_mengajar'] * $result2['jumlah_rombel'];
                $mapelData['total_hasil'] += $hasil;

                $mapelData['tingkat_pendidikan'][] = [
                    'tingkat' => $tingkat,
                    'total_jam_mengajar' => $result['total_jam_mengajar'],
                    'jumlah_rombel' => $result2['jumlah_rombel'] ?? 0,
                ];
            }
    
            $mapelData['rasio'] = $mapelData['total_hasil'] / 24;
            $mapelData['rasio_rounded'] = max(1, floor($mapelData['rasio']));
            $data[] = $mapelData;
        }

        return $this->render('index', [
            'data' => $data
        ]);
    }
}
