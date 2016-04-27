<?php

namespace frontend\models;

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
            [['phone', 'state', 'city', 'address', 'zipcode'], 'filter', 'filter' => 'trim', 'skipOnArray' => true],
            [['phone', 'state', 'city', 'address', 'zipcode'], 'filter', 'filter' => 'strip_tags', 'skipOnArray' => true],
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
            'phone' => Yii::t('app', 'Телефон'),
            'state' => Yii::t('app', 'Область'),
            'city' => Yii::t('app', 'Город'),
            'address' => Yii::t('app', 'Адресс'),
            'zipcode' => Yii::t('app', 'Почтовый код'),
        ];
    }
}
