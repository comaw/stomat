<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\Page;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model app\models\Page */
/* @var $form yii\widgets\ActiveForm */
?>

<?=\backend\widgets\TinyMce::widget()?>

<div class="page-form">

    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
    <?php if(!$model->isNewRecord){ ?>
        <?= $form->field($model, 'url')->textInput(['maxlength' => true]) ?>
    <?php } ?>
    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'description')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'content')->textarea(['rows' => 6, 'class' => 'myTinyMce']) ?>

    <?= $form->field($model, 'imageFile')->fileInput() ?>
    <?php if(!$model->isNewRecord && $model->img){ ?>
        <div class="row">
            <div class="col-xs-12">
                <img src="<?=Page::getUrlImg($model->img)?>" alt="" style="max-height: 150px;">
                <a href="<?=Url::toRoute(['page/imgdel', 'id' => $model->id])?>" class="btn btn-danger btn-sm" onclick="return confirm('<?=Yii::t('app', 'Are you sure you want to delete this image?')?>');"><?=Yii::t('app', 'Delete')?></a>
                <br><br>
            </div>
        </div>
    <?php } ?>
    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
