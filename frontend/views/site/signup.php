<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \frontend\models\SignupForm */

use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\ActiveForm;

$this->title = Yii::t('app', 'Регистрация');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-signup">
    <h1><?= Html::encode($this->title) ?></h1>
    <p><?=Yii::t('app', 'Пожалуйста, заполните следующие поля, чтобы зарегистрироваться')?>:</p>
    <div class="row">
        <div class="col-lg-5">
            <?php $form = ActiveForm::begin(['id' => 'form-signup']); ?>

                <?= $form->field($model, 'username')->textInput(['autofocus' => true]) ?>

                <?= $form->field($model, 'email') ?>

                <?= $form->field($model, 'password')->passwordInput() ?>
                <?= $form->field($model, 'confirm')->passwordInput() ?>
            <?= $form->field($model, 'verifyCode')->widget(
                \common\recaptcha\ReCaptcha::className(),
                ['siteKey' => \common\recaptcha\ReCaptcha::SITE_KEY]
            ) ?>
            <?= $form->field($model, 'laws')->checkbox(['class' => 'forest'])->label(Yii::t('app', 'Я согласен с <a href="{url}" title="{name}">{name}</a>.', [
                'url' => Url::toRoute('page/laws'),
                'name' => Html::encode(Yii::t('app', 'условия использования')),
            ])) ?>
                <div class="form-group">
                    <?= Html::submitButton(Yii::t('app', 'Отправить'), ['class' => 'btn btn-primary', 'name' => 'signup-button']) ?>
                </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
