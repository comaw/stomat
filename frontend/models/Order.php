<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "{{%order}}".
 *
 * @property string $id
 * @property string $user
 * @property string $username
 * @property string $email
 * @property string $phone
 * @property string $state
 * @property string $city
 * @property string $address
 * @property string $zipcode
 * @property string $created
 * @property string $comment
 *
 * @property User $user0
 * @property OrderItem[] $orderItems
 */
class Order extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%order}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['username', 'email', 'phone', 'state', 'city', 'address', 'zipcode', 'comment'], 'filter', 'filter' => 'trim', 'skipOnArray' => true],
            [['username', 'email', 'phone', 'state', 'city', 'address', 'zipcode', 'comment'], 'filter', 'filter' => 'strip_tags', 'skipOnArray' => true],
            [['user'], 'integer'],
            [['username', 'email', 'phone', 'state', 'city', 'address'], 'required'],
            [['created'], 'safe'],
            [['username', 'email', 'phone', 'state', 'city', 'address', 'zipcode'], 'string', 'max' => 255],
            [['comment'], 'string'],
            [['user'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user' => 'id']],
            [['email'], 'email'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'user' => Yii::t('app', 'User'),
            'username' => Yii::t('app', 'Ф.И.О.'),
            'email' => Yii::t('app', 'Email'),
            'phone' => Yii::t('app', 'Телефон'),
            'state' => Yii::t('app', 'Область'),
            'city' => Yii::t('app', 'Город'),
            'address' => Yii::t('app', 'Адресс'),
            'zipcode' => Yii::t('app', 'Почтовый код'),
            'comment' => Yii::t('app', 'Комментарий'),
            'created' => Yii::t('app', 'Created'),
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
    public function getOrderItems()
    {
        return $this->hasMany(OrderItem::className(), ['orders' => 'id']);
    }
}
