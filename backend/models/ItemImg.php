<?php

namespace backend\models;

use common\CImageHandler;
use common\UrlHelp;
use Yii;

/**
 * This is the model class for table "{{%item_img}}".
 *
 * @property string $id
 * @property string $item
 * @property string $name
 * @property string $position
 * @property Item $item0
 */
class ItemImg extends \yii\db\ActiveRecord
{

    public $imageFile;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%item_img}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'filter', 'filter' => 'trim', 'skipOnArray' => true],
            [['name'], 'filter', 'filter' => 'strip_tags', 'skipOnArray' => true],
            [['item', 'name'], 'required'],
            [['item', 'position'], 'integer'],
            [['name'], 'string', 'max' => 255],
            [['item'], 'exist', 'skipOnError' => true, 'targetClass' => Item::className(), 'targetAttribute' => ['item' => 'id']],
            [['imageFile'], 'file', 'extensions' => ['png', 'jpg', 'jpeg', 'gif'], 'maxFiles' => 4],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'item' => Yii::t('app', 'Item'),
            'name' => Yii::t('app', 'Name'),
            'position' => Yii::t('app', 'Position'),
            'imageFile' => Yii::t('app', 'Image File'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getItem0()
    {
        return $this->hasOne(Item::className(), ['id' => 'item']);
    }

    /**
     * @param $model
     *
     * @return bool
     * @throws \yii\base\Exception
     */
    public function upload($model)
    {
        $dirItemImg = Yii::getAlias('@frontend/web/image/item/');
        if(!is_dir($dirItemImg)){
            mkdir($dirItemImg, 0777);
        }
        $this->item = $model->id;
        $this->name = 'test';
        $dirItemImg .= $model->id.'/';
        if(!is_dir($dirItemImg)){
            mkdir($dirItemImg, 0777);
        }
        if ($this->validate()) {
            $key = 0;
            $positions = Yii::$app->request->post('ItemImg');
            foreach ($this->imageFile AS $file) {
                $fileName = $file->baseName . '.' . $file->extension;
                $file->saveAs($dirItemImg . $fileName);
                $ih = new CImageHandler();
                $ih->load($dirItemImg . $fileName)
                    ->resize(198, 132)
                    ->save($dirItemImg . 'small_' . $fileName)
                    ->reload()
                    ->resize(330, 220)
                    ->save($dirItemImg . 'normal_' . $fileName);
                $imgSave = new self();
                $imgSave->item = $model->id;
                $imgSave->name = $fileName;
                $imgSave->position = isset($positions['position']) && is_numeric($positions['position']) ? $positions['position'] : (4 - $key);
                $imgSave->save();
                $key++;
            }
            return true;
        }
        return false;
    }

    public static function uploadInUrl($url, $model)
    {
        $dirItemImg = Yii::getAlias('@frontend/web/image/item/');
        if(!is_dir($dirItemImg)){
            mkdir($dirItemImg, 0777);
        }
        $dirItemImg .= $model->id.'/';
        if(!is_dir($dirItemImg)){
            mkdir($dirItemImg, 0777);
        }
        $fileName = explode('/', $url);
        $fileName = end($fileName);
        if(!$url || !$fileName){
            return false;
        }
        $copy = @copy($url, $dirItemImg . $fileName);
        if(!$copy){
            return false;
        }
        $ih = new CImageHandler();
        $ih->load($dirItemImg . $fileName)
            ->resize(198, 132)
            ->save($dirItemImg . 'small_' . $fileName)
            ->reload()
            ->resize(330, 220)
            ->save($dirItemImg . 'normal_' . $fileName);
        $imgSave = new self();
        $imgSave->item = $model->id;
        $imgSave->name = $fileName;
        $imgSave->position = 1;
        return $imgSave->save();
    }

    public function getImgUrl($type = ''){
        if(!$this->name){
            return null;
        }
        $dirItemImg = Yii::getAlias('@frontend/web/image/item/').$this->item.'/'.$type.$this->name;
        if(!is_file($dirItemImg)){
            return null;
        }
        return UrlHelp::adminHome().'image/item/'.$this->item.'/'.$type.$this->name;
    }

    public function deleteImg(){
        $dirItemImg = Yii::getAlias('@frontend/web/image/item/').$this->item.'/'.$this->name;
        $dirItemImgsmall = Yii::getAlias('@frontend/web/image/item/').$this->item.'/small_'.$this->name;
        $dirItemImgnormal = Yii::getAlias('@frontend/web/image/item/').$this->item.'/normal_'.$this->name;
        if(!is_file($dirItemImg)){
            return null;
        }
        @unlink($dirItemImg);
        @unlink($dirItemImgsmall);
        @unlink($dirItemImgnormal);
        return true;
    }
}
