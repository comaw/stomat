<?php
/**
 * powered by php-shaman
 * indexno.php 27.04.2016
 * stomat
 */

use yii\helpers\Html;
use yii\helpers\Url;
use frontend\models\SortForm;
use yii\widgets\ActiveForm;

$this->title = Yii::t('app', 'Введите фразу или слово для поиска');
$this->params['breadcrumbs'][] = $this->title;
Yii::$app->view->registerMetaTag([
    'name' => 'description',
    'content' => $this->title,
]);
?>
<h1 class="headline first-child text-color"><?=$this->title?></h1>
<div class="row">
    <div class="tab-content">
        <div class="tab-pane fade in active">
            <form role="search" id="nav-search-form" action="<?=Url::toRoute(['search/index'])?>" method="get" accept-charset="<?=Yii::$app->charset?>">
                <div class="input-group">
                    <input type="text" name="search_text" value="<?=Yii::$app->request->get('search_text')?>" class="form-control" placeholder="<?=Yii::t('app', 'Поиск')?>">
                    <span class="input-group-btn">
                        <button type="submit" class="btn btn-default"><i class="fa fa-search"></i></button>
                    </span>
                </div>
            </form>
        </div>
    </div>
</div>