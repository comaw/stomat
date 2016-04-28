<?php
/* @var $this yii\web\View */
/* @var $model frontend\models\Page */

use yii\helpers\Html;
use yii\helpers\Url;

$this->title = $model->title;
$this->params['breadcrumbs'][] = $model->name;
Yii::$app->view->registerMetaTag([
    'name' => 'description',
    'content' => $model->description,
]);
?>
<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    <h4 class="modal-title" id="myModalLabel"><?=$model->name?></h4>
</div>
<div class="modal-body">
    <?=$model->content?>
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-default" data-dismiss="modal"><?=Yii::t('app', 'Закрыть')?></button>
</div>
