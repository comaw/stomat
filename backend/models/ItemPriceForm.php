<?php
/**
 * powered by php-shaman
 * ItemPriceForm.php 23.04.2016
 * stomat
 */

namespace backend\models;

use Yii;
use yii\base\Model;


class ItemPriceForm extends Model
{
    public $file;

    const FILENAME = 'price_update.xlsx';

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['file'], 'file', 'extensions' => ['xlsx']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'file' => Yii::t('app', 'File'),
        ];
    }

    public function upload()
    {
        $dirItemImg = Yii::getAlias('@runtime/excel/');
        if(!is_dir($dirItemImg)){
            mkdir($dirItemImg, 0777);
        }
        if ($this->validate()) {
            $currentName = $dirItemImg . $this->file->baseName . '.' . $this->file->extension;
            $this->file->saveAs($currentName);
            $objPHPExcel = \PHPExcel_IOFactory::load($currentName);
            $objWriter = \PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
            $objWriter->save($dirItemImg . self::FILENAME);
            @unlink($currentName);
            return true;
        }
        return false;
    }

    public static function getPriceFile($url = false){
        $file = Yii::getAlias('@runtime/excel/').self::FILENAME;
        if($url){
            return $file;
        }
        return file_get_contents($file);
    }

    public static function updateItem(){
        ob_start();
        $r = 0;
        $objPHPExcel = \PHPExcel_IOFactory::load(self::getPriceFile(true));
        foreach ($objPHPExcel->getWorksheetIterator() as $worksheet) {
            $highestRow         = $worksheet->getHighestRow(); // e.g. 10
            $highestColumn      = $worksheet->getHighestColumn(); // e.g 'F'
            $highestColumnIndex = \PHPExcel_Cell::columnIndexFromString($highestColumn);
            for ($row = 1; $row <= $highestRow; ++ $row) {
                if($row <= 2){
                    continue;
                }
                $code = null;
                $stock = null;
                $price = null;
                for ($col = 0; $col < $highestColumnIndex; ++ $col) {
                    $cell = $worksheet->getCellByColumnAndRow($col, $row);
                    $val = $cell->getValue();
                    if($col == 0){
                        $code = trim($val);
                    }
                    if($col == 2){
                        $stock = (int)$val;
                    }
                    if($col == 3){
                        $price = str_replace([',', ' '], ['.', ''],trim($val));
                    }
                }
                if($code && $price){
                    $item = Item::find()->where("code = :code", [':code' => $code])->one();
                    if($item){
                        $item->price = $price;
                        $item->stock = $stock;
                        $item->save();
                        echo $item->id;
                        ob_flush();
                        flush();
                    }
                }
            }
            $r++;
        }
        @unlink(self::getPriceFile(true));
        ob_clean();
        return $r;
    }
}