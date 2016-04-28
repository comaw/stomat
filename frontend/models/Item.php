<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "{{%item}}".
 *
 * @property string $id
 * @property string $name
 * @property string $url
 * @property integer $home
 * @property string $title
 * @property string $description
 * @property string $content
 * @property string $code
 * @property string $currency
 * @property string $category
 * @property string $manufacturer
 * @property string $country
 * @property string $price
 * @property string $unit
 * @property integer $stock
 * @property integer $warranty
 * @property integer $delivery
 * @property integer $delivery_time
 * @property string $packing
 * @property string $created
 *
 * @property Currency $currency0
 * @property Category $category0
 * @property Manufacturer $manufacturer0
 * @property Country $country0
 * @property ItemCharacteristic[] $itemCharacteristics
 * @property ItemImg[] $itemImgs
 */
class Item extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%item}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'url', 'code', 'currency', 'category'], 'required'],
            [['home', 'currency', 'category', 'manufacturer', 'country', 'stock', 'warranty', 'delivery', 'delivery_time'], 'integer'],
            [['content'], 'string'],
            [['price'], 'number'],
            [['created'], 'safe'],
            [['name', 'url', 'title', 'description', 'packing'], 'string', 'max' => 255],
            [['code', 'unit'], 'string', 'max' => 20],
            [['name'], 'unique'],
            [['url'], 'unique'],
            [['code'], 'unique'],
            [['currency'], 'exist', 'skipOnError' => true, 'targetClass' => Currency::className(), 'targetAttribute' => ['currency' => 'id']],
            [['category'], 'exist', 'skipOnError' => true, 'targetClass' => Category::className(), 'targetAttribute' => ['category' => 'id']],
            [['manufacturer'], 'exist', 'skipOnError' => true, 'targetClass' => Manufacturer::className(), 'targetAttribute' => ['manufacturer' => 'id']],
            [['country'], 'exist', 'skipOnError' => true, 'targetClass' => Country::className(), 'targetAttribute' => ['country' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'name' => Yii::t('app', 'Name'),
            'url' => Yii::t('app', 'Url'),
            'home' => Yii::t('app', 'Home'),
            'title' => Yii::t('app', 'Title'),
            'description' => Yii::t('app', 'Description'),
            'content' => Yii::t('app', 'Content'),
            'code' => Yii::t('app', 'Code'),
            'currency' => Yii::t('app', 'Currency'),
            'category' => Yii::t('app', 'Category'),
            'manufacturer' => Yii::t('app', 'Manufacturer'),
            'country' => Yii::t('app', 'Country'),
            'price' => Yii::t('app', 'Price'),
            'unit' => Yii::t('app', 'Unit'),
            'stock' => Yii::t('app', 'Stock'),
            'warranty' => Yii::t('app', 'Warranty'),
            'delivery' => Yii::t('app', 'Delivery'),
            'delivery_time' => Yii::t('app', 'Delivery Time'),
            'packing' => Yii::t('app', 'Packing'),
            'created' => Yii::t('app', 'Created'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCurrency0()
    {
        return $this->hasOne(Currency::className(), ['id' => 'currency']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCategory0()
    {
        return $this->hasOne(Category::className(), ['id' => 'category']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getManufacturer0()
    {
        return $this->hasOne(Manufacturer::className(), ['id' => 'manufacturer']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCountry0()
    {
        return $this->hasOne(Country::className(), ['id' => 'country']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getItemCharacteristics()
    {
        return $this->hasMany(ItemCharacteristic::className(), ['item' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getItemImgs()
    {
        return $this->hasMany(ItemImg::className(), ['item' => 'id']);
    }

    public function getStockName(){
        return isset(self::yesOrNo()[$this->stock]) ? self::yesOrNo()[$this->stock] : null;
    }

    public function getHomeName(){
        return isset(self::yesOrNo()[$this->home]) ? self::yesOrNo()[$this->home] : null;
    }

    public function getDeliveryName(){
        return isset(self::yesOrNo()[$this->delivery]) ? self::yesOrNo()[$this->delivery] : null;
    }

    public function getWarrantyName(){
        return isset(self::warrantyList()[$this->warranty]) ? self::warrantyList()[$this->warranty] : null;
    }

    public static function yesOrNo($ksort = false){
        $r = [
            1 => Yii::t('app', 'Да'),
            0 => Yii::t('app', 'Нет'),
        ];
        if($ksort){
            ksort($r);
        }
        return $r;
    }

    public static function warrantyList(){
        return [
            1 => Yii::t('app', '1 месяц'),
            2 => Yii::t('app', '2 месяца'),
            3 => Yii::t('app', '3 месяца'),
            6 => Yii::t('app', '6 месяцев'),
            9 => Yii::t('app', '9 месяцев'),
            12 => Yii::t('app', '12 месяцев'),
            18 => Yii::t('app', '18 месяцев'),
            24 => Yii::t('app', '24 месяца'),
            36 => Yii::t('app', '26 месяцев'),
            48 => Yii::t('app', '48 месяцев'),
            72 => Yii::t('app', '72 месяца'),
        ];
    }
}
