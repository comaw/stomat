<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\Characteristic */

$this->title = Yii::t('app', 'Create Characteristic');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Characteristics'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="characteristic-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
