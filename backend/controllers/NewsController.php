<?php

namespace backend\controllers;

use common\UrlHelp;
use Yii;
use app\models\News;
use app\models\NewsSearch;
use backend\ext\BaseController;
use yii\helpers\Url;
use yii\web\NotFoundHttpException;
use yii\web\UploadedFile;


/**
 * NewsController implements the CRUD actions for News model.
 */
class NewsController extends BaseController
{

    /**
     * Lists all News models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new NewsSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single News model.
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
     * Creates a new News model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new News();

        if ($model->load(Yii::$app->request->post())) {
            $model->url = UrlHelp::translateUrl($model->name);
            if($model->validate()){
                $model->imageFile = UploadedFile::getInstance($model, 'imageFile');
                if($model->imageFile) {
                    if ($imgName = $model->upload($model->url)) {
                        $model->img = $imgName;
                    }
                }
                $model->imageFile = null;
                $model->save();
                return $this->redirect(['view', 'id' => $model->id]);
            }
        }
        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing News model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post())) {
            $model->url = UrlHelp::translateUrl($model->url);
            if($model->validate()){
                $model->imageFile = UploadedFile::getInstance($model, 'imageFile');
                if($model->imageFile){
                    if($imgName = $model->upload($model->url)){
                        $model->img = $imgName;
                    }
                }
                $model->imageFile = null;
                $model->save();
                return $this->redirect(['view', 'id' => $model->id]);
            }
        }
        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing News model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        News::delImg($model->img);
        $model->delete();
        return $this->redirect(['index']);
    }

    public function actionImgdel($id){
        $model = $this->findModel($id);
        News::delImg($model->img);
        $model->img = null;
        $model->save();
        return $this->redirect(Url::toRoute(['news/update', 'id' => $model->id]));
    }

    /**
     * Finds the Page model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return News the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = News::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
        }
    }
}
