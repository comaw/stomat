<?php

/* @var $this yii\web\View */
/* @var $name string */
/* @var $message string */
/* @var $exception Exception */

use yii\helpers\Html;
use yii\helpers\Url;

$this->title = $name;
?>
<div class="site-error">
    <h1 class="headline first-child text-color"><?=$this->title?></h1>
    <div class="alert alert-danger">
        <?= nl2br(Html::encode($message)) ?>
    </div>
    <div class="text-center">
        <a href="<?=Url::home()?>"><?=Yii::t('app', 'На главную')?></a> |
        <a href="javascript:history.back();"><?=Yii::t('app', 'Назад')?></a>
    </div>
</div>
