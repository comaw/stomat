<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;
use backend\models\Item;
use backend\models\Category;
use backend\models\Manufacturer;
use backend\models\Currency;
use backend\models\Country;
use backend\models\Characteristic;


/* @var $this yii\web\View */
/* @var $model backend\models\Item */
/* @var $form yii\widgets\ActiveForm */
/* @var $imgs backend\models\ItemImg */
/* @var $characteristic backend\models\Characteristic */
/* @var $chara backend\models\Characteristic */

$ItemCharacter = $model->itemCharacteristics;
$ItemCharacteristic = [];
if($ItemCharacter){
    foreach($ItemCharacter AS $ItemChar){
        $ItemCharacteristic[$ItemChar->characteristic] = $ItemChar;
    }
}

$urlReturn = Url::toRoute(['item/index']);
$session = Yii::$app->session;
if($session->has('urlToList')){
    $urlReturn = $session->get('urlToList');
}

?>
<?=Html::a(Yii::t('app', 'К списку товаров'), $urlReturn, ['class' => 'btn btn-warning pull-right'])?>
<?=\backend\widgets\TinyMce::widget()?>

<div class="item-form">

    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

    <div class="row">
        <div class="col-sm-4 col-xs-12">
            <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-sm-2 col-xs-12">
            <?= $form->field($model, 'code')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-sm-2 col-xs-12">
            <?= $form->field($model, 'stock')->dropDownList(Item::yesOrNo()) ?>
        </div>
        <div class="col-sm-4 col-xs-12">
            <?php if(!$model->isNewRecord){ ?>
            <?= $form->field($model, 'url')->textInput(['maxlength' => true]) ?>
            <?php } ?>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-3 col-xs-12">
            <?= $form->field($model, 'category')->dropDownList(Category::getToList(), ['prompt' => Yii::t('app', '-- Выберите категорию --')]) ?>
        </div>
        <div class="col-sm-3 col-xs-12">
            <?= $form->field($model, 'country')->dropDownList(Country::getToList(), ['prompt' => Yii::t('app', '-- Выберите страну --')]) ?>
        </div>
        <div class="col-sm-3 col-xs-12">
            <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-sm-3 col-xs-12">
            <?= $form->field($model, 'description')->textInput(['maxlength' => true]) ?>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-3 col-xs-12">
            <?= $form->field($model, 'price')->textInput(['maxlength' => true])->hint(Yii::t('app', 'Напримет: 132 или 1500,63')) ?>
        </div>
        <div class="col-sm-3 col-xs-12">
            <?= $form->field($model, 'unit')->textInput(['maxlength' => true])->hint(Yii::t('app', 'Напримет: шт.')) ?>
        </div>
        <div class="col-sm-3 col-xs-12">
            <?= $form->field($model, 'currency')->dropDownList(Currency::getToList()) ?>
        </div>
        <div class="col-sm-3 col-xs-12">
            <?= $form->field($model, 'manufacturer')->dropDownList(Manufacturer::getToList(), ['prompt' => Yii::t('app', '-- Выберите производителя --')]) ?>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-2 col-xs-12">
            <?= $form->field($model, 'home')->dropDownList(Item::yesOrNo()) ?>
        </div>
        <div class="col-sm-3 col-xs-12">
            <?= $form->field($model, 'warranty')->dropDownList(Item::warrantyList(), ['prompt' => Yii::t('app', '-- Выберите срок гарантии --')]) ?>
        </div>
        <div class="col-sm-2 col-xs-12">
            <?= $form->field($model, 'delivery')->dropDownList(Item::yesOrNo(true)) ?>
        </div>
        <div class="col-sm-2 col-xs-12">
            <?= $form->field($model, 'delivery_time')->textInput()->hint(Yii::t('app', 'Напримет: 11 дней')) ?>
        </div>
        <div class="col-sm-2 col-xs-12">
            <?= $form->field($model, 'packing')->textInput(['maxlength' => true])->hint(Yii::t('app', 'Напримет: коробка')) ?>
        </div>
    </div>
    <h4><?=Yii::t('app', 'Характеристики')?></h4>
    <div class="row">
        <?php
        foreach($characteristic AS $chara){
            $value = null;
            $value = isset($ItemCharacteristic[$chara->id]) ? $ItemCharacteristic[$chara->id]->value : null;
            ?>
        <?php if(isset(Yii::$app->request->post('ItemCharacteristic')[$chara->id])){$value = Yii::$app->request->post('ItemCharacteristic')[$chara->id];} ?>
        <div class="col-sm-3 col-xs-12">
            <div class="form-group field-item-warranty">
                <?php if($chara->type == 'textarea'){ ?>
                    <label class="control-label" for="ItemCharacteristic<?=$chara->id?>"><?=$chara->name?> (<?=$chara->dimension?>)</label>
                    <textarea class="form-control" id="ItemCharacteristic<?=$chara->id?>" name="ItemCharacteristic[<?=$chara->id?>]"><?=$value?></textarea>
                <?php }elseif($chara->type == 'checkbox'){ ?>
                    <label><input type="checkbox" id="ItemCharacteristic<?=$chara->id?>" name="ItemCharacteristic[<?=$chara->id?>]" value="1"<?=$value ? 'checked' : ''?>> <?=$chara->name?> (<?=$chara->dimension?>)</label>
                 <?php }else{ ?>
                    <label class="control-label" for="ItemCharacteristic<?=$chara->id?>"><?=$chara->name?> (<?=$chara->dimension?>)</label>
                    <input id="ItemCharacteristic<?=$chara->id?>" name="ItemCharacteristic[<?=$chara->id?>]" value="<?=$value?>" type="text" class="form-control">
                <?php } ?>
                <div class="help-block"></div>
            </div>
        </div>
        <?php } ?>
    </div>
    <?= $form->field($model, 'fileInstruction')->fileInput() ?>
    <?= $form->field($model, 'content')->textarea(['rows' => 6, 'class' => 'myTinyMce']) ?>
    <?php for($i = 0; $i < 4; $i++){ ?>
    <div class="row">
        <div class="col-sm-4 col-xs-12">
            <?= $form->field($imgs, 'imageFile[]')->fileInput(['multiple' => true, 'accept' => 'image/*']) ?>
        </div>
        <div class="col-sm-2 col-xs-12">
            <?= $form->field($imgs, 'position')->textInput(['value' => (isset($model->itemImgs[$i]->position) ? $model->itemImgs[$i]->position : (isset(Yii::$app->request->post('ItemImg')['position']) ? Yii::$app->request->post('ItemImg')['position'] : 0))])->hint(Yii::t('app', 'Напримет: 2')) ?>
        </div>
        <div class="col-sm-4 col-xs-12">
            <?php  if(isset($model->itemImgs[$i])){ ?>
                <div id="itemImgs<?=$model->itemImgs[$i]->id?>">
                    <img src="<?=$model->itemImgs[$i]->getImgUrl()?>" alt="" style="max-width: 100px;">
                    <a href="javascript:void(0);" data-img="delete" data-idimg="<?=$model->itemImgs[$i]->id?>" class="btn btn-danger btn-sm"><?=Yii::t('app', 'Удалить')?></a>
                </div>
            <?php } ?>
        </div>
    </div>
    <?php } ?>
    <div class="form-group">
        <div class="col-sm-6 col-xs-12">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        <?=Html::a(Yii::t('app', 'К списку товаров'), $urlReturn, ['class' => 'pull-right'])?>
        </div>
    </div>
    <?php ActiveForm::end(); ?>
</div>
<?php
$urlImgDelete = Url::toRoute(['item/imgdelete']);
$jsView = <<<JS
    $('[data-img="delete"]').click(function(){
        var self = this;
        var id = $(self).data("idimg");
            $.ajax({
        type: "POST",
        url: "{$urlImgDelete}",
        data: {id : id},
        dataType: 'json',
        cache: false,
        success: function(msg){
            if(!msg.e){
                $('#itemImgs' + id).html('');
            }else{
                alert(msg.t);
            }
        }
    });
    });
JS;
$this->registerJs($jsView);
