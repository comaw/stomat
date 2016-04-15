<?php

namespace app\models;

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
            [['ip'], 'string', 'max' => 30],
            [['email'], 'string', 'max' => 255]
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

    /**
     * @param null $id
     * @param null $mail
     *
     * @return bool|null
     */
    public static function addLog($id = null, $mail = null){
        if(!Yii::$app->request->getUserIP()){
            return null;
        }
        $model = null;
        if($id){
            $model = self::getLog($id);
        }
        if(!$model){
            $model = new self();
            $model->email = trim($mail);
            $model->ip = Yii::$app->request->getUserIP();
        }
        $model->created = date("Y-m-d H:i:s");
        if($model->validate()){
            $model->save();
            return true;
        }
        return false;
    }

    /**
     * @param null $id
     *
     * @return array|null|\yii\db\ActiveRecord
     */
    public static function getLog($id = null){
        if($id){
            return self::find()->where("id = :id", [':id' => $id])->one();
        }
        if(!Yii::$app->request->getUserIP()){
            return null;
        }
        return self::find()->where("ip = :ip AND created >= :created", [
            ':ip' => Yii::$app->request->getUserIP(),
            ':created' => date("Y-m-d H:i:s", (time() - 60 * 15)),
        ])->one();
    }

    public static function del(){
        $model = self::getLog();
        if($model){
            $model->delete();
        }
    }
}
