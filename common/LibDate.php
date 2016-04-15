<?php
/**
 * powered by php-shaman
 * LibDate.php 12.04.2016
 * SAAS
 */

namespace common;


use frontend\models\UserDescription;

class LibDate
{

    public static function date($time, $user = 0){
        if(!is_numeric($time)){
            $time = strtotime($time);
        }
        $format = 'm/d/Y';
        $zone = [0, 0];
        if($user){
            $user = UserDescription::getCurrent($user);
            $format = $user->date_format == 2 ? 'd/m/Y' : 'm/d/Y';
            $zone = explode(':', ltrim($user->timezone, '+'));
        }
        if($zone[0] < 0){
            $time = $time - ($zone[0] * 60 * 60) - ($zone[1] * 60);
        }else{
            $time = $time + ($zone[0] * 60 * 60) + ($zone[1] * 60);
        }
        return date($format, ($time));
    }
}