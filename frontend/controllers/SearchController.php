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
        if($sortForm->load(Yii::$app->request->post()) && $sortForm->validate()){
            $toSort = $sortForm->getSort();
        }else{
            $sortForm->sort = $sortForm->getSort();
        }
        $searchText = $search_text.'%';
        $query = Item::find()->with(['itemImgs', 'currency0', 'manufacturer0'])->where("name LIKE :name AND stock > 0", [
            ':name' => $searchText
        ]);
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
        ]);
    }
}
