<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\Category */

$this->title = Yii::t('app', 'Создать категорию');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Категории'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="manufacturer-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
