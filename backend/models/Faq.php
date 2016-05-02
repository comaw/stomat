<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "{{%faq}}".
 *
 * @property string $id
 * @property string $question
 * @property string $answer
 * @property string $acitve
 */
class Faq extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%faq}}';
    }

    /**
     * @inheritdoc
     */
    public function beforeSave($insert)
    {
        if(parent::beforeSave($insert)){
            if(!$this->isNewRecord) {
                $attributes = $this->getAttributes(null, []);
                foreach ($attributes AS $attribute => $v) {
                    $old = $this->getOldAttribute($attribute);
                    $new = $this->$attribute;
                    if($old != $new && mb_strlen($new, Yii::$app->charset) < 200){
                        $m = Yii::t('app', 'В FAQ ID').$this->id;
                        $m .= Yii::t('app', ' Поле ').$this->getAttributeLabel($attribute);
                        $m .= Yii::t('app', ' изменилось с "').$old;
                        $m .= Yii::t('app', '" на "').$new.'"';
                        \backend\models\Log::add($m);
                    }elseif($old != $new && mb_strlen($new, Yii::$app->charset) >= 200){
                        $m = Yii::t('app', 'В FAQ ID').$this->id;
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
            [['question', 'answer', 'acitve'], 'filter', 'filter' => 'trim', 'skipOnArray' => true],
            [['question'], 'filter', 'filter' => 'strip_tags', 'skipOnArray' => true],
            [['question'], 'required'],
            [['answer', 'acitve'], 'string'],
            [['question'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'question' => Yii::t('app', 'Question'),
            'answer' => Yii::t('app', 'Answer'),
            'acitve' => Yii::t('app', 'Acitve'),
        ];
    }

    public static function listActive(){
        return [
            'active' => Yii::t('app', 'Active'),
            'hide' => Yii::t('app', 'Hide'),
        ];
    }

    public function getActiveName(){
        return isset(self::listActive()[$this->acitve]) ? self::listActive()[$this->acitve] : null;
    }
}
