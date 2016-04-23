<?php

namespace backend\models;

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
 * @property string $pass
 */
class User extends \yii\db\ActiveRecord
{

    public $pass;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%user}}';
    }

    public function beforeValidate()
    {
        return parent::beforeValidate();
    }

    public function beforeSave($insert)
    {
        if(parent::beforeSave($insert)){
            if($this->isNewRecord){
                $this->created_at = time();
            }
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
            [['username', 'email', 'password_hash'], 'required'],
            [['role'], 'string'],
            [['status', 'created_at', 'updated_at'], 'integer'],
            [['username', 'email', 'password_hash', 'password_reset_token'], 'string', 'max' => 255],
            [['auth_key'], 'string', 'max' => 32],
            [['username'], 'unique'],
            [['email'], 'unique'],
            [['email'], 'email'],
            [['pass'], 'string', 'max' => 32, 'min' => 6],
            [['role'], 'in', 'range' => array_keys(self::listRole())],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'username' => Yii::t('app', 'Username'),
            'email' => Yii::t('app', 'Email'),
            'role' => Yii::t('app', 'Role'),
            'auth_key' => Yii::t('app', 'Auth Key'),
            'password_hash' => Yii::t('app', 'Password Hash'),
            'password_reset_token' => Yii::t('app', 'Password Reset Token'),
            'status' => Yii::t('app', 'Status'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
            'pass' => Yii::t('app', 'Password'),
        ];
    }

    public static function listRole(){
        return [
            'user' => Yii::t('app', 'User'),
            'manager' => Yii::t('app', 'Manager'),
            'admin' => Yii::t('app', 'Admin'),
        ];
    }

    public function getRoleName(){
        return isset(self::listRole()[$this->role]) ? self::listRole()[$this->role] : null;
    }

    public static function listStatus(){
        return [
            10 => Yii::t('app', 'Active'),
            20 => Yii::t('app', 'Banned'),
        ];
    }

    public function getStatusName(){
        return isset(self::listStatus()[$this->status]) ? self::listStatus()[$this->status] : null;
    }
}
