<?php

/** @var yii\web\View $this */
/** @var string $content */

use app\assets\AppAsset;
use app\widgets\Alert;
use yii\bootstrap5\Breadcrumbs;
use yii\bootstrap5\Html;

AppAsset::register($this);

$this->registerCsrfMetaTags();
$this->registerMetaTag(['charset' => Yii::$app->charset], 'charset');
$this->registerMetaTag(['name' => 'viewport', 'content' => 'width=device-width, initial-scale=1, shrink-to-fit=no']);
$this->registerMetaTag(['name' => 'description', 'content' => $this->params['meta_description'] ?? '']);
$this->registerMetaTag(['name' => 'keywords', 'content' => $this->params['meta_keywords'] ?? '']);
$this->registerLinkTag(['rel' => 'icon', 'type' => 'image/x-icon', 'href' => Yii::getAlias('@web/favicon.png')]);
$this->registerCssFile('https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css', [
    'depends' => [\yii\web\JqueryAsset::class],
]);
$this->registerJsFile('https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js', [
    'depends' => [\yii\web\JqueryAsset::class],
]);
$this->registerCssFile('https://cdn.datatables.net/buttons/2.3.6/css/buttons.dataTables.min.css', [
    'depends' => [\yii\web\JqueryAsset::class],
]);
$this->registerJsFile('https://cdn.datatables.net/buttons/2.3.6/js/dataTables.buttons.min.js', [
    'depends' => [\yii\web\JqueryAsset::class],
]);
$this->registerJsFile('https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js', [
    'depends' => [\yii\web\JqueryAsset::class],
]);
$this->registerJsFile('https://cdn.datatables.net/buttons/2.3.6/js/buttons.html5.min.js', [
    'depends' => [\yii\web\JqueryAsset::class],
]);

$this->registerJs(<<<JS
$(document).ready(function () {
    $('#myTable').DataTable({
        "paging": true,
        "searching": true,
        "ordering": true,
        "responsive": true,
        "language": {
            "sProcessing":   "Sedang memproses...",
            "sLengthMenu":   "Tampilkan _MENU_ data",
            "sZeroRecords":  "Tidak ditemukan data yang sesuai",
            "sInfo":         "Menampilkan _START_ sampai _END_ dari _TOTAL_ data",
            "sInfoEmpty":    "Menampilkan 0 sampai 0 dari 0 data",
            "sInfoFiltered": "(disaring dari _MAX_ data keseluruhan)",
            "sSearch":       "Cari:",
            "oPaginate": {
                "sFirst":    "Awal",
                "sPrevious": "Sebelumnya",
                "sNext":     "Berikutnya",
                "sLast":     "Akhir"
            }
        },
        dom: 'Bfrtip', // Tambahkan tombol
        buttons: [
            {
                extend: 'excelHtml5',
                text: 'Unduh Excel',
                className: 'btn btn-success',
                title: 'ALDRIN TERPADU-' + new Date().getTime()
            }
        ]
    });
});
JS);

$kodeAkses = Yii::$app->session->get('kode_akses');
$roles = [
    0 => 'Super Admin',
    1 => 'Admin',
    3 => 'Operator Sekolah',
];

?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
    <head>
        <title><?= Html::encode($this->title) ?> | <?= getenv('APP_NAME') ?></title>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/css/adminlte.min.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
        <?php $this->head() ?>
    </head>
    <body class="hold-transition sidebar-mini layout-fixed">
        <?php $this->beginBody() ?>
        <div class="wrapper">
            
            <!-- Navbar -->
            <nav class="main-header navbar navbar-expand navbar-dark position-fixed w-100 top-0">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
                    </li>
                </ul>
            </nav>
            
            <!-- Sidebar -->
            <aside class="main-sidebar sidebar-dark-primary elevation-5">
                <a href="#" class="brand-link text-center text-decoration-none p-0">
                    <img class="w-75 m-0 p-0" src="<?= Yii::getAlias('@web') ?>/app_logo.png" alt="<?= getenv('APP_NAME') ?>">
                    <hr>
                    <p class="fst-italic fs-6 mt-0"><?= isset($roles[$kodeAkses]) ? $roles[$kodeAkses] : 'Tidak Diketahui'; ?></p>
                </a>

                <div class="sidebar overflow-auto">
                    <nav class="mt-2">
                        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu">
                            <li class="nav-item">
                                <a href="<?= Yii::$app->urlManager->createUrl(['/beranda']) ?>" class="nav-link">
                                    <i class="nav-icon fas fa-home"></i>
                                    <p>Beranda</p>
                                </a>
                            </li>
                            <li class="nav-header"><hr></li>
                            <li class="nav-item has-treeview">
                                <a href="#" class="nav-link">
                                    <i class="nav-icon fas fa-database"></i>
                                    <p>Master Data <i class="right fas fa-angle-left"></i></p>
                                </a>
                                <ul class="nav nav-treeview">
                                    <li class="nav-item">
                                        <a href="<?= Yii::$app->urlManager->createUrl(['/ptk']) ?>" class="nav-link">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>Data PTK</p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="<?= Yii::$app->urlManager->createUrl(['/siswa']) ?>" class="nav-link">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>Data Siswa</p>
                                        </a>
                                    </li>
                                    <?php
                                    if(Yii::$app->session->get('kode_akses')!=3){
                                        ?>
                                        <li class="nav-item">
                                            <a href="<?= Yii::$app->urlManager->createUrl(['/mapel']) ?>" class="nav-link">
                                                <i class="far fa-circle nav-icon"></i>
                                                <p>Data Mata Pelajaran</p>
                                            </a>
                                        </li>
                                        <?php
                                    }
                                    ?>
                                    <li class="nav-item">
                                        <a href="<?= Yii::$app->urlManager->createUrl(['/rombel']) ?>" class="nav-link">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>Data Rombel</p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="<?= Yii::$app->urlManager->createUrl(['/pembelajaran']) ?>" class="nav-link">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>Data Pembelajaran</p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="<?= Yii::$app->urlManager->createUrl(['/sekolah']) ?>" class="nav-link">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>Data Sekolah</p>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                            <li class="nav-item">
                                <a href="<?= Yii::$app->urlManager->createUrl(['/akg']) ?>" class="nav-link">
                                    <i class="nav-icon fas fa-line-chart"></i>
                                    <p>Analisis Keb. Guru</p>
                                </a>
                            </li>
                            <?php
                            if(Yii::$app->session->get('kode_akses')==0){
                                ?>
                                <li class="nav-item">
                                    <a href="<?= Yii::$app->urlManager->createUrl(['/manajemen_pengguna']) ?>" class="nav-link">
                                        <i class="nav-icon fas fa-users-cog"></i>
                                        <p>Manajemen Pengguna</p>
                                    </a>
                                </li>
                                <?php
                            }
                            ?>
                            <li class="nav-header"><hr></li>
                            <li class="nav-item">
                                <a href="<?= Yii::$app->urlManager->createUrl(['/profil']) ?>" class="nav-link">
                                    <i class="nav-icon fas fa-user-cog"></i>
                                    <p>Pengaturan Profil</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="<?= Yii::$app->urlManager->createUrl(['/login/logout']) ?>" class="nav-link">
                                    <i class="nav-icon fas fa-sign-out"></i>
                                    <p>Keluar</p>
                                </a>
                            </li>
                        </ul>
                    </nav>
                </div>
            </aside>
            
            <!-- Content Wrapper -->
            <div class="content-wrapper pt-4">
                <section class="content mt-4 pt-4">
                    <div class="container-fluid">
                        <?= Alert::widget() ?>
                        <?= $content ?>
                    </div>
                </section>
            </div>
            
            <!-- Footer -->
            <footer class="main-footer text-left">
                <strong>&copy; Dinas Pendidikan Kabupaten Minahasa Utara <?= date('Y') ?></strong>
            </footer>
        </div>

        <script src="https://cdn.jsdelivr.net/npm/jquery/dist/jquery.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/js/adminlte.min.js"></script>
        <?php $this->endBody() ?>
    </body>
</html>
<?php $this->endPage() ?>