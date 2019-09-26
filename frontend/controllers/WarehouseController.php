<?php

namespace frontend\controllers;

use Yii;
use app\models\Warehouse;
use app\models\WarehouseSearch;
use yii\db\Exception;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * WarehouseController implements the CRUD actions for Warehouse model.
 */
class WarehouseController extends Controller
{
    /**
     * {@inheritdoc}
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
     * Lists all Warehouse models.
     * @return mixed
     */
    public function actionIndex()
    {
        if (\Yii::$app->user->can('listWarehouse')) {
            // 2019-08-04 : Records the access to Warehouse module.
            Yii::info('[The user gets access to the Warehouse Module]', 'cttwapp_user');

            $searchModel = new WarehouseSearch();
            $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

            return $this->render('index_warehouse', [
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
                'qryParams' => Yii::$app->request->queryParams,   // 2019-08-04 : This parameter is send to index_warehouse.php view for test if 'WarehouseSearch'
            ]);
        } else {
            // 2019-08-04 : If the user is a guest, then sends an error message to him. Otherwise it sends a warning message.
            if (Yii::$app->user->getIsGuest()) {
                Yii::$app->session->setFlash('error', Yii::t('app', 'Usted esta tratando de ingresar al sistema de forma no autorizada. Por favor, primero autentifique su acceso').'.');
                Yii::error('[Access denied to the Warehouse Module]', 'cttwapp_user');
            } else {
                Yii::$app->session->setFlash('warning', Yii::t('app', 'Su perfil de acceso no le autoriza a utilizar esta acción. Por favor contacte al administrador del sistema para mayores detalles').'.');
                Yii::warning('[Unauthorized access profile to the Warehouse Module]', 'cttwapp_user');
            }
        }
        return $this->redirect(['site/index', 'hash' => '0']);
    }

    /**
     * Displays a single Warehouse model.
     * @param string $id
     * @param string $page
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id, $page)
    {
        if (\Yii::$app->user->can('viewWarehouse')) {
            // 2019-08-04 : Records the warehouse view operation.
            Yii::info('[The user has consulted the warehouse record with ID=' . $id . ']', 'cttwapp_user');
            return $this->render('view_warehouse', ['model' => $this->findModel($id),]);
        } else {
            // 2019-08-04 : If the user is a guest, then sends an error message to him. Otherwise it sends a warning message.
            if (Yii::$app->user->getIsGuest()) {
                Yii::$app->session->setFlash('error', Yii::t('app', 'Usted esta tratando de ingresar al sistema de forma no autorizada. Por favor, primero autentifique su acceso').'.');
                Yii::error('[Access denied to view an warehouse record]', 'cttwapp_user');
                return $this->redirect(['site/index', 'hash' => '0']);
            }
            Yii::$app->session->setFlash('warning', Yii::t('app', 'Su perfil de acceso no le autoriza a utilizar esta acción. Por favor contacte al administrador del sistema para mayores detalles').'.');
            Yii::warning('[Unauthorized access profile to view an warehouse record]', 'cttwapp_user');
        }
        return $this->redirect(['warehouse/index', 'page' => $page, 'hash' => '0']);
    }

    /**
     * Creates a new Warehouse model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @param integer $page
     * @return mixed
     */
    public function actionCreate($page)
    {
        if (\Yii::$app->user->can('createWarehouse')) {

            $model = new Warehouse();

            if ($model->load(Yii::$app->request->post())) {
                if ($model->save()) {
                    // 2019-08-04 : Records the warehouse create operation.
                    Yii::info('[The user has created a new warehouse record with ID=' . $model->id . ']', 'cttwapp_user');
                    Yii::$app->session->setFlash('success', Yii::t('app', 'El registro se ha creado exitosamente').'.');
                    return $this->redirect(['view', 'id' => $model->id, 'page' => $page]);
                }
                // 2019-08-04 : An error occurred in the data capture process. A flash message is issued.

                Yii::$app->session->setFlash('warning', Yii::t('app', 'Por favor atienda las siguientes consideraciones antes de proceder a registrar la información').'.');
                return $this->render('create_warehouse', ['model' => $model, 'page' => $page]);
            }

            Yii::info('[The user gets access to create a new warehouse record]', 'cttwapp_user');
            // Render the page to create an article.
            return $this->render('create_warehouse', ['model' => $model, 'page' => $page]);
        } else {
            // 2019-08-04 : If the user is a guest, then sends an error message to him. Otherwise it sends a warning message.
            if (Yii::$app->user->getIsGuest()) {
                Yii::$app->session->setFlash('error', Yii::t('app', 'Usted esta tratando de ingresar al sistema de forma no autorizada. Por favor, primero autentifique su acceso').'.');
                Yii::error('[Access denied to create an warehouse record]', 'cttwapp_user');
                return $this->redirect(['site/index', 'hash' => '0']);
            }
            Yii::$app->session->setFlash('warning', Yii::t('app', 'Su perfil de acceso no le autoriza a utilizar esta acción. Por favor contacte al administrador del sistema para mayores detalles').'.');
            Yii::warning('[Unauthorized access profile to create an warehouse record]', 'cttwapp_user');
            return $this->redirect(['warehouse/index', 'page' => $page, 'hash' => '0']);
        }
    }

    /**
     * Updates an existing Warehouse model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @param integer $page
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id, $page)
    {
        if (\Yii::$app->user->can('updateWarehouse')) {

            $model = $this->findModel($id);

            if ($model->load(Yii::$app->request->post())) {
                // 2019-08-04 : Try to catch any DBMS constraint violation
                try{
                    if ($model->update() !== false) {
                        // 2019-08-04 : Records the warehouse update operation.
                        Yii::info('[The user has updated the warehouse record with ID='.$model->id.']', 'cttwapp_user');
                        Yii::$app->session->setFlash('success', Yii::t('app', 'El registro se ha actualizado exitosamente').'.');
                        return $this->redirect(['view', 'id' => $model->id, 'page' => $page]);
                    }
                    else{
                        // 2019-08-04 : An error occurred in the data capture. A flash message is issued.
                        Yii::$app->session->setFlash('warning', Yii::t('app', 'Por favor atienda las siguientes consideraciones antes de proceder a registrar la información').'.');
                        return $this->render('update_warehouse', ['model' => $model, 'page' => $page]);
                    }
                }catch (Exception $e) {
                    // 2019-08-04 : The next statement is used to display the current error reported by SQLSTATUS : nl2br($e->errorInfo[0].' '.$e->errorInfo[2])
                    // The error info provided by a PDO exception. This is the same as returned by PDO::errorInfo.
                    switch ($e->errorInfo[0]){
                        case '23503' :
                            Yii::info('[SQLState: 23503 - Foreign key violation at the warehouse record with ID='.$id.']', 'cttwapp_user');
                            Yii::$app->session->setFlash('error',  Yii::t('app', 'Es imposible ejecutar la acción de Actualizar o Eliminar sobre este registro, debido a una violación de llave foránea. Este registro forma parte de una referencia en otra entidad').'.');
                            break;
                        case '42501' :
                            Yii::info('[SQLState: 42501 - Insufficient privileges at the warehouse table]', 'cttwapp_user');
                            Yii::$app->session->setFlash('error',  Yii::t('app', 'Es imposible ejecutar la acción de Actualizar o Eliminar sobre este registro, debido a no contar con los suficientes privilegios').'.');
                            break;
                        default :
                            Yii::info('[SQLState: '.$e->errorInfo[0], 'cttwapp_user');
                    }
                    return $this->redirect(['warehouse/index', 'page' => $page, 'hash' => '0']);
                }
            }

            Yii::info('[The user gets access to update a warehouse record]', 'cttwapp_user');
            return $this->render('update_warehouse', ['model' => $model, 'page' => $page]);
        }
        else {
            if (Yii::$app->user->getIsGuest()) {
                Yii::$app->session->setFlash('error', Yii::t('app', 'Usted esta tratando de ingresar al sistema de forma no autorizada. Por favor, primero autentifique su acceso').'.');
                Yii::error('[Access denied to update a warehouse record]', 'cttwapp_user');
                return $this->redirect(['site/index', 'hash' => '0']);
            }
            // 2019-08-04 : If the user is a guest, then sends an error message to him. Otherwise it sends a warning message.
            Yii::warning('[Unauthorized access profile to update a warehouse record]', 'cttwapp_user');
            return $this->redirect(['warehouse/index', 'page' => $page, 'hash' => '0']);
            Yii::$app->session->setFlash('warning', Yii::t('app', 'Su perfil de acceso no le autoriza a utilizar esta acción. Por favor contacte al administrador del sistema para mayores detalles').'.');
        }
    }

    /**
     * Deletes an existing Warehouse model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @param integer $page
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id, $page)
    {
        if (\Yii::$app->user->can('deleteWarehouse')) {
            // 2019-08-04 : Try to catch any DBMS constraint violation
            try{
                if ($this->findModel($id)->delete()){
                    // 2019-08-04 : Records the warehouse delete operation.
                    Yii::info('[The user has deleted the warehouse record with ID='.$id.']', 'cttwapp_user');
                    Yii::$app->session->setFlash('success', Yii::t('app', 'El registro se ha eliminado exitosamente').'.');
                }
            }catch (Exception $e) {
                // 2019-08-04 : The next statement is used to display the current error reported by SQLSTATUS : nl2br($e->errorInfo[0].' '.$e->errorInfo[2])
                // The error info provided by a PDO exception. This is the same as returned by PDO::errorInfo.
                switch ($e->errorInfo[0]){
                    case '23503' :
                         Yii::info('[SQLState: 23503 - Foreign key violation at the warehouse record with ID='.$id.']', 'cttwapp_user');
                         Yii::$app->session->setFlash('error',  Yii::t('app', 'Es imposible ejecutar la acción de Actualizar o Eliminar sobre este registro, debido a una violación de llave foránea. Este registro forma parte de una referencia en otra entidad').'.');
                         break;
                    case '42501' :
                         Yii::info('[SQLState: 42501 - Insufficient privileges at the warehouse table]', 'cttwapp_user');
                         Yii::$app->session->setFlash('error',  Yii::t('app', 'Es imposible ejecutar la acción de Actualizar o Eliminar sobre este registro, debido a no contar con los suficientes privilegios').'.');
                         break;
                    default :
                         Yii::info('[SQLState: '.$e->errorInfo[0], 'cttwapp_user');
                }
            }
        }
        else {
            // 2019-08-04 : If the user is a guest, then sends an error message to him. Otherwise it sends a warning message.
            if (Yii::$app->user->getIsGuest()) {
                Yii::$app->session->setFlash('error', Yii::t('app', 'Usted esta tratando de ingresar al sistema de forma no autorizada. Por favor, primero autentifique su acceso').'.');
                Yii::error('[Access denied to delete a Warehouse]', 'cttwapp_user');
                return $this->redirect(['site/index', 'hash' => '0']);
            }
            Yii::$app->session->setFlash('warning', Yii::t('app', 'Su perfil de acceso no le autoriza a utilizar esta acción. Por favor contacte al administrador del sistema para mayores detalles').'.');
            Yii::warning('[Unauthorized access profile to delete a Warehouse]', 'cttwapp_user');
        }
        return $this->redirect(['warehouse/index', 'page' => $page, 'hash' => '0']);
    }

    /**
     * Finds the Warehouse model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return Warehouse the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Warehouse::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'La página solicitada no existe').'.');
    }
}
