<?php
/**
 * powered by php-shaman
 * UrlHelp.php 04.01.2016
 * Naturalniy kamen
 */

namespace common;

use Yii;
use yii\helpers\Url;

class UrlHelp extends Url
{
    /**
     * @param $str
     * @param string $character
     * @param bool $trim
     *
     * @return mixed|string
     */
    public static function reduceMultiples($str, $character = ',', $trim = FALSE){
        $str = preg_replace('#'.preg_quote($character, '#').'{2,}#', $character, $str);
        if($trim === TRUE) {
            $str = trim($str, $character);
        }
        return $str;
    }

    /**
     * @param $str
     *
     * @return string
     */
    public static function translateUrl($str, $suffle = false){
        $search		= '_';
        $replace	= '-';
        if($suffle){
            $search		= '-';
            $replace	= '_';
        }
        $go = "а б в г д е ё ж з и й к л м н о п р с т у ф х ц ч ш щ ъ ы ь э ю я А Б В Г Д Е Ё Ж З И Й К Л М Н О П Р С Т У Ф Х Ц Ч Ш Щ Ъ Ы Ь Э Ю Я ' \" ( ) [ ] { } . ,";
        $to = "a b v g d e jo zh z i j k l m n o p r s t u f h c ch sh shh i y i je ju ja A B V G D E Jo Zh Z I J K L M N O P R S T U F H C Ch Sh Shh II Y II JE JU JA _ _ _ _ _ _ _ _ - -";
        $go = explode(" ", $go);
        $to = explode(" ", $to);
        $str = str_replace($go, $to, trim($str));
        $trans = array(
            '&\#\d+?;'				=> '',
            '&\S+?;'				=> '',
            '\s+'					=> $replace,
            '[^a-z0-9\-\._]'		=> '',
            $search.'+'			=> $replace,
            $search.'$'			=> $replace,
            '^'.$search			=> $replace,
            '\.+$'					=> ''
        );
        $str = strip_tags($str);
        foreach ($trans as $key => $val){
            $str = preg_replace("#".$key."#i", $val, $str);
        }
        $str = mb_strtolower($str, 'UTF-8');
        $str = self::reduceMultiples($str, '-', true);
        return trim(stripslashes($str));
    }

    public static function baseAdmin(){
        return self::reduceMultiples(str_replace('admin', '', self::base()), '/');
    }
}