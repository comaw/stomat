<?php
/**
 * powered by php-shaman
 * LeftNews.php 27.04.2016
 * stomat
 */

namespace frontend\widgets;


use frontend\models\News;

class LeftNews extends \yii\bootstrap\Widget
{
    public function init(){
        parent::init();
    }

    public function run(){
        $models = News::find()->orderBy('id desc')->limit(2)->all();
        return $this->render('LeftNews', [
            'models' => $models,
        ]);
    }
}