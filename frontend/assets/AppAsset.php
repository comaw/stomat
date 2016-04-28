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
        '//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css',
        'template/font-awesome.min.css',
        'template/lightbox.css',
        'template/animate.css',
        'template/css',
        'template/css(1)',
        'template/color-styles.css',
        'template/ui-elements.css',
        'template/custom.css',
    ];
    public $js = [
        '//code.jquery.com/ui/1.11.4/jquery-ui.js',
        'template/lightbox.min.js',
        'template/inputmask/jquery.inputmask.bundle.min.js',
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
