<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use backend\models\User;

/* @var $this yii\web\View */
/* @var $model backend\models\User */

$this->title = $model->username;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Users'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-view">

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
            'username',
            'email:email',
            [
                'attribute' => 'role',
                'format' => 'raw',
                'value' => $model->getRoleName(),
            ],
            [
                'attribute' => 'status',
                'format' => 'raw',
                'value' => $model->getStatusName(),
            ],
            [
                'attribute' => 'created_at',
                'format' => 'raw',
                'value' => date("d/m/Y H:i:s", $model->created_at),
            ],
            [
                'attribute' => 'updated_at',
                'format' => 'raw',
                'value' =>  date("d/m/Y H:i:s", $model->updated_at),
            ],
        ],
    ]) ?>

</div>
