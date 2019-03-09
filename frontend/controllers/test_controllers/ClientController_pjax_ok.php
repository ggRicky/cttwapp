<?php

namespace frontend\controllers;

use Yii;
use app\models\Client;
use app\models\ClientSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * ClientController implements the CRUD actions for Client model.
 */
class ClientController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Client models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ClientSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index_client', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'qryParams' => Yii::$app->request->queryParams,   // 2018-04-11 : This parameter is send to index_client.php view for test if 'ClientSearch'
        ]);
    }

    /**
     * Displays a single Client model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        if (\Yii::$app->user->can('viewClient')) {
            return $this->render('view_client', [
                'model' => $this->findModel($id),
            ]);
        }
        else {
            Yii::$app->session->setFlash('error', Yii::t('app', 'Su perfil de acceso no le autoriza a utilizar esta acción. Por favor contacte al administrador del sistema para mayores detalles.'));
        }
        return $this->redirect(['client/index', '#' => 'work-area-index']);
    }

    /**
     * Creates a new Client model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        if (\Yii::$app->user->can('createClient')) {

            $model = new Client();

            if ($model->load(Yii::$app->request->post())) {
                if ($model->save()) {
                    return $this->redirect(['view', 'id' => $model->id]);
                }
                // 2018-05-07 : An error occurred in the data capture. A flash message is issued.

                Yii::$app->session->setFlash('error', Yii::t('app', 'Por favor atienda las siguientes consideraciones antes de proceder a registrar la información.'));
                return $this->render('create_client', [
                    'model' => $model,
                ]);
            }

            return $this->render('create_client', [
                'model' => $model,
            ]);
        }
        else {
            Yii::$app->session->setFlash('error', Yii::t('app', 'Su perfil de acceso no le autoriza a utilizar esta acción. Por favor contacte al administrador del sistema para mayores detalles.'));
            return $this->redirect(['client/index', '#' => 'work-area-index']);
        }
    }

    /**
     * Updates an existing Client model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        if (\Yii::$app->user->can('updateClient')) {

            $model = $this->findModel($id);

            if ($model->load(Yii::$app->request->post())) {
                if ($model->save()) {
                    return $this->redirect(['view', 'id' => $model->id]);
                }
                // 2018-05-07 : An error occurred in the data capture. A flash message is issued.

                Yii::$app->session->setFlash('error', Yii::t('app', 'Por favor atienda las siguientes consideraciones antes de proceder a registrar la información.'));
                return $this->render('update_client', [
                    'model' => $model,
                ]);
            }

            return $this->render('update_client', [
                'model' => $model,
            ]);
        }
        else {
            Yii::$app->session->setFlash('error', Yii::t('app', 'Su perfil de acceso no le autoriza a utilizar esta acción. Por favor contacte al administrador del sistema para mayores detalles.'));
        }

        return $this->redirect(['client/index', '#' => 'work-area-index']);
    }

    /**
     * Deletes an existing Client model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        if (\Yii::$app->user->can('deleteClient')) {
            if ($this->findModel($id)->delete()){
                Yii::$app->session->setFlash('success', Yii::t('app', 'El registro se ha eliminado exitosamente.'));
            }
        }
        else {
            Yii::$app->session->setFlash('error', Yii::t('app', 'Su perfil de acceso no le autoriza a utilizar esta acción. Por favor contacte al administrador del sistema para mayores detalles.'));
        }

        return $this->redirect(['client/index', '#' => 'work-area-index']);
    }

    /**
     * Finds the Client model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Client the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Client::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException( Yii::t('app','La página solicitada no existe.'));
        }
    }

    /**
     * Stores the client colored status in a cookie.
     *
     * 2018-05-14 22:20 Hrs.
     *
     */

    public function actionColor($color)
    {
        if (isset($color)){ // if color parameter is set.
            // Create and store a new cookie
            $cookie = new \yii\web\Cookie(['name' => 'client-color', 'value' => $color]);
            Yii::$app->getResponse()->getCookies()->add($cookie);
        }
        return $this->redirect(['client/index', '#' => 'work-area-index']);
    }
}