<?php
namespace frontend\controllers;

use Yii;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\models\LoginForm;
use yii\base\InvalidParamException;
use yii\web\BadRequestHttpException;
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
                'only' => ['logout', 'signup', 'language'],
                'rules' => [
                    // 2018-05-24 : Removes the rules for a guest user, due to the yii2 rbac security is on.
                    [
                        'actions' => ['signup', 'logout', 'language'],
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
        // 2018-05-25 : Yii2 Rbac - Validates the access.

        if (\Yii::$app->user->can('adminSite') || \Yii::$app->user->can('userGuest')) {
            return $this->render('index');
        }

        return $this->redirect(['site/login']);
    }

    /**
     * Logs in a user.
     *
     * @return mixed
     */
    public function actionLogin()
    {
        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post())) {

            // 2018-05-06 : This method were refactoring for issue a warning message in an wrong access operation.

            if ($model->login()){
                // Access success

                $str1 = Yii::t('app', 'Bienvenido');
                $str2 = Yii::t('app', 'Su acceso ha sido autentificado correctamente. Por favor NO olvide cerrar su sesión al terminar.');
                $str3 = '<h4>'.$str1.'&nbsp;&nbsp;<b>'.Yii::$app->user->identity->username.'</b></h4><p>'.$str2.'<br/></p>';

                Yii::$app->session->setFlash('successLogin', $str3);

                // 2018-06-10 : Clears out all the flash error and warning messages, launched before the login session.

                // Description : If the user request an cttwapp url to create a client, and the user is not logged yet, then an error message will be
                // issued. Then when the user will be logged again and get into the Client module, the expired warning message will be displayed.
                Yii::$app->session->setFlash('error', null);
                Yii::$app->session->setFlash('warning', null);

                return $this->goBack();
            }

            // Access error
            // 2018-05-06 : An error occurred in the login process. A flash message is issued.

            Yii::$app->session->setFlash('warning', Yii::t('app','Por favor atienda las siguientes consideraciones antes de proceder a su atentificación.'));
            return $this->render('login', [
                'model' => $model,
            ]);
        }

        return $this->render('login', [
            'model' => $model,
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
        // 2018-05-25 : Yii2 Rbac - Validates the access.

        if (\Yii::$app->user->can('adminSite')) {
            $model = new ContactForm();
            if ($model->load(Yii::$app->request->post()) && $model->validate()) {
                if ($model->sendEmail(Yii::$app->params['adminEmail'])) {
                    Yii::$app->session->setFlash('success', Yii::t('app','Gracias por contactarnos. Responderemos tan pronto como nos sea posible.'));
                } else {
                    Yii::$app->session->setFlash('warning', Yii::t('app','Se presentó un error al enviar su mensaje.'));
                }
                return $this->refresh();
            } else {
                return $this->render('contact', [
                    'model' => $model,
                ]);
            }
        }

        Yii::$app->session->setFlash('forbiddenAccess', Yii::t('app', 'Su perfil de acceso no le autoriza a utilizar esta acción. Por favor contacte al administrador del sistema para mayores detalles.'));
        return $this->redirect(['site/index']);
    }

    /**
     * Displays about page.
     *
     * @return mixed
     */
    public function actionAbout()
    {
        // 2018-05-25 : Yii2 Rbac - Validates the access.

        if (\Yii::$app->user->can('adminSite')) {
            return $this->render('about');
        }

        Yii::$app->session->setFlash('forbiddenAccess', Yii::t('app', 'Su perfil de acceso no le autoriza a utilizar esta acción. Por favor contacte al administrador del sistema para mayores detalles.'));
        return $this->redirect(['site/index']);
    }

    /**
     * Signs user up.
     *
     * @return mixed
     */
    public function actionSignup()
    {
        // 2018-05-25 : Yii2 Rbac - Validates the access.

        if (\Yii::$app->user->can('adminSite')) {
            $model = new SignupForm();
            if ($model->load(Yii::$app->request->post())) {
                if ($user = $model->signup()) {
                    if (Yii::$app->getUser()->login($user)) {

                        // 2018-05-23 : Display an welcome message window to the new user.

                        // Signup success

                        $str1 = Yii::t('app', 'Bienvenido');
                        $str2 = Yii::t('app', 'Su registro ha sido procesado correctamente. Por favor NO olvide cerrar su sesión al terminar.');
                        $str3 = '<h4>'.$str1.'&nbsp;&nbsp;<b>'.Yii::$app->user->identity->username.'</b></h4><p>'.$str2.'<br/></p>';

                        Yii::$app->session->setFlash('successLogin', $str3);

                        return $this->goHome();
                    }
                }

                // 2018-04-08 : An error occurred in the captured data. A flash message is issued.

                Yii::$app->session->setFlash('warning', Yii::t('app','Por favor atienda las siguientes consideraciones antes de proceder a registrar la información.'));
                return $this->render('signup', [
                    'model' => $model,
                ]);
            }

            return $this->render('signup', [
                'model' => $model,
            ]);
        }

        return $this->redirect(['site/login', '#' => 'work-area-index']);
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
                Yii::$app->session->setFlash('warning', Yii::t('app','Lo sentimos, no hemos logrado re-iniciar la contraseña de la cuenta de correo proporcionada.'));
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
     * Display a window help for general topics about de application.
     *
     * 2018-02-07 14:23 Hrs.
     *
     */

    public function actionHelp()
    {
        // 2018-05-25 : Yii2 Rbac - Validates the access.

        if (\Yii::$app->user->can('adminSite')) {
            return $this->render('help');
        }

        Yii::$app->session->setFlash('forbiddenAccess', Yii::t('app', 'Su perfil de acceso no le autoriza a utilizar esta acción. Por favor contacte al administrador del sistema para mayores detalles.'));
        return $this->redirect(['site/index']);
    }
    /**
     * Stores a language value user's preference to a cookie.
     *
     * 2018-02-05 13:34 Hrs.
     *
     * Source : Yii2 Lesson - 51 Internationalization | i18n File Based ( Nov 14 2015 )
     * Resource : https://www.youtube.com/watch?v=_qNMcJKoEK0
     *
     */

    public function actionLanguage()
    {
        Yii::$app->language = $_POST['lang'];
        $cookie = new \yii\web\Cookie(['name' => 'lang', 'value' => $_POST['lang']]);
        Yii::$app->getResponse()->getCookies()->add($cookie);
    }
    /**
     * Displays a debug view for general purpose.
     *
     * 2018-06-15 12:25 Hrs.
     *
     * Author : ISC. Ricardo González González
     * Reference : http://cttwapp.com/index.php?r=site/debug
     *
     */
    public function actionDebug()
    {
        return $this->render('debug');
    }
}