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
 */

class SortForm extends Model
{
    public $sort;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['sort', 'filter', 'filter' => 'trim'],
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
        ];
    }

    public static function listSort(){
        return [
            'price asc' => Yii::t('app', 'От дешевых к дорогим'),
            'price desc' => Yii::t('app', 'От дорогих к дешевым'),
            'id desc' => Yii::t('app', 'Новые послупления'),
            'name asc' => Yii::t('app', 'По имени'),
        ];
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