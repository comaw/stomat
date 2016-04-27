<?php
/**
 * powered by php-shaman
 * sitemap.php 29.01.2016
 * Hashtag
 */

/* @var $model \app\models\Hashtag */

use yii\helpers\Url;

?>
<?='<?xml version="1.0" encoding="UTF-8"?>'?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
    <url>
        <loc><?=Url::home(true)?></loc>
        <lastmod><?=date("Y-m-d")?></lastmod>
        <changefreq>daily</changefreq>
        <priority>1</priority>
    </url>
    <?php foreach($models AS $model){ ?>
        <url>
            <loc><?=Url::toRoute(['category/view', 'url' => $model->url], true)?></loc>
            <lastmod><?=date("Y-m-d", time() - 60 * 60 * 24 * 5)?></lastmod>
            <changefreq>weekly</changefreq>
            <priority>0.7</priority>
        </url>
    <?php } ?>
    <?php foreach($news AS $v){ ?>
        <url>
            <loc><?=Url::toRoute(['news/view', 'url' => $v->url], true)?></loc>
            <lastmod><?=date("Y-m-d", strtotime($v->created))?></lastmod>
            <changefreq>weekly</changefreq>
            <priority>0.7</priority>
        </url>
    <?php } ?>
    <?php foreach($manufacturer AS $v){ ?>
        <url>
            <loc><?=Url::toRoute(['manufacturer/view', 'url' => $v->url], true)?></loc>
            <lastmod><?=date("Y-m-d", time() - 60 * 60 * 24 * 5)?></lastmod>
            <changefreq>weekly</changefreq>
            <priority>0.7</priority>
        </url>
    <?php } ?>
    <?php foreach($item AS $v){ ?>
        <url>
            <loc><?=Url::toRoute(['item/view', 'url' => $v->url], true)?></loc>
            <lastmod><?=date("Y-m-d", time() - 60 * 60 * 24 * 5)?></lastmod>
            <changefreq>weekly</changefreq>
            <priority>0.6</priority>
        </url>
    <?php } ?>
</urlset>
