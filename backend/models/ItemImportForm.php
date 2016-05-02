<?php
/**
 * powered by php-shaman
 * ItemPriceForm.php 23.04.2016
 * stomat
 */

namespace backend\models;

use Yii;
use yii\base\Model;


class ItemImportForm extends Model
{
    public $limit;
    public $offset;

    const FILENAME = 'tovar.xlsx';

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['limit', 'offset'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'limit' => Yii::t('app', 'Количество товаров'),
            'offset' => Yii::t('app', 'Начиная с товара номер'),
        ];
    }


}