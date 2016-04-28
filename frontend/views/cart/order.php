<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \frontend\models\SignupForm */

use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\ActiveForm;

$this->title = Yii::t('app', 'Оформить заказ');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Корзина'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-signup">
    <div class="sign-form">
        <h1 class="headline first-child text-color"><?= Html::encode($this->title) ?></h1>
        <div class="row">
            <div class="col-lg-9 col-xs-12">
                <?php $form = ActiveForm::begin(['id' => 'form-signup']); ?>

                <?= $form->field($model, 'username')->textInput() ?>
                <?= $form->field($model, 'email')->textInput() ?>
                <?= $form->field($model, 'phone')->textInput(['placeholder' => '+38 (099) 999-99-99']) ?>
                <?= $form->field($model, 'state')->textInput() ?>
                <?= $form->field($model, 'city')->textInput() ?>
                <?= $form->field($model, 'zipcode')->textInput() ?>
                <?= $form->field($model, 'address')->textInput() ?>
                <?= $form->field($model, 'comment')->textarea(['rows' => 6]) ?>
                <div class="form-group">
                    <?= Html::submitButton(Yii::t('app', 'Заказать'), ['class' => 'btn btn-primary', 'name' => 'signup-button']) ?>
                </div>

                <?php ActiveForm::end(); ?>
            </div>
        </div>
    </div>
</div>