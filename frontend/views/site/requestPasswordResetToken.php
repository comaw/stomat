<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \frontend\models\PasswordResetRequestForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = Yii::t('app', 'Запрос восстановления пароля');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-request-password-reset">
    <div class="sign-form">
        <h1 class="headline first-child text-color"><?= Html::encode($this->title) ?></h1>
        <p><?=Yii::t('app', 'Пожалуйста, заполните вашу электронную почту. Ссылка для сброса пароля будет отправлена туда.')?></p>
        <div class="row">
            <div class="col-lg-5">
                <?php $form = ActiveForm::begin(['id' => 'request-password-reset-form']); ?>

                    <?= $form->field($model, 'email')->textInput(['autofocus' => true]) ?>
                <?= $form->field($model, 'verifyCode')->widget(
                    \common\recaptcha\ReCaptcha::className(),
                    ['siteKey' => \common\recaptcha\ReCaptcha::SITE_KEY]
                ) ?>
                    <div class="form-group">
                        <?= Html::submitButton(Yii::t('app', 'Отправить'), ['class' => 'btn btn-primary']) ?>
                    </div>

                <?php ActiveForm::end(); ?>
            </div>
        </div>
    </div>
</div>
