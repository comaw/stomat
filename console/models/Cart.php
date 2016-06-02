<?php

namespace console\models;

use Yii;

/**
 * This is the model class for table "{{%cart}}".
 *
 * @property string $id
 * @property string $code
 * @property string $user
 * @property string $created
 * @property string $last
 *
 * @property User $user0
 * @property CartItem[] $cartItems
 */
class Cart extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%cart}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['code'], 'required'],
            [['user'], 'integer'],
            [['created', 'last'], 'safe'],
            [['code'], 'string', 'max' => 32],
            [['code'], 'unique'],
            [['user'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'code' => Yii::t('app', 'Code'),
            'user' => Yii::t('app', 'User'),
            'created' => Yii::t('app', 'Created'),
            'last' => Yii::t('app', 'Last'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser0()
    {
        return $this->hasOne(User::className(), ['id' => 'user']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCartItems()
    {
        return $this->hasMany(CartItem::className(), ['cart' => 'id']);
    }
}
