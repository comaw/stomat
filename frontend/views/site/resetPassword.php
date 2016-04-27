<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \frontend\models\ResetPasswordForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = Yii::t('app', 'Восстановление пароля');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-reset-password">
    <div class="sign-form">
        <h1 class="headline first-child text-color"><?= Html::encode($this->title) ?></h1>
        <p><?=Yii::t('app', 'Пожалуйста, выберите ваш новый пароль')?>:</p>
        <div class="row">
            <div class="col-lg-5">
                <?php $form = ActiveForm::begin(['id' => 'reset-password-form']); ?>
                    <?= $form->field($model, 'password')->passwordInput(['autofocus' => true]) ?>
                    <div class="form-group">
                        <?= Html::submitButton(Yii::t('app', 'Сохранить'), ['class' => 'btn btn-primary']) ?>
                    </div>
                <?php ActiveForm::end(); ?>
            </div>
        </div>
    </div>
</div>
