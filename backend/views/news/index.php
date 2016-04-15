<?php

use yii\helpers\Html;
use yii\grid\GridView;
use app\models\News;

/* @var $this yii\web\View */
/* @var $searchModel app\models\NewsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'News');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="page-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a(Yii::t('app', 'Create News'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            [
                'attribute' => 'img',
                'format' => 'raw',
                'value' => function($data){
                    return $data->img ? '<img src="'.News::getUrlImg($data->img).'" style="max-height: 60px;">' : '';
                },
                'filter' => false,
            ],
            'id',
            'name',
            'url',
//            'title',
//            'description',
            // 'content:ntext',
            // 'img',
             'created',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
