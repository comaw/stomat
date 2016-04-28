<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "{{%subscribe}}".
 *
 * @property string $id
 * @property string $email
 * @property integer $active
 * @property string $created
 */
class Subscribe extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%subscribe}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['email'], 'filter', 'filter' => 'trim', 'skipOnArray' => true],
            [['email'], 'filter', 'filter' => 'strip_tags', 'skipOnArray' => true],
            [['email'], 'required'],
            [['active'], 'integer'],
            [['created'], 'safe'],
            [['email'], 'string', 'max' => 255],
            [['email'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'email' => Yii::t('app', 'Email'),
            'active' => Yii::t('app', 'Active'),
            'created' => Yii::t('app', 'Created'),
        ];
    }

    public function getActiveName(){
        return isset(self::getActive()[$this->active]) ? self::getActive()[$this->active] : null;
    }

    public static function getActive($ksort = false){
        $r = [
            1 => Yii::t('app', 'Да'),
            0 => Yii::t('app', 'Нет'),
        ];
        if($ksort){
            ksort($r);
        }
        return $r;
    }
}
