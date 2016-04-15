<?php

namespace app\models;

use common\UrlHelp;
use Yii;
use yii\helpers\Url;

/**
 * This is the model class for table "{{%page}}".
 *
 * @property string $id
 * @property string $name
 * @property string $url
 * @property string $title
 * @property string $description
 * @property string $content
 * @property string $img
 * @property string $imageFile
 * @property string $created
 */
class Page extends \yii\db\ActiveRecord
{
    public $imageFile;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%page}}';
    }

    /**
     * @inheritdoc
     */
    public function beforeSave($insert)
    {
        if(parent::beforeSave($insert)){
            if($this->isNewRecord){
                $this->title = $this->title ? $this->title : $this->name;
                $this->description = $this->description ? $this->description : $this->name;
            }
            return true;
        }
        return false;
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'url', 'title', 'description'], 'filter', 'filter' => 'trim', 'skipOnArray' => true],
            [['name', 'url', 'content'], 'required'],
            [['content'], 'string'],
            [['created', 'img'], 'safe'],
            [['name', 'url', 'title', 'description', 'img'], 'string', 'max' => 255],
            [['name'], 'unique'],
            [['url'], 'unique'],
            [['imageFile'], 'file', 'extensions' => ['png', 'jpg', 'jpeg', 'gif']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'name' => Yii::t('app', 'Name'),
            'url' => Yii::t('app', 'Url'),
            'title' => Yii::t('app', 'Title'),
            'description' => Yii::t('app', 'Description'),
            'content' => Yii::t('app', 'Content'),
            'img' => Yii::t('app', 'Img'),
            'imageFile' => Yii::t('app', 'Img'),
            'created' => Yii::t('app', 'Created'),
        ];
    }

    public function upload($url)
    {
        if ($this->validate()) {
            $this->imageFile->saveAs(Yii::getAlias('@frontend/web/images/pages/'). $url . '.' . $this->imageFile->extension);
            return $url . '.' . $this->imageFile->extension;
        } else {
            return false;
        }
    }

    public static function getUrlImg($img){
        return UrlHelp::baseAdmin().'images/pages/'.$img;
    }

    public static function delImg($img){
        return @unlink(Yii::getAlias('@frontend/web/images/pages/').$img);
    }
}
