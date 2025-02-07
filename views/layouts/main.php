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
$this->registerLinkTag(['rel' => 'icon', 'type' => 'image/x-icon', 'href' => Yii::getAlias('@web/favicon.ico')]);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
    <head>
        <title><?= Html::encode($this->title) ?></title>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/css/adminlte.min.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
        <?php $this->head() ?>
    </head>
    <body class="hold-transition sidebar-mini layout-fixed">
        <?php $this->beginBody() ?>
        <div class="wrapper">
            
            <!-- Navbar -->
            <nav class="main-header navbar navbar-expand navbar-dark">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
                    </li>
                </ul>
            </nav>
            
            <!-- Sidebar -->
            <aside class="main-sidebar sidebar-dark-primary elevation-5">
                <a href="#" class="brand-link text-center text-decoration-none">
                    <span class="brand-text font-weight"><?= getenv('APP_NAME') ?></span>
                </a>

                <div class="sidebar">
                    <nav class="mt-2">
                        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu">
                            <li class="nav-item">
                                <a href="<?= Yii::$app->urlManager->createUrl(['/beranda']) ?>" class="nav-link">
                                    <i class="nav-icon fas fa-home"></i>
                                    <p>Beranda</p>
                                </a>
                            </li>
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
                                    <li class="nav-item">
                                        <a href="<?= Yii::$app->urlManager->createUrl(['/mata_pelajaran']) ?>" class="nav-link">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>Data Mata Pelajaran</p>
                                        </a>
                                    </li>
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
                            <li class="nav-item">
                                <a href="<?= Yii::$app->urlManager->createUrl(['/logout']) ?>" class="nav-link">
                                    <i class="nav-icon fas fa-sign-out-alt"></i>
                                    <p>Keluar</p>
                                </a>
                            </li>
                        </ul>
                    </nav>
                </div>
            </aside>
            
            <!-- Content Wrapper -->
            <div class="content-wrapper">
                <div class="content-header">
                    <div class="container-fluid">
                        <div class="row mb-2">
                            <div class="col-sm-6">
                                <h1 class="m-0"><?= Html::encode($this->title) ?></h1>
                            </div>
                        </div>
                    </div>
                </div>
                <section class="content">
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