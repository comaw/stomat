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
<div class="row">
    <div class="col-xs-12">
        <h1 class="headline first-child text-color"><?=$model->name?></h1>
        <?=$model->content?>
    </div>
</div>

