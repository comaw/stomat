<?php

/* @var $this \yii\web\View */
/* @var $content string */

use backend\assets\AppAsset;
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use common\widgets\Alert;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
    <link rel="shortcut icon" type="image/x-icon" href="/admin/css/favicon.ico">
</head>
<body>
<?php $this->beginBody() ?>

<div class="wrap">
    <?php
    NavBar::begin([
        'brandLabel' => Yii::$app->name,
        'brandUrl' => Yii::$app->homeUrl,
        'options' => [
            'class' => 'navbar-inverse navbar-fixed-top',
        ],
    ]);
    $menuItems = [];
    if (Yii::$app->user->isGuest) {
        $menuItems[] = ['label' => Yii::t('app', 'Вход'), 'url' => ['/site/login']];
    } else {
        $menuItems[] = ['label' => Yii::t('app', 'Настройки'), 'url' => ['/settings/index']];
        $menuItems[] = ['label' => Yii::t('app', 'Users'), 'url' => ['/user/index']];
        $menuItems[] = ['label' => Yii::t('app', 'Texts'),
            'items' => [
                ['label' => Yii::t('app', 'Pages'), 'url' => ['/page/index']],
                ['label' => Yii::t('app', 'News'), 'url' => ['/news/index']],
                ['label' => Yii::t('app', 'Faq'), 'url' => ['/faq/index']],
            ]
        ];
        $menuItems[] = ['label' => Yii::t('app', 'Товары'),
            'items' => [
                ['label' => Yii::t('app', 'Производители'), 'url' => ['/manufacturer/index']],
                ['label' => Yii::t('app', 'Категории'), 'url' => ['/category/index']],
                ['label' => Yii::t('app', 'Товары'), 'url' => ['/item/index']],
            ]
        ];
        $menuItems[] = ['label' => Yii::t('app', 'Заказы'),
            'items' => [
                ['label' => Yii::t('app', 'Заказы'), 'url' => ['/order/index']],
            ]
        ];
        $menuItems[] = ['label' => Yii::t('app', 'Дополнения'),
            'items' => [
                ['label' => Yii::t('app', 'Страны'), 'url' => ['/country/index']],
                ['label' => Yii::t('app', 'Характеристики товара'), 'url' => ['/characteristic/index']],
                ['label' => Yii::t('app', 'Валюта'), 'url' => ['/currency/index']],
                ['label' => Yii::t('app', 'Подпищики'), 'url' => ['/subscribe/index']],
                ['label' => Yii::t('app', 'Логи действий'), 'url' => ['/log/index']],
            ]
        ];
        $menuItems[] = '<li>'
            . Html::beginForm(['/site/logout'], 'post')
            . Html::submitButton(
                Yii::t('app', 'Выход ({user})', ['user' => Yii::$app->user->identity->username]),
                ['class' => 'btn btn-link']
            )
            . Html::endForm()
            . '</li>';
    }
    echo Nav::widget([
        'options' => ['class' => 'navbar-nav navbar-right'],
        'items' => $menuItems,
    ]);
    NavBar::end();
    ?>

    <div class="container">
        <?= Breadcrumbs::widget([
            'homeLink' => [
                'label' => Yii::t('app', 'Настройки'),
                'url' => \yii\helpers\Url::toRoute(['settings/index']),
            ],
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>
        <?= Alert::widget() ?>
        <?= $content ?>
    </div>
</div>

<footer class="footer">
    <div class="container">
        <p class="pull-left">&copy; <?=Yii::$app->name?> <?= date('Y') ?></p>
    </div>
</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
