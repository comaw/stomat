<?php

namespace backend\models;

use common\UrlHelper;
use Yii;

/**
 * This is the model class for table "{{%item}}".
 *
 * @property string $id
 * @property string $name
 * @property string $url
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
 * @property integer $home
 * @property integer $warranty
 * @property integer $delivery
 * @property integer $delivery_time
 * @property string $packing
 * @property string $created
 *
 * @property Country $country0
 * @property Currency $currency0
 * @property Category $category0
 * @property Manufacturer $manufacturer0
 * @property ItemCharacteristic[] $itemCharacteristics
 *
 * @property ItemImg $itemImg
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

    public function beforeValidate()
    {
        if(!$this->url){
            $this->url = $this->name;
        }
        $this->url = UrlHelper::translateUrl($this->url);
        return parent::beforeValidate();
    }

    /**
     * @inheritdoc
     */
    public function beforeSave($insert)
    {
        if(parent::beforeSave($insert)){
            if($this->isNewRecord){
                $this->title = $this->title ? $this->title : $this->name;
                $this->description = $this->description ? $this->description : $this->name;
            }
            if(!$this->isNewRecord) {
                $attributes = $this->getAttributes(null, []);
                foreach ($attributes AS $attribute => $v) {
                    $old = $this->getOldAttribute($attribute);
                    $new = $this->$attribute;
                    if($old != $new && mb_strlen($new, Yii::$app->charset) < 200){
                        $m = Yii::t('app', 'В товаре ID').$this->id;
                        $m .= Yii::t('app', ' Поле ').$this->getAttributeLabel($attribute);
                        $m .= Yii::t('app', ' изменилось с "').$old;
                        $m .= Yii::t('app', '" на "').$new.'"';
                        \backend\models\Log::add($m);
                    }elseif($old != $new && mb_strlen($new, Yii::$app->charset) >= 200){
                        $m = Yii::t('app', 'В товаре ID').$this->id;
                        $m .= Yii::t('app', ' Поле ').$this->getAttributeLabel($attribute);
                        $m .= Yii::t('app', ' изменилось');
                        \backend\models\Log::add($m);
                    }
                }
            }
            return true;
        }
        return false;
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'url', 'title', 'description', 'packing', 'code', 'unit'], 'filter', 'filter' => 'trim', 'skipOnArray' => true],
            [['name', 'url', 'title', 'description', 'packing', 'code', 'unit'], 'filter', 'filter' => 'strip_tags', 'skipOnArray' => true],
            [['name', 'url', 'code', 'currency', 'category'], 'required'],
            [['content'], 'string'],
            [['currency', 'category', 'manufacturer', 'country', 'stock', 'warranty', 'delivery', 'delivery_time', 'home'], 'integer'],
            [['price'], 'number'],
            [['created'], 'safe'],
            [['name', 'url', 'title', 'description', 'packing'], 'string', 'max' => 255],
            [['code', 'unit'], 'string', 'max' => 20],
            [['name'], 'unique'],
            [['url'], 'unique'],
            [['code'], 'unique'],
            [['country'], 'exist', 'skipOnError' => true, 'targetClass' => Country::className(), 'targetAttribute' => ['country' => 'id']],
            [['currency'], 'exist', 'skipOnError' => true, 'targetClass' => Currency::className(), 'targetAttribute' => ['currency' => 'id']],
            [['category'], 'exist', 'skipOnError' => true, 'targetClass' => Category::className(), 'targetAttribute' => ['category' => 'id']],
            [['manufacturer'], 'exist', 'skipOnError' => true, 'targetClass' => Manufacturer::className(), 'targetAttribute' => ['manufacturer' => 'id']],
            [['unit'], 'default', 'value' => Yii::t('app', 'шт.')],
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
            'home' =>  Yii::t('app', 'Отображать на главной'),
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
    public function getCountry0()
    {
        return $this->hasOne(Country::className(), ['id' => 'country']);
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
    public function getItemCharacteristics()
    {
        return $this->hasMany(ItemCharacteristic::className(), ['item' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getItemImgs()
    {
        return $this->hasMany(ItemImg::className(), ['item' => 'id'])->orderBy('position desc, id asc');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getItemImg()
    {
        return $this->hasOne(ItemImg::className(), ['item' => 'id'])->orderBy('position desc, id asc');
    }

    public function getStockName(){
        $r = $this->stock;
        if($r > 1){
            $r = 1;
        }
        return isset(self::yesOrNo()[$r]) ? self::yesOrNo()[$r] : null;
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

    public function allCharacteristics(){
        $r = '';
        if(isset($this->itemCharacteristics) && sizeof($this->itemCharacteristics) > 0){
            foreach($this->itemCharacteristics AS $characteristic){
                if(!$characteristic->value){
                    continue;
                }
                $r .= $characteristic->characteristic0->name.' '.$characteristic->value.' '.$characteristic->characteristic0->dimension.' '."\n\t";
            }
        }
        return $r;
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
