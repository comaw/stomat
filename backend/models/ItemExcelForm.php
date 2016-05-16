<?php
/**
 * powered by php-shaman
 * ItemPriceForm.php 23.04.2016
 * stomat
 */

namespace backend\models;

use common\UrlHelp;
use Yii;
use yii\base\Model;


class ItemExcelForm extends Model
{
    public $file;

    const FILENAME = 'item_update.xlsx';

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['file'], 'file', 'extensions' => ['xlsx', 'xls', 'csv']],
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
        $data = [];
        foreach ($objPHPExcel->getWorksheetIterator() as $worksheet) {
            echo '<pre>';
            echo PHP_EOL.'<br>';
            ob_flush();
            flush();
            $highestRow         = $worksheet->getHighestRow(); // e.g. 10
            $highestColumn      = $worksheet->getHighestColumn(); // e.g 'F'
            $highestColumnIndex = \PHPExcel_Cell::columnIndexFromString($highestColumn);
            for ($row = 2; $row <= $highestRow; ++ $row) {
                $code = null;
                $stock = null;
                $price = null;
                $data['Item'] = [];
                $data['Item']['code'] = trim($worksheet->getCellByColumnAndRow(0, $row)->getValue());
                $data['Item']['name'] = mb_substr(trim($worksheet->getCellByColumnAndRow(1, $row)->getValue()), 0, 254, Yii::$app->charset);
                if(!$data['Item']['code'] || !$data['Item']['name']){
                    continue;
                }
                $data['Item']['url'] = UrlHelp::translateUrl($data['Item']['name']);
                $data['Item']['stock'] = $worksheet->getCellByColumnAndRow(12, $row)->getValue() == '+' ? 1 : 0;
                $data['Item']['price'] = str_replace([' ', ','], ['', '.'], trim($worksheet->getCellByColumnAndRow(5, $row)->getValue()));
                if(!$data['Item']['price']){
                    $data['Item']['price'] = 0;
                }
                $data['Item']['currency'] = trim($worksheet->getCellByColumnAndRow(6, $row)->getValue());
                $data['Item']['unit'] = trim($worksheet->getCellByColumnAndRow(7, $row)->getValue());
                if(!$data['Item']['unit']){
                    $data['Item']['unit'] = 'шт.';
                }
                $data['Item']['manufacturer'] = trim($worksheet->getCellByColumnAndRow(22, $row)->getValue());
                $data['Item']['warranty'] = (int)($worksheet->getCellByColumnAndRow(23, $row)->getValue());
                $data['Item']['country'] = trim($worksheet->getCellByColumnAndRow(24, $row)->getValue());
                $data['Item']['packing'] = trim($worksheet->getCellByColumnAndRow(17, $row)->getValue());
                $data['Item']['delivery'] = trim($worksheet->getCellByColumnAndRow(15, $row)->getValue())? 1 : 0;
                $data['Item']['delivery_time'] = (int)trim($worksheet->getCellByColumnAndRow(16, $row)->getValue());
                $data['Item']['title'] = $data['Item']['name'];
                $data['Item']['description'] = $data['Item']['name'];
                $data['Item']['content'] = str_replace(['&nbsp;', '<br />', '<b>', '<i>'], [' ', '<br>', '<strong>', '<em>'], trim($worksheet->getCellByColumnAndRow(3, $row)->getValue()));
                $data['Item']['category'] = trim($worksheet->getCellByColumnAndRow(14, $row)->getValue());
                if(!$data['Item']['category']){
                    continue;
                }
                $catContent = @file_get_contents($data['Item']['category']);
                preg_match("/<h1(.*)>(.*)<\/h1>/Uis", $catContent, $cat);
                $data['Item']['category'] = isset($cat[2]) ? trim(str_replace('в Украине', '', strip_tags($cat[2]))) : null;
                if(!$data['Item']['category']){
                    continue;
                }
                $cat = Category::find()->where("name = :name", [':name' => $data['Item']['category']])->one();
                if(!$cat){
                    $cat = new Category();
                    $cat->name = $data['Item']['category'];
                    $cat->save();
                }
                $data['Item']['category'] = $cat->id;
                if($data['Item']['currency']){
                    $currency = Currency::find()->where("name = :name", [':name' => $data['Item']['currency']])->one();
                    if(!$currency){
                        $currency = new Currency();
                        $currency->name = $data['Item']['currency'];
                        $currency->save();
                    }
                    $data['Item']['currency'] = $currency->id;
                }else{
                    continue;
                }
                if($data['Item']['manufacturer']){
                    $manufacturer = Manufacturer::find()->where("name = :name", [':name' => $data['Item']['manufacturer']])->one();
                    if(!$manufacturer){
                        $manufacturer = new Manufacturer();
                        $manufacturer->name = $data['Item']['manufacturer'];
                        $manufacturer->save();
                    }
                    $data['Item']['manufacturer'] = $manufacturer->id;
                }else{
                    $data['Item']['manufacturer'] = null;
                }
                if($data['Item']['country']){
                    $manufacturer = Country::find()->where("name = :name", [':name' => $data['Item']['country']])->one();
                    if(!$manufacturer){
                        $manufacturer = new Country();
                        $manufacturer->name = $data['Item']['country'];
                        $manufacturer->save();
                    }
                    $data['Item']['country'] = $manufacturer->id;
                }else{
                    $data['Item']['country'] = null;
                }
                $oldPrice = $data['Item']['price'];
                $item = Item::find()->where("code = :code", [':code' => $data['Item']['code']])->one();
                if(!$item){
                    $item = new Item();
                }else{
                    $oldPrice = $item->price;
                }
                $item->load($data);
                $item->price = $oldPrice;
                if($item->validate()) {
                    $item->save(false);
                }else{
                    continue;
                }
                $data['ItemCharacteristic'] = [];
                $data['Characteristic'] = [];
                for($col = 27; $col <= 43; $col += 3){
                    $data['ItemCharacteristic']['value'] = trim($worksheet->getCellByColumnAndRow(($col + 2), $row)->getValue());
                    $data['Characteristic']['name'] = trim($worksheet->getCellByColumnAndRow($col, $row)->getValue());
                    if(!$data['Characteristic']['name']){
                        continue;
                    }
                    $data['Characteristic']['dimension'] = trim($worksheet->getCellByColumnAndRow(($col + 1), $row)->getValue());
                    $Characteristic = Characteristic::find()->where("name = :name", [':name' => $data['Characteristic']['name']])->one();
                    if(!$Characteristic){
                        $Characteristic = new Characteristic();
                    }
                    $Characteristic->load($data);
                    if($Characteristic->validate()) {
                        $Characteristic->save(false);
                    }else{
                        continue;
                    }
                    $data['ItemCharacteristic']['item'] = $item->id;
                    $data['ItemCharacteristic']['characteristic'] = $Characteristic->id;
                    $ItemCharacteristic = ItemCharacteristic::find()->where("item = :item AND characteristic = :characteristic", [
                        ':item' => $data['ItemCharacteristic']['item'],
                        ':characteristic' => $data['ItemCharacteristic']['characteristic'],
                    ])->one();
                    if(!$ItemCharacteristic){
                        if(!$data['ItemCharacteristic']['value']){
                            continue;
                        }
                        $ItemCharacteristic = new ItemCharacteristic();
                    }
                    $ItemCharacteristic->load($data);
                    var_dump($data['ItemCharacteristic']['value']);
                    echo PHP_EOL.'<br>';
                    ob_flush();
                    flush();
                    if($ItemCharacteristic->validate()) {
                        $ItemCharacteristic->save(false);
                    }else{
                        var_dump($ItemCharacteristic->getErrors());
                        echo PHP_EOL.'<br>';
                        ob_flush();
                        flush();
                    }
                }
                $imgUrl = trim($worksheet->getCellByColumnAndRow(11, $row)->getValue());
                ItemImg::uploadInUrl($imgUrl, $item);
                var_dump($data['Item']);
            }
            sleep(6);
            echo PHP_EOL.'<br>';
            echo '</pre>';
            ob_flush();
            flush();
            $r++;
        }
        echo PHP_EOL.'<br>'.$r;
        ob_flush();
        flush();
        @unlink(self::getPriceFile(true));
        ob_clean();
        return  $r;
    }
}