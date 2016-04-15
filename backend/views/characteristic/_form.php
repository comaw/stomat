<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use backend\models\Characteristic;

/* @var $this yii\web\View */
/* @var $model backend\models\Characteristic */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="characteristic-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'dimension')->textInput(['maxlength' => true])->hint(Yii::t('app', 'Например: кг')) ?>

    <?= $form->field($model, 'type')->dropDownList(Characteristic::typeList()) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
