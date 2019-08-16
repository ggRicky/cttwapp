<?php

namespace frontend\controllers;

use Yii;
use app\models\ClientType;
use app\models\ClientTypeSearch;
use yii\db\Exception;
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
                'class' => VerbFilter::class,
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
        if (\Yii::$app->user->can('listClientType')) {
            // 2018-10-30 : Records the access to Client Type module.
            Yii::info('[The user get access to the Client Type Module]', 'cttwapp_user');

            $searchModel = new ClientTypeSearch();
            $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

            return $this->render('index_client_type', [
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
                'qryParams' => Yii::$app->request->queryParams,   // 2018-04-11 : This parameter is send to index_client_type.php view for test if 'ClientTypeSearch'
            ]);
        }
        else {
            // 2018-07-26 : If the user is a guest, then he sends an error message. Otherwise it sends a warning message.
            if (Yii::$app->user->getIsGuest()) {
                Yii::$app->session->setFlash('error', Yii::t('app', 'Usted esta tratando de ingresar al sistema de forma no autorizada. Por favor, primero autentifique su acceso.'));
                Yii::error('[Access denied to the Client Type Module]', 'cttwapp_user');
            }
            else {
                Yii::$app->session->setFlash('warning', Yii::t('app', 'Su perfil de acceso no le autoriza a utilizar esta acción. Por favor contacte al administrador del sistema para mayores detalles.'));
                Yii::warning('[Unauthorized access profile to the Client Type Module]', 'cttwapp_user');
            }
        }
        return $this->redirect(['site/index', 'hash' => '0']);
    }

    /**
     * Displays a single ClientType model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id, $page)
    {
        if (\Yii::$app->user->can('viewClientType')) {
            // 2018-10-30 : Records the client type view operation.
            Yii::info('[The user has consulted the client type record with ID='.$id.']', 'cttwapp_user');
            return $this->render('view_client_type', ['model' => $this->findModel($id),]);
        }
        else {
            // 2018-07-26 : If the user is a guest, then he sends an error message. Otherwise it sends a warning message.
            if (Yii::$app->user->getIsGuest()) {
                Yii::$app->session->setFlash('error', Yii::t('app', 'Usted esta tratando de ingresar al sistema de forma no autorizada. Por favor, primero autentifique su acceso.'));
                Yii::error('[Access denied to view a client type record]', 'cttwapp_user');
                return $this->redirect(['site/index', 'hash' => '0']);
            }
            Yii::$app->session->setFlash('warning', Yii::t('app', 'Su perfil de acceso no le autoriza a utilizar esta acción. Por favor contacte al administrador del sistema para mayores detalles.'));
            Yii::warning('[Unauthorized access profile to view a client type record]', 'cttwapp_user');
        }
        return $this->redirect(['client-type/index', 'page' => $page, 'hash' => '0']);
    }

    /**
     * Creates a new ClientType model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @param integer $page
     * @return mixed
     */
    public function actionCreate($page)
    {
        if (\Yii::$app->user->can('createClientType')) {

            $model = new ClientType();

            if ($model->load(Yii::$app->request->post())) {
                if ($model->save()) {
                    // 2018-10-30 : Records the client type create operation.
                    Yii::info('[The user has created the client type record with ID='.$model->id.']', 'cttwapp_user');
                    Yii::$app->session->setFlash('success', Yii::t('app', 'El registro se ha creado exitosamente.'));
                    return $this->redirect(['view', 'id' => $model->id, 'page' => $page]);
                }
                // 2018-05-07 : An error occurred in the data capture. A flash message is issued.
                Yii::$app->session->setFlash('warning', Yii::t('app', 'Por favor atienda las siguientes consideraciones antes de proceder a registrar la información.'));
                return $this->render('create_client_type', ['model' => $model, 'page' => $page ]);
            }

            Yii::info('[The user gets access to create a new client type record]', 'cttwapp_user');
            return $this->render('create_client_type', ['model' => $model, 'page' => $page]);
        }
        else {
            // 2018-07-27 : If the user is a guest, then he sends an error message. Otherwise it sends a warning message.
            if (Yii::$app->user->getIsGuest()) {
                Yii::$app->session->setFlash('error', Yii::t('app', 'Usted esta tratando de ingresar al sistema de forma no autorizada. Por favor, primero autentifique su acceso.'));
                Yii::error('[Access denied to create a client type record]', 'cttwapp_user');
                return $this->redirect(['site/index', 'hash' => '0']);
            }
            Yii::$app->session->setFlash('warning', Yii::t('app', 'Su perfil de acceso no le autoriza a utilizar esta acción. Por favor contacte al administrador del sistema para mayores detalles.'));
            Yii::warning('[Unauthorized access profile to create a client type record]', 'cttwapp_user');
            return $this->redirect(['client-type/index', 'page' => $page, 'hash' => '0']);
        }
    }

    /**
     * Updates an existing ClientType model.
     * If update is successful, the browser will be redirected to the 'index' view and positioned at the current GridView page.
     * @param integer $id
     * @param integer $page
     * @return mixed
     */
    public function actionUpdate($id, $page)
    {
        if (\Yii::$app->user->can('updateClientType')) {

            $model = $this->findModel($id);

            if ($model->load(Yii::$app->request->post())) {

                // 2019-03-05 : Try to catch any DBMS constraint violation
                try{
                    if ($model->update() !== false) {
                        // 2018-10-30 : Records the brand update operation.
                        Yii::info('[The user has updated the client type record with ID='.$model->id.']', 'cttwapp_user');
                        Yii::$app->session->setFlash('success', Yii::t('app', 'El registro se ha actualizado exitosamente.'));
                        return $this->redirect(['view', 'id' => $model->id, 'page' => $page]);
                    }
                    else{
                        // 2018-05-07 : An error occurred in the data capture. A flash message is issued.
                        Yii::$app->session->setFlash('warning', Yii::t('app', 'Por favor atienda las siguientes consideraciones antes de proceder a registrar la información.'));
                        return $this->render('update_client_type', ['model' => $model, 'page' => $page]);
                    }
                }catch (Exception $e) {
                    // 2019-03-06 : The next statement is used to display the current error reported by SQLSTATUS : nl2br($e->errorInfo[0].' '.$e->errorInfo[2])
                    // The error info provided by a PDO exception. This is the same as returned by PDO::errorInfo.
                    switch ($e->errorInfo[0]){
                        case '23503' :
                             Yii::info('[SQLState: 23503 - Foreign key violation at the client type record with ID='.$id.']', 'cttwapp_user');
                             Yii::$app->session->setFlash('error',  Yii::t('app', 'Es imposible ejecutar la acción de Actualizar o Eliminar sobre este registro, debido a una violación de llave foránea. Este registro forma parte de una referencia en otra entidad.'));
                             break;
                        case '42501' :
                             Yii::info('[SQLState: 42501 - Insufficient privileges at the client type table]', 'cttwapp_user');
                             Yii::$app->session->setFlash('error',  Yii::t('app', 'Es imposible ejecutar la acción de Actualizar o Eliminar sobre este registro, debido a no contar con los suficientes privilegios.'));
                             break;
                        default :
                             Yii::info('[SQLState: '.$e->errorInfo[0], 'cttwapp_user');
                    }
                    return $this->redirect(['client-type/index', 'page' => $page, 'hash' => '0']);
                }
            }

            Yii::info('[The user gets access to update a client type record]', 'cttwapp_user');
            return $this->render('update_client_type', ['model' => $model, 'page' => $page]);
        }
        else {
            // 2018-07-27 : If the user is a guest, then he sends an error message. Otherwise it sends a warning message.
            if (Yii::$app->user->getIsGuest()) {
                Yii::$app->session->setFlash('error', Yii::t('app', 'Usted esta tratando de ingresar al sistema de forma no autorizada. Por favor, primero autentifique su acceso.'));
                Yii::error('[Access denied to update a client type record]', 'cttwapp_user');
                return $this->redirect(['site/index', 'hash' => '0']);
            }
            Yii::$app->session->setFlash('warning', Yii::t('app', 'Su perfil de acceso no le autoriza a utilizar esta acción. Por favor contacte al administrador del sistema para mayores detalles.'));
            Yii::warning('[Unauthorized access profile to update a client type record]', 'cttwapp_user');
            return $this->redirect(['client-type/index', 'page' => $page, 'hash' => '0']);
        }
    }

    /**
     * Deletes an existing ClientType model.
     * If deletion is successful, the browser will be redirected to the 'index' view and positioned at the current GridView page.
     * @param integer $id
     * @param integer $page
     * @return mixed
     */
    public function actionDelete($id, $page)
    {
        if (\Yii::$app->user->can('deleteClientType')) {
            // 2019-03-05 : Try to catch any DBMS constraint violation
            try{
                if ($this->findModel($id)->delete()){
                    // 2018-10-30 : Records the brand delete operation.
                    Yii::info('[The user has deleted the client type record with ID='.$id.']', 'cttwapp_user');
                    Yii::$app->session->setFlash('success', Yii::t('app', 'El registro se ha eliminado exitosamente.'));
                }
            }catch (Exception $e) {
                // 2019-03-06 : The next statement is used to display the current error reported by SQLSTATUS : nl2br($e->errorInfo[0].' '.$e->errorInfo[2])
                // The error info provided by a PDO exception. This is the same as returned by PDO::errorInfo.
                switch ($e->errorInfo[0]){
                    case '23503' :
                        Yii::info('[SQLState: 23503 - Foreign key violation at the client type record with ID='.$id.']', 'cttwapp_user');
                        Yii::$app->session->setFlash('error',  Yii::t('app', 'Es imposible ejecutar la acción de Actualizar o Eliminar sobre este registro, debido a una violación de llave foránea. Este registro forma parte de una referencia en otra entidad.'));
                        break;
                    case '42501' :
                        Yii::info('[SQLState: 42501 - Insufficient privileges at the client type table]', 'cttwapp_user');
                        Yii::$app->session->setFlash('error',  Yii::t('app', 'Es imposible ejecutar la acción de Actualizar o Eliminar sobre este registro, debido a no contar con los suficientes privilegios.'));
                        break;
                    default :
                        Yii::info('[SQLState: '.$e->errorInfo[0], 'cttwapp_user');
                }
            }
        }
        else {
            // 2018-07-27 : If the user is a guest, then he sends an error message. Otherwise it sends a warning message.
            if (Yii::$app->user->getIsGuest()) {
                Yii::$app->session->setFlash('error', Yii::t('app', 'Usted esta tratando de ingresar al sistema de forma no autorizada. Por favor, primero autentifique su acceso.'));
                Yii::error('[Access denied to delete a Client Type]', 'cttwapp_user');
                return $this->redirect(['site/index', 'hash' => '0']);
            }
            Yii::$app->session->setFlash('warning', Yii::t('app', 'Su perfil de acceso no le autoriza a utilizar esta acción. Por favor contacte al administrador del sistema para mayores detalles.'));
            Yii::warning('[Unauthorized access profile to delete a Client Type]', 'cttwapp_user');
        }
        return $this->redirect(['client-type/index', 'page' => $page, 'hash' => '0']);
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
