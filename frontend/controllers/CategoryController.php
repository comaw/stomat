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

class CategoryController extends \yii\web\Controller
{
    public function actionView($url, $manufacturer = null, $page = 0)
    {
        $sortForm = new SortForm();
        $toSort = $sortForm->getSort();
        if($sortForm->load(Yii::$app->request->post()) && $sortForm->validate()){
            $toSort = $sortForm->getSort();
        }else{
            $sortForm->sort = $sortForm->getSort();
        }
        $category = Category::find()->where("url = :url", [':url' => $url])->one();
        if(!$category){
            throw new HttpException(404, 'Not found');
        }
        $query = Item::find()->with(['itemImgs', 'currency0', 'manufacturer0'])->where("category = :category AND stock > 0", [
            ':category' => $category->id
        ]);
        if($manufacturer){
            $manufacturer = Manufacturer::find()->where("url = :url", [':url' => $manufacturer])->one();
            if(!$manufacturer){
                throw new HttpException(404, 'Not found');
            }
            $query->andWhere("manufacturer = :manufacturer", [':manufacturer' => $manufacturer->id]);
        }
        $countQuery = clone $query;
        $pages = new Pagination(['totalCount' => $countQuery->count()]);
        $models = $query->offset($pages->offset)
            ->orderBy($toSort)
            ->limit($pages->limit)
            ->all();
        $manufacturers = Manufacturer::find()
            ->innerJoin('{{%item}}', '{{%item}}.manufacturer = {{%manufacturer}}.id')
            ->where('{{%item}}.category = :category AND {{%item}}.stock > 0', [
                ':category' => $category->id
            ])
            ->orderBy('name, id desc')->all();
        return $this->render('view', [
            'models' => $models,
            'category' => $category,
            'pages' => $pages,
            'manufacturers' => $manufacturers,
            'manufacturerCurrent' => $manufacturer,
            'sortForm' => $sortForm,
        ]);
    }

}
