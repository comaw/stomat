<?php
$params = array_merge(
    require(__DIR__ . '/../../common/config/params.php'),
    require(__DIR__ . '/../../common/config/params-local.php'),
    require(__DIR__ . '/params.php'),
    require(__DIR__ . '/params-local.php')
);

return [
    'id' => 'app-frontend',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'sourceLanguage'=>'en_US',
    'language' => 'ru',
    'charset' => 'UTF-8',
    'timeZone' => 'Europe/Kiev',
    'name' => \Yii::t('app', 'Стомат Плюс'),
    'controllerNamespace' => 'frontend\controllers',
    'modules' => [
        'gii' => [
            'class' => 'yii\gii\Module',
            'allowedIPs' => ['127.0.0.1', '::1']
        ],
    ],
    'components' => [
        'cache' => [
//            'class' => 'yii\caching\DbCache',
            // 'db' => 'mydb',
            // 'cacheTable' => 'my_cache',
        ],
        'cacheFile' => [
            'class' => 'yii\caching\FileCache',
        ],
        'assetManager' => [
            'bundles' => [
                'yii\web\JqueryAsset' => [
                    'sourcePath' => null,
                    'js' => ['template/jquery.min.js']
                ],
                'yii\bootstrap\BootstrapPluginAsset' => [
                    'js'=>[]
                ],
                'yii\bootstrap\BootstrapAsset' => [
                    'sourcePath' => null,
                    'css' => ['template/bootstrap.min.css'],
                    'js' => ['template/bootstrap.min.js'],
                ],

            ],
        ],
        'mail' => [
            'class' => 'yii\swiftmailer\Mailer',
            'viewPath' => '@common/mail',
            'transport' => [
                'class' => 'Swift_SmtpTransport',
                'host' => 'smtp.yandex.ru',
                'username' => 'php-shaman@yandex.ru',
                'password' => '12microsoft12',
                'port' => '465',
                'encryption' => 'ssl',
            ],
        ],
        'formatter' => [
            'timeZone' => 'Europe/Kiev',
            'dateFormat' => 'dd.MM.yyyy',
            'datetimeFormat' => 'dd/MM/yyyy H:i:s',
            'decimalSeparator' => ',',
            'thousandSeparator' => ' ',
            'currencyCode' => '',
        ],
        'request' => [
            'enableCsrfValidation' => true,
            'cookieValidationKey' => 'aslgn38945$%w*(5',
            'baseUrl'=>'',
        ],
//        'session' => [
//            //'savePath' => '\app\session',
//            'cookieParams' => [
//                'domain' => '.1saas.ru',
//                'httpOnly' => true,
//                'path' => '/',
//            ],
//        ],
        'user' => [
            'identityClass' => 'common\models\User',
            'enableAutoLogin' => true,
//            'identityCookie' => [
//                'name' => '_identity',
//                'httpOnly' => true,
//                'path' => '/',
//                'domain' => '',
//            ],
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
        'db' => require(__DIR__ . '/db.php'),
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'enableStrictParsing' => true,
            'baseUrl' => '/',
            'suffix' => '/',
            'scriptUrl'=>'/index.php',
            'rules' => [
                '' => 'site/index',
                'signin' => 'site/login',
                'signup' => 'site/signup',
                'contact' => 'site/contact',
                'passwordreset' => 'site/requestpasswordreset',
                'resetpassword' => 'site/resetpassword',

                'page/<url:.+>' => 'page/view',
                'category/<url:.+>/<manufacturer:.+>' => 'category/view',
                'category/<url:.+>' => 'category/view',
                'manufacturer' => 'manufacturer/index',
                'manufacturer/<url:.+>' => 'manufacturer/view',
                'item/<url:.+>' => 'item/view',

                'news' => 'news/index',
                'news/<url:.+>' => 'news/view',

                'search/<url:.+>' => 'search/index',

                '<controller:\w+>/<id:\d+>/<action:(create|update|delete)>' => '<controller>/<action>',
                '<controller:\w+>/<action:\w+>' => '<controller>/<action>',
                '<controller:\w+>' => '<controller>/index',
            ],
        ],
    ],
    'params' => $params,
];
