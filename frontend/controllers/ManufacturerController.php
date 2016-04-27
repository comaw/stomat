<?php

namespace frontend\controllers;

use common\lib\Pagination;
use frontend\models\Category;
use frontend\models\Manufacturer;
use frontend\models\SortForm;
use Yii;
use frontend\models\Item;
use yii\helpers\Url;
use yii\web\HttpException;

class ManufacturerController extends \yii\web\Controller
{

    public function actionIndex()
    {
        $models = Manufacturer::find()->with(['items'])->orderBy('name')->all();
        return $this->render('index', [
            'models' => $models,
        ]);
    }

    public function actionView($url, $page = 0)
    {
        $sortForm = new SortForm();
        $toSort = $sortForm->getSort();
        $toStock = $sortForm->getStock();
        if($sortForm->load(Yii::$app->request->post()) && $sortForm->validate()){
            $toSort = $sortForm->getSort();
            $toStock = $sortForm->getStock();
        }else{
            $sortForm->sort = $sortForm->getSort();
            $sortForm->stock = $sortForm->getStock();
        }
        $manufacturer = Manufacturer::find()->where("url = :url", [':url' => $url])->one();
        if(!$manufacturer){
            throw new HttpException(404, 'Not found');
        }
        $query = Item::find()->with(['itemImgs', 'currency0', 'manufacturer0'])->where("manufacturer = :manufacturer", [
            ':manufacturer' => $manufacturer->id
        ]);
        if($toStock == 2){
            $query->andWhere("stock > 0");
        }
        $countQuery = clone $query;
        $pages = new Pagination(['totalCount' => $countQuery->count()]);
        $models = $query->offset($pages->offset)
            ->orderBy($toSort)
            ->limit($pages->limit)
            ->all();
        return $this->render('view', [
            'models' => $models,
            'manufacturer' => $manufacturer,
            'pages' => $pages,
            'sortForm' => $sortForm,
            'toStock' => $toStock,
        ]);
    }
}
