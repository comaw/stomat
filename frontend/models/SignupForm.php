<?php
namespace frontend\models;

use common\models\User;
use yii\base\Model;
use Yii;

/**
 * Signup form
 */
class SignupForm extends Model
{
    public $username;
    public $email;
    public $password;
    public $confirm;
    public $verifyCode;
    public $laws;


    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'username' => Yii::t('app', 'Ф.И.О.'),
            'email' => Yii::t('app', 'Email'),
            'password' => Yii::t('app', 'Пароль'),
            'confirm' => Yii::t('app', 'Повторите пароль'),
            'laws' => Yii::t('app', 'Я согласен с условиями использования.'),
            'verifyCode' => Yii::t('app', 'Я не робот'),
        ];
    }
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['username', 'email'], 'filter', 'filter' => 'strip_tags'],
            ['username', 'filter', 'filter' => 'trim'],
            ['username', 'required'],
            ['username', 'unique', 'targetClass' => '\common\models\User', 'message' => Yii::t('app', 'Это имя пользователя уже занято.')],
            ['username', 'string', 'min' => 2, 'max' => 255],

            ['email', 'filter', 'filter' => 'trim'],
            ['email', 'required'],
            ['email', 'email'],
            ['email', 'string', 'max' => 255],
            ['email', 'unique', 'targetClass' => '\common\models\User', 'message' => Yii::t('app', 'Этот адрес электронной почты уже занят.')],

            ['password', 'required'],
            ['password', 'string', 'min' => 6],

            [['confirm'], 'compare', 'compareAttribute'=> 'password', 'message'=> Yii::t('app', 'Пароли не совпадают') ],
            [['verifyCode'], \common\recaptcha\ReCaptchaValidator::className(), 'secret' => \common\recaptcha\ReCaptcha::SECRET_KEY],

            ['laws', 'required', 'requiredValue' => 1, 'message' => Yii::t('app', 'Вы должны согласиться с условиями')],
        ];
    }

    /**
     * Signs user up.
     *
     * @return User|null the saved model or null if saving fails
     */
    public function signup()
    {
        if (!$this->validate()) {
            return null;
        }
        
        $user = new User();
        $user->username = $this->username;
        $user->email = $this->email;
        $user->setPassword($this->password);
        $user->generateAuthKey();
        if($user->save()){
            $description = new UserDescription();
            $description->id = $user->id;
            $description->save();
            Yii::$app->mail
                ->compose(
                    ['html' => 'signup-html', 'text' => 'signup-text'],
                    ['user' => $user]
                )
                ->setFrom([Yii::$app->params['adminEmail'] => Yii::$app->params['site_name']])
                ->setTo($user->email)
                ->setSubject(Yii::t('app', 'Успешная регистрация на сайте: {sitename}', ['sitename' => Yii::$app->name]))
                ->send();
            return $user;
        }
        return null;
    }
}
