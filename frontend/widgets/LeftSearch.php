<?php
/**
 * powered by php-shaman
 * LeftSearch.php 27.04.2016
 * stomat
 */

namespace frontend\widgets;


class LeftSearch extends \yii\bootstrap\Widget
{
    public function init(){
        parent::init();
    }

    public function run(){
        return $this->render('LeftSearch', [

        ]);
    }
}