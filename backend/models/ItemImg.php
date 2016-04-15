<?php

namespace backend\models;

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

    public function upload($model)
    {
        $dirItemImg = Yii::getAlias('@frontend/web/image/item/');
        if(!is_dir($dirItemImg)){
            mkdir($dirItemImg, 0777);
        }
        $this->item = $model->id;
        $dirItemImg .= $model->id.'/';
        if(!is_dir($dirItemImg)){
            mkdir($dirItemImg, 0777);
        }
        if ($this->validate()) {
            foreach ($this->imageFiles as $key => $file) {
                $fileName = $file->baseName . '.' . $file->extension;
                $file->saveAs($dirItemImg . $fileName);
                $imgSave = new self();
                $imgSave->item = $model->id;
                $imgSave->name = $fileName;
                $imgSave->position = $this->position ? $this->position : (4 - $key);
                $imgSave->save();
            }
            return true;
        }
        return false;
    }
}
