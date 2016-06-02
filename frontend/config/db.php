<?php
/**
 * powered by php-shaman
 * db.php 15.04.2016
 * stomat
 */

if((isset($_SERVER['REMOTE_ADDR']) && '127.0.0.1' == $_SERVER['REMOTE_ADDR']) || mb_substr_count(__DIR__, '1stomat.ru', 'UTF-8') > 0){
    return [
        'class' => 'yii\db\Connection',
        'dsn' => 'mysql:host=localhost;dbname=stomat2',
        'username' => 'root',
        'password' => '',
        'charset' => 'utf8',
        'tablePrefix' => 'st_',
        'enableSchemaCache' => true,
        'schemaCacheDuration' => 5,
        'schemaCache' => 'cacheFile',
    ];
}

return [
    'class' => 'yii\db\Connection',
    'dsn' => 'mysql:host=db18.freehost.com.ua;dbname=stomatplu_marcket',
    'username' => 'stomatplu_coma',
    'password' => '12microsof',
    'charset' => 'utf8',
    'tablePrefix' => 'st_',
    'enableSchemaCache' => true,
    'schemaCacheDuration' => 3600,
    'schemaCache' => 'cacheFile',
];