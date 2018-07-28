<?php
namespace backend\controllers;

use Yii;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\models\LoginForm;

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
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'actions' => ['login', 'error'],
                        'allow' => true,
                    ],
                    [
                        'actions' => ['logout', 'index', 'language'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::class,
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
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        // 2018-07-27 : Yii2 Rbac - Validates the access to the main page.
        if (\Yii::$app->user->can('accessMain')) {
            return $this->render('index');
        }

        return $this->redirect(['site/login']);
    }

    /**
     * Login action.
     *
     * @return string
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
     * Logout action.
     *
     * @return string
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        // 2018-06-21 : Redirects to the login page and jumps immediately to the 'work-area-index' anchor.
        return $this->redirect(['site/login', 'hash' => '0']);
    }

    /**
     * Stores a language value user's preference to a cookie.
     *
     * 2018-02-05 13:34 Hrs.
     *
     * Source : Yii2 Lesson - 51 Internationalization | i18n File Based ( Nov 14 2015 )
     * Resource : https://www.youtube.com/watch?v=_qNMcJKoEK0
     */

    public function actionLanguage()
    {
        Yii::$app->language = $_POST['lang'];
        $cookie = new \yii\web\Cookie(['name' => 'lang', 'value' => $_POST['lang']]);
        Yii::$app->getResponse()->getCookies()->add($cookie);
    }
}