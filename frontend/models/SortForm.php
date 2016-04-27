<?php
/**
 * powered by php-shaman
 * SortForm.php 27.04.2016
 * stomat
 */

namespace frontend\models;

use common\models\User;
use yii\base\Model;
use Yii;

/**
 * @property string $sort
 * @property string $stock
 */

class SortForm extends Model
{
    public $sort;
    public $stock;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['sort', 'filter', 'filter' => 'trim'],
            ['stock', 'in', 'range' => [1, 2]],
            ['sort', 'in', 'range' => array_keys(self::listSort())],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'sort' => Yii::t('app', 'Сортировать'),
            'stock' => Yii::t('app', 'Наличие товара'),
        ];
    }

    public static function listStock(){
        return [
            1 => Yii::t('app', 'Все товары'),
            2 => Yii::t('app', 'Только в наличии'),
        ];
    }

    public static function listSort(){
        return [
            'price asc' => Yii::t('app', 'От дешевых к дорогим'),
            'price desc' => Yii::t('app', 'От дорогих к дешевым'),
            'id desc' => Yii::t('app', 'Новые поступления'),
            'name asc' => Yii::t('app', 'По имени'),
        ];
    }

    public function getStock(){
        $stock = 1;
        if($this->stock){
            Yii::$app->session->set('stock', $this->stock);
            $stock = (int)$this->stock;
        }
        if(Yii::$app->session->get('stock')){
            $stock = Yii::$app->session->get('stock');
            $this->stock = $stock;
        }
        if(!$this->validate()){
            $stock = 1;
            $this->stock = $stock;
        }
        return $stock;
    }

    public function getSort(){
        $sort = null;
        if($this->sort){
            Yii::$app->session->set('formSort', $this->sort);
            $sort = $this->sort;
        }
        if(Yii::$app->session->get('formSort')){
            if($this->validate()){
                $sort = Yii::$app->session->get('formSort');
            }
        }
        if(!$sort){
            $sort = 'id desc';
        }
        return $sort;
    }
}