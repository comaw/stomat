<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "{{%user}}".
 *
 * @property string $id
 * @property string $username
 * @property string $email
 * @property string $role
 * @property string $auth_key
 * @property string $password_hash
 * @property string $password_reset_token
 * @property integer $status
 * @property integer $created_at
 * @property integer $updated_at
 */
class User extends \yii\db\ActiveRecord
{

    public $pass;
    public $confirm;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%user}}';
    }

    public function beforeSave($insert)
    {
        if(parent::beforeSave($insert)){
            $this->updated_at = time();
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
            [['username', 'email', 'pass'], 'filter', 'filter' => 'trim', 'skipOnArray' => true],
            [['username', 'email', 'pass'], 'filter', 'filter' => 'strip_tags', 'skipOnArray' => true],
            [['username', 'email', 'password_hash'], 'required'],
            [['role'], 'string'],
            [['status', 'created_at', 'updated_at'], 'integer'],
            [['username', 'email', 'password_hash', 'password_reset_token'], 'string', 'max' => 255],
            [['auth_key'], 'string', 'max' => 32],
            [['username'], 'unique'],
            [['email'], 'unique'],
            [['email'], 'email'],
            [['confirm'], 'compare', 'compareAttribute'=> 'pass', 'message'=> Yii::t('app', 'Пароли не совпадают') ],
            [['pass'], 'string', 'max' => 32, 'min' => 6],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'username' => Yii::t('app', 'Ф.И.О.'),
            'email' => Yii::t('app', 'Email'),
            'role' => Yii::t('app', 'Роль'),
            'auth_key' => Yii::t('app', 'Auth Key'),
            'password_hash' => Yii::t('app', 'Password Hash'),
            'password_reset_token' => Yii::t('app', 'Password Reset Token'),
            'status' => Yii::t('app', 'Статус'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
            'pass' => Yii::t('app', 'Пароль'),
            'confirm' => Yii::t('app', 'Повторите пароль'),
        ];
    }
}
