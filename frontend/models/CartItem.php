<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "{{%cart_item}}".
 *
 * @property string $id
 * @property string $cart
 * @property string $user
 * @property string $item
 * @property integer $count
 * @property string $price
 * @property string $price_all
 *
 * @property User $user0
 * @property Cart $cart0
 * @property Item $item0
 */
class CartItem extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%cart_item}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['cart', 'item'], 'required'],
            [['cart', 'user', 'item', 'count'], 'integer'],
            [['price', 'price_all'], 'number'],
            [['user'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user' => 'id']],
            [['cart'], 'exist', 'skipOnError' => true, 'targetClass' => Cart::className(), 'targetAttribute' => ['cart' => 'id']],
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
            'cart' => Yii::t('app', 'Cart'),
            'user' => Yii::t('app', 'User'),
            'item' => Yii::t('app', 'Item'),
            'count' => Yii::t('app', 'Count'),
            'price' => Yii::t('app', 'Price'),
            'price_all' => Yii::t('app', 'Price All'),
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
    public function getCart0()
    {
        return $this->hasOne(Cart::className(), ['id' => 'cart']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getItem0()
    {
        return $this->hasOne(Item::className(), ['id' => 'item']);
    }
}
