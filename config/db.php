<?php
try {
    return [
        'class' => 'yii\db\Connection',
        'dsn' => 'mysql:host=' . '127.0.0.1' . ';port=' .'3306' . ';dbname=' . 'db_aldrin',
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
