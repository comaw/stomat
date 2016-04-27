<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace frontend\assets;

use yii\web\AssetBundle;

/**
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'template/font-awesome.min.css',
        'template/animate.css',
        'template/css',
        'template/css(1)',
        'template/color-styles.css',
        'template/ui-elements.css',
        'template/custom.css',
    ];
    public $js = [
        'template/scrolltopcontrol.js',
        'template/jquery.sticky.js',
        'template/custom.js',
        'template/home.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
}
