<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\Manufacturer;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model backend\models\Manufacturer */
/* @var $form yii\widgets\ActiveForm */



?>

<?=\backend\widgets\TinyMce::widget()?>

<div class="manufacturer-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?php if(!$model->isNewRecord){ ?>
        <?= $form->field($model, 'url')->textInput(['maxlength' => true]) ?>
    <?php } ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'description')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'content')->textarea(['rows' => 6, 'class' => 'myTinyMce']) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
