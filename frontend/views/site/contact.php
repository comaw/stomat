<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \frontend\models\ContactForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\captcha\Captcha;

$this->title = Yii::t('app', 'Контакты');
$this->params['breadcrumbs'][] = $this->title;
Yii::$app->view->registerMetaTag([
    'name' => 'description',
    'content' => Yii::t('app', 'Контакты'),
]);
?>
<div class="site-contact">
    <h1 class="headline first-child text-color"><?=$this->title?></h1>
    <p>
        <?=Yii::t('app', 'Если у вас есть деловое предложение или другие вопросы, пожалуйста, заполните следующую форму, чтобы связаться с нами. Спасибо.')?>
    </p>
    <div class="row">
        <div class="col-lg-8 col-xs-12">
            <?php $form = ActiveForm::begin(['id' => 'contact-form']); ?>

                <?= $form->field($model, 'name')->textInput(['autofocus' => true]) ?>

                <?= $form->field($model, 'email') ?>

                <?= $form->field($model, 'subject') ?>

                <?= $form->field($model, 'body')->textArea(['rows' => 6]) ?>

            <?= $form->field($model, 'verifyCode')->widget(
                \common\recaptcha\ReCaptcha::className(),
                ['siteKey' => \common\recaptcha\ReCaptcha::SITE_KEY]
            ) ?>

                <div class="form-group">
                    <?= Html::submitButton(Yii::t('app', 'Отправить'), ['class' => 'btn btn-primary', 'name' => 'contact-button']) ?>
                </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>

</div>
