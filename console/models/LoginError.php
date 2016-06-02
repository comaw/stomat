<?php

namespace console\models;

use Yii;

/**
 * This is the model class for table "{{%login_error}}".
 *
 * @property string $id
 * @property string $ip
 * @property string $email
 * @property string $created
 */
class LoginError extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%login_error}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['ip'], 'required'],
            [['created'], 'safe'],
            [['ip'], 'string', 'max' => 32],
            [['email'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'ip' => Yii::t('app', 'Ip'),
            'email' => Yii::t('app', 'Email'),
            'created' => Yii::t('app', 'Created'),
        ];
    }
}
