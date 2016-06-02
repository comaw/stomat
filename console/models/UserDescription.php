<?php

namespace console\models;

use Yii;

/**
 * This is the model class for table "{{%user_description}}".
 *
 * @property string $id
 * @property string $phone
 * @property string $state
 * @property string $city
 * @property string $address
 * @property string $zipcode
 */
class UserDescription extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%user_description}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id'], 'required'],
            [['id'], 'integer'],
            [['phone', 'state', 'city', 'address', 'zipcode'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'phone' => Yii::t('app', 'Phone'),
            'state' => Yii::t('app', 'State'),
            'city' => Yii::t('app', 'City'),
            'address' => Yii::t('app', 'Address'),
            'zipcode' => Yii::t('app', 'Zipcode'),
        ];
    }
}
