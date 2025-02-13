<?php
try {
    return [
        'class' => 'yii\db\Connection',
        'dsn' => 'mysql:host=' . getenv('DB_HOSTNAME') . ';port=' . getenv('DB_PORT') . ';dbname=' . getenv('DB_NAME'),
        'username' => 'root',
        'password' => '',
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
