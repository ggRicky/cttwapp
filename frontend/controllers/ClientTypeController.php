<?php

namespace frontend\controllers;

use Yii;
use app\models\ClientType;
use app\models\ClientTypeSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * ClientTypeController implements the CRUD actions for ClientType model.
 */
class ClientTypeController extends Controller
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
     * Lists all ClientType models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ClientTypeSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index_client_type', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'qryParams' => Yii::$app->request->queryParams,   // 2018-04-11 : This parameter is send to index_client_type.php view for test if 'ClientTypeSearch'
        ]);
    }

    /**
     * Displays a single ClientType model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        if (\Yii::$app->user->can('viewClientType')) {
            return $this->render('view_client_type', [
                'model' => $this->findModel($id),
            ]);
        }
        else {
            Yii::$app->session->setFlash('error', Yii::t('app', 'Su perfil de acceso no le autoriza a utilizar esta acción. Por favor contacte al administrador del sistema para mayores detalles.'));
        }

        return $this->redirect(['client-type/index', '#' => 'work-area-index']);
    }

    /**
     * Creates a new ClientType model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        if (\Yii::$app->user->can('createClientType')) {

            $model = new ClientType();

            if ($model->load(Yii::$app->request->post())) {
                if ($model->save()) {
                    return $this->redirect(['view', 'id' => $model->id]);
                }
                // 2018-05-07 : An error occurred in the data capture. A flash message is issued.

                Yii::$app->session->setFlash('error', Yii::t('app', 'Por favor atienda las siguientes consideraciones antes de proceder a registrar la información.'));
                return $this->render('create_client_type', [
                    'model' => $model,
                ]);
            }

            return $this->render('create_client_type', [
                'model' => $model,
            ]);
        }
        else {
            Yii::$app->session->setFlash('error', Yii::t('app', 'Su perfil de acceso no le autoriza a utilizar esta acción. Por favor contacte al administrador del sistema para mayores detalles.'));
            return $this->redirect(['client-type/index', '#' => 'work-area-index']);
        }
    }

    /**
     * Updates an existing ClientType model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        if (\Yii::$app->user->can('updateClientType')) {
            $model = $this->findModel($id);

            if ($model->load(Yii::$app->request->post()) && $model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            } else {
                return $this->render('update_client_type', [
                    'model' => $model,
                ]);
            }
        }
        else {
            Yii::$app->session->setFlash('error', Yii::t('app', 'Su perfil de acceso no le autoriza a utilizar esta acción. Por favor contacte al administrador del sistema para mayores detalles.'));
        }

        return $this->redirect(['client-type/index', '#' => 'work-area-index']);
    }

    /**
     * Deletes an existing ClientType model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        if (\Yii::$app->user->can('deleteClient')) {
            if ($this->findModel($id)->delete()){
                Yii::$app->session->setFlash('success', Yii::t('app', 'El registro se ha eliminado del sistema exitosamente.'));
            }
        }
        else {
            Yii::$app->session->setFlash('error', Yii::t('app', 'Su perfil de acceso no le autoriza a utilizar esta acción. Por favor contacte al administrador del sistema para mayores detalles.'));
        }
        return $this->redirect(['client-type/index', '#' => 'work-area-index']);
    }

    /**
     * Finds the ClientType model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return ClientType the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = ClientType::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException( Yii::t('app','La página solicitada no existe.'));
        }
    }
}
