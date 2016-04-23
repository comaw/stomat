<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use backend\models\Item;
use backend\models\Category;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\ItemSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Items');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="item-index">
    <h1><?= Html::encode($this->title) ?></h1>
    <p>
        <?= Html::a(Yii::t('app', 'Create Item'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>
<?php Pjax::begin(); ?>    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'name',
            'url',
             'code',
            [
                'attribute' => 'category',
                'format' => 'raw',
                'value' => function($data){
                    return $data->category0->name;
                },
                'filter' => Category::getToList(),
            ],
            [
                'attribute' => 'price',
                'format' => 'raw',
                'value' => function($data){
                    return (int)$data->price;
                },
            ],
            [
                'attribute' => 'stock',
                'format' => 'raw',
                'value' => function($data){
                    return $data->getStockName();
                },
                'filter' => Item::yesOrNo(),
            ],

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
<?php Pjax::end(); ?></div>
