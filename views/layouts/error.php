<?php

/** @var yii\web\View $this */
/** @var string $content */

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

$this->title = "Error - " . Html::encode($this->title);

?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>

<div class="error-container">
    <p><?= $content?></p>
</div>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
