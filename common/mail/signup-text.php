<?php

/* @var $this yii\web\View */
/* @var $user common\models\User */

$resetLink = Yii::$app->urlManager->createAbsoluteUrl(['site/index']);
?>
<?=Yii::t('app', 'Здравствуйте')?> <?= $user->username ?>,

<?=Yii::t('app', 'Вы успешно зарегистрировались на сайте {site}', ['site' => Yii::$app->name])?>:

<?= $resetLink ?>
