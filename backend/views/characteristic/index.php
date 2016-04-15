<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use backend\models\Characteristic;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\CharacteristicSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Characteristics');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="characteristic-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a(Yii::t('app', 'Create Characteristic'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>
<?php Pjax::begin(); ?>    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'name',
            'dimension',
//            'type',
            [
                'attribute' => 'type',
                'format' => 'raw',
                'value' => function($data){
                    return $data->getTypeName();
                },
                'filter' => Characteristic::typeList(),
            ],

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
<?php Pjax::end(); ?></div>
