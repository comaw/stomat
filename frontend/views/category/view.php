<?php

/* @var $this yii\web\View */
/* @var $models frontend\models\Item */
/* @var $model frontend\models\Item */
/* @var $category frontend\models\Category */
/* @var $manufacturers frontend\models\Manufacturer */
/* @var $manufacturer frontend\models\Manufacturer */
/* @var $manufacturerCurrent frontend\models\Manufacturer */
/* @var $sortForm frontend\models\SortForm */

use frontend\models\Settings;
use yii\helpers\Html;
use yii\helpers\Url;
use frontend\models\SortForm;
use yii\widgets\ActiveForm;

$this->title = $category->title.(Yii::$app->request->get('page')? ' - '.Yii::t('app', 'страница ').(Yii::$app->request->get('page') - 1) : '');
if($manufacturerCurrent){
    $this->params['breadcrumbs'][] = ['label' => $category->name, 'url' => ['/category/view', 'url' => $category->url]];
    $this->params['breadcrumbs'][] = $manufacturerCurrent->name;
}else{
    $this->params['breadcrumbs'][] = $category->name;
}
Yii::$app->view->registerMetaTag([
    'name' => 'description',
    'content' => $category->description.(Yii::$app->request->get('page')? ' - '.Yii::t('app', 'страница ').(Yii::$app->request->get('page') - 1) : ''),
]);
?>
<h1 class="headline first-child text-color"><?=$category->name?></h1>
<ul class="nav nav-tabs nav-justified">
    <?php if($manufacturers){ ?>
        <li class="<?=Url::current() == Url::toRoute(['category/view', 'url' => $category->url]) ? 'active' : ''?>"><a href="<?=Url::toRoute(['category/view', 'url' => $category->url])?>"><?=Yii::t('app', 'Все')?></a></li>
        <?php foreach($manufacturers AS $manufacturer){ ?>
            <li class="<?=Url::current() == Url::toRoute(['category/view', 'url' => $category->url, 'manufacturer' => $manufacturer->url]) ? 'active' : ''?>"><a href="<?=Url::toRoute(['category/view', 'url' => $category->url, 'manufacturer' => $manufacturer->url])?>" title="<?=Html::encode($manufacturer->name)?>"><?=$manufacturer->name?></a></li>
        <?php } ?>
    <?php } ?>
</ul>
<div class="row">
    <div class="col-xs-12 text-right">
        <?php $form = ActiveForm::begin(['id' => 'sort-form']); ?>
        <div class="col-sm-3 col-xs-12 pull-right">
            <?= $form->field($sortForm, 'stock')->dropDownList(SortForm::listStock()) ?>
        </div>
        <div class="col-sm-3 col-xs-12 pull-right">
            <?= $form->field($sortForm, 'sort')->dropDownList(SortForm::listSort(), ['prompt' => Yii::t('app', '-- Сортировать --')]) ?>
        </div>
        <?php ActiveForm::end(); ?>
    </div>
</div>
<div class="row">
    <div class="tab-content">
        <div class="tab-pane fade in active">
            <?php foreach($models AS $model){ ?>
                <div class="col-sm-4 col-xs-12">
                    <div class="shop-product" style="height: 320px !important;">
                        <a href="<?=Url::toRoute(['item/view', 'url'=> $model->url])?>" title="<?=Html::encode($model->name)?>"><img src="<?=isset($model->itemImgs[0]) ? $model->itemImgs[0]->getImgUrl('small_') : ''?>" class="img-responsive" alt="<?=Html::encode($model->name)?>" style="margin: auto;"></a>
                        <a href="<?=Url::toRoute(['item/view', 'url'=> $model->url])?>" title="<?=Html::encode($model->name)?>"><h5 class="primary-font"><?=$model->name?></h5></a>
                        <p class="text-muted">
                            <?php if(isset($model->manufacturer0->name)){ ?>
                                <?=Yii::t('app', 'Производитель')?>: <?=Html::a($model->manufacturer0->name, ['manufacturer/view', 'url' => $model->manufacturer0->url])?>
                            <?php } ?>
                        </p>
                        <p class="price">
                            <?php if($model->stock){ ?>
                                <span class="new text-success"><?=Yii::$app->formatter->asInteger($model->price)?> <?=$model->currency0->title?></span>
                            <?php }else{ ?>
                                <span class="new text-danger"><?=Yii::t('app', 'Нет в наличии')?></span>
                            <?php } ?>
                        </p>
                        <a href="#" class="btn btn-sm btn-color"><i class="fa fa-shopping-cart"></i> <?=Yii::t('app', 'В корзину')?></a>
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>
</div>
    <div class="row">
        <div class="col-xs-12 text-center">
            <?php
            echo \common\lib\LinkPager::widget([
                'pagination' => $pages,
            ]);
            ?>
        </div>
    </div>
<?php if(!$manufacturerCurrent && (!Yii::$app->request->get('page') || Yii::$app->request->get('page') < 2)){ ?>
<div><?=$category->content?></div>
<?php } ?>