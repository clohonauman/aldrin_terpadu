<?php
try {
    return [
        'class' => 'yii\db\Connection',
        'dsn' => 'mysql:host=' . $_ENV['DB_HOSTNAME'] . ';port=' . $_ENV['DB_PORT'] . ';dbname=' . $_ENV['DB_NAME'],
        'username' => $_ENV['DB_USERNAME'],
        'password' => $_ENV['DB_PASSWORD'],
        'charset' => 'utf8',
        // Schema cache options (for production environment)
        //'enableSchemaCache' => true,
        //'schemaCacheDuration' => 60,
        //'schemaCache' => 'cache',
    ];
} catch (\Throwable $th) {
    Yii::$app->response->statusCode = 500;
    echo Yii::$app->controller->render('@app/views/site/error', ['exception' => $th]);
    exit;
}
