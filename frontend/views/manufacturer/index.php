<?php
/**
 * powered by php-shaman
 * index.php 27.04.2016
 * stomat
 */

/* @var $this yii\web\View */
/* @var $models frontend\models\Manufacturer */
/* @var $model frontend\models\Manufacturer */

use frontend\models\Settings;
use yii\helpers\Html;
use yii\helpers\Url;

$this->title = Yii::t('app', 'Производители');
$this->params['breadcrumbs'][] = Yii::t('app', 'Производители');
Yii::$app->view->registerMetaTag([
    'name' => 'description',
    'content' => Yii::t('app', 'Производители'),
]);

?>
<h1 class="headline first-child text-color"><?=Yii::t('app', 'Производители')?></h1>
<div class="row">
    <div class="tab-content">
        <div class="tab-pane fade in active">
            <ul class="">
            <?php foreach($models AS $model){ ?>
                <li><?=Html::a($model->name, ['manufacturer/view', 'url' => $model->url])?> (<?=$model->itemsByCount?>)</li>
            <?php } ?>
            </ul>
        </div>
    </div>
</div>