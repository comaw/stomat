<?php

namespace backend\controllers;

use Yii;
use backend\models\User;
use backend\models\UserSearch;
use backend\ext\BaseController;
use yii\web\NotFoundHttpException;


/**
 * UserController implements the CRUD actions for User model.
 */
class UserController extends BaseController
{

    /**
     * Lists all User models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new UserSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single User model.
     * @param string $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new User model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new User();

        if ($model->load(Yii::$app->request->post())) {
            if($model->pass){
                $model->password_hash = Yii::$app->security->generatePasswordHash($model->pass);
                if($model->validate()){
                    $model->save(false);
                    \backend\models\Log::add(Yii::t('app', 'Добавление пользователя ID').$model->id);
                    return $this->redirect(['view', 'id' => $model->id]);
                }
            }else{
                $model->addError('', Yii::t('app', 'Нужно заполнить поле "Пароль"'));
            }
        }
        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing User model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post())) {
            if($model->pass){
                $model->password_hash = Yii::$app->security->generatePasswordHash($model->pass);
            }
            if($model->validate()){
                $model->save(false);
                \backend\models\Log::add(Yii::t('app', 'Редактирование пользователя ID').$id);
                return $this->redirect(['view', 'id' => $model->id]);
            }
        }
        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing User model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();
        \backend\models\Log::add(Yii::t('app', 'Удаление пользователя ID').$id);
        return $this->redirect(['index']);
    }

    /**
     * Finds the User model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return User the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = User::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
