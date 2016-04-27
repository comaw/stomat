<?php
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $user common\models\User */

$resetLink = Yii::$app->urlManager->createAbsoluteUrl(['site/resetpassword', 'token' => $user->password_reset_token]);
?>
<div class="password-reset">
    <p><?=Yii::t('app', 'Здравствуйте')?> <?= Html::encode($user->username) ?>,</p>

    <p><?=Yii::t('app', 'Перейдите по ссылке ниже, чтобы сбросить пароль')?>:</p>

    <p><?= Html::a(Html::encode($resetLink), $resetLink) ?></p>
</div>
