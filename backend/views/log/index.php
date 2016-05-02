<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel backend\models\LogSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Logs');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="log-index">
    <h1><?= Html::encode($this->title) ?></h1>
<?php Pjax::begin(); ?>    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

//            'id',
//            'user',
            [
                'attribute' => 'user',
                'format' => 'raw',
                'value' => function($data){
                    return isset($data->user0->username) ? $data->user0->username : null;
                },
                'filter' => \backend\models\User::listUser(),
            ],
            'created',
            'description',

            ['class' => 'yii\grid\ActionColumn',
                'template' => '{delete}'],
        ],
    ]); ?>
<?php Pjax::end(); ?>
</div>
