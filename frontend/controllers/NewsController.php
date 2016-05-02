<?php

namespace frontend\controllers;

use frontend\models\News;
use common\lib\Pagination;
use yii\web\HttpException;

class NewsController extends \yii\web\Controller
{
    public function actionIndex($page = null)
    {
        $query = News::find();
        $countQuery = clone $query;
        $pages = new Pagination(['totalCount' => $countQuery->count()]);
        $models = $query->offset($pages->offset)
            ->limit($pages->limit)
            ->all();
        return $this->render('index', [
            'models' => $models,
            'pages' => $pages,
        ]);
    }

    public function actionView($url)
    {
        $model = News::find()->where("url = :url", [':url' => $url])->one();
        if(!$model){
            throw  new HttpException(404, 'Not found');
        }
        return $this->render('view', [
            'model' => $model,
        ]);
    }
}
