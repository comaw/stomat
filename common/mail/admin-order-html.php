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
<div class="password-reset">
    <p><?=Yii::t('app', 'Здравствуйте')?></p>

    <p><?=Yii::t('app', 'Новый заказ с сайта {site}', ['site' => Yii::$app->name])?>:</p>
    <p><?=date("d/m/Y H:i:s")?></p>

    <p><?=$order->username?></p>

    <p><?=$order->email?></p>

    <p><?=$order->phone?></p>

    <p><?=$order->state?></p>

    <p><?=$order->city?></p>

    <p><?=$order->zipcode?></p>

    <p><?=$order->address?></p>

    <p><?=$order->comment?></p>

    <p><b><?=Yii::t('app', 'Товары')?>:</b></p>

    <?php $items = OrderItem::find()->where("order = :order", [':order' => $order->id])->all() ?>
    <?php foreach($items AS $item){ ?>

        <p>
            <?=$item->item0->name?> (<?=$item->count?> за <?=$item->price_all?> грн)
        </p>

    <?php } ?>
</div>

