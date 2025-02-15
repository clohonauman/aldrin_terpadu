<?php
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
/** @var yii\web\View $this */
$this->title = 'DATA PTK';

// Ambil data filter dari tabel sekolah
$sekolahList = Yii::$app->db->createCommand("SELECT DISTINCT npsn, nama FROM sekolah ORDER BY nama")->queryAll();
?>

<div class="card">
    <div class="card-header">
    <div class="col-sm-12">
            <h1>
                <i class="fa fa-graphic icon-title"></i> ANALISIS KEBUTUHAN GURU
            </h1>
        </div>
    </div>
    <div class="card-body">
        <?php
        if(Yii::$app->session->get('kode_akses')!=3){
            ?>
            <!-- Form Filter -->
            <div class="row">
                <div class="col-md-6 text-left">
                    <h4><i class="fa fa-search"></i> FILTER</h4>
                </div>
            </div>
            <form method="GET">
                <div class="row">
                    <div class="row">
                        <div class="col-md-4">
                            <label><b>Sekolah <span class="text-danger">*</span></b></label>
                            <?= Select2::widget([
                                'name' => 'id',
                                'data' => ArrayHelper::map($sekolahList, 'npsn', 'nama'),
                                'options' => ['placeholder' => '- Pilih Sekolah -'],
                                'pluginOptions' => [
                                    'allowClear' => true
                                ],
                            ]); ?>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-auto">
                            <label>&nbsp;</label>
                            <button type="submit" class="btn btn-primary btn-block"><i class="fa fa-search"></i> CARI</button>
                        </div>
                    </div>
                </div>
            </form>
            <hr>
            <?php
        }
        ?>
        <?php date_default_timezone_set("Asia/Jakarta"); ?>
        <section class="content">
            <div class="row">
                <div class="col-lg-12 col-xs-12">
                    <div class="card alert alert-danger alert-dismissable">
                        <b><i class="fa fa-warning"></i> Perhatian!</b>
                        <p style="font-size:15px">
                            Pada bagian ini ditampilkan data Analisis Kebutuhan Guru sesuai Data Pembelajaran yang telah dimasukkan oleh operator sekolah. 
                            Jika terdapat data yang tidak lengkap, harap meminta pihak sekolah untuk segera 
                            melengkapinya. Terima kasih.
                        </p>        
                    </div>
                </div>
            </div>
            <hr>
            <!-- Tabel Data PTK -->
            <div class="table-responsive">
                <table id="myTable" class="table table-striped table-bordered">
                    <thead>
        <tr>
            <th rowspan="2">No</th>
            <th rowspan="2">Mata Pelajaran</th>
            <?php for ($i = 1; $i <= 9; $i++) : ?>
                <th colspan="3">Tingkat <?= $i ?></th>
            <?php endfor; ?>
            <th rowspan="2">Total Hasil</th>
            <th rowspan="2">Rasio</th>
            <th rowspan="2">Rasio Rounded</th>
            <th colspan="4">Jumlah PTK (Existing)</th>
            <th rowspan="2">Kebutuhan</th>
            <!-- <th rowspan="2">Analisis</th> -->
        </tr>
        <tr>
            <?php for ($i = 1; $i <= 9; $i++) : ?>
                <th>JJM</th>
                <th>ROMBEL</th>
                <th>HASIL</th>
            <?php endfor; ?>
            <th>PNS</th>
            <th>PPPK</th>
            <th>NON ASN</th>
            <th>TOTAL</th>
        </tr>
    </thead>
    <tbody>
        <?php $no = 1; ?>
        <?php foreach ($data as $mapel) : ?>
            <tr>
                <td><?= $no++ ?></td>
                <td><?= $mapel['nama_mapel'] ?></td>
                <?php foreach ($mapel['tingkat_pendidikan'] as $tingkat) : ?>
                    <td><?= $tingkat['total_jam_mengajar'] ?></td>
                    <td><?= $tingkat['jumlah_rombel'] ?></td>
                    <td><?= $tingkat['total_jam_mengajar'] * ($tingkat['jumlah_rombel'] ?: 1) ?></td>
                <?php endforeach; ?>
                <td><?= $mapel['total_hasil'] ?></td> <!-- Rasio -->
                <td><?= $mapel['rasio'] ?></td> <!-- Rasio -->
                <td><?= $mapel['rasio_rounded'] ?></td> <!-- Rasio Rounded -->
                <td><?= $mapel['pns'] ?></td> <!-- PNS -->
                <td><?= $mapel['pppk'] ?></td> <!-- PPPK -->
                <td><?= $mapel['non_asn'] ?></td> <!-- NON ASN -->
                <td><?= $mapel['total_ptk'] ?></td> <!-- TOTAL -->
                <td><?= $mapel['rasio_rounded']-$mapel['total_ptk'] ?></td> <!-- Kebutuhan -->
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>
            </div>
        </section>
    </div>
</div>