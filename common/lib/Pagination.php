<?php
/**
 * powered by php-shaman
 * Pagination.php 09.03.2016
 * NewFutbolca
 */

namespace common\lib;

use yii\web\BadRequestHttpException;
use Yii;
use yii\base\Object;
use yii\web\Link;
use yii\web\Linkable;
use yii\web\Request;


class Pagination extends \yii\data\Pagination
{
    public $pageSizeParam = false;
    public $forcePageParam = false;

    public function __construct($config = [])
    {
        if(Yii::$app->request->get($this->pageParam)){
            $_GET[$this->pageParam] = (Yii::$app->request->get($this->pageParam) / Yii::$app->params['pageSize']) + 1;
        }

        parent::__construct($config);
        $this->pageSize = Yii::$app->params['pageSize'];
    }
}