<?php
/**
 * powered by php-shaman
 * LinkPager.php 09.03.2016
 * NewFutbolca
 */

namespace common\lib;

use yii\helpers\Html;
use yii\helpers\Url;
use Yii;


class LinkPager extends \yii\widgets\LinkPager
{
    public $options = ['class' => 'page-nav22'];
    /**
     * @var string the CSS class for the "first" page button.
     */
    public $firstPageCssClass = '';
    /**
     * @var string the CSS class for the "last" page button.
     */
    public $lastPageCssClass = '';
    /**
     * @var string the CSS class for the "previous" page button.
     */
    public $prevPageCssClass = '';
    /**
     * @var string the CSS class for the "next" page button.
     */
    public $nextPageCssClass = '';
    /**
     * @var string the CSS class for the active (currently selected) page button.
     */
    public $activePageCssClass = 'active';
    /**
     * @var string the CSS class for the disabled page buttons.
     */
    public $disabledPageCssClass = '';
    /**
     * @var string|boolean the label for the "next" page button. Note that this will NOT be HTML-encoded.
     * If this property is false, the "next" page button will not be displayed.
     */
    public $nextPageLabel = '>';
    /**
     * @var string|boolean the text label for the previous page button. Note that this will NOT be HTML-encoded.
     * If this property is false, the "previous" page button will not be displayed.
     */
    public $prevPageLabel = '<';

    public function init()
    {
        parent::init();
        $this->registerLinkTags = true;
    }

    public function run()
    {
        parent::run();
    }

    protected function renderPageButton($label, $page, $class, $disabled, $active)
    {
        $options = ['class' => empty($class) ? $this->pageCssClass : $class];
        if ($active) {
            Html::addCssClass($options, $this->activePageCssClass);
        }
        if ($disabled) {
            Html::addCssClass($options, $this->disabledPageCssClass);

            return Html::tag('li', Html::tag('span', $label), $options);
        }
        $linkOptions = $this->linkOptions;
        $linkOptions['data-page'] = $page;
        $page = $page * Yii::$app->params['pageSize'] - 1;
        if($active){
            $options['rel'] = 'nofollow';
        }
        return Html::tag('li', Html::a($label, $this->pagination->createUrl($page), $linkOptions), $options);
    }
}