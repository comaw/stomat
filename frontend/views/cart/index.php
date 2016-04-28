<?php
/* @var $this yii\web\View */
/* @var $model frontend\models\CartItem */
/* @var $models frontend\models\CartItem */
/* @var $item frontend\models\Item */

use frontend\models\Settings;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

$this->title = Yii::t('app', 'Корзина');
$this->params['breadcrumbs'][] = Yii::t('app', 'Корзина');
Yii::$app->view->registerMetaTag([
    'name' => 'description',
    'content' => Yii::t('app', 'Корзина'),
]);

$priceTotal = 0;
$currency = '';
?>
<div class="shopping-cart">
    <h1 class="headline first-child text-color"><?=Yii::t('app', 'Корзина')?></h1>
    <?php if(!$models){ ?>
    <p><?=Yii::t('app', 'Корзина пуста')?></p>
    <?php }else{ ?>
        <p><?=Yii::t('app', 'Чтобы удалить товар - поставьте его количество равным нулю.')?></p>
    <div class="row">
        <div class="col-sm-12 col-xs-12">
            <?php $form = ActiveForm::begin(['id' => 'cart-form']); ?>
            <table class="table table-bordered">
                <thead>
                <tr>
                    <th><?=Yii::t('app', 'Товары')?></th>
                    <th><?=Yii::t('app', 'Цена')?></th>
                    <th><?=Yii::t('app', 'Количство')?></th>
                    <th><?=Yii::t('app', 'Цена за все')?></th>
                </tr>
                </thead>
                <tbody>
                <?php foreach($models AS $model){ ?>
                <tr>
                    <td>
                        <img class="img-responsive" src="<?=isset($model->item0->itemImgs[0]) ? $model->item0->itemImgs[0]->getImgUrl('small_') : ''?>" alt="<?=Html::encode($model->item0->name)?>">
                        <div class="item">
                            <?=Html::a($model->item0->name, ['/item/view', 'url' => $model->item0->url], [
                                'title' => $model->item0->name,
                                'target' => '_blank',
                            ])?>
                            <p class="text-muted">
                                <br>
                                <?=Yii::t('app', 'Категория')?>: <?=Html::a($model->item0->category0->name, ['/category/view', 'url' => $model->item0->category0->url], [
                                    'title' => $model->item0->category0->name,
                                    'target' => '_blank',
                                ])?>
                            </p>
                        </div>
                    </td>
                    <td><?=Yii::$app->formatter->asInteger($model->price)?> <?=$model->item0->currency0->title?></td>
                    <td><input type="number" name="item[<?=$model->id?>]" value="<?=$model->count?>" class="form-control"></td>
                    <td><?=Yii::$app->formatter->asInteger(($model->price * $model->count))?> <?=$model->item0->currency0->title?></td>
                    <?php $priceTotal += ($model->price * $model->count); ?>
                    <?php $currency = $model->item0->currency0->title; ?>
                </tr>
                <?php } ?>
                </tbody>
            </table>
            <ul class="text-right checkout">
                <li><strong><?=Yii::t('app', 'Общая цена')?></strong>: <?=Yii::$app->formatter->asInteger($priceTotal)?> <?=$currency?></li>
                <li><button type="submit" class="btn btn-primary"><?=Yii::t('app', 'Сохранить')?></button></li>
                <li><a href="<?=Url::toRoute(['cart/order'])?>" class="btn btn-color btn" title="<?=Yii::t('app', 'Перейти к оформлению заказа')?>"><?=Yii::t('app', 'Перейти к оформлению заказа')?></a></li>
            </ul>
            <?php ActiveForm::end(); ?>
        </div>
    </div>
    <?php } ?>
</div>
