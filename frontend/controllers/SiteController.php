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
use app\models\ValidarFormulario;
use app\models\ValidarFormularioAjax;
use yii\widgets\ActiveForm;
use yii\web\response;
use app\models\FormAlumnos;
use app\models\Alumnos;
use app\models\FormSearch;
use yii\helpers\Html;
use yii\data\Pagination;
use yii\helpers\Url;

/**
 * Site controller
 */
class SiteController extends Controller
{

    /**
     *
     * Acción para el tutorial 3 - Yii Framework 2 Conectar acción-vista (Hola Mundo)
     *
     */
    public function actionSaluda($get = "Tutorial Yii2")
    {
        $mensaje = "Hola Mundo";
        $numeros= [0, 1, 2, 3, 4, 5];
        return $this->render("saluda",
                            [
                                "mensaje"=>$mensaje,
                                "numeros"=>$numeros,
                                "parametro"=>$get,
                            ]);
    }

    /**
     *
     * Acción para el tutorial 4 - Yii Framework 2 Conectar vista-acción (formularios y redirecciones)
     *
     */
    public function actionFormulario($mensaje = null)
    {
        return $this->render("formulario",["mensaje" => $mensaje]);
    }

    /**
     *
     * Acción para el tutorial 4 - Yii Framework 2 Conectar vista-acción (formularios y redirecciones)
     *
     */
    public function actionRequest()
    {
        $mensaje = null;

        if (isset($_REQUEST["nombre"]))
        {
            $mensaje = "Bien, has enviado tu nombre correctamente " . $_REQUEST["nombre"];
        }

        $this->redirect(["site/formulario","mensaje" => $mensaje]);
    }

    /**
     *
     * Accion para el tutorial 5 - Yii Framework 2 - Validar formularios lado cliente y servidor (ActiveForm)
     *
     */
    public function actionValidarformulario()
    {
        $model = new ValidarFormulario;

        if ($model->load(Yii::$app->request->post()))
        {
            if ($model->validate())
            {
                // Por ejemplo, se puede consultar una base de datos
            }
            else
            {
                $model->getErrors();
            }
        }

        return $this->render("validarformulario", ["model" => $model]);
    }

    /**
     *
     * Accion para el tutorial 6 - Yii Framework 2 - Validar formulario con AJAX
     *
     */
    public function actionValidarformularioajax()
    {
        $model = new ValidarFormularioAjax();
        $msg = null;

        if ($model->load(Yii::$app->request->post()) && Yii::$app->request->isAjax)
        {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($model);
        }

        if ($model->load(Yii::$app->request->post()))
        {
            if($model->validate())
            {
                // Por ejemplo aqui hacemos una consulta a una base de datos
                $msg = "Enhorabuena, formulario enviado correctamente.";
                $model -> nombre = null;
                $model -> email = null;
            }
            else
            {
                $model->getErrors();
            }

        }

        return $this->render("validarformularioajax",['model' => $model, 'msg' => $msg ]);

    }

    /**
     *
     * Acción para el tutorial 7 - Yii Framework 2  CRUD ActiveRecord Create (Crear registros)
     *
     */
    public function actionCreate()
    {
        $model = new FormAlumnos;
        $msg = null;

        if ($model->load(Yii::$app->request->post()))
        {
            if ($model->validate())
            {
                $table = new Alumnos;

                $table->nombre = $model->nombre;
                $table->apellidos = $model->apellidos;
                $table->clase = $model->clase;
                $table->nota_final = $model->nota_final;

                if ($table->insert())
                {

                    $msg = "Enhorabuenaregistro guardado correctamente";
                    $model->nombre = null;
                    $model->apellidos = null;
                    $model->clase = null;
                    $model->nota_final = null;

                }
                else
                {
                    $msg = "Ha ocurrido un error al insertar el registro";
                }

            }
            else
            {
                $model-> getErrors();
            }
        }

        return $this -> render("create", ['model' => $model,'msg' => $msg]);

    }


    /**
     *
     * Acción para el tutorial 8 - Yii Framework 2  CRUD ActiveRecord Read (Lectura de registros)
     *
    public function actionView()
    {

        $table = new Alumnos;
        $model = $table->find()->all();

        return $this->render("view", ["model" => $model]);

    }
    */

    /**
     *
     * Acción para el tutorial 9 - Yii Framework 2 - CRUD ActiveRecord Search (Formulario de búsqueda)
     *
    public function actionView()
    {
        $table = new Alumnos;
        $model = $table->find()->all();

        $form = new FormSearch;
        $search = null;
        if($form->load(Yii::$app->request->get()))
        {
            if ($form->validate())
            {
                $search = Html::encode($form->q);

                // 2017-09-11 INCIDENCIA : Al ejecutar el siguiente código original del tutorial .....

                //       $query = "SELECT * FROM alumnos WHERE id_alumno LIKE '%$search%' OR ...";

                // Ocurrió un error :

                //      $query = "SELECT * FROM alumnos WHERE id_alumno LIKE '%Fernández%' OR ...";
                //                                                            ^
                //                                                            |
                //      ERROR : Hint: Ningún operador coincide con el nombre y el tipo de los argumentos. Puede ser necesario agregar conversiones explícitas de tipos.

                // Explicación : Este error se provocó debido a que el campo 'id_alumno' es de tipo numérico, y se usa el operador LIKE que trabaja con valores de TEXTO en la consulta SQL.
                //               MySQL hace una conversión implícita, pero Postrgesql NO la hace. Así que se debe realizar de forma explícita con la función CAST ( AS TEXT).

                // Solución :

                //       $query = "SELECT * FROM alumnos WHERE CAST(id_alumno AS TEXT) LIKE '%$search%' OR ";

                $query = "SELECT * FROM alumnos WHERE CAST(id_alumno AS TEXT) LIKE '%$search%' OR ";
                $query .= "nombre LIKE '%$search%' OR apellidos LIKE '%$search%'";
                $model = $table->findBySql($query)->all();
            }
            else
            {
                $form->getErrors();
            }
        }
        return $this->render("view", ["model" => $model, "form" => $form, "search" => $search]);
    }
     */

    /**
     *
     * Acción para el tutorial 10 - Yii Framework 2 - CRUD ActiveRecord Pagination (Paginación de resultados)
     *
     */
    public function actionView()
    {
        $form = new FormSearch;
        $search = null;
        if($form->load(Yii::$app->request->get()))
        {
            if ($form->validate())
            {
                $search = Html::encode($form->q);
                $table = Alumnos::find()
                    ->where(["like", "id_alumno", $search])
                    ->orWhere(["like", "nombre", $search])
                    ->orWhere(["like", "apellidos", $search]);
                $count = clone $table;
                $pages = new Pagination([
                    "pageSize" => 1,
                    "totalCount" => $count->count()
                ]);
                $model = $table
                    ->offset($pages->offset)
                    ->limit($pages->limit)
                    ->all();
            }
            else
            {
                $form->getErrors();
            }
        }
        else
        {
            $table = Alumnos::find();
            $count = clone $table;
            $pages = new Pagination([
                "pageSize" => 1,
                "totalCount" => $count->count(),
            ]);
            $model = $table
                ->offset($pages->offset)
                ->limit($pages->limit)
                ->all();
        }
        return $this->render("view", ["model" => $model, "form" => $form, "search" => $search, "pages" => $pages]);
    }

    /**
     *
     * Acción para el tutorial 11 - Yii Framework 2 - CRUD ActiveRecord Delete (Eliminar Registros)
     *
     */
    public function actionDelete()
    {
        if(Yii::$app->request->post())
        {
            $id_alumno = Html::encode($_POST["id_alumno"]);
            if((int) $id_alumno)
            {
                if(Alumnos::deleteAll("id_alumno=:id_alumno", [":id_alumno" => $id_alumno]))
                {
                    echo "Alumno con id $id_alumno eliminado con éxito, redireccionando ...";
                    echo "<meta http-equiv='refresh' content='3; ".Url::toRoute("site/view")."'>";
                }
                else
                {
                    echo "Ha ocurrido un error al eliminar el alumno, redireccionando ...";
                    echo "<meta http-equiv='refresh' content='3; ".Url::toRoute("site/view")."'>";
                }
            }
            else
            {
                echo "Ha ocurrido un error al eliminar el alumno, redireccionando ...";
                echo "<meta http-equiv='refresh' content='3; ".Url::toRoute("site/view")."'>";
            }
        }
        else
        {
            return $this->redirect(["site/view"]);
        }
    }


    /**
     *
     * Acción para el tutorial 12 - Yii Framework 2 - CRUD ActiveRecord Update (Actualizar Registros)
     *
     */
    public function actionUpdate()
    {
        $model = new FormAlumnos;
        $msg = null;

        if($model->load(Yii::$app->request->post()))
        {
            if($model->validate())
            {
                $table = Alumnos::findOne($model->id_alumno);
                if($table)
                {
                    $table->nombre = $model->nombre;
                    $table->apellidos = $model->apellidos;
                    $table->clase = $model->clase;
                    $table->nota_final = $model->nota_final;
                    if ($table->update())
                    {
                        $msg = "El Alumno ha sido actualizado correctamente";
                    }
                    else
                    {
                        $msg = "El Alumno no ha podido ser actualizado";
                    }
                }
                else
                {
                    $msg = "El alumno seleccionado no ha sido encontrado";
                }
            }
            else
            {
                $model->getErrors();
            }
        }

        if (Yii::$app->request->get("id_alumno"))
        {
            $id_alumno = Html::encode($_GET["id_alumno"]);
            if ((int) $id_alumno)
            {
                $table = Alumnos::findOne($id_alumno);
                if($table)
                {
                    $model->id_alumno = $table->id_alumno;
                    $model->nombre = $table->nombre;
                    $model->apellidos = $table->apellidos;
                    $model->clase = $table->clase;
                    $model->nota_final = $table->nota_final;
                }
                else
                {
                    return $this->redirect(["site/view"]);
                }
            }
            else
            {
                return $this->redirect(["site/view"]);
            }
        }
        else
        {
            return $this->redirect(["site/view"]);
        }
        return $this->render("update", ["model" => $model, "msg" => $msg]);
    }



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
                Yii::$app->session->setFlash('success', 'Thank you for contacting us. We will respond to you as soon as possible.');
            } else {
                Yii::$app->session->setFlash('error', 'There was an error sending your message.');
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
                Yii::$app->session->setFlash('success', 'Check your email for further instructions.');

                return $this->goHome();
            } else {
                Yii::$app->session->setFlash('error', 'Sorry, we are unable to reset password for the provided email address.');
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
            Yii::$app->session->setFlash('success', 'New password saved.');

            return $this->goHome();
        }

        return $this->render('resetPassword', [
            'model' => $model,
        ]);
    }
}
