<?php

namespace frontend\controllers;

use frontend\models\Page;
use Yii;
use yii\web\HttpException;

class PageController extends \yii\web\Controller
{
    public function actionView($url = null)
    {
        $model = Page::find()->where('url = :url', [':url' => $url])->one();
        if(!$model){
            throw new HttpException(404, 'Страница не найдена');
        }
        if(Yii::$app->request->isAjax){
            return $this->renderPartial('viewIsAjax', [
                'model' => $model,
            ]);
        }
        return $this->render('view', [
            'model' => $model,
        ]);
    }

}
