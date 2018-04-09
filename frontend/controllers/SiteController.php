<?php
namespace frontend\controllers;

use Yii;
use yii\base\InvalidParamException;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\models\LoginForm;
use frontend\models\PasswordResetRequestForm;
use frontend\models\ResetPasswordForm;
use frontend\models\SignupForm;
use frontend\models\ContactForm;

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
                        'actions' => ['signup','language'],
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
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
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
        return $this->render('index');
    }

    /**
     * Logs in a user.
     *
     * @return mixed
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            // Exito en el acceso
            Yii::$app->session->setFlash('successLogin', Yii::t('app','<h4>Bienvenido <b>'.Yii::$app->user->identity->username).'</b></h4><p>Su acceso ha sido autentificado correctamente. Por favor NO olvide cerrar su sesión al terminar.<br/></p>');
            return $this->goBack();
        } else {
            return $this->render('login', [
                'model' => $model,
            ]);
        }
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
                Yii::$app->session->setFlash('success', Yii::t('app','Gracias por contactarnos. Responderemos tan pronto como nos sea posible.'));
            } else {
                Yii::$app->session->setFlash('error', Yii::t('app','Se presentó un error al enviar su mensaje.'));
            }
            return $this->refresh();
        } else {
            return $this->render('contact', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Displays about page.
     *
     * @return mixed
     */
    public function actionAbout()
    {
        return $this->render('about');
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

            // 2018-04-08 : An error occurred in the data capture. A flash message is issued.

            Yii::$app->session->setFlash('error', Yii::t('app','Por favor atienda las siguientes consideraciones antes de proceder a registrar la información.'));
            return $this->render('signup', [
                'model' => $model,
            ]);
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
    public function actionRequestPasswordReset()
    {
        $model = new PasswordResetRequestForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail()) {
                Yii::$app->session->setFlash('success', Yii::t('app','Revise su correo para obtener más instrucciones.'));

                return $this->goHome();
            } else {
                Yii::$app->session->setFlash('error', Yii::t('app','Lo sentimos, no hemos logrado re-iniciar la contraseña de la cuenta de correo proporcionada.'));
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
    public function actionResetPassword($token)
    {
        try {
            $model = new ResetPasswordForm($token);
        } catch (InvalidParamException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }

        if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->resetPassword()) {
            Yii::$app->session->setFlash('success', Yii::t('app','Nueva contraseña generada.'));

            return $this->goHome();
        }

        return $this->render('resetPassword', [
            'model' => $model,
        ]);
    }

    /**
     * Stores a language value user's preference to a cookie.
     *
     * 2018-02-05 13:34 Hrs.
     *
     * Source : Yii2 Lesson - 51 Internationalization | i18n File Based ( Nov 14 2015 )
     * Resource : https://www.youtube.com/watch?v=_qNMcJKoEK0
     */

    public function actionLanguage(){

        if (isset($_POST['lang'])){

            Yii::$app->language = $_POST['lang'];
            $cookie = new \yii\web\Cookie(['name' => 'lang', 'value' => $_POST['lang']]);
            Yii::$app->getResponse()->getCookies()->add($cookie);

        }

    }

    /**
     * Display a window help for general topics about de application.
     *
     * 2018-02-07 14:23 Hrs.
     *
     */

    public function actionHelp(){

        return $this->render('help');

    }

}
