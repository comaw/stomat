<?php

namespace frontend\controllers;

use common\lib\Pagination;
use frontend\models\Item;
use frontend\models\SortForm;
use Yii;

class SearchController extends \yii\web\Controller
{
    public function actionIndex($search_text, $page = 0)
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
        $searchText = $search_text.'%';
        if(mb_strlen($searchText, Yii::$app->charset) < 2){
            return $this->render('indexno');
        }
        $query = Item::find()->with(['itemImgs', 'currency0', 'manufacturer0'])->where("name LIKE :name", [
            ':name' => $searchText
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
        return $this->render('index', [
            'models' => $models,
            'pages' => $pages,
            'search_text' => $search_text,
            'sortForm' => $sortForm,
            'toStock' => $toStock,
        ]);
    }
}
