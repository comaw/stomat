<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\Order */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Orders'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="order-view">
    <h1><?= Html::encode($this->title) ?></h1>
    <p>
        <?= Html::a(Yii::t('app', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
<!--        --><?//= Html::a(Yii::t('app', 'Delete'), ['delete', 'id' => $model->id], [
//            'class' => 'btn btn-danger',
//            'data' => [
//                'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
//                'method' => 'post',
//            ],
//        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
//            'user',
            'username',
            'email:email',
            'phone',
            'state',
            'city',
            'address',
            'zipcode',
            'created',
            'comment:ntext',
        ],
    ]) ?>
    <h3><?=Yii::t('app', 'Товары')?></h3>
    <?php $items = \backend\models\OrderItem::find()->where("orders = :orders", [':orders' => $model->id])->all() ?>
    <?php foreach($items AS $item){ ?>
        <p>
            <a href="<?=str_replace('/admin/', '/', \common\UrlHelp::toRoute(['/item/view', 'url' => $item->item0->url]))?>" target="_blank"><?=$item->item0->name?></a>
            (<?=$item->count?> шт за <?=$item->price_all?> грн)
        </p>
    <?php } ?>
</div>
