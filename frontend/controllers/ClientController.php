<?php

namespace frontend\controllers;

use Yii;
use app\models\Client;
use app\models\ClientSearch;
use yii\db\Exception;
use yii\web\Cookie;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\helpers\Url;
use yii\filters\VerbFilter;
use kartik\mpdf\Pdf;

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
                'class' => VerbFilter::class,
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
        if (\Yii::$app->user->can('listClient')) {

            // 2018-09-30 : Records the access to Client module.
            Yii::info('[The user get access to the Client Module]', 'cttwapp_user');

            $searchModel = new ClientSearch();
            $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

            return $this->render('index_client', [
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
                'qryParams' => Yii::$app->request->queryParams,   // 2018-04-11 : This parameter is send to index_client.php view for test if 'ClientSearch'
            ]);
        }
        else {
            // 2018-07-26 : If the user is a guest, then he sends an error message. Otherwise it sends a warning message.
            if (Yii::$app->user->getIsGuest()) {
                Yii::$app->session->setFlash('error', Yii::t('app', 'Usted esta tratando de ingresar al sistema de forma no autorizada. Por favor, primero autentifique su acceso.'));
                Yii::error('[Access denied to the Client Module]', 'cttwapp_user');
            }
            else {
                Yii::$app->session->setFlash('warning', Yii::t('app', 'Su perfil de acceso no le autoriza a utilizar esta acción. Por favor contacte al administrador del sistema para mayores detalles.'));
                Yii::warning('[Unauthorized access profile to the Client Module]', 'cttwapp_user');
            }
        }
        return $this->redirect(['site/index', 'hash' => '0']);
    }

    /**
     * Displays a single Client model.
     * @param integer $id
     * @param integer $page
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be foun
     */
    public function actionView($id, $page)
    {
        if (\Yii::$app->user->can('viewClient')) {
            // 2018-09-30 : Records the client view operation.
            Yii::info('[The user has consulted the client record with ID='.$id.']', 'cttwapp_user');
            return $this->render('view_client', ['model' => $this->findModel($id),]);
        }
        else {
            // 2018-07-26 : If the user is a guest, then he sends an error message. Otherwise it sends a warning message.
            if (Yii::$app->user->getIsGuest()) {
                Yii::$app->session->setFlash('error', Yii::t('app', 'Usted esta tratando de ingresar al sistema de forma no autorizada. Por favor, primero autentifique su acceso.'));
                Yii::error('[Access denied to view a client record]', 'cttwapp_user');
                return $this->redirect(['site/index', 'hash' => '0']);
            }
            Yii::$app->session->setFlash('warning', Yii::t('app', 'Su perfil de acceso no le autoriza a utilizar esta acción. Por favor contacte al administrador del sistema para mayores detalles.'));
            Yii::warning('[Unauthorized access profile to view a client record]', 'cttwapp_user');
        }
        return $this->redirect(['client/index', 'page' => $page, 'hash' => '0']);
    }

    /**
     * Creates a new Client model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @param integer $page
     * @return mixed
     */
    public function actionCreate($page)
    {
        if (\Yii::$app->user->can('createClient')) {

            $model = new Client();

            if ($model->load(Yii::$app->request->post())) {
                if ($model->save()) {
                    // 2018-09-30 : Records the client create operation.
                    Yii::info('[The user has created the client record with ID='.$model->id.']', 'cttwapp_user');
                    Yii::$app->session->setFlash('success', Yii::t('app', 'El registro se ha creado exitosamente.'));
                    return $this->redirect(['view', 'id' => $model->id, 'page' => $page]);
                }
                // 2018-05-07 : An error occurred in the data capture process. A flash message is issued.

                Yii::$app->session->setFlash('warning', Yii::t('app', 'Por favor atienda las siguientes consideraciones antes de proceder a registrar la información.'));
                return $this->render('create_client', ['model' => $model, 'page' => $page]);
            }

            Yii::info('[The user gets access to create a new client record]', 'cttwapp_user');
            return $this->render('create_client', ['model' => $model, 'page' => $page]);
        }
        else {
            // 2018-07-27 : If the user is a guest, then he sends an error message. Otherwise it sends a warning message.
            if (Yii::$app->user->getIsGuest()) {
                Yii::$app->session->setFlash('error', Yii::t('app', 'Usted esta tratando de ingresar al sistema de forma no autorizada. Por favor, primero autentifique su acceso.'));
                Yii::error('[Access denied to create a client record]', 'cttwapp_user');
                return $this->redirect(['site/index', 'hash' => '0']);
            }
            Yii::$app->session->setFlash('warning', Yii::t('app', 'Su perfil de acceso no le autoriza a utilizar esta acción. Por favor contacte al administrador del sistema para mayores detalles.'));
            Yii::warning('[Unauthorized access profile to create a client record]', 'cttwapp_user');
            return $this->redirect(['client/index', 'page' => $page, 'hash' => '0']);
        }
    }

    /**
     * Updates an existing Client model.
     * If update is successful, the browser will be redirected to the 'index' view and positioned at the current GridView page.
     * @param integer $id
     * @param integer $page
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id, $page)
    {
        if (\Yii::$app->user->can('updateClient')) {

            $model = $this->findModel($id);

            if ($model->load(Yii::$app->request->post())) {
                // 2019-03-05 : Try to catch any DBMS constraint violation
                try{
                    if ($model->update() !== false) {
                        // 2018-10-30 : Records the brand update operation.
                        Yii::info('[The user has updated the cleient record with ID='.$model->id.']', 'cttwapp_user');
                        Yii::$app->session->setFlash('success', Yii::t('app', 'El registro se ha actualizado exitosamente.'));
                        return $this->redirect(['view', 'id' => $model->id, 'page' => $page]);
                    }
                    else{
                        // 2018-05-07 : An error occurred in the data capture. A flash message is issued.
                        Yii::$app->session->setFlash('warning', Yii::t('app', 'Por favor atienda las siguientes consideraciones antes de proceder a registrar la información.'));
                        return $this->render('update_client', ['model' => $model, 'page' => $page]);
                    }
                }catch (Exception $e) {
                    // 2019-03-06 : The next statement is used to display the current error reported by SQLSTATUS : nl2br($e->errorInfo[0].' '.$e->errorInfo[2])
                    // The error info provided by a PDO exception. This is the same as returned by PDO::errorInfo.
                    switch ($e->errorInfo[0]){
                        case '23503' :
                            Yii::$app->session->setFlash('error',  Yii::t('app', 'Es imposible ejecutar la acción de Actualizar o Eliminar sobre este registro, debido a una violación de llave foránea. Este registro forma parte de una referencia en otra entidad.'));

                    }
                    return $this->redirect(['client/index', 'page' => $page, 'hash' => '0']);
                }
            }

            Yii::info('[The user gets access to update a client record]', 'cttwapp_user');
            return $this->render('update_client', ['model' => $model, 'page' => $page]);
        }
        else {
            // 2018-07-27 : If the user is a guest, then he sends an error message. Otherwise it sends a warning message.
            if (Yii::$app->user->getIsGuest()) {
                Yii::$app->session->setFlash('error', Yii::t('app', 'Usted esta tratando de ingresar al sistema de forma no autorizada. Por favor, primero autentifique su acceso.'));
                Yii::error('[Access denied to update a client record]', 'cttwapp_user');
                return $this->redirect(['site/index', 'hash' => '0']);
            }
            Yii::$app->session->setFlash('warning', Yii::t('app', 'Su perfil de acceso no le autoriza a utilizar esta acción. Por favor contacte al administrador del sistema para mayores detalles.'));
            Yii::warning('[Unauthorized access profile to update a client record]', 'cttwapp_user');
            return $this->redirect(['client/index', 'page' => $page, 'hash' => '0']);
        }
    }

    /**
     * Deletes an existing Client model.
     * If deletion is successful, the browser will be redirected to the 'index' view and positioned at the current GridView page.
     * @param integer $id
     * @param integer $page
     * @return mixed
     */
    public function actionDelete($id, $page)
    {
        if (\Yii::$app->user->can('deleteClient')) {
            // 2019-03-05 : Try to catch any DBMS constraint violation
            try{
                if ($this->findModel($id)->delete()){
                    // 2018-10-30 : Records the brand delete operation.
                    Yii::info('[The user has deleted the client record with ID='.$id.']', 'cttwapp_user');
                    Yii::$app->session->setFlash('success', Yii::t('app', 'El registro se ha eliminado exitosamente.'));
                }
            }catch (Exception $e) {
                // 2019-03-06 : The next statement is used to display the current error reported by SQLSTATUS : nl2br($e->errorInfo[0].' '.$e->errorInfo[2])
                // The error info provided by a PDO exception. This is the same as returned by PDO::errorInfo.
                switch ($e->errorInfo[0]){
                    case '23503' :
                        Yii::$app->session->setFlash('error',  Yii::t('app', 'Es imposible ejecutar la acción de Actualizar o Eliminar sobre este registro, debido a una violación de llave foránea. Este registro forma parte de una referencia en otra entidad.'));

                }
            }
        }
        else {
            // 2018-07-27 : If the user is a guest, then he sends an error message. Otherwise it sends a warning message.
            if (Yii::$app->user->getIsGuest()) {
                Yii::$app->session->setFlash('error', Yii::t('app', 'Usted esta tratando de ingresar al sistema de forma no autorizada. Por favor, primero autentifique su acceso.'));
                Yii::error('[Access denied to delete a Client]', 'cttwapp_user');
                return $this->redirect(['site/index', 'hash' => '0']);
            }
            Yii::$app->session->setFlash('warning', Yii::t('app', 'Su perfil de acceso no le autoriza a utilizar esta acción. Por favor contacte al administrador del sistema para mayores detalles.'));
            Yii::warning('[Unauthorized access profile to delete a Client]', 'cttwapp_user');
        }
        return $this->redirect(['client/index', 'page' => $page, 'hash' => '0']);
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
     * Switch and stores the client colored status in a cookie.
     * @param string $color
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     *
     * 2018-05-14 22:20 Hrs.
     *
     */

    public function actionSetColor($color)
    {
        if (isset($color)){ // if color parameter is set.
            // Create and store a new cookie
            $cookie = new \yii\web\Cookie(['name' => 'client-color', 'value' => $color, 'expire' => time() + 86400 * 365,]);
            Yii::$app->getResponse()->getCookies()->add($cookie);
            // Send a message about the current color status.
            Yii::$app->session->setFlash('configProcess', Yii::t('app','La configuración del color ha sido : '.($color==1?'ACTIVADA':'DESACTIVADA')));
        }
        return $this->redirect(['client/index', 'page' => '1', 'hash' => '0']);
    }

    /**
     * Generates a PDF file with the data of an client in printable version.
     * @param string $id
     * @param string $page
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     *
     * 2018-09-30 11:50 Hrs.
     */
    public function actionPrint($id, $page)
    {
        // 2018-09-30 : Only for debug purpose.
        // return $this->render('print_client', ['model' => $this->findModel($id),]);

        if (\Yii::$app->user->can('printClient')) {
            // 2018-08-28 : Records the client delete operation.
            Yii::info('[The user has printed the client record with ID='.$id.']', 'cttwapp_user');

            // Get your HTML raw content without any layouts or scripts
            $content = $this->renderPartial('print_client', ['model' => $this->findModel($id),]);
            $footer = "<hr style=\"color: gainsboro;\"/>\n   <table width=\"100%\" style=\"vertical-align: bottom; font-size: 9px; color: gray;\"><tr>\n   <td width=\"33%\"><span style=\"letter-spacing: 3px;\">CTTwapp ver-1.0</span></td>\n   <td width=\"33%\" align=\"center\" style=\"letter-spacing: 5px;\">".Yii::t('app','Inventarios')."</td>\n   <td width=\"33%\" style=\"text-align: right; letter-spacing: 3px;\">".Yii::t('app', 'Página')." [ {PAGENO} ]</td>\n   </tr></table>";

            // Setup kartik\mpdf\Pdf component
            $pdf = new Pdf([
                // Set to use core fonts only
                'mode' => Pdf::MODE_CORE,
                // LETTER paper format
                'format' => Pdf::FORMAT_LETTER,
                // Portrait orientation
                'orientation' => Pdf::ORIENT_PORTRAIT,
                // Stream to browser inline
                'destination' => Pdf::DEST_BROWSER,
                // File name
                'filename' => 'cttwapp_client_report.pdf',
                // Your html content input
                'content' => $content,
                // Format content from your own css file if needed or use the
                // enhanced bootstrap css built by Krajee for mPDF formatting
                //'cssFile' => '@vendor/kartik-v/yii2-mpdf/assets/kv-mpdf-bootstrap.min.css',
                'cssFile' => '@vendor/bower/cttwapp/css/cttwapp-stylish.css',
                // Any css to be embedded if required
                'cssInline' => '.kv-heading-1{font-size:32px; color: #15598c} .kv-heading-2{font-size:10px; color:red; letter-spacing: 3px}',
                // Call mPDF methods on the fly
                'methods' => [
                    'SetHTMLHeader'=>['<div style="text-align: right; font-size: 9px; font-weight: lighter; color: grey; letter-spacing: 3px">'.'CTT Exp. & Rentals S.A. de C.V.'.'</div>', 'O', true],
                    'SetHTMLFooter'=>$footer,
                ]
            ]);

            // Set mPDF properties on the fly

            // Directly use the mPDF api for various other mPDF manipulations
            // Fetches mPDF API
            $mpdf = $pdf->api;

            // Call methods or set any properties
            $mpdf->SetTitle(Yii::t('app', 'Cliente').' : '.$id);
            $mpdf->SetAuthor('ISC. Ricardo González González');
            $mpdf->SetCreator('CTTwapp v1.0');
            $mpdf->SetSubject('Reporte');
            $mpdf->SetKeywords('cttwapp, report, client, detail, pdf');
            // 2018-09-30 : Enables a water mark text

            $mpdf->showWatermarkText = true;                         // To shows the water mark text.
            $mpdf->watermarkTextAlpha = 0.1;                         // To defines the alpha value for the water mark text.
            $mpdf->watermark_font = 'Source Sans Pro';               // To defines the font type for the water mark text.
            $mpdf->SetWatermarkText(Yii::t('app', 'Confidencial'));  // To defines the legend for the water mark text.

            // 2018-08-11 : Enables a water image
            $mpdf->showWatermarkImage = true;                        // To shows the water mark image.
            $mpdf->watermarkImageAlpha = 0.1;                        // To defines the alpha value for the water mark image.
            $mpdf->defaultfooterline = true;                         // To shows the water mark image.
            $mpdf->SetWatermarkImage(Url::to('/img/ctt-logo.png', true),0.2,'P',[0,-42]);   // To defines the image file for the water mark image.

            // Return the pdf output as per the destination setting
            return $pdf->render();
        }
        else {
            // 2018-08-04 : If the user is a guest, then he sends an error message. Otherwise it sends a warning message.
            if (Yii::$app->user->getIsGuest()) {
                Yii::$app->session->setFlash('error', Yii::t('app', 'Usted esta tratando de ingresar al sistema de forma no autorizada. Por favor, primero autentifique su acceso.'));
                return $this->redirect(['site/index', 'hash' => '0']);
            }
            Yii::$app->session->setFlash('warning', Yii::t('app', 'Su perfil de acceso no le autoriza a utilizar esta acción. Por favor contacte al administrador del sistema para mayores detalles.'));
        }
        return $this->redirect(['client/index', 'page' => $page, 'hash' => '0']);
    }

    /**
     * Sets and stores each client column visibility status in cookies.
     * @param string $client_columns_config
     * @return mixed
     *
     * 2018-09-30 11:57 Hrs.
     */
    public function actionSetColumns($client_columns_config)
    {
        if (isset($client_columns_config)){  // If the parameter for columns config has been set, then ....
            $cookie = new \yii\web\Cookie(['name' => 'client_columns_config', 'value' => $client_columns_config, 'expire' => time() + 86400 * 365,]);   // Creates a new cookie and stores the column visibility status in it.
            Yii::$app->getResponse()->getCookies()->add($cookie);
        }

        // Apply and show the newly generated changes.
        return $this->redirect(['client/index', 'page' => '1', 'hash' => '0']);
    }

    /**
     * Shows the Column-Selector and sets the client columns visibility status.
     * @return mixed
     *
     * 2018-09-30 12:05 Hrs.
     */
    public function actionSelectColumns(){

        // Creates the new dynamic model
        $model_1 = new \yii\base\DynamicModel(['column_0',  'column_1',  'column_2',  'column_3',  'column_4',  'column_5',  'column_6',
                                               'column_7',  'column_8',  'column_9',  'column_10', 'column_11', 'column_12', 'column_13',
                                               'column_14', 'column_15', 'column_16', 'column_17', 'column_18', 'column_19', 'column_20',
                                               'column_21', 'column_22', 'column_23', 'column_24']);
        // Add the rules to the new dynamic model
        $model_1->addRule(['column_0',  'column_1',  'column_2',  'column_3',  'column_4',  'column_5',  'column_6',
                           'column_7',  'column_8',  'column_9',  'column_10', 'column_11', 'column_12', 'column_13',
                           'column_14', 'column_15', 'column_16', 'column_17', 'column_18', 'column_19', 'column_20',
                           'column_21', 'column_22', 'column_23', 'column_24'], 'string', ['max' => 1]);
        // Add the rules to the new dynamic model
        $model_1->addRule(['column_0',  'column_1',  'column_2',  'column_3',  'column_4',  'column_5',  'column_6',
                           'column_7',  'column_8',  'column_9',  'column_10', 'column_11', 'column_12', 'column_13',
                           'column_14', 'column_15', 'column_16', 'column_17', 'column_18', 'column_19', 'column_20',
                           'column_21', 'column_22', 'column_23', 'column_24'], 'required'); // The ->validate() can be used here to validate the user input data.

        if ($model_1->load(Yii::$app->request->post())) {
            // Saves all columns visibility status collected through the form.
            return $this->redirect(['client/set-columns',
                                    'client_columns_config' => $model_1->column_0. $model_1->column_1. $model_1->column_2. $model_1->column_3. $model_1->column_4.
                                                               $model_1->column_5. $model_1->column_6. $model_1->column_7. $model_1->column_8. $model_1->column_9.
                                                               $model_1->column_10.$model_1->column_11.$model_1->column_12.$model_1->column_13.$model_1->column_14.
                                                               $model_1->column_15.$model_1->column_16.$model_1->column_17.$model_1->column_18.$model_1->column_19.
                                                               $model_1->column_20.$model_1->column_21.$model_1->column_22.$model_1->column_23.$model_1->column_24
                                    ]
            );
        }

        // Shows the Column-Selector view and pass to this the new model.
        return $this->render('select_client_columns',['model_1' => $model_1]);
    }

    /**
     * Gets the client page size.
     * @return mixed
     *
     * 2018-09-30 12:16 Hrs.
     */
    public function actionGetPageSize(){

        // Creates the new dynamic model
        $model_2 = new \yii\base\DynamicModel(['paginado']);
        // Adds the type rule to the new dynamic model
        $model_2->addRule(['paginado'], 'integer', ['min' => 1, 'max' => 100, 'tooSmall' => Yii::t('app', 'El valor no debe ser menor a ') . '1.', 'tooBig' => Yii::t('app', 'El valor no debe ser mayor a ') . '100.']);
        // Adds the required rule to the new dynamic model
        $model_2->addRule(['paginado'], 'required', ['message' => Yii::t('app', 'El valor no puede estar vacío.')]); // The ->validate() can be used here to validate the user input data.

        if ($model_2->load(Yii::$app->request->post())) {
            // Saves the page size value collected through the form.
            return $this->redirect(['client/set-page-size',
                'page_size_config' => $model_2->paginado,
            ]);
        }

        // Apply and show the newly generated changes.
        return $this->render('set_client_page_size', ['model_2' => $model_2]);
    }

    /**
     * Sets and stores the client page size.
     * @param string $page_size_config
     * @return mixed
     *
     * 2018-09-30 12:18 Hrs.
     */
    public function actionSetPageSize($page_size_config)
    {
        if (isset($page_size_config)){  // If the parameter for page size has been set, then ....
            $cookie = new Cookie(['name' => 'client-pageSize', 'value' => $page_size_config, 'expire' => time() + 86400 * 365,]);   // Creates a new cookie and stores the page size value in it.
            Yii::$app->getResponse()->getCookies()->add($cookie);
            Yii::$app->session->setFlash('configProcess', Yii::t('app','La configuración del tamaño de página ha sido definida en').' '.$page_size_config.' '.Yii::t('app','registro(s)').'.');
        }

        // Apply and show the newly generated changes.
        return $this->redirect(['client/index', 'page' => '1', 'hash' => '0']);
    }

}