<?php
/**
 * powered by php-shaman
 * LeftSearch.php 27.04.2016
 * stomat
 */

/* @var $models frontend\models\News */
/* @var $model frontend\models\News */

use yii\helpers\Url;
use yii\bootstrap\Html;

?>
<div class="shop-category"><?=Yii::t('app', 'Новости')?></div>
<div class="row">
    <?php foreach($models AS $model){ ?>
    <div class="col-xs-12">
        <h5><?=Html::a($model->name, ['news/view' , 'url' => $model->url], ['title' => $model->name])?></h5>
        <div><?=strip_tags($model->small)?></div>
    </div>
    <?php } ?>
</div>
<div class="row">
    <div class="col-xs-12">
        <br>
        <a href="<?=Url::toRoute(['news/index'])?>" title="<?=Html::encode(Yii::t('app', 'Все новости'))?>"><?=Yii::t('app', 'Все новости')?></a>
    </div>
</div>
