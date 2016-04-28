<?php
/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \frontend\models\User */
/* @var $description \frontend\models\UserDescription */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = Yii::t('app', 'Настройки');
$this->params['breadcrumbs'][] = $this->title;
$this->registerMetaTag(['name' => 'description', 'content' => $this->title]);

?>
<div class="site-login">
    <div class="sign-form">
        <h1 class="headline first-child text-color"><?= Html::encode($this->title) ?></h1>
        <div class="row">
            <div class="col-lg-9">
                <?php $form = ActiveForm::begin(['id' => 'user-form']); ?>

                <?= $form->field($model, 'username')->textInput() ?>
                <?= $form->field($model, 'email')->textInput() ?>
                <?= $form->field($model, 'pass')->passwordInput()->hint(Yii::t('app', 'Оставить пустым, если не нужно изменять!')) ?>
                <?= $form->field($model, 'confirm')->passwordInput() ?>

                <?= $form->field($description, 'phone')->textInput(['placeholder' => '+38 (099) 999-99-99']) ?>
                <?= $form->field($description, 'zipcode')->textInput() ?>
                <?= $form->field($description, 'state')->textInput() ?>
                <?= $form->field($description, 'city')->textInput() ?>
                <?= $form->field($description, 'address')->textInput() ?>
                <div class="form-group">
                    <?= Html::submitButton(Yii::t('app', 'Сохранить'), ['class' => 'btn btn-primary', 'name' => 'login-button']) ?>
                </div>
                <?php ActiveForm::end(); ?>
            </div>
        </div>
    </div>
</div>