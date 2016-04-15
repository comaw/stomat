<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\Manufacturer */

$this->title = Yii::t('app', 'Обновить {modelClass}: ', [
    'modelClass' => 'Производителя',
]) . $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Производители'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="manufacturer-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
