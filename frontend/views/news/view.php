<?php
/**
 * powered by php-shaman
 * view.php 27.04.2016
 * stomat
 */


/* @var $this yii\web\View */
/* @var $model frontend\models\News */


use yii\helpers\Html;
use yii\helpers\Url;

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Новости'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $model->name;
Yii::$app->view->registerMetaTag([
    'name' => 'description',
    'content' => $model->description,
]);

?>
<div class="blog-p-body">
    <h1><?=$model->name?></h1>
    <hr>
    <p class="text-muted"><time datetime="<?=$model->created?>"><?=date("d/m/Y", strtotime($model->created))?></time></p>
    <div>
        <?=$model->content?>
    </div>
</div>