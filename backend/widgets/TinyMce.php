<?php
/**
 * powered by php-shaman
 * TinyMce.php 04.01.2016
 * Naturalniy kamen
 */

namespace backend\widgets;


class TinyMce extends \yii\bootstrap\Widget
{
    public function init(){
        parent::init();
    }

    public function run(){
        return $this->render('TinyMce', [

        ]);
    }
}