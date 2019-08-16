<?php

namespace frontend\controllers;

use Yii;
use app\models\Catalog;
use app\models\CatalogSearch;
use yii\db\Exception;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * CatalogController implements the CRUD actions for Catalog model.
 */
class CatalogController extends Controller
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
     * Lists all Catalog models.
     * @return mixed
     */
    public function actionIndex()
    {
        if (\Yii::$app->user->can('listCatalog')) {
            // 2018-10-30 : Records the access to Catalog module.
            Yii::info('[The user get access to the Catalog Module]', 'cttwapp_user');

            $searchModel = new CatalogSearch();
            $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

            return $this->render('index_catalog', [
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
                'qryParams' => Yii::$app->request->queryParams,   // 2018-05-06 : This parameter is send to index_catalog.php view for test if 'CatalogSearch'
            ]);
        }
        else {
            // 2018-07-26 : If the user is a guest, then he sends an error message. Otherwise it sends a warning message.
            if (Yii::$app->user->getIsGuest()){
                Yii::$app->session->setFlash('error', Yii::t('app', 'Usted esta tratando de ingresar al sistema de forma no autorizada. Por favor, primero autentifique su acceso.'));
                Yii::error('[Access denied to the Catalog Module]', 'cttwapp_user');
            }
            else {
                Yii::$app->session->setFlash('warning', Yii::t('app', 'Su perfil de acceso no le autoriza a utilizar esta acción. Por favor contacte al administrador del sistema para mayores detalles.'));
                Yii::warning('[Unauthorized access profile to the Catalog Module]', 'cttwapp_user');
            }
        }
        return $this->redirect(['site/index', 'hash' => '0']);
    }

    /**
     * Displays a single Catalog model.
     * @param string $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id, $page)
    {
        if (\Yii::$app->user->can('viewCatalog')) {
            // 2018-10-30 : Records the catalog view operation.
            Yii::info('[The user has consulted the catalog record with ID='.$id.']', 'cttwapp_user');
            return $this->render('view_catalog', ['model' => $this->findModel($id),]);
        }
        else {
            // 2018-07-26 : If the user is a guest, then he sends an error message. Otherwise it sends a warning message.
            if (Yii::$app->user->getIsGuest()) {
                Yii::$app->session->setFlash('error', Yii::t('app', 'Usted esta tratando de ingresar al sistema de forma no autorizada. Por favor, primero autentifique su acceso.'));
                Yii::error('[Access denied to view a catalog record]', 'cttwapp_user');
                return $this->redirect(['site/index', 'hash' => '0']);
            }
            Yii::$app->session->setFlash('warning', Yii::t('app', 'Su perfil de acceso no le autoriza a utilizar esta acción. Por favor contacte al administrador del sistema para mayores detalles.'));
            Yii::warning('[Unauthorized access profile to view a catalog record]', 'cttwapp_user');

        }
        return $this->redirect(['catalog/index', 'page' => $page, 'hash' => '0']);
    }

    /**
     * Creates a new Catalog model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @param integer $page
     * @return mixed
     */
    public function actionCreate($page)
    {
        if (\Yii::$app->user->can('createCatalog')) {

            $model = new Catalog();

            if ($model->load(Yii::$app->request->post())) {
                if ($model->save()) {
                    // 2018-10-30 : Records the catalog create operation.
                    Yii::info('[The user has created the catalog record with ID='.$model->id.']', 'cttwapp_user');
                    Yii::$app->session->setFlash('success', Yii::t('app', 'El registro se ha creado exitosamente.'));
                    return $this->redirect(['view', 'id' => $model->id, 'page' => $page]);
                }
                // 2018-05-07 : An error occurred in the data capture process. A flash message is issued.
                Yii::$app->session->setFlash('warning', Yii::t('app', 'Por favor atienda las siguientes consideraciones antes de proceder a registrar la información.'));
                return $this->render('create_catalog', ['model' => $model, 'page' => $page]);
            }

            Yii::info('[The user gets access to create a new catalog record]', 'cttwapp_user');
            return $this->render('create_catalog', ['model' => $model, 'page' => $page]);
        }
        else {
            // 2018-07-27 : If the user is a guest, then he sends an error message. Otherwise it sends a warning message.
            if (Yii::$app->user->getIsGuest()) {
                Yii::$app->session->setFlash('error', Yii::t('app', 'Usted esta tratando de ingresar al sistema de forma no autorizada. Por favor, primero autentifique su acceso.'));
                Yii::error('[Access denied to create a catalog record]', 'cttwapp_user');
                return $this->redirect(['site/index', 'hash' => '0']);
            }
            Yii::$app->session->setFlash('warning', Yii::t('app', 'Su perfil de acceso no le autoriza a utilizar esta acción. Por favor contacte al administrador del sistema para mayores detalles.'));
            Yii::warning('[Unauthorized access profile to create a catalog record]', 'cttwapp_user');
            return $this->redirect(['catalog/index', 'page' => $page, 'hash' => '0']);
        }
    }

    /**
     * Updates an existing Catalog model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @param integer $page
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id, $page)
    {
        if (\Yii::$app->user->can('updateCatalog')) {

            $model = $this->findModel($id);

            if ($model->load(Yii::$app->request->post())) {
                // 2019-03-07 : Try to catch any DBMS constraint violation
                try{
                    if ($model->update() !== false) {
                        // 2018-10-30 : Records the catalog update operation.
                        Yii::info('[The user has updated the catalog record with ID='.$model->id.']', 'cttwapp_user');
                        Yii::$app->session->setFlash('success', Yii::t('app', 'El registro se ha actualizado exitosamente.'));
                        return $this->redirect(['view', 'id' => $model->id, 'page' => $page]);
                    }
                    else{
                        // 2018-05-07 : An error occurred in the data capture. A flash message is issued.
                        Yii::$app->session->setFlash('warning', Yii::t('app', 'Por favor atienda las siguientes consideraciones antes de proceder a registrar la información.'));
                        return $this->render('update_catalog', ['model' => $model, 'page' => $page]);
                    }
                }catch (Exception $e) {
                    // 2019-03-06 : The next statement is used to display the current error reported by SQLSTATUS : nl2br($e->errorInfo[0].' '.$e->errorInfo[2])
                    // The error info provided by a PDO exception. This is the same as returned by PDO::errorInfo.
                    switch ($e->errorInfo[0]){
                        case '23503' :
                            Yii::info('[SQLState: 23503 - Foreign key violation at the catalog record with ID='.$id.']', 'cttwapp_user');
                            Yii::$app->session->setFlash('error',  Yii::t('app', 'Es imposible ejecutar la acción de Actualizar o Eliminar sobre este registro, debido a una violación de llave foránea. Este registro forma parte de una referencia en otra entidad.'));
                            break;
                        case '42501' :
                            Yii::info('[SQLState: 42501 - Insufficient privileges at the catalog table]', 'cttwapp_user');
                            Yii::$app->session->setFlash('error',  Yii::t('app', 'Es imposible ejecutar la acción de Actualizar o Eliminar sobre este registro, debido a no contar con los suficientes privilegios.'));
                            break;
                        default :
                            Yii::info('[SQLState: '.$e->errorInfo[0], 'cttwapp_user');
                    }
                    return $this->redirect(['catalog/index', 'page' => $page, 'hash' => '0']);
                }
            }

            Yii::info('[The user gets access to update a catalog record]', 'cttwapp_user');
            return $this->render('update_catalog', ['model' => $model, 'page' => $page]);
        }
        else {
            // 2018-07-27 : If the user is a guest, then he sends an error message. Otherwise it sends a warning message.
            if (Yii::$app->user->getIsGuest()) {
                Yii::$app->session->setFlash('error', Yii::t('app', 'Usted esta tratando de ingresar al sistema de forma no autorizada. Por favor, primero autentifique su acceso.'));
                Yii::error('[Access denied to update a catalog record]', 'cttwapp_user');
                return $this->redirect(['site/index', 'hash' => '0']);
            }
            Yii::$app->session->setFlash('warning', Yii::t('app', 'Su perfil de acceso no le autoriza a utilizar esta acción. Por favor contacte al administrador del sistema para mayores detalles.'));
            Yii::warning('[Unauthorized access profile to update a catalog record]', 'cttwapp_user');
            return $this->redirect(['catalog/index', 'page' => $page, 'hash' => '0']);
        }
    }

    /**
     * Deletes an existing Catalog model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @param integer $page
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id, $page)
    {
        if (\Yii::$app->user->can('deleteCatalog')) {
            // 2019-03-07 : Try to catch any DBMS constraint violation
            try{
                if ($this->findModel($id)->delete()){
                    // 2018-10-30 : Records the catalog delete operation.
                    Yii::info('[The user has deleted the catalog record with ID='.$id.']', 'cttwapp_user');
                    Yii::$app->session->setFlash('success', Yii::t('app', 'El registro se ha eliminado exitosamente.'));
                }
            }catch (Exception $e) {
                // 2019-03-06 : The next statement is used to display the current error reported by SQLSTATUS : nl2br($e->errorInfo[0].' '.$e->errorInfo[2])
                // The error info provided by a PDO exception. This is the same as returned by PDO::errorInfo.
                switch ($e->errorInfo[0]){
                    case '23503' :
                         Yii::info('[SQLState: 23503 - Foreign key violation in at the catalog record with ID='.$id.']', 'cttwapp_user');
                         Yii::$app->session->setFlash('error',  Yii::t('app', 'Es imposible ejecutar la acción de Actualizar o Eliminar sobre este registro, debido a una violación de llave foránea. Este registro forma parte de una referencia en otra entidad.'));
                         break;
                    case '42501' :
                         Yii::info('[SQLState: 42501 - Insufficient privileges at the catalog table]', 'cttwapp_user');
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
                Yii::error('[Access denied to delete a Catalog]', 'cttwapp_user');
                return $this->redirect(['site/index', 'hash' => '0']);
            }
            Yii::$app->session->setFlash('warning', Yii::t('app', 'Su perfil de acceso no le autoriza a utilizar esta acción. Por favor contacte al administrador del sistema para mayores detalles.'));
            Yii::warning('[Unauthorized access profile to delete a Catalog]', 'cttwapp_user');
        }
        return $this->redirect(['catalog/index', 'page' => $page, 'hash' => '0']);
    }

    /**
     * Finds the Catalog model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return Catalog the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Catalog::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'La página solicitada no existe.'));
    }
}
