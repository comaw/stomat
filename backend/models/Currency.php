<?php

namespace backend\models;

use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "{{%currency}}".
 *
 * @property string $id
 * @property string $name
 * @property string $title
 */
class Currency extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%currency}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'title'], 'filter', 'filter' => 'trim', 'skipOnArray' => true],
            [['name', 'title'], 'filter', 'filter' => 'strip_tags', 'skipOnArray' => true],
            [['name'], 'required'],
            [['name', 'title'], 'string', 'max' => 255],
            [['name'], 'unique'],
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
            'title' => Yii::t('app', 'Общее название'),
        ];
    }

    public static function getToList(){
        return ArrayHelper::map(self::find()->orderBy('id asc')->all(), 'id', 'name');
    }
}
