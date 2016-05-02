<?php

namespace app\models;

use common\UrlHelp;
use common\UrlHelper;
use Yii;
use yii\helpers\Url;

/**
 * This is the model class for table "{{%news}}".
 *
 * @property string $id
 * @property string $name
 * @property string $url
 * @property string $title
 * @property string $description
 * @property string $small
 * @property string $content
 * @property string $img
 * @property string $imageFile
 * @property string $created
 */
class News extends \yii\db\ActiveRecord
{
    public $imageFile;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%news}}';
    }

    public function beforeValidate()
    {
        if($this->isNewRecord){
            $this->url = $this->name;
        }
        return parent::beforeValidate();
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
            $this->url = UrlHelper::translateUrl($this->url);
            if(!$this->isNewRecord) {
                $attributes = $this->getAttributes(null, []);
                foreach ($attributes AS $attribute => $v) {
                    $old = $this->getOldAttribute($attribute);
                    $new = $this->$attribute;
                    if($old != $new && mb_strlen($new, Yii::$app->charset) < 200){
                        $m = Yii::t('app', 'В Новостях ID').$this->id;
                        $m .= Yii::t('app', ' Поле ').$this->getAttributeLabel($attribute);
                        $m .= Yii::t('app', ' изменилось с "').$old;
                        $m .= Yii::t('app', '" на "').$new.'"';
                        \backend\models\Log::add($m);
                    }elseif($old != $new && mb_strlen($new, Yii::$app->charset) >= 200){
                        $m = Yii::t('app', 'В Новостях ID').$this->id;
                        $m .= Yii::t('app', ' Поле ').$this->getAttributeLabel($attribute);
                        $m .= Yii::t('app', ' изменилось');
                        \backend\models\Log::add($m);
                    }
                }
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
            [['content', 'small'], 'string'],
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
            'small' => Yii::t('app', 'Preview'),
            'img' => Yii::t('app', 'Img'),
            'imageFile' => Yii::t('app', 'Img'),
            'created' => Yii::t('app', 'Created'),
        ];
    }

    public function upload($url)
    {
        if ($this->validate()) {
            $this->imageFile->saveAs(Yii::getAlias('@frontend/web/images/news/'). $url . '.' . $this->imageFile->extension);
            return $url . '.' . $this->imageFile->extension;
        } else {
            return false;
        }
    }

    public static function getUrlImg($img){
        return UrlHelp::baseAdmin().'images/news/'.$img;
    }

    public static function delImg($img){
        return @unlink(Yii::getAlias('@frontend/web/images/news/').$img);
    }
}
