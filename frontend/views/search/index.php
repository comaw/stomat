<?php

/* @var $this yii\web\View */
/* @var $models frontend\models\Item */
/* @var $model frontend\models\Item */

use frontend\models\Settings;
use yii\helpers\Html;
use yii\helpers\Url;
use frontend\models\SortForm;
use yii\widgets\ActiveForm;

$this->title = Yii::t('app', 'Поиск по запросу: ').$search_text.(Yii::$app->request->get('page')? ' - '.Yii::t('app', 'страница ').(Yii::$app->request->get('page') - 1) : '');
$this->params['breadcrumbs'][] = Yii::t('app', 'Поиск по запросу: ').$search_text;
Yii::$app->view->registerMetaTag([
    'name' => 'description',
    'content' => Yii::t('app', 'Поиск по запросу: ').$search_text.(Yii::$app->request->get('page')? ' - '.Yii::t('app', 'страница ').(Yii::$app->request->get('page') - 1) : ''),
]);
?>
<h1><?=Yii::t('app', 'Поиск по запросу: ').$search_text?></h1>
<div class="row">
    <div class="col-xs-12 text-right">
        <?php $form = ActiveForm::begin(['id' => 'sort-form']); ?>
        <div class="col-sm-3 col-xs-12 pull-right">
            <?= $form->field($sortForm, 'sort')->dropDownList(SortForm::listSort(), ['prompt' => Yii::t('app', '-- Сортировать --')])->label('') ?>
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
                            <span class="new"><?=Yii::$app->formatter->asInteger($model->price)?> <?=$model->currency0->title?></span>
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
