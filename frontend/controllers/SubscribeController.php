<?php

namespace frontend\controllers;

use frontend\models\Subscribe;
use Yii;
use yii\web\HttpException;

class SubscribeController extends \yii\web\Controller
{
    public function actionIndex()
    {
        if(!Yii::$app->request->isAjax){
            throw new HttpException(404, 'Not found');
        }
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $email = Yii::$app->request->post('email');
        if(!$email){
            return ['e' => 1, 't' => Yii::t('app', 'Нужно ввести Email')];
        }
        $model = new Subscribe();
        $model->email = $email;
        $model->active = 1;
        $model->created = date("Y-m-d H:i:s");
        if($model->validate()){
            $model->save(false);
        }
        return ['e' => 0, 't' => Yii::t('app', 'Спасибо! Вы успешно подписались.')];
    }

}
