<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \common\models\LoginForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = Yii::t('app', 'Вход');
$this->params['breadcrumbs'][] = $this->title;
$this->registerMetaTag(['name' => 'description', 'content' => $this->title]);
?>
<div class="site-login">
    <div class="sign-form">
        <h1 class="headline first-child text-color"><?= Html::encode($this->title) ?></h1>
        <p><?=Yii::t('app', 'Пожалуйста, заполните следующие поля для входа')?>:</p>
        <div class="row">
            <div class="col-lg-5">
                <?php $form = ActiveForm::begin(['id' => 'login-form']); ?>

                    <?= $form->field($model, 'username')->textInput(['autofocus' => true]) ?>

                    <?= $form->field($model, 'password')->passwordInput() ?>

                    <?= $form->field($model, 'rememberMe')->checkbox() ?>

                <?php if($errorLogin){ ?>
                    <?= $form->field($model, 'verifyCode')->widget(
                        \common\recaptcha\ReCaptcha::className(),
                        ['siteKey' => \common\recaptcha\ReCaptcha::SITE_KEY]
                    ) ?>
                <?php } ?>

                    <div class="form-group">
                        <?= Html::submitButton(Yii::t('app', 'Войти'), ['class' => 'btn btn-primary', 'name' => 'login-button']) ?>
                    </div>
                <?php ActiveForm::end(); ?>
                <a href="<?=\yii\helpers\Url::toRoute(['site/requestpasswordreset'])?>" title="<?=Html::encode(Yii::t('app', 'Забыли пароль?'))?>"><?=Yii::t('app', 'Забыли пароль?')?></a>
            </div>
        </div>
    </div>
</div>
