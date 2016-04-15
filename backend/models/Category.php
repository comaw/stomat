<?php

namespace backend\models;

use common\UrlHelper;
use Yii;

/**
 * This is the model class for table "{{%category}}".
 *
 * @property string $id
 * @property string $name
 * @property string $url
 * @property string $title
 * @property string $description
 * @property string $content
 */
class Category extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%category}}';
    }

    public function beforeValidate()
    {
        if(!$this->url){
            $this->url = $this->name;
        }
        $this->url = UrlHelper::translateUrl($this->url);
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
            [['name', 'url'], 'required'],
            [['content'], 'string'],
            [['name', 'url', 'title', 'description'], 'string', 'max' => 255],
            [['name'], 'unique'],
            [['url'], 'unique'],
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
        ];
    }
}
