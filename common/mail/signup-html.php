<?php
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $user common\models\User */

$resetLink = Yii::$app->urlManager->createAbsoluteUrl(['site/index']);
?>
<div class="password-reset">
    <p><?=Yii::t('app', 'Здравствуйте')?> <?= Html::encode($user->username) ?>,</p>

    <p><?=Yii::t('app', 'Вы успешно зарегистрировались на сайте {site}', ['site' => Yii::$app->name])?>:</p>

    <p><?= Html::a(Html::encode($resetLink), $resetLink) ?></p>
</div>
