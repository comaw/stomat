<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "{{%manufacturer}}".
 *
 * @property string $id
 * @property string $name
 * @property string $url
 * @property string $title
 * @property string $description
 * @property string $content
 *
 * @property Item[] $items
 * @property string $itemsByCount
 */
class Manufacturer extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%manufacturer}}';
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

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getItems()
    {
        return $this->hasMany(Item::className(), ['manufacturer' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getItemsByCount()
    {
        return $this->hasMany(Item::className(), ['manufacturer' => 'id'])->where("stock > 0")->count();
    }
}
