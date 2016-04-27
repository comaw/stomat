<?php
/**
 * powered by php-shaman
 * LeftMenu.php 27.04.2016
 * stomat
 */

namespace frontend\widgets;


use frontend\models\Category;

class LeftMenu extends \yii\bootstrap\Widget
{
    public function init(){
        parent::init();
    }

    public function run(){
        $models = Category::find()->orderBy('name')->all();
        return $this->render('LeftMenu', [
            'models' => $models,
        ]);
    }
}