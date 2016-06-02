<?php
$params = array_merge(
    require(__DIR__ . '/../../common/config/params.php'),
    require(__DIR__ . '/../../common/config/params-local.php'),
    require(__DIR__ . '/params.php'),
    require(__DIR__ . '/params-local.php')
);

return [
    'id' => 'app-console',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'sourceLanguage'=>'en_US',
    'language' => 'ru',
    'charset' => 'UTF-8',
    'timeZone' => 'Europe/Kiev',
    'controllerNamespace' => 'console\controllers',
    'components' => [
        'cache' => [
            'class' => 'yii\caching\DbCache',
            // 'db' => 'mydb',
            // 'cacheTable' => 'my_cache',
        ],
        'cacheFile' => [
            'class' => 'yii\caching\FileCache',
        ],
        'db' => require(__DIR__ . '/../../frontend/config/db.php'),
        'log' => [
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
    ],
    'params' => $params,
];
