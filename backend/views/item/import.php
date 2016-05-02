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

$this->title = Yii::t('app', 'Импорт товаров');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Items'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="item-index">
    <h1><?= Html::encode($this->title) ?></h1>
    <p>
        Будет создан файл вормата <strong>.xlsx</strong>
        Все товары импортировать долго, рекомендуется установить лимиты импорта
    </p>
    <div class="row">
        <div class="col-sm-8 col-xs-12">
            <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>
            <?= $form->field($model, 'limit')->textInput()->hint(Yii::t('app', '0 - все товары')) ?>
            <?= $form->field($model, 'offset')->textInput()->hint(Yii::t('app', '0 - с первого товара')) ?>
            <div class="form-group">
                <?= Html::submitButton(Yii::t('app', 'Импорт'), ['class' => 'btn btn-primary']) ?>
            </div>
            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
