<?php

namespace frontend\controllers;

use frontend\models\User;
use frontend\models\UserDescription;
use yii\filters\AccessControl;
use Yii;

class UserController extends \yii\web\Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                    [
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                ],
            ],
        ];
    }

    public function actionProfile()
    {
        $model = User::find()->where("id = :id", [':id' => Yii::$app->user->id])->one();
        $description = UserDescription::find()->where("id = :id", [':id' => $model->id])->one();
        if(!$description){
            $description = new UserDescription();
            $description->id = $model->id;
            $description->save();
        }
        if ($model->load(Yii::$app->request->post())){
            if($model->validate()){
                if($model->pass){
                    $model->password_hash = Yii::$app->security->generatePasswordHash($model->pass);
                }
                $model->save(false);
                if($description->load(Yii::$app->request->post())){
                    if($description->validate()){
                        $description->save(false);
                    }
                }
                Yii::$app->session->setFlash('success', Yii::t('app', 'Успешно сохраненно!'));
                return $this->refresh();
            }
        }
        return $this->render('profile', [
            'model' => $model,
            'description' => $description,
        ]);
    }

}
