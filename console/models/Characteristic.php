<?php

namespace console\models;

use Yii;

/**
 * This is the model class for table "{{%characteristic}}".
 *
 * @property string $id
 * @property string $name
 * @property string $dimension
 * @property string $type
 *
 * @property ItemCharacteristic[] $itemCharacteristics
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

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['type'], 'string'],
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
            'dimension' => Yii::t('app', 'Dimension'),
            'type' => Yii::t('app', 'Type'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getItemCharacteristics()
    {
        return $this->hasMany(ItemCharacteristic::className(), ['characteristic' => 'id']);
    }
}
