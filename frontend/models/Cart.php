<?php

namespace frontend\models;

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

    public static function generateCode(){
        $user = !Yii::$app->user->isGuest ? Yii::$app->user->id : rand(0, 5);
        return md5(time().'||'.$user);
    }

    public static function getCodeCartCurrent(){
        $cookies1 = Yii::$app->request->cookies;
        $cookies = Yii::$app->response->cookies;
        $cart = null;
        if ($cookies1->has('cart')) {
            $cartCode = $cookies1->getValue('cart');
            $cart = Cart::find()->where("code = :code", [':code' => $cartCode])->one();
            $cart->last = date("Y-m-d H:i:s");
            $cart->save();
            $cookies->add(new \yii\web\Cookie([
                'name' => 'cart',
                'value' => $cart->code,
                'expire' => (time() + 86400 * 365),
            ]));
        }
        if(!$cart){
            $cart = new Cart();
            $cart->user = !Yii::$app->user->isGuest ? Yii::$app->user->id : null;
            $cart->created = date("Y-m-d H:i:s");
            $cart->last = date("Y-m-d H:i:s");
            $cart->code = Cart::generateCode();
            $cart->save();
            $cookies->add(new \yii\web\Cookie([
                'name' => 'cart',
                'value' => $cart->code,
                'expire' => (time() + 86400 * 365),
            ]));
        }
        return $cart->id;
    }

    public static function itemCountInCart(){
        $r = 0;
        $cookies1 = Yii::$app->request->cookies;
        $cookies = Yii::$app->response->cookies;
        $cart = null;
        if ($cookies1->has('cart')) {
            $cartCode = $cookies1->getValue('cart');
            $cart = Cart::find()->where("code = :code", [':code' => $cartCode])->one();
            $cart->last = date("Y-m-d H:i:s");
            $cart->save();
            $cookies->add(new \yii\web\Cookie([
                'name' => 'cart',
                'value' => $cart->code,
                'expire' => (time() + 86400 * 365),
            ]));
        }
        if(!$cart){
            $cart = new Cart();
            $cart->user = !Yii::$app->user->isGuest ? Yii::$app->user->id : null;
            $cart->created = date("Y-m-d H:i:s");
            $cart->last = date("Y-m-d H:i:s");
            $cart->code = Cart::generateCode();
            $cart->save();
            $cookies->add(new \yii\web\Cookie([
                'name' => 'cart',
                'value' => $cart->code,
                'expire' => (time() + 86400 * 365),
            ]));
        }
        $model = CartItem::find()->where("cart = :cart", [
            ':cart' => $cart->id,
        ])->all();
        foreach($model AS $v){
            $r += $v->count;
        }
        return $r;
    }

    public static function itemInCart(){
        $cookies1 = Yii::$app->request->cookies;
        $cookies = Yii::$app->response->cookies;
        $cart = null;
        if ($cookies1->has('cart')) {
            $cartCode = $cookies1->getValue('cart');
            $cart = Cart::find()->where("code = :code", [':code' => $cartCode])->one();
            $cart->last = date("Y-m-d H:i:s");
            $cart->save();
            $cookies->add(new \yii\web\Cookie([
                'name' => 'cart',
                'value' => $cart->code,
                'expire' => (time() + 86400 * 365),
            ]));
        }
        if(!$cart){
            $cart = new Cart();
            $cart->user = !Yii::$app->user->isGuest ? Yii::$app->user->id : null;
            $cart->created = date("Y-m-d H:i:s");
            $cart->last = date("Y-m-d H:i:s");
            $cart->code = Cart::generateCode();
            $cart->save();
            $cookies->add(new \yii\web\Cookie([
                'name' => 'cart',
                'value' => $cart->code,
                'expire' => (time() + 86400 * 365),
            ]));
        }
        return CartItem::find()->with(['item0'])->where("cart = :cart", [
            ':cart' => $cart->id,
        ])->all();
    }
}
