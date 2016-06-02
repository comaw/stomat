<?php

namespace console\models;

use Yii;

/**
 * This is the model class for table "{{%cache}}".
 *
 * @property string $id
 * @property integer $expire
 * @property resource $data
 */
class Cache extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%cache}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id'], 'required'],
            [['expire'], 'integer'],
            [['data'], 'string'],
            [['id'], 'string', 'max' => 128],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'expire' => Yii::t('app', 'Expire'),
            'data' => Yii::t('app', 'Data'),
        ];
    }
}
