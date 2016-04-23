<?php

namespace backend\controllers;

use backend\models\Characteristic;
use backend\models\ItemCharacteristic;
use backend\models\ItemImg;
use Yii;
use backend\models\Item;
use backend\models\ItemSearch;
use backend\ext\BaseController;
use yii\web\NotFoundHttpException;
use yii\web\UploadedFile;


/**
 * ItemController implements the CRUD actions for Item model.
 */
class ItemController extends BaseController
{

    /**
     * Lists all Item models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ItemSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Item model.
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
     * Creates a new Item model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Item();
        $imgs = new ItemImg();
        $characteristic = Characteristic::find()->orderBy('name asc')->all();
        if ($model->load(Yii::$app->request->post())) {
            if($model->validate()){
                $model->save(false);
                if($imgs->load(Yii::$app->request->post())){
                    $imgs->imageFile = UploadedFile::getInstances($imgs, 'imageFile');
                    $imgs->upload($model);
                }
                if(Yii::$app->request->post('ItemCharacteristic')){
                    $ItemCharacteristic = Yii::$app->request->post('ItemCharacteristic');
                    foreach($ItemCharacteristic AS $idCharacteristic => $value){
                        $value = trim($value);
                        if(!$value){
                            continue;
                        }
                        $newCharacteristic = new ItemCharacteristic();
                        $newCharacteristic->item = $model->id;
                        $newCharacteristic->characteristic = (int)$idCharacteristic;
                        $newCharacteristic->value = $value;
                        if($newCharacteristic->validate()){
                            $newCharacteristic->save(false);
                        }
                    }
                }
                return $this->redirect(['view', 'id' => $model->id]);
            }
        }
        return $this->render('create', [
            'model' => $model,
            'imgs' => $imgs,
            'characteristic' => $characteristic,
        ]);
    }

    /**
     * Updates an existing Item model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $imgs = new ItemImg();
        $characteristic = Characteristic::find()->orderBy('name asc')->all();
        if ($model->load(Yii::$app->request->post())) {
            if($model->validate()){
                $model->save(false);
                if($imgs->load(Yii::$app->request->post())){
                    $imgs->imageFile = UploadedFile::getInstances($imgs, 'imageFile');
                    $imgs->upload($model);
                }
                if(Yii::$app->request->post('ItemCharacteristic')){
                    $ItemCharacteristic = Yii::$app->request->post('ItemCharacteristic');
                    foreach($ItemCharacteristic AS $idCharacteristic => $value){
                        $value = trim($value);
                        $newCharacteristic = ItemCharacteristic::find()->where("item = :item AND characteristic = :characteristic", [
                            ':item' => $model->id,
                            ':characteristic' => (int)$idCharacteristic,
                        ])->one();
                        if(!$newCharacteristic){
                            $newCharacteristic = new ItemCharacteristic();
                            $newCharacteristic->item = $model->id;
                            $newCharacteristic->characteristic = (int)$idCharacteristic;
                        }
                        $newCharacteristic->value = $value;
                        if($newCharacteristic->validate()){
                            $newCharacteristic->save(false);
                        }
                    }
                }
                Yii::$app->session->setFlash('success', Yii::t('app', 'Успешно сохраненно!'));
                return $this->refresh();
            }
        }
        return $this->render('update', [
            'model' => $model,
            'imgs' => $imgs,
            'characteristic' => $characteristic,
        ]);
    }

    /**
     * Deletes an existing Item model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Item model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return Item the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Item::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
