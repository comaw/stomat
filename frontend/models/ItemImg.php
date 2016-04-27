<?php

namespace frontend\models;

use Yii;
use yii\helpers\Url;

/**
 * This is the model class for table "{{%item_img}}".
 *
 * @property string $id
 * @property string $item
 * @property string $name
 * @property integer $position
 *
 * @property Item $item0
 */
class ItemImg extends \yii\db\ActiveRecord
{
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
            [['item', 'name'], 'required'],
            [['item', 'position'], 'integer'],
            [['name'], 'string', 'max' => 255],
            [['item'], 'exist', 'skipOnError' => true, 'targetClass' => Item::className(), 'targetAttribute' => ['item' => 'id']],
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
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getItem0()
    {
        return $this->hasOne(Item::className(), ['id' => 'item']);
    }

    public function getImgUrl($type = ''){
        if(!$this->name){
            return null;
        }
        $dirItemImg = Yii::getAlias('@frontend/web/image/item/').$this->item.'/'.$type.$this->name;
        if(!is_file($dirItemImg)){
            return null;
        }
        return Url::home(true).'image/item/'.$this->item.'/'.$type.$this->name;
    }
}
