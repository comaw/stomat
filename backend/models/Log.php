<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "{{%log}}".
 *
 * @property string $id
 * @property string $user
 * @property string $created
 * @property string $description
 *
 * @property User $user0
 */
class Log extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%log}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['description'], 'filter', 'filter' => 'trim', 'skipOnArray' => true],
//            [['description'], 'filter', 'filter' => 'strip_tags', 'skipOnArray' => true],
            [['user'], 'integer'],
            [['created'], 'safe'],
            [['description'], 'string'],
            [['user'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'user' => Yii::t('app', 'User'),
            'created' => Yii::t('app', 'Created'),
            'description' => Yii::t('app', 'Описание'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser0()
    {
        return $this->hasOne(User::className(), ['id' => 'user']);
    }

    public static function add($text = null){
        $model = new self();
        $model->user = Yii::$app->user->id;
        $model->created = date("Y-m-d H:i:s");
        $model->description = $text;
        return $model->save();
    }
}
