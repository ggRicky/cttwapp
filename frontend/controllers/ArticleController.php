<?php

namespace frontend\controllers;

use Yii;
use app\models\Article;
use app\models\ArticleSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * ArticleController implements the CRUD actions for Article model.
 */
class ArticleController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Article models.
     * @return mixed
     */
    public function actionIndex()
    {
        if (\Yii::$app->user->can('listArticle')) {
            $searchModel = new ArticleSearch();
            $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

            return $this->render('index_article', [
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
                'qryParams' => Yii::$app->request->queryParams,   // 2018-05-06 : This parameter is send to index_article.php view for test if 'ArticleSearch'
            ]);
        }
        else {
            // 2018-07-26 : If the user is a guest, then he sends an error message. Otherwise it sends a warning message.
            if (Yii::$app->user->getIsGuest())
                Yii::$app->session->setFlash('error', Yii::t('app', 'Usted esta tratando de ingresar al sistema de forma no autorizada. Por favor, primero autentifique su acceso.'));
            else
                Yii::$app->session->setFlash('warning', Yii::t('app', 'Su perfil de acceso no le autoriza a utilizar esta acción. Por favor contacte al administrador del sistema para mayores detalles.'));
        }
        return $this->redirect(['site/index', 'hash' => '0']);
    }

    /**
     * Displays a single Article model.
     * @param string $id
     * @param string $page
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id, $page)
    {
        if (\Yii::$app->user->can('viewArticle')) {
            return $this->render('view_article', ['model' => $this->findModel($id),]);
        }
        else {
            // 2018-07-26 : If the user is a guest, then he sends an error message. Otherwise it sends a warning message.
            if (Yii::$app->user->getIsGuest()) {
                Yii::$app->session->setFlash('error', Yii::t('app', 'Usted esta tratando de ingresar al sistema de forma no autorizada. Por favor, primero autentifique su acceso.'));
                return $this->redirect(['site/index', 'hash' => '0']);
            }
            Yii::$app->session->setFlash('warning', Yii::t('app', 'Su perfil de acceso no le autoriza a utilizar esta acción. Por favor contacte al administrador del sistema para mayores detalles.'));
        }
        return $this->redirect(['article/index', 'page' => $page, 'hash' => '0']);
    }

    /**
     * Creates a new Article model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @param integer $page
     * @return mixed
     */
    public function actionCreate($page)
    {
        if (\Yii::$app->user->can('createArticle')) {

            $model = new Article();

            if ($model->load(Yii::$app->request->post())) {
                if ($model->save()) {
                    return $this->redirect(['view', 'id' => $model->id, 'page' => $page]);
                }
                // 2018-05-07 : An error occurred in the data capture process. A flash message is issued.

                Yii::$app->session->setFlash('warning', Yii::t('app', 'Por favor atienda las siguientes consideraciones antes de proceder a registrar la información.'));
                return $this->render('create_article', ['model' => $model, 'page' => $page]);
            }

            return $this->render('create_article', ['model' => $model, 'page' => $page]);
        }
        else {
            // 2018-07-27 : If the user is a guest, then he sends an error message. Otherwise it sends a warning message.
            if (Yii::$app->user->getIsGuest()) {
                Yii::$app->session->setFlash('error', Yii::t('app', 'Usted esta tratando de ingresar al sistema de forma no autorizada. Por favor, primero autentifique su acceso.'));
                return $this->redirect(['site/index', 'hash' => '0']);
            }
            Yii::$app->session->setFlash('warning', Yii::t('app', 'Su perfil de acceso no le autoriza a utilizar esta acción. Por favor contacte al administrador del sistema para mayores detalles.'));
            return $this->redirect(['article/index', 'page' => $page, 'hash' => '0']);
        }
    }

    /**
     * Updates an existing Article model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @param integer $page
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id, $page)
    {
        if (\Yii::$app->user->can('updateArticle')) {

            $model = $this->findModel($id);

            if ($model->load(Yii::$app->request->post())) {
                if ($model->save()) {
                    return $this->redirect(['view', 'id' => $model->id, 'page' => $page]);
                }
                // 2018-05-07 : An error occurred in the data capture. A flash message is issued.

                Yii::$app->session->setFlash('warning', Yii::t('app', 'Por favor atienda las siguientes consideraciones antes de proceder a registrar la información.'));
                return $this->render('update_article', ['model' => $model, 'page' => $page]);
            }

            return $this->render('update_article', ['model' => $model, 'page' => $page]);
        }
        else {
            // 2018-07-27 : If the user is a guest, then he sends an error message. Otherwise it sends a warning message.
            if (Yii::$app->user->getIsGuest()) {
                Yii::$app->session->setFlash('error', Yii::t('app', 'Usted esta tratando de ingresar al sistema de forma no autorizada. Por favor, primero autentifique su acceso.'));
                return $this->redirect(['site/index', 'hash' => '0']);
            }
            Yii::$app->session->setFlash('warning', Yii::t('app', 'Su perfil de acceso no le autoriza a utilizar esta acción. Por favor contacte al administrador del sistema para mayores detalles.'));
            return $this->redirect(['article/index', 'page' => $page, 'hash' => '0']);
        }
    }

    /**
     * Deletes an existing Article model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id, $page)
    {
        if (\Yii::$app->user->can('deleteArticle')) {
            if ($this->findModel($id)->delete()){
                Yii::$app->session->setFlash('success', Yii::t('app', 'El registro se ha eliminado del sistema exitosamente.'));
            }
        }
        else {
            // 2018-07-27 : If the user is a guest, then he sends an error message. Otherwise it sends a warning message.
            if (Yii::$app->user->getIsGuest()) {
                Yii::$app->session->setFlash('error', Yii::t('app', 'Usted esta tratando de ingresar al sistema de forma no autorizada. Por favor, primero autentifique su acceso.'));
                return $this->redirect(['site/index', 'hash' => '0']);
            }
            Yii::$app->session->setFlash('warning', Yii::t('app', 'Su perfil de acceso no le autoriza a utilizar esta acción. Por favor contacte al administrador del sistema para mayores detalles.'));
        }
        return $this->redirect(['article/index', 'page' => $page, 'hash' => '0']);
    }

    /**
     * Finds the Article model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return Article the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Article::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException( Yii::t('app','La página solicitada no existe.'));
        }
    }

    /**
     * Stores the article colored status in a cookie.
     *
     * 2018-05-14 22:31 Hrs.
     *
     */

    public function actionColor($color)
    {
        if (isset($color)){ // if color parameter is set.
            // Create and store a new cookie
            $cookie = new \yii\web\Cookie(['name' => 'article-color', 'value' => $color]);
            Yii::$app->getResponse()->getCookies()->add($cookie);
        }
        return $this->redirect(['article/index', 'page' => '1', 'hash' => '0']);
    }
}