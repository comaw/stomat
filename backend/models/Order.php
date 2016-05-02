<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "{{%order}}".
 *
 * @property string $id
 * @property string $user
 * @property integer $status
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
            [['username', 'email', 'phone', 'state', 'city', 'address', 'zipcode'], 'filter', 'filter' => 'trim', 'skipOnArray' => true],
            [['user', 'status'], 'integer'],
            [['username', 'email', 'phone', 'state', 'city', 'address'], 'required'],
            [['created'], 'safe'],
            [['comment'], 'string'],
            [['username', 'email', 'phone', 'state', 'city', 'address', 'zipcode'], 'string', 'max' => 255],
            [['user'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user' => 'id']],
            [['status'], 'in', 'range' =>array_keys(self::listStatus())],
        ];
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
                        $m = Yii::t('app', 'В заказе ID').$this->id;
                        $m .= Yii::t('app', ' Поле ').$this->getAttributeLabel($attribute);
                        $m .= Yii::t('app', ' изменилось с "').$old;
                        $m .= Yii::t('app', '" на "').$new.'"';
                        \backend\models\Log::add($m);
                    }elseif($old != $new && mb_strlen($new, Yii::$app->charset) >= 200){
                        $m = Yii::t('app', 'В заказе ID').$this->id;
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
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'user' => Yii::t('app', 'User'),
            'status' => Yii::t('app', 'Status'),
            'username' => Yii::t('app', 'Username'),
            'email' => Yii::t('app', 'Email'),
            'phone' => Yii::t('app', 'Phone'),
            'state' => Yii::t('app', 'State'),
            'city' => Yii::t('app', 'City'),
            'address' => Yii::t('app', 'Address'),
            'zipcode' => Yii::t('app', 'Zipcode'),
            'created' => Yii::t('app', 'Created'),
            'comment' => Yii::t('app', 'Comment'),
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

    public static function listStatus(){
        return [
            1 => Yii::t('app', 'Новый'),
            2 => Yii::t('app', 'В работе'),
            3 => Yii::t('app', 'Ждет отправки'),
            4 => Yii::t('app', 'Отправлен'),
            5 => Yii::t('app', 'Ждет оплаты'),
            6 => Yii::t('app', 'Доставлен'),
            7 => Yii::t('app', 'Выполнен'),
            10 => Yii::t('app', 'Архив'),
        ];
    }

    public function getStatusName(){
        return isset(self::listStatus()[$this->status]) ? self::listStatus()[$this->status] : null;
    }
}
