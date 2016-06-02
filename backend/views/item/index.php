<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;
use yii\widgets\Pjax;
use backend\models\Item;
use backend\models\Category;
use yii\helpers\Json;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\ItemSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Items');
$this->params['breadcrumbs'][] = $this->title;
$idEdit = [];
?>
<div class="item-index">
    <h1><?= Html::encode($this->title) ?></h1>
    <p>
        <?= Html::a(Yii::t('app', 'Create Item'), ['create'], ['class' => 'btn btn-success']) ?>
        <?= Html::a(Yii::t('app', 'Обновить цены Excel'), ['price'], ['class' => 'btn btn-warning']) ?>
        <?= Html::a(Yii::t('app', 'Добавить / обновить продукцию Excel'), ['excel'], ['class' => 'btn btn-info']) ?>
        <?= Html::a(Yii::t('app', 'Импорт товаров'), ['import'], ['class' => 'btn btn-primary']) ?>
    </p>
<?php Pjax::begin(); ?>    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'layout' => "{pager}\n{summary}\n{items}\n{pager}",
        'pager' => [
            'firstPageLabel' => Yii::t('app', 'Начало'),
            'lastPageLabel' => Yii::t('app', 'Конец'),
        ],
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            [
                'attribute' => 'img',
                'contentOptions' => ['style' => 'word-wrap: break-word; overflow-wrap: break-word; white-space: pre-wrap; width: 100px; '],
                'format' => 'raw',
                'value' => function($data){
                    return isset($data->itemImgs[0]) ? Html::img($data->itemImgs[0]->getImgUrl(), ['style' => 'width: 60px;']) : null;
                },
            ],
            'id',
            [
                'attribute' => 'name',
                'format' => 'raw',
                'contentOptions' => ['style' => 'width: 100px !important; white-space: pre-wrap; word-wrap: break-word;'],
                'value'=> function ($model) use (& $idEdit) {
                    $id = 'name_edit_'.$model->id;
                    $idEdit[] = '#'.$id;
                    return '<a title="Редактировать" href="javascript:void(0);" data-name="name" data-pk="'.$model->id.'" data-url="'.Url::toRoute('item/edit').'" id="'.$id.'" data-type="text" data-title="Редактировать">'.$model->name.'</a>';
                },
            ],
            [
                'attribute' => 'url',
                'format' => 'raw',
                'contentOptions' => ['style' => 'width: 100px !important; white-space: pre-wrap; word-wrap: break-word;'],
                'value'=> function ($model) use (& $idEdit) {
                    $id = 'url_edit_'.$model->id;
                    $idEdit[] = '#'.$id;
                    return '<a title="Редактировать" href="javascript:void(0);" data-name="url" data-pk="'.$model->id.'" data-url="'.Url::toRoute('item/edit').'" id="'.$id.'" data-type="text" data-title="Редактировать">'.$model->url.'</a>';
                },
            ],
            [
                'attribute' => 'code',
                'format' => 'raw',
                'contentOptions' => ['style' => 'width: 100px !important; white-space: pre-wrap; word-wrap: break-word;'],
                'value'=> function ($model) use (& $idEdit) {
                    $id = 'code_edit_'.$model->id;
                    $idEdit[] = '#'.$id;
                    return '<a title="Редактировать" href="javascript:void(0);" data-name="code" data-pk="'.$model->id.'" data-url="'.Url::toRoute('item/edit').'" id="'.$id.'" data-type="text" data-title="Редактировать">'.$model->code.'</a>';
                },
            ],
            [
                'attribute' => 'category',
                'format' => 'raw',
                'contentOptions' => ['style' => 'width: 100px !important; white-space: pre-wrap; word-wrap: break-word;'],
                'value'=> function ($model) use (& $idEdit) {
                    $id = 'category_edit_'.$model->id;
                    $idEdit[] = '#'.$id;
                    return '<a title="Редактировать" href="javascript:void(0);" data-name="category" data-value="'.$model->category.'" data-source=\''.Json::encode(Category::getToList()).'\' data-pk="'.$model->id.'" data-url="'.Url::toRoute('item/edit').'" id="'.$id.'" data-type="select" data-title="Редактировать">'.$model->category0->name.'</a>';
                },
                'filter' => Category::getToList(),
            ],
            [
                'attribute' => 'price',
                'format' => 'raw',
                'contentOptions' => ['style' => 'width: 100px !important; white-space: pre-wrap; word-wrap: break-word;'],
                'value'=> function ($model) use (& $idEdit) {
                    $id = 'price_edit_'.$model->id;
                    $idEdit[] = '#'.$id;
                    return '<a title="Редактировать" href="javascript:void(0);" data-name="price" data-pk="'.$model->id.'" data-url="'.Url::toRoute('item/edit').'" id="'.$id.'" data-type="text" data-title="Редактировать">'.(int)$model->price.'</a>';
                },
            ],
            [
                'attribute' => 'stock',
                'format' => 'raw',
                'contentOptions' => ['style' => 'width: 100px !important; white-space: pre-wrap; word-wrap: break-word;'],
                'value'=> function ($model) use (& $idEdit) {
                    $id = 'stock_edit_'.$model->id;
                    $idEdit[] = '#'.$id;
                    return '<a title="Редактировать" href="javascript:void(0);" data-name="stock" data-value="'.$model->stock.'" data-source=\''.Json::encode(Item::yesOrNo()).'\' data-pk="'.$model->id.'" data-url="'.Url::toRoute('item/edit').'" id="'.$id.'" data-type="select" data-title="Редактировать">'.$model->getStockName().'</a>';
                },
                'filter' => Item::yesOrNo(),
            ],
            [
                'attribute' => 'home',
                'format' => 'raw',
                'contentOptions' => ['style' => 'width: 100px !important; white-space: pre-wrap; word-wrap: break-word;'],
                'value'=> function ($model) use (& $idEdit) {
                    $id = 'home_edit_'.$model->id;
                    $idEdit[] = '#'.$id;
                    return '<a title="Редактировать" href="javascript:void(0);" data-name="home" data-value="'.$model->home.'" data-source=\''.Json::encode(Item::yesOrNo()).'\' data-pk="'.$model->id.'" data-url="'.Url::toRoute('item/edit').'" id="'.$id.'" data-type="select" data-title="Редактировать">'.$model->getHomeName().'</a>';
                },
                'filter' => Item::yesOrNo(),
            ],
            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
<?php Pjax::end(); ?></div>
<?php

$idEdit = join(', ', $idEdit);
$js = <<<JS
$(document).ready(function() {
    var ListDesc = '{$idEdit}';
    $(ListDesc).editable();
});
JS;
$this->registerJs($js, $this::POS_END, 'my-edit-statur');
