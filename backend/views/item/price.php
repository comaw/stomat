<?php
/**
 * powered by php-shaman
 * price.php 23.04.2016
 * stomat
 */

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\Item */

$this->title = Yii::t('app', 'Обновить цены Excel');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Items'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="item-index">
    <h1><?= Html::encode($this->title) ?></h1>
    <p>
        Файл должен быть в формате <strong>.xlsx</strong>
        (если в другом формате - открыть файл, выбрать "<strong>Сохранить как</strong>" - "<strong>Книга Excel</strong>")
    </p>
    <p>
        В файле должно быть 5 строк (код товара, наименование, количство, цена, общая цена).
        У всех товаров должен быть <strong>уникальны код</strong>. Именно коду будет идти оиск товара и обновление цны.
    </p>
    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>
    <?= $form->field($model, 'file')->fileInput() ?>
    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Обновить'), ['class' => 'btn btn-primary']) ?>
    </div>
    <?php ActiveForm::end(); ?>
</div>
