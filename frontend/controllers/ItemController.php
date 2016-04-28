<?php

namespace frontend\controllers;

use frontend\models\Item;
use yii\web\HttpException;

class ItemController extends \yii\web\Controller
{

    public function actionView($url)
    {
        $model = Item::find()->with(['itemCharacteristics', 'category0', 'manufacturer0', 'country0', 'itemImgs'])->where("url = :url", [':url' => $url])->one();
        if(!$model){
            throw new HttpException(404, 'Not found');
        }
        $models = Item::find()->with(['category0', 'manufacturer0', 'itemImgs'])
            ->where("id BETWEEN :id1 AND :id2", [
                ':id1' => ($model->id - 30),
                ':id2' => ($model->id + 30),
            ])
            ->andWhere("stock > 0")
            ->andWhere("id != :idCurrent", [':idCurrent' => $model->id])
            ->orderBy('id asc')
            ->offset(rand(0, 3))
            ->limit(3)
            ->all();
        return $this->render('view', [
            'model' => $model,
            'models' => $models,
        ]);
    }
}
