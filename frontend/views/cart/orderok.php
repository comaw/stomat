<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \frontend\models\SignupForm */

use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\ActiveForm;

$this->title = Yii::t('app', 'Заказ принят на обработку');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Корзина'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-signup">
    <h1 class="headline first-child text-color"><?= Html::encode($this->title) ?></h1>
    <div class="row">
        <div class="col-lg-9 col-xs-12">
            <p><?=Yii::t('app', 'Заказ принят на обработку. Наши менеджеры скоро с вами свяжутся.')?></p>
        </div>
    </div>
</div>