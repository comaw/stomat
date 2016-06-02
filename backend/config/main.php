<?php
$params = array_merge(
    require(__DIR__ . '/../../common/config/params.php'),
    require(__DIR__ . '/../../common/config/params-local.php'),
    require(__DIR__ . '/params.php'),
    require(__DIR__ . '/params-local.php')
);

return [
    'id' => 'app-backend',
    'basePath' => dirname(__DIR__),
    'controllerNamespace' => 'backend\controllers',
    'bootstrap' => ['log'],
    'sourceLanguage'=>'en_US',
    'language' => 'ru',
    'charset' => 'UTF-8',
    'timeZone' => 'Europe/Kiev',
    'name' => \Yii::t('app', 'Админка'),
    'modules' => [
        'gii' => [
            'class' => 'yii\gii\Module',
            'allowedIPs' => ['127.0.0.1', '::1']
        ],
    ],
    'components' => [
        'assetManager' => [
            'bundles' => [
//                'yii\web\JqueryAsset' => [
//                    'sourcePath' => null,
//                    'js' => ['template/jquery.min.js']
//                ],
                'yii\bootstrap\BootstrapPluginAsset' => [
                    'js'=>[]
                ],
                'yii\bootstrap\BootstrapAsset' => [
                    'sourcePath' => null,
                    'css' => ['template/bootstrap.min.css'],
                    'js' => ['tinymce/bootstrap.js'],
                ],
            ],
        ],
        'cache' => [
//            'class' => 'yii\caching\DbCache',
            // 'db' => 'mydb',
            // 'cacheTable' => 'my_cache',
        ],
        'cacheFile' => [
            'class' => 'yii\caching\FileCache',
        ],
        'request' => [
            'enableCsrfValidation' => false,
            'cookieValidationKey' => 'jksh3786($(W^',
            'baseUrl' => '/admin',
        ],
        'user' => [
            'identityClass' => 'common\models\User',
            'enableAutoLogin' => true,
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'db' => require(__DIR__ . '/../../frontend/config/db.php'),
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'enableStrictParsing' => true,
            'baseUrl' => '/admin',
            'suffix' => '/',
            'scriptUrl'=>'/backend/index.php',
            'rules' => [
                '' => 'settings/index',
                'item/index' => 'item/index',
                'item/<id:\d+>' => 'item/view',
                'item/create' => 'item/create',
                'item/update' => 'item/update',
                'item/<id:\d+>/<action:(create|update|delete)>' => 'item/<action>',
                'item/price' => 'item/price',
                'item/excel' => 'item/excel',
                'item/import' => 'item/import',
                'item/imgdelete' => 'item/imgdelete',
                'item/edit' => 'item/edit',
                'item/<url:.+>' => 'item/view',


                '<controller:\w+>/<id:\d+>/<action:(create|update|delete)>' => '<controller>/<action>',
                '<controller:\w+>/<action:\w+>' => '<controller>/<action>',
                '<controller:\w+>' => '<controller>/index',
            ],
        ],
    ],
    'params' => $params,
];
