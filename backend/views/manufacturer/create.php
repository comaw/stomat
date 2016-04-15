<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\Manufacturer */

$this->title = Yii::t('app', 'Создать производителя');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Производители'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="manufacturer-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
