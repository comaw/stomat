<?php

namespace frontend\controllers;

use frontend\models\Cart;
use frontend\models\CartItem;
use frontend\models\Item;
use frontend\models\Order;
use frontend\models\OrderItem;
use frontend\models\UserDescription;
use Yii;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use yii\web\HttpException;

class CartController extends \yii\web\Controller
{
    public function actionOrder()
    {
        if(!Cart::itemCountInCart()){
            throw new HttpException(403, 'У вас нет товаров');
        }
        $model = new Order();
        if(!Yii::$app->user->isGuest){
            $description = UserDescription::findOne(Yii::$app->user->id);
            if($description){
                $model->phone = $description->phone;
                $model->state = $description->state;
                $model->city = $description->city;
                $model->address = $description->address;
                $model->zipcode = $description->zipcode;
                $model->username = Yii::$app->user->identity->username;
                $model->email = Yii::$app->user->identity->email;
            }
        }
        if($model->load(Yii::$app->request->post())){
            $model->user = !Yii::$app->user->isGuest ? Yii::$app->user->id : null;
            $model->created = date("Y-m-d H:i:s");
            if($model->validate()){
                $model->save(false);
                $items = Cart::itemInCart();
                foreach($items AS $item){
                    $itemOrder = new OrderItem();
                    $itemOrder->orders = $model->id;
                    $itemOrder->user = !Yii::$app->user->isGuest ? Yii::$app->user->id : null;
                    $itemOrder->item = $item->item;
                    $itemOrder->count = $item->count;
                    $itemOrder->price = $item->price;
                    $itemOrder->price_all = $item->price_all;
                    if($itemOrder->validate()){
                        $itemOrder->save(false);
                    }
                }
                $idDelete = ArrayHelper::map($items, 'id', 'id');
                CartItem::deleteAll(['in', 'id', $idDelete]);
                Yii::$app->mail
                    ->compose(
                        ['html' => 'admin-order-html', 'text' => 'admin-order-text'],
                        ['order' => $model]
                    )
                    ->setFrom([Yii::$app->params['adminEmail'] => Yii::$app->params['site_name']])
                    ->setTo(Yii::$app->params['adminEmail2'])
                    ->setSubject(Yii::t('app', 'Новый заказ с сайта {site}', ['site' => Yii::$app->name]))
                    ->send();
                Yii::$app->mail
                    ->compose(
                        ['html' => 'user-order-html', 'text' => 'user-order-text'],
                        ['order' => $model]
                    )
                    ->setFrom([Yii::$app->params['adminEmail'] => Yii::$app->params['site_name']])
                    ->setTo($model->email)
                    ->setSubject(Yii::t('app', 'Ваш заказ на сайте {site}', ['site' => Yii::$app->name]))
                    ->send();
                return $this->redirect(Url::toRoute(['cart/orderok']));
            }
        }
        return $this->render('order', [
            'model' => $model
        ]);
    }

    public function actionOrderok()
    {
        return $this->render('orderok', [

        ]);
    }

    public function actionIndex()
    {
        if(Yii::$app->request->post('item')){
            foreach(Yii::$app->request->post('item') AS $cartItemId => $count){
                $cartItem = CartItem::find()->where("id = :id AND cart = :cart", [
                    ':cart' => Cart::getCodeCartCurrent(),
                    ':id' => (int)$cartItemId,
                ])->one();
                if(!$cartItem){
                    continue;
                }
                $count = (int)$count;
                if($count < 1){
                    $cartItem->delete();
                }else{
                    $cartItem->count = $count;
                    $cartItem->price_all = ($count * $cartItem->price);
                    $cartItem->save();
                }
            }
            Yii::$app->session->setFlash('success', Yii::t('app', 'Успешно сохраненно!'));
            return $this->refresh();
        }
        $models = Cart::itemInCart();
        return $this->render('index', [
            'models' => $models,
        ]);
    }

    public function actionAdd()
    {
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        if(!Yii::$app->request->isAjax){
            throw new HttpException(404, 'Not found');
        }
        $cookies1 = Yii::$app->request->cookies;
        $cookies = Yii::$app->response->cookies;
        $cartCode = null;
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
        $item = Item::findOne((int)Yii::$app->request->post('id'));
        if(!$item){
            throw new HttpException(404, 'Not found item');
        }
        $count = (int)Yii::$app->request->post('count');
        if($count < 1){
            $count = 1;
        }
        $model = CartItem::find()->where("cart = :cart AND item = :item", [
            ':item' => $item->id,
            ':cart' => $cart->id,
        ])->one();
        if(!$model){
            $model = new CartItem();
            $model->cart = $cart->id;
            $model->item = $item->id;
            $model->user = !Yii::$app->user->isGuest ? Yii::$app->user->id : null;
        }
        $model->count = $count;
        $model->price = $item->price;
        $model->price_all = ($item->price * $count);
        $model->save();
        return [
            'e' => 0,
            'count' => Cart::itemCountInCart(),
            't' => Yii::t('app', 'Товар успешно добавлен в корзину')
        ];
    }

}
