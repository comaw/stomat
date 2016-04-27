<?php
/**
 * powered by php-shaman
 * TpMenu.php 27.04.2016
 * stomat
 */

namespace frontend\widgets;


class TpMenu extends \yii\bootstrap\Widget
{
    public function init(){
        parent::init();
    }

    public function run(){
        return $this->render('TpMenu', [

        ]);
    }
}