<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "{{%characteristic}}".
 *
 * @property string $id
 * @property string $name
 * @property string $dimension
 * @property string $type
 */
class Characteristic extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%characteristic}}';
    }

    public static function typeList(){
        return [
            'text' => Yii::t('app', 'Текст'),
            'checkbox' => Yii::t('app', 'Кнопка'),
//            'radio' => Yii::t('app', 'Выбор'),
            'textarea' => Yii::t('app', 'Большой текст')
        ];
    }

    public function getTypeName(){
        return isset(self::typeList()[$this->type]) ? self::typeList()[$this->type] : null;
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'dimension'], 'filter', 'filter' => 'trim', 'skipOnArray' => true],
            [['name', 'dimension'], 'filter', 'filter' => 'strip_tags', 'skipOnArray' => true],
            [['name'], 'required'],
            [['type', 'dimension'], 'string'],
            [['name'], 'string', 'max' => 255],
            [['dimension'], 'string', 'max' => 30],
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
            'dimension' => Yii::t('app', 'Измерение'),
            'type' => Yii::t('app', 'Type'),
        ];
    }
}
