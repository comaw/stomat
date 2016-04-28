<?php
/**
 * powered by php-shaman
 * admin-order-html.php 28.04.2016
 * stomat
 */

use yii\helpers\Html;
use frontend\models\OrderItem;
use frontend\models\Order;

/* @var $this yii\web\View */
/* @var $order frontend\models\Order */
/* @var $item frontend\models\OrderItem */

?>

    <?=Yii::t('app', 'Здравствуйте')?>

    <?=Yii::t('app', 'Ваш заказ на сайте {site}', ['site' => Yii::$app->name])?>:
    <?=date("d/m/Y H:i:s")?>

    <?=$order->username?>

    <?=$order->email?>

    <?=$order->phone?>

    <?=$order->state?>

    <?=$order->city?>

    <?=$order->zipcode?>

    <?=$order->address?>

    <?=$order->comment?>

    <?=Yii::t('app', 'Товары')?>:

    <?php $items = OrderItem::find()->where("order = :order", [':order' => $order->id])->all() ?>
    <?php foreach($items AS $item){ ?>

        
            <?=$item->item0->name?> (<?=$item->count?> за <?=$item->price_all?> грн)
        

    <?php } ?>


