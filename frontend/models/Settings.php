<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "{{%settings}}".
 *
 * @property string $id
 * @property string $name
 * @property string $value
 * @property string $title
 * @property string $last
 */
class Settings extends \yii\db\ActiveRecord
{

    public static $settings = [];

    public static function setSettings(){
        if(!self::$settings){
            $model = self::find()->orderBy('id desc')->all();
            foreach($model AS $v){
                self::$settings[$v->name] = $v->value;
            }
        }
        return self::$settings;
    }

    public static function getSettings($name = null){
        if(!self::$settings){
            self::setSettings();
        }
        if($name){
            return isset(self::$settings[$name]) ? self::$settings[$name] : null;
        }
        return self::$settings;
    }


    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%settings}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['value'], 'string'],
            [['last'], 'safe'],
            [['name', 'title'], 'string', 'max' => 255],
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
            'value' => Yii::t('app', 'Value'),
            'title' => Yii::t('app', 'Title'),
            'last' => Yii::t('app', 'Last'),
        ];
    }
}
