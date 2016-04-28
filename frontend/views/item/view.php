<?php
/* @var $this yii\web\View */
/* @var $model frontend\models\Item */
/* @var $models frontend\models\Item */
/* @var $item frontend\models\Item */

use frontend\models\Settings;
use yii\helpers\Html;
use yii\helpers\Url;
use frontend\models\SortForm;
use yii\widgets\ActiveForm;

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => $model->category0->name, 'url' => ['/category/view', 'url' => $model->category0->url]];
$this->params['breadcrumbs'][] = $model->name;
Yii::$app->view->registerMetaTag([
    'name' => 'description',
    'content' => $model->description,
]);
?>
<div class="modal fade bs-example-modal-lg" id="dostavka" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">

        </div>
    </div>
</div>
<div class="modal fade bs-example-modal-lg" id="onas" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">

        </div>
    </div>
</div>
<div class="col-sm-9" itemscope itemtype="http://schema.org/Product">
    <div class="row">
        <div class="col-sm-6">
            <div class="product-img">
                <?php $sizeofImg = sizeof($model->itemImgs); if($sizeofImg > 0){ ?>
                <a href="<?=$model->itemImgs[0]->getImgUrl('')?>" data-lightbox="products" title="<?=Html::encode($model->name)?>">
                    <img itemprop="image" src="<?=$model->itemImgs[0]->getImgUrl('normal_')?>" class="img-responsive main" alt="<?=Html::encode($model->name)?>">
                </a>
                <div class="row">
                    <?php if($sizeofImg > 1){ for($i = 1; $i < $sizeofImg; $i++){ if($i > 3){ break; } ?>
                    <div class="col-xs-4">
                        <a href="<?=$model->itemImgs[$i]->getImgUrl('')?>" data-lightbox="products">
                            <img src="<?=$model->itemImgs[$i]->getImgUrl('normal_')?>" class="img-responsive" alt="<?=Html::encode($model->name.Yii::t('app', ' картинка № {im}', ['im' => $i]))?>">
                        </a>
                    </div>
                    <?php }} ?>
                </div>
                <?php } ?>
            </div>
        </div>
        <div class="col-sm-6">
            <h1 class="primary-font first-child" itemprop="name"><?=$model->name?></h1>
            <span class="reviews"><?=$model->stock > 0 ? '<strong class="text-success">'.Yii::t('app', 'Есть в наличии').'</strong>' : '<strong class="text-danger">'.Yii::t('app', 'Нет наскладе').'</strong>'?></span>
            <div class="row">
                <div class="col-xs-12">
                    <br>
                    <?=Yii::t('app', 'Категория')?>:
                    <?=Html::a($model->category0->name, ['/category/view', 'url' => $model->category0->url], [
                        'title' => $model->category0->name,
                        'itemprop' => 'category',
                    ])?>
                </div>
            </div>
            <ul class="list-unstyled text-muted">
                <li><?=Yii::t('app', 'Код товара')?>: <strong><?=$model->code?></strong></li>
                <?php if(isset($model->manufacturer0->name)){ ?>
                    <li><?=Yii::t('app', 'Производитель')?>: <strong itemprop="manufacturer"><?=$model->manufacturer0->name?></strong></li>
                <?php } ?>
                <?php if(isset($model->country0->name)){ ?>
                    <li><?=Yii::t('app', 'Страна производитель')?>: <strong><?=$model->country0->name?></strong></li>
                <?php } ?>
                <?php if($model->packing){ ?>
                    <li><?=Yii::t('app', 'Тип упаковки')?>: <strong><?=$model->packing?></strong></li>
                <?php } ?>
                <?php if($model->warranty){ ?>
                    <li><?=Yii::t('app', 'Гарантия')?>: <strong><?=$model->getWarrantyName()?></strong></li>
                <?php } ?>
                <?php if(sizeof($model->itemCharacteristics) > 0){ foreach($model->itemCharacteristics AS $characteristics){ if(!$characteristics->value){ continue; } ?>
                    <li><?=$characteristics->characteristic0->name?>: <strong><?=$characteristics->value?> <?=$characteristics->characteristic0->dimension?></strong></li>
                <?php }} ?>
                <li>
                    <?=Html::a(Yii::t('app', 'Доставка и оплата'), ['/page/view', 'url' => 'dostavka-i-oplata'], [
                        'title' => Yii::t('app', 'Доставка и оплата'),
                        'data-toggle' => 'modal',
                        'data-target' => '#dostavka',
                    ])?>
                </li>
                <li>
                    <?=Html::a(Yii::t('app', 'Адрес и контакты'), ['/page/view', 'url' => 'o-nas'], [
                        'title' => Yii::t('app', 'Адрес и контакты'),
                        'data-toggle' => 'modal',
                        'data-target' => '#onas',
                    ])?>
                </li>
            </ul>
            <?php if($model->stock > 0){ ?>
            <div itemprop="offers" itemscope itemtype="http://schema.org/Offer">
                <div class="price-block">
                    <?=Yii::t('app', 'Цена')?>: <span class="price"><?=Yii::$app->formatter->asInteger($model->price)?> <?=$model->currency0->title?>/<?=$model->unit?></span>
                    <meta itemprop="price" content="<?=Yii::$app->formatter->asInteger($model->price)?>">
                    <meta itemprop="priceCurrency" content="<?=$model->currency0->name?>">
                    <input type="number" name="countItem" value="1" class="form-control">
                </div>
                <br>
                <a class="btn btn-color" href="javascript:void(0);" onclick="cart.add(<?=(int)$model->id?>);"><i class="fa fa-shopping-cart"></i> <?=Yii::t('app', 'В корзину')?></a>
                <link itemprop="availability" href="http://schema.org/InStock">
            </div>
            <?php } ?>
            <div class="row">
                <div class="col-xs-12">
                    <br><?=Yii::t('app', 'Поделиться')?>
                    <script type="text/javascript" src="//yastatic.net/es5-shims/0.0.2/es5-shims.min.js" rel="nofollow" charset="utf-8"></script>
                    <script type="text/javascript" src="//yastatic.net/share2/share.js" rel="nofollow" charset="utf-8"></script>
                    <div class="ya-share2" data-services="vkontakte,facebook,odnoklassniki,moimir,gplus,twitter,viber,whatsapp"></div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12">
            <h3 class="headline text-color">
                <span class="border-color"><?=Yii::t('app', 'Описание')?></span>
            </h3>
            <div itemprop="description">
                <?=$model->content?>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12">
            <h3 class="headline text-color">
                <span class="border-color"><?=Yii::t('app', 'Похожие товары')?></span>
            </h3>
            <div class="row">
                <?php foreach($models AS $item){ ?>
                <div class="col-sm-4">
                    <div class="shop-product" style="height: 320px !important;">
                        <a href="<?=Url::toRoute(['item/view', 'url'=> $item->url])?>" title="<?=Html::encode($item->name)?>"><img src="<?=isset($item->itemImgs[0]) ? $item->itemImgs[0]->getImgUrl('small_') : ''?>" class="img-responsive" alt="<?=Html::encode($item->name)?>" style="margin: auto;"></a>
                        <a href="<?=Url::toRoute(['item/view', 'url'=> $item->url])?>" title="<?=Html::encode($item->name)?>"><h5 class="primary-font"><?=$item->name?></h5></a>
                        <p class="text-muted">
                            <?php if(isset($item->manufacturer0->name)){ ?>
                                <?=Yii::t('app', 'Производитель')?>: <?=Html::a($item->manufacturer0->name, ['manufacturer/view', 'url' => $item->manufacturer0->url])?>
                            <?php } ?>
                        </p>
                        <p class="price">
                            <?php if($item->stock){ ?>
                                <span class="new text-success"><?=Yii::$app->formatter->asInteger($item->price)?> <?=$item->currency0->title?></span>
                            <?php }else{ ?>
                                <span class="new text-danger"><?=Yii::t('app', 'Нет в наличии')?></span>
                            <?php } ?>
                        </p>
                        <a href="javascript:void(0);" class="btn btn-sm btn-color" onclick="cart.add(<?=(int)$item->id?>);"><i class="fa fa-shopping-cart"></i> <?=Yii::t('app', 'В корзину')?></a>
                    </div>
                </div>
                <?php } ?>
            </div>
        </div>
    </div>
</div>
