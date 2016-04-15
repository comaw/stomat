<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "{{%item_characteristic}}".
 *
 * @property string $id
 * @property string $item
 * @property string $characteristic
 * @property string $value
 *
 * @property Characteristic $characteristic0
 * @property Item $item0
 */
class ItemCharacteristic extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%item_characteristic}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['item', 'characteristic'], 'required'],
            [['item', 'characteristic'], 'integer'],
            [['value'], 'string', 'max' => 255],
            [['characteristic'], 'exist', 'skipOnError' => true, 'targetClass' => Characteristic::className(), 'targetAttribute' => ['characteristic' => 'id']],
            [['item'], 'exist', 'skipOnError' => true, 'targetClass' => Item::className(), 'targetAttribute' => ['item' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'item' => Yii::t('app', 'Item'),
            'characteristic' => Yii::t('app', 'Characteristic'),
            'value' => Yii::t('app', 'Value'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCharacteristic0()
    {
        return $this->hasOne(Characteristic::className(), ['id' => 'characteristic']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getItem0()
    {
        return $this->hasOne(Item::className(), ['id' => 'item']);
    }
}
