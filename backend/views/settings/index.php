<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\SettingsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Settings');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="settings-index">
    <h1><?= Html::encode($this->title) ?></h1>
    <p>
        <?= Html::a(Yii::t('app', 'Create Settings'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

//            'id',
            'name',
            [
                'attribute' => 'value',
                'contentOptions' => ['style' => 'word-wrap: break-word; overflow-wrap: break-word; white-space: pre-wrap; width: 300px; '],
                'format' => 'raw',
                'value' => function($data){
                    return Html::encode($data->value);
                },
            ],
            'title',
//            'last',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
