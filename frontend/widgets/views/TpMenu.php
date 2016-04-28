<?php
/**
 * powered by php-shaman
 * TpMenu.php 27.04.2016
 * stomat
 */

use yii\helpers\Url;
use yii\bootstrap\Html;
use frontend\models\Cart;

?>
<ul class="nav navbar-nav navbar-right">
    <li>
        <a href="<?=Url::toRoute(['page/view', 'url' => 'o-nas'])?>" class="bg-hover-color" title="<?=Html::encode(Yii::t('app', 'О нас'))?>"><?=Yii::t('app', 'О нас')?></a>
    </li>
    <li>
        <a href="<?=Url::toRoute(['site/contact'])?>" class="bg-hover-color" title="<?=Html::encode(Yii::t('app', 'Контакты'))?>"><?=Yii::t('app', 'Контакты')?></a>
    </li>
    <li>
        <a href="<?=Url::toRoute(['page/view', 'url' => 'dostavka-i-oplata'])?>" class="bg-hover-color" title="<?=Html::encode(Yii::t('app', 'Доставка и оплата'))?>"><?=Yii::t('app', 'Доставка и оплата')?></a>
    </li>
    <li>
        <a href="<?=Url::toRoute(['page/view', 'url' => 'vozvrat-i-obmen'])?>" class="bg-hover-color" title="<?=Html::encode(Yii::t('app', 'Возврат/обмен'))?>"><?=Yii::t('app', 'Возврат/обмен')?></a>
    </li>
    <li class="btn-color">
        <a href="<?=Url::toRoute(['cart/index'])?>" class="bg-hover-color" title="<?=Html::encode(Yii::t('app', 'Корзина'))?>"><?=Yii::t('app', 'Корзина')?> (<span id="cartItemCount"><?=Cart::itemCountInCart()?></span>)</a>
    </li>
</ul>
