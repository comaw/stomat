<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\Item */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Items'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="item-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('app', 'Delete'), ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'name',
            'url',
            'code',
            [
                'attribute' => 'currency',
                'format' => 'raw',
                'value' => isset($model->currency0->name) ? $model->currency0->name : null,
            ],
            [
                'attribute' => 'category',
                'format' => 'raw',
                'value' => isset($model->category0->name) ? $model->category0->name : null,
            ],
            [
                'attribute' => 'manufacturer',
                'format' => 'raw',
                'value' => isset($model->manufacturer0->name) ? $model->manufacturer0->name : null,
            ],
            [
                'attribute' => 'country',
                'format' => 'raw',
                'value' => isset($model->country0->name) ? $model->country0->name : null,
            ],
            'price',
            'unit',
            [
                'attribute' => 'stock',
                'format' => 'raw',
                'value' => $model->getStockName(),
            ],
            [
                'attribute' => 'warranty',
                'format' => 'raw',
                'value' => $model->getWarrantyName(),
            ],
            [
                'attribute' => 'delivery',
                'format' => 'raw',
                'value' => $model->getDeliveryName(),
            ],
            'delivery_time:datetime',
            'packing',
            'created',
            'title',
            'description',
            [
                'attribute' => 'instruction',
                'format' => 'raw',
                'value' => Html::a($model->instruction, $model->getFileUrl(), ['target' => '_blank']),
            ],
            'content:ntext',
        ],
    ]) ?>

</div>
