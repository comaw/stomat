<?php
/**
 * powered by php-shaman
 * ImageController.php 02.06.2016
 * stomat
 */

namespace console\controllers;

set_time_limit(0);

use console\models\ItemImg;
use yii\console\Controller;


class ImageController extends Controller // e:\xampp1\php\php.exe yii image
{
    public function actionIndex()
    {
        $models = ItemImg::find()->select(['id'])->orderBy('item asc')->limit(1200)->all();
        foreach($models AS $model){
            $model = ItemImg::find()->with(['item0'])->where("id = :id", [':id' => $model->id])->one();
            $link = $model->imgLink();
            $linksmall = $model->imgLink('small_');
            $linknormal = $model->imgLink('normal_');
            $dir = $model->imgDir();
            $extetion = explode('.', $link);
            $extetion = end($extetion);
            $newName = $model->item0->url.'-'.$model->id . '.' . $extetion;
            if(!is_file($link)){
                continue;
            }
            copy($link, $dir . $newName);
            unlink($link);
            $model->name = $newName;
            $model->save();

            $newNamesmall = 'small_'. $newName;
            copy($linksmall, $dir . $newNamesmall);
            unlink($linksmall);

            $newNamenormal = 'normal_' . $newName;
            copy($linknormal, $dir . $newNamenormal);
            unlink($linknormal);

            var_dump($dir . $newName);
        }

    }
}