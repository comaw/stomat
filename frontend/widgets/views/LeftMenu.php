<?php
/**
 * powered by php-shaman
 * LeftMenu.php 27.04.2016
 * stomat
 */

/* @var $models frontend\models\Category */
/* @var $model frontend\models\Category */

use yii\helpers\Url;
use yii\bootstrap\Html;

?>
<ul class="nav nav-pills nav-stacked">
    <li<?=Url::current() == Url::toRoute(['site/index']) ? ' class="active" ' : ''?>><a href="<?=Url::toRoute(['site/index'])?>" title="<?=Html::encode(Yii::t('app', 'Популярне товары'))?>"><?=Yii::t('app', 'Популярне товары')?></a></li>
    <?php foreach($models AS $model){ ?>
        <li<?=Url::current() == Url::toRoute(['category/view', 'url' => $model->url]) ? ' class="active" ' : ''?>><a href="<?=Url::toRoute(['category/view', 'url' => $model->url])?>" title="<?=Html::encode($model->name)?>"><?=$model->name?></a></li>
    <?php } ?>
</ul>
