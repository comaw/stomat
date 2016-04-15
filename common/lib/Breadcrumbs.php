<?php
/**
 * powered by php-shaman
 * Breadcrumbs.php 11.03.2016
 * NewFutbolca
 */

namespace common\lib;


use Yii;
use yii\base\InvalidConfigException;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;

class Breadcrumbs extends \yii\widgets\Breadcrumbs
{
    public $activeItemTemplate = "<!--noindex--><li class=\"active\">{link}</li><!--/noindex-->\n";
    public $itemTemplate = "<li>{link}</li> <li>/</li>\n";

    protected function renderItem($link, $template)
    {
        $encodeLabel = ArrayHelper::remove($link, 'encode', $this->encodeLabels);
        if (array_key_exists('label', $link)) {
            $label = $encodeLabel ? Html::encode($link['label']) : $link['label'];
        } else {
            throw new InvalidConfigException('The "label" element is required for each link.');
        }
        if (isset($link['template'])) {
            $template = $link['template'];
        }
        if (isset($link['url'])) {
            $options = $link;
            unset($options['template'], $options['label'], $options['url']);
            $options['title'] = $label;
            $link = Html::a($label, $link['url'], $options);
        } else {
            $link = $label;
        }
        return strtr($template, ['{link}' => $link]);
    }
}