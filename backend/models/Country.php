<?php

namespace backend\models;

use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "{{%country}}".
 *
 * @property string $id
 * @property string $name
 */
class Country extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%country}}';
    }

    /**
     * @inheritdoc
     */
    public function beforeSave($insert)
    {
        if(parent::beforeSave($insert)){
            if(!$this->isNewRecord) {
                $attributes = $this->getAttributes(null, []);
                foreach ($attributes AS $attribute => $v) {
                    $old = $this->getOldAttribute($attribute);
                    $new = $this->$attribute;
                    if($old != $new && mb_strlen($new, Yii::$app->charset) < 200){
                        $m = Yii::t('app', 'В стране ID').$this->id;
                        $m .= Yii::t('app', ' Поле ').$this->getAttributeLabel($attribute);
                        $m .= Yii::t('app', ' изменилось с "').$old;
                        $m .= Yii::t('app', '" на "').$new.'"';
                        \backend\models\Log::add($m);
                    }elseif($old != $new && mb_strlen($new, Yii::$app->charset) >= 200){
                        $m = Yii::t('app', 'В стране ID').$this->id;
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
            [['name'], 'filter', 'filter' => 'trim', 'skipOnArray' => true],
            [['name'], 'filter', 'filter' => 'strip_tags', 'skipOnArray' => true],
            [['name'], 'required'],
            [['name'], 'string', 'max' => 255],
            [['name'], 'unique'],
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
        ];
    }

    public static function getToList(){
        return ArrayHelper::map(self::find()->orderBy('name')->all(), 'id', 'name');
    }
}
