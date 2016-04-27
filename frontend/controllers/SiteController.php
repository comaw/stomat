<?php
namespace frontend\controllers;

use frontend\models\Category;
use frontend\models\Item;
use frontend\models\LoginError;
use frontend\models\Manufacturer;
use frontend\models\News;
use Yii;
use common\models\LoginForm;
use frontend\models\PasswordResetRequestForm;
use frontend\models\ResetPasswordForm;
use frontend\models\SignupForm;
use frontend\models\ContactForm;
use yii\base\InvalidParamException;
use yii\helpers\Url;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\filters\AccessControl;

/**
 * Site controller
 */
class SiteController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout', 'signup'],
                'rules' => [
                    [
                        'actions' => ['signup'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return mixed
     */
    public function actionIndex()
    {
        $models = Item::find()->with(['itemImgs', 'currency0', 'manufacturer0'])->where("home = :home AND stock > 0", [':home' => 1])->orderBy('name, id desc')->all();
        return $this->render('index', [
            'models' => $models,
        ]);
    }

    /**
     * Logs in a user.
     *
     * @return mixed
     */
    public function actionLogin()
    {
        if (!\Yii::$app->user->isGuest) {
            return $this->goHome();
        }
        $errorLogin = null;
        $model = new LoginForm();
        $errorLogin = LoginError::getLog();
        if($errorLogin){
            $model = new LoginForm(['scenario' => 'error']);
        }
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            LoginError::del();
            return $this->goBack();
        } else {
            $errorLogin = LoginError::getLog();
            return $this->render('login', [
                'model' => $model,
                'errorLogin' => $errorLogin,
            ]);
        }
    }

    public function actionSitemap()
    {
        Yii::$app->response->format = \yii\web\Response::FORMAT_RAW;
        $headers = Yii::$app->response->headers;
        $headers->add('Content-Type', 'text/xml');

        $models = Category::find()->orderBy("id desc")->limit(200)->all();
        $news = News::find()->orderBy("id desc")->limit(200)->all();
        $manufacturer = Manufacturer::find()->orderBy("id desc")->limit(200)->all();
        $item = Item::find()->orderBy("id desc")->limit(2000)->all();
        return $this->renderPartial('sitemap', [
            'models' => $models,
            'news' => $news,
            'manufacturer' => $manufacturer,
            'item' => $item,
        ]);
    }

    /**
     * Logs out the current user.
     *
     * @return mixed
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * Displays contact page.
     *
     * @return mixed
     */
    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail(Yii::$app->params['adminEmail'])) {
                Yii::$app->session->setFlash('success', Yii::t('app', 'Благодарим Вас за обращение к нам. Мы ответим вам как можно скорее.'));
            } else {
                Yii::$app->session->setFlash('error', Yii::t('app', 'Был ошибка отправки электронной почты.'));
            }

            return $this->refresh();
        } else {
            return $this->render('contact', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Signs user up.
     *
     * @return mixed
     */
    public function actionSignup()
    {
        $model = new SignupForm();
        if ($model->load(Yii::$app->request->post())) {
            if ($user = $model->signup()) {
                if (Yii::$app->getUser()->login($user)) {
                    return $this->goHome();
                }
            }
        }

        return $this->render('signup', [
            'model' => $model,
        ]);
    }

    /**
     * Requests password reset.
     *
     * @return mixed
     */
    public function actionRequestpasswordreset()
    {
        $model = new PasswordResetRequestForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail()) {
                Yii::$app->session->setFlash('success', Yii::t('app', 'Проверьте свою электронную почту для получения дальнейших инструкций.'));

                return $this->refresh();
            } else {
                Yii::$app->session->setFlash('error', Yii::t('app', 'К сожалению, мы не можем сбросить пароль для электронной почты при условии.'));
            }
        }

        return $this->render('requestPasswordResetToken', [
            'model' => $model,
        ]);
    }

    /**
     * Resets password.
     *
     * @param string $token
     * @return mixed
     * @throws BadRequestHttpException
     */
    public function actionResetpassword($token)
    {
        try {
            $model = new ResetPasswordForm($token);
        } catch (InvalidParamException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }

        if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->resetPassword()) {
            Yii::$app->session->setFlash('success', Yii::t('app', 'Новый пароль был сохранен.'));

            return $this->redirect(Url::toRoute(['site/login']));
        }

        return $this->render('resetPassword', [
            'model' => $model,
        ]);
    }
}
