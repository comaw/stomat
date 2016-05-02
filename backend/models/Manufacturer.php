<?php

namespace backend\models;

use common\UrlHelper;
use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "{{%manufacturer}}".
 *
 * @property string $id
 * @property string $name
 * @property string $url
 * @property string $title
 * @property string $description
 * @property string $content
 */
class Manufacturer extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%manufacturer}}';
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
                        $m = Yii::t('app', 'В Производители ID').$this->id;
                        $m .= Yii::t('app', ' Поле ').$this->getAttributeLabel($attribute);
                        $m .= Yii::t('app', ' изменилось с "').$old;
                        $m .= Yii::t('app', '" на "').$new.'"';
                        \backend\models\Log::add($m);
                    }elseif($old != $new && mb_strlen($new, Yii::$app->charset) >= 200){
                        $m = Yii::t('app', 'В Производители ID').$this->id;
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
            [['name', 'url', 'title', 'description', 'content'], 'filter', 'filter' => 'trim', 'skipOnArray' => true],
            [['name', 'url', 'title', 'description'], 'filter', 'filter' => 'strip_tags', 'skipOnArray' => true],
            [['name', 'url'], 'required'],
            [['content'], 'string'],
            [['name', 'url', 'title', 'description'], 'string', 'max' => 255],
            [['name'], 'unique'],
            [['url'], 'unique'],
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
            'title' => Yii::t('app', 'Title'),
            'description' => Yii::t('app', 'Description'),
            'content' => Yii::t('app', 'Content'),
        ];
    }

    public static function getToList(){
        return ArrayHelper::map(self::find()->orderBy('name')->all(), 'id', 'name');
    }
}
