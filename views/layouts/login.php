<?php

/** @var yii\web\View $this */
/** @var string $content */

use app\assets\AppAsset;
use yii\bootstrap5\Html;

AppAsset::register($this);

$this->registerCsrfMetaTags();
$this->registerMetaTag(['charset' => Yii::$app->charset], 'charset');
$this->registerMetaTag(['name' => 'viewport', 'content' => 'width=device-width, initial-scale=1, shrink-to-fit=no']);
$this->registerMetaTag(['name' => 'description', 'content' => $this->params['meta_description'] ?? '']);
$this->registerMetaTag(['name' => 'keywords', 'content' => $this->params['meta_keywords'] ?? '']);
$this->registerLinkTag(['rel' => 'icon', 'type' => 'image/x-icon', 'href' => Yii::getAlias('@web/favicon.png')]);

?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
    <style>
        /* Background Gradient */
        body {
            background: linear-gradient(135deg, #1d3557, #457b9d, #a8dadc);
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Poppins', sans-serif;
        }

        /* Login Container */
        .login-container {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            border-radius: 10px;
            padding: 40px;
            max-width: 400px;
            width: 100%;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
            text-align: center;
            animation: fadeIn 0.7s ease-in-out;
        }

        /* Animasi Fade In */
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(-30px); }
            to { opacity: 1; transform: translateY(0); }
        }

        /* Input Styling */
        .form-control {
            background: rgba(255, 255, 255, 0.3);
            border: none;
            border-radius: 25px;
            padding: 12px 15px;
            color: white;
        }
        .form-control::placeholder {
            color: rgba(255, 255, 255, 0.7);
        }

        /* Button Styling */
        .btn-primary {
            background: #1d3557;
            border: none;
            border-radius: 25px;
            padding: 12px;
            transition: 0.3s;
        }
        .btn-primary:hover {
            background: #457b9d;
            transform: scale(1.05);
        }
    </style>
</head>
<body>
<?php $this->beginBody() ?>

<div class="login-container">
    <h3 class="mb-3 text-white">ALDRIN TERPADU</h3>
    <?= $content ?>
</div>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
