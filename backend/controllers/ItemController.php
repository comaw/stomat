<?php

namespace backend\controllers;

use backend\models\Characteristic;
use backend\models\ItemCharacteristic;
use backend\models\ItemImg;
use backend\models\ItemImportForm;
use backend\models\ItemPriceForm;
use backend\models\ItemExcelForm;
use Yii;
use backend\models\Item;
use backend\models\ItemSearch;
use backend\ext\BaseController;
use yii\helpers\Url;
use yii\web\HttpException;
use yii\web\NotFoundHttpException;
use yii\web\UploadedFile;


/**
 * ItemController implements the CRUD actions for Item model.
 */

class ItemController extends BaseController
{

    public function actionImport()
    {
        set_time_limit(0);
        $model = new ItemImportForm();
        $model->limit = 0;
        $model->offset = 0;
        if($model->load(Yii::$app->request->post()) && $model->validate()) {
            \backend\models\Log::add(Yii::t('app', 'Выгрузка товаров в Excel '));
            $xlsx = new \PHPExcel();
            $xlsx->getProperties()->setCreator(Yii::t('app', 'Стомат плюс'));
            $xlsx->getProperties()->setLastModifiedBy(Yii::t('app', 'Стомат плюс'));
            $xlsx->getProperties()->setTitle(Yii::t('app', 'Стомат плюс список товаров'));
            $xlsx->getProperties()->setSubject(Yii::t('app', 'Стомат плюс список товаров'));
            $xlsx->getProperties()->setDescription(Yii::t('app', 'Стомат плюс список товаров'));


            $aql = Item::find();
            $aql->orderBy('id asc');
            if($model->limit > 0){
                $aql->limit($model->limit);
            }
            if($model->offset > 0){
                $aql->offset($model->offset);
            }
            $items = $aql->all();

            $xlsx->setActiveSheetIndex(0)
                ->setCellValue('A1', Yii::t('app', 'ID товара'))
                ->setCellValue('B1', Yii::t('app', 'Код товара'))
                ->setCellValue('C1', Yii::t('app', 'Название'))
                ->setCellValue('D1', Yii::t('app', 'Цена'))
                ->setCellValue('E1', Yii::t('app', 'Валюта'))
                ->setCellValue('F1', Yii::t('app', 'Измерение'))
                ->setCellValue('G1', Yii::t('app', 'Наличие на складе'))
                ->setCellValue('H1', Yii::t('app', 'Гарантия'))
                ->setCellValue('I1', Yii::t('app', 'Тип упаковки'))
                ->setCellValue('J1', Yii::t('app', 'Возможность доставки'))
                ->setCellValue('K1', Yii::t('app', 'Сроки доставки'))
                ->setCellValue('L1', Yii::t('app', 'На главной'))
                ->setCellValue('M1', Yii::t('app', 'Категория'))
                ->setCellValue('N1', Yii::t('app', 'Производитель'))
                ->setCellValue('O1', Yii::t('app', 'Страна'))
                ->setCellValue('P1', Yii::t('app', 'ID категории'))
                ->setCellValue('Q1', Yii::t('app', 'Url товара'))
                ->setCellValue('R1', Yii::t('app', 'Title'))
                ->setCellValue('S1', Yii::t('app', 'Description'))
                ->setCellValue('T1', Yii::t('app', 'Описание'))
                ->setCellValue('U1', Yii::t('app', 'Картинка'))
                ->setCellValue('V1', Yii::t('app', 'Характеристики'));

            foreach($items AS $k => $item) {
                $index = $k + 2;
                $xlsx->setActiveSheetIndex(0)
                    ->setCellValue('A'.$index, $item->id)
                    ->setCellValue('B'.$index, $item->code)
                    ->setCellValue('C'.$index, $item->name)
                    ->setCellValue('D'.$index, $item->price)
                    ->setCellValue('E'.$index, (isset($item->currency0->name) ? $item->currency0->name : null))
                    ->setCellValue('F'.$index, $item->unit)
                    ->setCellValue('G'.$index, $item->getStockName())
                    ->setCellValue('H'.$index, $item->getWarrantyName())
                    ->setCellValue('I'.$index, $item->packing)
                    ->setCellValue('J'.$index, $item->getDeliveryName())
                    ->setCellValue('K'.$index, ( !$item->delivery_time ? $item->delivery_time : null ) )
                    ->setCellValue('L'.$index, $item->getHomeName())
                    ->setCellValue('M'.$index, (isset($item->category0->name) ? $item->category0->name : null))
                    ->setCellValue('N'.$index, (isset($item->manufacturer0->name) ? $item->manufacturer0->name : null))
                    ->setCellValue('O'.$index, (isset($item->country0->name) ? $item->country0->name : null))
                    ->setCellValue('P'.$index, $item->category)
                    ->setCellValue('Q'.$index, str_replace('/admin/', '/', Url::toRoute(['item/view', 'url' => $item->url], true)))
                    ->setCellValue('R'.$index, $item->title)
                    ->setCellValue('S'.$index, $item->description)
                    ->setCellValue('T'.$index, $item->content)
                    ->setCellValue('U'.$index, ( isset($item->itemImg->name) ? str_replace('/admin/', '/', Url::home(true)).'image/item/'.$item->id.'/'.$item->itemImg->name : null ))
                    ->setCellValue('V'.$index, $item->allCharacteristics())
                ;
                $xlsx->setActiveSheetIndex(0)->getStyle('V'.$index)->getAlignment()->setWrapText(true);
                $xlsx->setActiveSheetIndex(0)->getStyle('T'.$index)->getAlignment()->setWrapText(true);
                $xlsx->setActiveSheetIndex(0)->getColumnDimension('V')->setWidth(400);
                $xlsx->setActiveSheetIndex(0)->getRowDimension($index)->setRowHeight(20);;
            }

            $xlsx->getActiveSheet()->setTitle(Yii::t('app', 'Стомат плюс список товаров'));
            $xlsx->setActiveSheetIndex(0);
            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            header('Content-Disposition: attachment;filename="'.ItemImportForm::FILENAME.'"');
            header('Cache-Control: max-age=0');
            $objWriter = \PHPExcel_IOFactory::createWriter($xlsx, 'Excel2007');
            $objWriter->save('php://output');
            Yii::$app->end();
        }else{
            return $this->render('import', [
                'model' => $model,
            ]);
        }
    }

    public function actionPrice()
    {
        set_time_limit(0);
        $model = new ItemPriceForm();
        if($model->load(Yii::$app->request->post())) {
            $model->file = UploadedFile::getInstance($model, 'file');
            if($model->upload()) {
                $size = $model->updateItem();
                \backend\models\Log::add(Yii::t('app', 'Обновление цен на товары. Всего - ').$size);
                Yii::$app->session->setFlash('success', Yii::t('app', 'Успешно обновленно!'));
                return $this->refresh();
            }
        }
        return $this->render('price', [
            'model' => $model,
        ]);
    }

    public function actionExcel()
    {
        set_time_limit(0);
        $model = new ItemExcelForm();
        if($model->load(Yii::$app->request->post())) {
            $model->file = UploadedFile::getInstance($model, 'file');
            if($model->upload()) {
                $size = $model->updateItem();
                \backend\models\Log::add(Yii::t('app', 'Обновление или добавление товаров. Всего - ').$size);
//                Yii::$app->session->setFlash('success', Yii::t('app', 'Успешно обновленно!'));
//                return $this->refresh();
            }
        }
        return $this->render('excel', [
            'model' => $model,
        ]);
    }

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

    public function afterAction($action, $result){
        if($action == 'index'){
            $session = Yii::$app->session;
            $session->set('urlToList', Url::current());
        }
        return parent::afterAction($action, $result);
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
                \backend\models\Log::add(Yii::t('app', 'Создание товара ID').$model->id);
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
                \backend\models\Log::add(Yii::t('app', 'Редактирование товара ID').$model->id);
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
        $model = $this->findModel($id);
        \backend\models\Log::add(Yii::t('app', 'Удаление товара ID').$model->id);
        if(sizeof($model->itemImgs) > 0){
            foreach($model->itemImgs AS $img){
                $img->deleteImg();
            }
        }
        $model->delete();
        return $this->redirect(['index']);
    }

    public function actionImgdelete()
    {
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        if(!Yii::$app->request->isAjax){
            throw new HttpException(404, 'Not ajax found');
        }
        $model = ItemImg::findOne((int)Yii::$app->request->post('id'));
        if(!$model){
            throw new HttpException(404, 'Not found');
        }
        $model->delete();
        return ['e' => 0, 't' => ''];
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
