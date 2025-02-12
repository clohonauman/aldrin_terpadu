<?php

use kartik\grid\GridView;
use yii\helpers\Html;
use yii\data\ActiveDataProvider;
use kartik\date\DatePicker;
use yii\widgets\Pjax;


/** @var yii\web\View $this */
/** @var app\models\MataPelajaranSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Daftar Mata Pelajaran';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="card">
    <div class="card-header">
        <div class="col-sm-12">
            <h1>
                <i class="fa fa-database icon-title"></i> Data Mata Pelajaran
            </h1>
        </div>
    </div>
    <div class="card-body">
        <?php date_default_timezone_set("Asia/Jakarta"); ?>
        <!-- Tabel Data PTK -->
        <div class="row mb-4">
            <div class="col-md-6 text-left">
                <h4><i class="fa fa-book"></i> Daftar Mata Pelajaran</h4>
            </div>
            <div class="col-md-6 text-right">
                <a href="<?= Yii::$app->urlManager->createUrl(['/mapel/create']) ?>" class="btn btn-primary">
                    <i class="fa fa-plus"></i> DATA
                </a>
            </div>
        </div>
        <hr>
        <div class="mata-pelajaran-index">
            <?php Pjax::begin(); ?>
            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'columns' => [
                    ['class' => 'kartik\grid\SerialColumn'],
                    'id',
                    'mata_pelajaran',
                    ['class' => 'kartik\grid\ActionColumn'],
                ],
                'toolbar' => [
                    '{export}',
                    '{toggleData}',
                ],
                'export' => [
                    'fontAwesome' => true,
                ],
                'pjax' => true,
            ]); ?>

            <?php Pjax::end(); ?>

        </div>

    </div>
</div>