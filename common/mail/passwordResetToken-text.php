<?php

/* @var $this yii\web\View */
/* @var $user common\models\User */

$resetLink = Yii::$app->urlManager->createAbsoluteUrl(['site/resetpassword', 'token' => $user->password_reset_token]);
?>
<?=Yii::t('app', 'Здравствуйте')?> <?= $user->username ?>,

<?=Yii::t('app', 'Перейдите по ссылке ниже, чтобы сбросить пароль')?>:

<?= $resetLink ?>
