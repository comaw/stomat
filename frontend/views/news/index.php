<?php
/**
 * powered by php-shaman
 * index.php 27.04.2016
 * stomat
 */

/* @var $this yii\web\View */
/* @var $models frontend\models\News */
/* @var $model frontend\models\News */

use frontend\models\Settings;
use yii\helpers\Html;
use yii\helpers\Url;
use common\lib\LinkPager;

$this->title = Yii::t('app', 'Новости').(Yii::$app->request->get('page')? ' - '.Yii::t('app', 'страница ').(Yii::$app->request->get('page') - 1) : '');
$this->params['breadcrumbs'][] = Yii::t('app', 'Новости');
Yii::$app->view->registerMetaTag([
    'name' => 'description',
    'content' => Yii::t('app', 'Новости').(Yii::$app->request->get('page')? ' - '.Yii::t('app', 'страница ').(Yii::$app->request->get('page') - 1) : ''),
]);

?>
<h1 class="headline first-child text-color"><?=Yii::t('app', 'Новости')?></h1>
<p><br></p>
<div class="row">
    <div class="col-xs-12">
        <?php foreach($models AS $model){ ?>
            <div class="blog-p-body">
                <h2 class="primary-font first-child"><a href="<?=Url::toRoute(['news/view', 'url' => $model->url])?>" title="<?=Html::encode($model->name)?>"><?=$model->name?></a></h2>
                <hr>
                <p class="text-muted"><time datetime="<?=$model->created?>"><?=date("d/m/Y", strtotime($model->created))?></time></p>
                <div>
                    <?=$model->small?>
                </div>
                <a href="<?=Url::toRoute(['news/view', 'url' => $model->url])?>" class="btn btn-sm btn-color pull-right"><?=Yii::t('app', 'Читать полностью')?>...</a>
            </div>
        <?php } ?>
    </div>
</div>
<div class="row">
    <div class="col-xs-12 text-center">
        <?php
        echo LinkPager::widget([
            'pagination' => $pages,
        ]);
        ?>
    </div>
</div>