<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use frontend\assets\AppAsset;
use common\widgets\Alert;
use yii\helpers\Url;
use frontend\models\Settings;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="author" content="php-shaman">
    <meta http-equiv="Cache-Control" content="no-cache">
    <meta http-equiv="Cache-Control" content="max-age=100, must-revalidate">
    <meta name="robots" content="<?=(mb_substr_count($this->title, '404', Yii::$app->charset) > 0 ? 'noindex,nofollow' : 'all')?>">
    <meta name="revisit-after" content="1 days">
    <meta name="generator" content="php-shaman">
    <link rel="canonical" href="<?=Url::canonical()?>">
    <?= Html::csrfMetaTags() ?>
    <?php if($this->title){ ?>
        <title><?= Html::encode($this->title). ' | ' . Html::encode(Yii::$app->name) ?></title>
    <?php }else{ ?>
        <title><?= Html::encode(Yii::$app->name) ?></title>
    <?php } ?>
    <?php $this->head() ?>
    <style type="text/css" id="Documents_extension_style">@keyframes documents_linkInserted { from{ clip:rect(1px, auto, auto, auto); }to{ clip:rect(0px, auto, auto, auto); } }@-webkit-keyframes documents_linkInserted { from{ clip:rect(1px, auto, auto, auto); }to{ clip:rect(0px, auto, auto, auto); } }a { animation: documents_linkInserted 1ms; -webkit-animation: documents_linkInserted 1ms; }</style>
    <link rel="shortcut icon" href="/css/favicon.ico">
    <style>
        .ui-autocomplete {
            max-height: 200px;
            overflow-y: auto;
            /* prevent horizontal scrollbar */
            overflow-x: hidden;
            z-index: 9999;
        }
        /* IE 6 doesn't support max-height
         * we use height instead, but this forces the menu to always be this tall
         */
        * html .ui-autocomplete {
            height: 200px;
        }
    </style>
</head>
<body class="body-green">
<?php $this->beginBody() ?>
<div class="mini-navbar mini-navbar-dark hidden-xs">
    <div class="container">
        <div class="col-sm-12">
            <a href="mailto:<?=Settings::getSettings('site_email')?>" class="first-child"><i class="fa fa-envelope"></i> <?=Yii::t('app', 'Email')?><span class="hidden-sm">: <?=Settings::getSettings('site_email')?></span></a>
            <span class="phone">
                <i class="fa fa-phone-square"></i> <?=Yii::t('app', 'Tel.:')?> <?=Settings::getSettings('site_phone')?>
            </span>
            <a href="<?=Url::toRoute(['site/signup'])?>" class="pull-right" title="<?=Html::encode(Yii::t('app', 'Регистрация'))?>"><i class="fa fa-arrow-circle-down"></i> <?=Yii::t('app', 'Регистрация')?></a>
            <a href="<?=Url::toRoute(['site/login'])?>" class="pull-right" title="<?=Html::encode(Yii::t('app', 'Войти'))?>"><i class="fa fa-sign-in"></i> <?=Yii::t('app', 'Войти')?></a>
            <a href="#" class="pull-right" id="nav-search"><i class="fa fa-search"></i> <?=Yii::t('app', 'Поиск')?></a>
            <a href="#" class="pull-right hidden" id="nav-search-close"><i class="fa fa-times"></i></a>
            <form class="pull-right hidden" role="search" id="nav-search-form" action="<?=Url::toRoute(['search/index'])?>" method="get" accept-charset="<?=Yii::$app->charset?>">
                <div class="input-group">
                    <input type="text" name="search_text" value="<?=Yii::$app->request->get('search_text')?>" class="form-control" placeholder="<?=Yii::t('app', 'Поиск')?>">
                    <span class="input-group-btn">
                        <button type="submit" class="btn btn-default"><i class="fa fa-search"></i></button>
                    </span>
                </div>
            </form>
        </div>
    </div>
</div>
<div id="undefined-sticky-wrapper" class="sticky-wrapper" style="height: 75px;">
    <div class="navbar navbar-dark navbar-static-top" role="navigation">
        <div class="container">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                    <span class="sr-only"><!--noindex--><?=Yii::t('app', 'Переключение навигации')?><!--/noindex--></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="<?=Url::home()?>" title="<?=Html::encode(Yii::$app->name)?>"><i class="fa fa-th-large"></i> <?=Yii::$app->name?> <span class="hidden-sm"><?=Yii::t('app', 'медтехника')?></span></a>
            </div>
            <div class="navbar-collapse collapse">
                <?=\frontend\widgets\TpMenu::widget()?>
                <form class="navbar-form navbar-left visible-xs" role="search" action="<?=Url::toRoute(['search/index'])?>" method="get" accept-charset="<?=Yii::$app->charset?>">
                    <div class="form-group">
                        <input type="text" name="search_text" value="<?=Yii::$app->request->get('search_text')?>" class="form-control" placeholder="<?=Yii::t('app', 'Поиск')?>">
                    </div>
                    <button type="submit" class="btn btn-default"><?=Yii::t('app', 'Искать!')?></button>
                </form>
            </div>
        </div>
    </div>
</div>
<div class="wrapper">
    <?php if(isset($this->params['breadcrumbs'])){ ?>
    <div class="topic">
        <div class="container">
            <div class="row">
                <div class="col-sm-12">
                    <?= \common\lib\Breadcrumbs::widget([
                        'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
                    ]) ?>
                </div>
            </div>
        </div>
    </div>
    <?php } ?>
    <div class="container">
        <div class="row">
            <div class="col-sm-3">
                <div class="shop-category first-child"><?=Yii::t('app', 'Категории')?></div>
                <?=\frontend\widgets\LeftMenu::widget()?>
                <?=\frontend\widgets\LeftNews::widget()?>
            </div>
            <div class="col-sm-9">
                <?=$content?>
            </div>
        </div>
    </div>
</div>
<footer class="footer-dark">
    <div class="container">
        <div class="row">
            <div class="col-sm-3">
                <h3 class="text-color"><span class="border-color"><?=Yii::t('app', 'Свяжитесь с нами')?></span></h3>
                <div class="content">
                    <p>
                        <?=Settings::getSettings('office_address')?><br>
                        <?=Yii::t('app', 'Телефон')?>: <?=Settings::getSettings('site_phone')?><br>
                        <?php if(Settings::getSettings('site_phone2')){ ?>
                            <?=Yii::t('app', 'Киевстар')?>: <?=Settings::getSettings('site_phone2')?><br>
                        <?php } ?>
                        <?php if(Settings::getSettings('site_phone3')){ ?>
                            <?=Yii::t('app', 'Городской')?>: <?=Settings::getSettings('site_phone3')?><br>
                        <?php } ?>
                        <?php if(Settings::getSettings('site_fax')){ ?>
                        <?=Yii::t('app', 'Fax')?>: <?=Settings::getSettings('site_fax')?><br>
                        <?php } ?>
                        <?=Yii::t('app', 'Email')?>: <a href="mailto:<?=Settings::getSettings('site_email')?>"><?=Settings::getSettings('site_email')?></a>
                    </p>
                </div>
            </div>
            <div class="col-sm-3">
                <h3 class="text-color"><span class="border-color"><?=Yii::t('app', 'Карта')?></span></h3>
                <div class="content">
                    <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d758.4625582371327!2d28.670646893842047!3d50.251712004055925!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x472c649a2fc50ae9%3A0x8edf4b4944637568!2zMkEsINCy0YPQuy4g0IbQstCw0L3QsCDQmtC-0YfQtdGA0LPQuCwgMtCQLCDQltC40YLQvtC80LjRgCwg0JbQuNGC0L7QvNC40YDRgdGM0LrQsCDQvtCx0LvQsNGB0YLRjA!5e0!3m2!1sru!2sua!4v1461743363726" width="200" height="150" frameborder="0" style="border:0" allowfullscreen></iframe>
                </div>
            </div>
            <div class="col-sm-2">
                <h3 class="text-color"><span><?=Yii::t('app', 'Соц. сети')?></span></h3>
                <div class="content social">
                    <p><?=Yii::t('app', 'Будьте с нами на связи')?>:</p>
                    <!--noindex-->
                    <ul class="list-inline">
                        <?php if(Settings::getSettings('twitter_soc')){ ?>
                            <li><a href="<?=Settings::getSettings('twitter_soc')?>" class="twitter" rel="nofollow" target="_blank"><i class="fa fa-twitter"></i></a></li>
                        <?php } ?>
                        <?php if(Settings::getSettings('facebook_soc')){ ?>
                            <li><a href="<?=Settings::getSettings('facebook_soc')?>" class="facebook" rel="nofollow" target="_blank"><i class="fa fa-facebook"></i></a></li>
                        <?php } ?>
                        <?php if(Settings::getSettings('linkedin_soc')){ ?>
                            <li><a href="<?=Settings::getSettings('linkedin_soc')?>" class="linkedin" rel="nofollow" target="_blank"><i class="fa fa-linkedin"></i></a></li>
                        <?php } ?>
                        <?php if(Settings::getSettings('vk_soc')){ ?>
                            <li><a href="<?=Settings::getSettings('vk_soc')?>" class="vk" rel="nofollow" target="_blank"><i class="fa fa-vk"></i></a></li>
                        <?php } ?>
                        <?php if(Settings::getSettings('plus_soc')){ ?>
                            <li><a href="<?=Settings::getSettings('plus_soc')?>" class="plus" rel="nofollow" target="_blank"><i class="fa fa-plus"></i></a></li>
                        <?php } ?>
                    </ul>
                    <!--/noindex-->
                    <div class="clearfix"></div>
                </div>
            </div>
            <div class="col-sm-3">
                <h3 class="text-color"><span><?=Yii::t('app', 'Подписки')?></span></h3>
                <div class="content">
                    <p><?=Yii::t('app', 'Введите адрес электронной почты ниже, чтобы подписаться на нашу бесплатную рассылку.')?><br><?=Yii::t('app', 'Мы обещаем не беспокоить вас часто!')?></p>
                    <form class="form" role="form" action="javascript:void(0);" method="post" accept-charset="<?=Yii::$app->charset?>">
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="input-group">
                                    <label class="sr-only" for="subscribe-email"><?=Yii::t('app', 'Email')?></label>
                                    <input type="email" class="form-control" name="subscribe-email" id="subscribe-email" placeholder="<?=Yii::t('app', 'Введите email')?>">
                                    <span class="input-group-btn">
                                        <button type="submit" class="btn btn-default" id="subscribe-ok"><?=Yii::t('app', 'OK')?></button>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="row"><div class="col-sm-12"><hr></div></div>
        <div class="row">
            <div class="col-sm-12">
                <p>
                    © <?=Yii::$app->name?> <?=date("Y")?>.
                    <a href="<?=Url::toRoute(['page/view', 'url' => 'policy'])?>" title="<?=Html::encode(Yii::t('app', 'Политика конфиденциальности'))?>"><?=Yii::t('app', 'Политика конфиденциальности')?></a> |
                    <a href="<?=Url::toRoute(['page/view', 'url' => 'terms'])?>" title="<?=Html::encode(Yii::t('app', 'Условия использования'))?>"><?=Yii::t('app', 'Условия использования')?></a>
                </p>
            </div>
        </div>
    </div>
</footer>
<?php $this->endBody() ?>
<div id="topcontrol" title="<?=Yii::t('app', 'Вверх')?>" style="position: fixed; bottom: 5px; right: 5px; opacity: 0; cursor: pointer;"><i class="fa fa-angle-up backtotop"></i></div>
</body>
</html>
<?php $this->endPage() ?>
