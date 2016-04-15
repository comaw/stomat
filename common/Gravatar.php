<?php

namespace common;


use yii\helpers\Html;

class Gravatar
{

    const URL = 'http://www.gravatar.com/avatar/';

    public static function getAvatar($email, $s = 40, $img = true, $atts = []){
        $url = self::URL;
        $url .= md5( strtolower( trim( $email ) ) );
        $url .= "?s=".(int)$s;
        if ( $img ) {
            $url = Html::img($url, $atts);
        }
        return $url;
    }
}