<?php

namespace frontend\controllers;

use frontend\models\UploadForm1;
use Yii;
use app\models\Article;
use app\models\ArticleSearch;
use yii\base\DynamicModel;
use yii\db\Exception;
use yii\web\Cookie;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\helpers\Url;
use yii\helpers\Json;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;
use frontend\models\UploadForm;

use kartik\mpdf\Pdf;

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
            // 2018-08-28 : Records the access to Article module.
            Yii::info('[The user gets access to the Article Module]', 'cttwapp_user');

            $searchModel = new ArticleSearch();
            $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

            return $this->render('index_article', [
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
                'qryParams' => Yii::$app->request->queryParams,   // 2018-05-06 : This parameter is send to index_article.php view for test if 'ArticleSearch'
            ]);
        } else {
            // 2018-07-26 : If the user is a guest, then sends an error message to him. Otherwise it sends a warning message.
            if (Yii::$app->user->getIsGuest()) {
                Yii::$app->session->setFlash('error', Yii::t('app', 'Usted esta tratando de ingresar al sistema de forma no autorizada. Por favor, primero autentifique su acceso').'.');
                Yii::error('[Access denied to the Article Module]', 'cttwapp_user');
            } else {
                Yii::$app->session->setFlash('warning', Yii::t('app', 'Su perfil de acceso no le autoriza a utilizar esta acción. Por favor contacte al administrador del sistema para mayores detalles').'.');
                Yii::warning('[Unauthorized access profile to the Article Module]', 'cttwapp_user');
            }
        }
        return $this->redirect(['site/index', 'hash' => '0']);
    }

    /**
     * Shows the special Price List view.
     * @return mixed
     */
    public function actionIndex2()
    {
        if (\Yii::$app->user->can('listPriceList')) {
            // 2018-08-28 : Records the access to Article module.
            Yii::info('[The user gets access to the Price List Module]', 'cttwapp_user');

            $searchModel = new ArticleSearch();
            $dataProvider = $searchModel->search(Yii::$app->request->queryParams, '0');

            return $this->render('index_article2', [
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
                'qryParams' => Yii::$app->request->queryParams,   // 2018-05-06 : This parameter is send to index_article.php view for test if 'ArticleSearch'
            ]);
        } else {
            // 2018-07-26 : If the user is a guest, then sends an error message to him. Otherwise it sends a warning message.
            if (Yii::$app->user->getIsGuest()) {
                Yii::$app->session->setFlash('error', Yii::t('app', 'Usted esta tratando de ingresar al sistema de forma no autorizada. Por favor, primero autentifique su acceso').'.');
                Yii::error('[Access denied to the Price List Module]', 'cttwapp_user');
            } else {
                Yii::$app->session->setFlash('warning', Yii::t('app', 'Su perfil de acceso no le autoriza a utilizar esta acción. Por favor contacte al administrador del sistema para mayores detalles').'.');
                Yii::warning('[Unauthorized access profile to the Price List Module]', 'cttwapp_user');
            }
        }
        return $this->redirect(['site/index', 'hash' => '0']);
    }

    /**
     * Displays a single Article model in the Products & Services GridView.
     * @param string $id
     * @param string $page
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id, $page)
    {
        if (\Yii::$app->user->can('viewArticle')) {
            // 2018-08-28 : Records the article view operation.
            Yii::info('[The user has consulted the article record with ID=' . $id . ']', 'cttwapp_user');
            return $this->render('view_article', ['model' => $this->findModel($id),]);
        } else {
            // 2018-07-26 : If the user is a guest, then sends an error message to him. Otherwise it sends a warning message.
            if (Yii::$app->user->getIsGuest()) {
                Yii::$app->session->setFlash('error', Yii::t('app', 'Usted esta tratando de ingresar al sistema de forma no autorizada. Por favor, primero autentifique su acceso').'.');
                Yii::error('[Access denied to view an article record]', 'cttwapp_user');
                return $this->redirect(['site/index', 'hash' => '0']);
            }
            Yii::$app->session->setFlash('warning', Yii::t('app', 'Su perfil de acceso no le autoriza a utilizar esta acción. Por favor contacte al administrador del sistema para mayores detalles').'.');
            Yii::warning('[Unauthorized access profile to view an article record]', 'cttwapp_user');
        }
        return $this->redirect(['article/index', 'page' => $page, 'hash' => '0']);
    }

    /**
     * Displays a single Article model in the Price List GridView.
     * @param string $id
     * @param string $page
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView2($id, $page)
    {
        if (\Yii::$app->user->can('viewArticle')) {
            // 2018-08-28 : Records the article view operation.
            Yii::info('[The user has consulted the article record with ID=' . $id . ']', 'cttwapp_user');
            return $this->render('view_article2', ['model' => $this->findModel($id),]);
        } else {
            // 2018-07-26 : If the user is a guest, then sends an error message to him. Otherwise it sends a warning message.
            if (Yii::$app->user->getIsGuest()) {
                Yii::$app->session->setFlash('error', Yii::t('app', 'Usted esta tratando de ingresar al sistema de forma no autorizada. Por favor, primero autentifique su acceso').'.');
                Yii::error('[Access denied to view an article record]', 'cttwapp_user');
                return $this->redirect(['site/index', 'hash' => '0']);
            }
            Yii::$app->session->setFlash('warning', Yii::t('app', 'Su perfil de acceso no le autoriza a utilizar esta acción. Por favor contacte al administrador del sistema para mayores detalles').'.');
            Yii::warning('[Unauthorized access profile to view an article record]', 'cttwapp_user');
        }
        return $this->redirect(['article/index2', 'page' => $page, 'hash' => '0']);
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
                    // 2018-08-28 : Records the article create operation.
                    Yii::info('[The user has created a new article record with ID=' . $model->id . ']', 'cttwapp_user');
                    Yii::$app->session->setFlash('success', Yii::t('app', 'El registro se ha creado exitosamente').'.');
                    return $this->redirect(['view', 'id' => $model->id, 'page' => $page]);
                }
                // 2018-05-07 : An error occurred in the data capture process. A flash message is issued.
                Yii::$app->session->setFlash('warning', Yii::t('app', 'Por favor atienda las siguientes consideraciones antes de proceder a registrar la información').'.');
                return $this->render('create_article', ['model' => $model, 'page' => $page]);
            }

            Yii::info('[The user gets access to create a new article record]', 'cttwapp_user');
            // Render the page to create an article.
            return $this->render('create_article', ['model' => $model, 'page' => $page]);
        } else {
            // 2018-07-27 : If the user is a guest, then sends an error message to him. Otherwise it sends a warning message.
            if (Yii::$app->user->getIsGuest()) {
                Yii::$app->session->setFlash('error', Yii::t('app', 'Usted esta tratando de ingresar al sistema de forma no autorizada. Por favor, primero autentifique su acceso').'.');
                Yii::error('[Access denied to create an article record]', 'cttwapp_user');
                return $this->redirect(['site/index', 'hash' => '0']);
            }
            Yii::$app->session->setFlash('warning', Yii::t('app', 'Su perfil de acceso no le autoriza a utilizar esta acción. Por favor contacte al administrador del sistema para mayores detalles').'.');
            Yii::warning('[Unauthorized access profile to create an article record]', 'cttwapp_user');
            return $this->redirect(['article/index', 'page' => $page, 'hash' => '0']);
        }
    }

    /**
     * Updates an existing Article model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @param integer $page
     * @return mixed
     * @throws
     *
     * 2018-09-30 11:50 Hrs.
     */
    public function actionUpdate($id, $page)
    {
        if (\Yii::$app->user->can('updateArticle')) {

            $model = $this->findModel($id);

            if ($model->load(Yii::$app->request->post())) {
                // 2019-03-07 : Try to catch any DBMS constraint violation
                try {
                    if ($model->update() !== false) {
                        // 2018-10-30 : Records the catalog update operation.
                        Yii::info('[The user has updated the article record with ID=' . $model->id . ']', 'cttwapp_user');
                        $message = Yii::t('app', 'El registro se ha actualizado exitosamente').'.';

                        // 2019-03-07 : Rename the inventory image file ( .jpg or .png formats ) if it exists.
                        if ($this->renameFile($id, $model->id, '.jpg') || $this->renameFile($id, $model->id, '.png')) {
                            $message = $message . '<br>' . Yii::t('app', 'El archivo de imagen asociado, también se ha actualizado exitosamente').'.';
                        }

                        Yii::$app->session->setFlash('success', $message);
                        return $this->redirect(['view', 'id' => $model->id, 'page' => $page]);
                    } else {
                        // 2018-05-07 : An error occurred in the data capture. A flash message is issued.
                        Yii::$app->session->setFlash('warning', Yii::t('app', 'Por favor atienda las siguientes consideraciones antes de proceder a registrar la información').'.');
                        return $this->render('update_article', ['model' => $model, 'page' => $page]);
                    }
                } catch (Exception $e) {
                    // 2019-03-06 : The next statement is used to display the current error reported by SQLSTATUS : nl2br($e->errorInfo[0].' '.$e->errorInfo[2])
                    // The error info provided by a PDO exception. This is the same as returned by PDO::errorInfo.
                    switch ($e->errorInfo[0]) {
                        case '23503' :
                            Yii::info('[SQLState: 23503 - Foreign key violation at the article record with ID='.$id.']', 'cttwapp_user');
                            Yii::$app->session->setFlash('error',  Yii::t('app', 'Es imposible ejecutar la acción de Actualizar o Eliminar sobre este registro, debido a una violación de llave foránea. Este registro forma parte de una referencia en otra entidad').'.');
                            break;
                        case '42501' :
                            Yii::info('[SQLState: 42501 - Insufficient privileges at the article table]', 'cttwapp_user');
                            Yii::$app->session->setFlash('error',  Yii::t('app', 'Es imposible ejecutar la acción de Actualizar o Eliminar sobre este registro, debido a no contar con los suficientes privilegios').'.');
                            break;
                        default :
                            Yii::info('[SQLState: '.$e->errorInfo[0], 'cttwapp_user');
                    }
                    return $this->redirect(['article/index', 'page' => $page, 'hash' => '0']);
                }
            }

            Yii::info('[The user gets access to update an article record]', 'cttwapp_user');
            // Render the page to update an article.
            return $this->render('update_article', ['model' => $model, 'page' => $page]);
        } else {
            // 2018-07-27 : If the user is a guest, then sends an error message to him. Otherwise it sends a warning message.
            if (Yii::$app->user->getIsGuest()) {
                Yii::$app->session->setFlash('error', Yii::t('app', 'Usted esta tratando de ingresar al sistema de forma no autorizada. Por favor, primero autentifique su acceso').'.');
                Yii::error('[Access denied to update an article record]', 'cttwapp_user');
                return $this->redirect(['site/index', 'hash' => '0']);
            }
            Yii::$app->session->setFlash('warning', Yii::t('app', 'Su perfil de acceso no le autoriza a utilizar esta acción. Por favor contacte al administrador del sistema para mayores detalles').'.');
            Yii::warning('[Unauthorized access profile to update an article record]', 'cttwapp_user');
            return $this->redirect(['article/index', 'page' => $page, 'hash' => '0']);
        }
    }

    /**
     * Updates the visibility status to shows or to hides a product or service record in the 'Price List' index.
     * Toggles the shown_price_list field content in the Article table, from 'S' value to 'N' value and vice versa.
     * If update is successful, the browser will be redirected to the 'Products & Services' index.
     * @param string $id
     * @param string $page
     * @return mixed
     * @throws
     *
     * 2019-04-02 12:12 Hrs.
     */
    public function actionUpdate2($id, $page)
    {
        if (\Yii::$app->user->can('updateArticle')) {

            // 2019-04-02 : Return static|null ActiveRecord instance matching the condition, or `null` if nothing matches.
            $model = $this->findModel($id);

            // 2019-04-02 : Toggles the visibility status for this article record
            if ($model->shown_price_list=='S') $model->shown_price_list='N'; else $model->shown_price_list='S';

            // 2019-03-07 : Try to catch any DBMS constraint violation
            try {
                if ($model->update() !== false) {
                    // 2018-10-30 : Records the catalog update operation.
                    Yii::$app->session->setFlash('success', Yii::t('app', 'El estado de visibilidad para este registro se ha actualizado exitosamente.'));
                } else {
                    // 2018-05-07 : An error occurred in the data capture. A flash message is issued.
                    Yii::$app->session->setFlash('warning', Yii::t('app', 'Por favor atienda las siguientes consideraciones antes de proceder a registrar la información').'.');
                }
            } catch (Exception $e) {
                // 2019-03-06 : The next statement is used to display the current error reported by SQLSTATUS : nl2br($e->errorInfo[0].' '.$e->errorInfo[2])
                // The error info provided by a PDO exception. This is the same as returned by PDO::errorInfo.
                switch ($e->errorInfo[0]) {
                    case '23503' :
                        Yii::info('[SQLState: 23503 - Foreign key violation at the article record with ID='.$id.']', 'cttwapp_user');
                        Yii::$app->session->setFlash('error',  Yii::t('app', 'Es imposible ejecutar la acción de Actualizar o Eliminar sobre este registro, debido a una violación de llave foránea. Este registro forma parte de una referencia en otra entidad').'.');
                        break;
                    case '42501' :
                        Yii::info('[SQLState: 42501 - Insufficient privileges at the article table]', 'cttwapp_user');
                        Yii::$app->session->setFlash('error',  Yii::t('app', 'Es imposible ejecutar la acción de Actualizar o Eliminar sobre este registro, debido a no contar con los suficientes privilegios').'.');
                        break;
                    default :
                        Yii::info('[SQLState: '.$e->errorInfo[0], 'cttwapp_user');
                }
            }

            Yii::info('[The user has updated the visibility status for the record with ID=' . $model->id . ']', 'cttwapp_user');
            // Redirects to show all available Products & Services at the same page.
            return $this->redirect(['article/index', 'page' => $page, 'hash' => '0']);
        } else {
            // 2018-07-27 : If the user is a guest, then sends an error message to him. Otherwise it sends a warning message.
            if (Yii::$app->user->getIsGuest()) {
                Yii::$app->session->setFlash('error', Yii::t('app', 'Usted esta tratando de ingresar al sistema de forma no autorizada. Por favor, primero autentifique su acceso').'.');
                Yii::error('[Access denied to update an article record]', 'cttwapp_user');
                return $this->redirect(['site/index', 'hash' => '0']);
            }
            Yii::$app->session->setFlash('warning', Yii::t('app', 'Su perfil de acceso no le autoriza a utilizar esta acción. Por favor contacte al administrador del sistema para mayores detalles').'.');
            Yii::warning('[Unauthorized access profile to update an article record]', 'cttwapp_user');
            return $this->redirect(['article/index', 'page' => $page, 'hash' => '0']);
        }
    }

    /**
     * Deletes an existing Article model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @param string $page
     * @return mixed
     * @throws
     *
     * 2018-09-30 11:50 Hrs.
     */
    public function actionDelete($id, $page)
    {
        if (\Yii::$app->user->can('deleteArticle')) {
            // 2019-03-07 : Try to catch any DBMS constraint violation
            try {
                if ($this->findModel($id)->delete()) {
                    // 2018-10-30 : Records the brand delete operation.
                    Yii::info('[The user has deleted the article record with ID=' . $id . ']', 'cttwapp_user');

                    $message = Yii::t('app', 'El registro se ha eliminado exitosamente').'.';

                    // 2019-03-07 : Try to delete the image file ( .jpg or .png formats ) if it exists
                    if ($this->deleteFile($id, '.jpg') || $this->deleteFile($id, '.png')) {
                        $message = $message . '<br>' . Yii::t('app', 'El archivo de imagen asociado, también se ha eliminado exitosamente').'.';
                    }

                    Yii::$app->session->setFlash('success', $message);
                }
            } catch (Exception $e) {
                // 2019-03-06 : The next statement is used to display the current error reported by SQLSTATUS : nl2br($e->errorInfo[0].' '.$e->errorInfo[2])
                // The error info provided by a PDO exception. This is the same as returned by PDO::errorInfo.
                switch ($e->errorInfo[0]) {
                    case '23503' :
                         Yii::info('[SQLState: 23503 - Foreign key violation at the article record with ID='.$id.']', 'cttwapp_user');
                         Yii::$app->session->setFlash('error', Yii::t('app', 'Es imposible ejecutar la acción de Actualizar o Eliminar sobre este registro, debido a una violación de llave foránea. Este registro forma parte de una referencia en otra entidad').'.');
                         break;
                    case '42501' :
                         Yii::info('[SQLState: 42501 - Insufficient privileges at the article table]', 'cttwapp_user');
                         Yii::$app->session->setFlash('error',  Yii::t('app', 'Es imposible ejecutar la acción de Actualizar o Eliminar sobre este registro, debido a no contar con los suficientes privilegios').'.');
                         break;
                    default :
                         Yii::info('[SQLState: '.$e->errorInfo[0], 'cttwapp_user');
                }
            }
        } else {
            // 2018-07-27 : If the user is a guest, then sends an error message to him. Otherwise it sends a warning message.
            if (Yii::$app->user->getIsGuest()) {
                Yii::$app->session->setFlash('error', Yii::t('app', 'Usted esta tratando de ingresar al sistema de forma no autorizada. Por favor, primero autentifique su acceso').'.');
                Yii::error('[Access denied to delete an Article]', 'cttwapp_user');
                return $this->redirect(['site/index', 'hash' => '0']);
            }
            Yii::$app->session->setFlash('warning', Yii::t('app', 'Su perfil de acceso no le autoriza a utilizar esta acción. Por favor contacte al administrador del sistema para mayores detalles').'.');
            Yii::warning('[Unauthorized access profile to delete an Article]', 'cttwapp_user');
        }
        // Redirects to show all available products & services at the same page.
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
            throw new NotFoundHttpException(Yii::t('app','La página solicitada no existe').'.');
        }
    }

    /**
     * Implement the action of loading an image file.
     *
     * 2018-07-08 11:23 Hrs.
     *
     * Source :  yii2/docs/guide/input-file-upload.md
     * Resource : https://github.com/yiisoft/yii2/blob/master/docs/guide/input-file-upload.md
     *
     */

    public function actionUpload($id=null)
    {
        $model = new UploadForm();

        // 2018-07-27 : Yii2 Rbac - Validates the access to uploads files.
        if (\Yii::$app->user->can('uploadFile')) {
            if (Yii::$app->request->isPost) {
                $model->file = UploadedFile::getInstance($model, 'file');
                if ($model->upload($id)) {
                    // File is uploaded successfully
                    Yii::$app->session->setFlash('success', Yii::t('app','El archivo fue validado, cargado y almacenado exitosamente').'.');
                }
            }
        }
        else
            Yii::$app->session->setFlash('warning', Yii::t('app', 'Su perfil de acceso no le autoriza a utilizar esta acción. Por favor contacte al administrador del sistema para mayores detalles').'.');

        return $this->render('upload_file', ['model' => $model, 'id' => $id]);
    }

    /**
     * Switch and stores the articles colored status in a cookie for the products & services view.
     * @param string $color
     * @return mixed
     *
     * 2018-05-14 22:31 Hrs.
     */
    public function actionSetColor($color)
    {
        if (isset($color)){ // if color parameter is set.
            // Create and store a new cookie
            $cookie = new Cookie(['name' => 'article-color', 'value' => $color, 'expire' => time() + 86400 * 365,]);
            Yii::$app->getResponse()->getCookies()->add($cookie);
            // Send a message about the current color status.
            Yii::$app->session->setFlash('configProcess', Yii::t('app','La configuración del color ha sido : '.($color==1?'ACTIVADA':'DESACTIVADA')));
        }
        return $this->redirect(['article/index', 'page' => '1', 'hash' => '0']);
    }

    /**
     * Switch and stores the articles colored status in a cookie for the price list view.
     * @param string $color
     * @return mixed
     * @throws
     *
     * 2019-01-07 17:27 Hrs.
     */
    public function actionSetColor2($color)
    {
        if (isset($color)){ // if color parameter is set.
            // Create and store a new cookie
            $cookie = new Cookie(['name' => 'article-color2', 'value' => $color, 'expire' => time() + 86400 * 365,]);
            Yii::$app->getResponse()->getCookies()->add($cookie);
            // Send a message about the current color status.
            Yii::$app->session->setFlash('configProcess', Yii::t('app','La configuración del color ha sido : '.($color==1?'ACTIVADA':'DESACTIVADA')));
        }
        return $this->redirect(['article/index2', 'page' => '1', 'hash' => '0']);
    }

    /**
     * Gets the article columns visibility status.
     * @param string $view_type
     * @return mixed
     *
     * 2018-10-01 20:13 Hrs.  Re-factor : This code only uses one cookie ( article_columns_config ) instead of 13 cookies ( one per each column ).
     *                                    Using one cookie resolves the trouble described in the file :
     *
     *                                    2018-09-30_PROBLEMA_CODIGO_DE_ERROR_502_DE_HTTP_AL_PASAR_COOKIES_EN_Yii2.pdf
     *
     * 2018-08-20 16:50 Hrs.
     */
    public function actionGetColumns($view_type='')
    {
        // Creates the new dynamic model
        $model_1 = new DynamicModel(['column_0', 'column_1', 'column_2', 'column_3', 'column_4', 'column_5', 'column_6', 'column_7', 'column_8', 'column_9', 'column_10', 'column_11', 'column_12', 'column_13',]);
        // Add the rules to the new dynamic model
        $model_1->addRule(['column_0',  'column_1',  'column_2',  'column_3',  'column_4',  'column_5',  'column_6',
                           'column_7',  'column_8',  'column_9',  'column_10', 'column_11', 'column_12', 'column_13'], 'string', ['max' => 1]);
        // Add the rules to the new dynamic model
        $model_1->addRule(['column_0',  'column_1',  'column_2',  'column_3',  'column_4',  'column_5',  'column_6',
                           'column_7',  'column_8',  'column_9',  'column_10', 'column_11', 'column_12', 'column_13'], 'required'); // The ->validate() can be used here to validate the user input data.

        if ($model_1->load(Yii::$app->request->post())) {
            // Saves all columns visibility status collected through the form.
            return $this->redirect(['article/set-columns',
                                    'article_columns_config' => $model_1->column_0. $model_1->column_1. $model_1->column_2. $model_1->column_3. $model_1->column_4.
                                                                $model_1->column_5. $model_1->column_6. $model_1->column_7. $model_1->column_8. $model_1->column_9.
                                                                $model_1->column_10.$model_1->column_11.$model_1->column_12.$model_1->column_13,
                                    'view_type' => $view_type,
                                    ]
            );
        }

        // Shows the Column-Selector view and pass to this the new model.
        return $this->render('select_article_columns',['model_1' => $model_1, 'view_type' => $view_type]);
    }

    /**
     * Sets and stores each articles column visibility status in cookies.
     * @param string $article_columns_config
     * @param string $view_type
     * @return mixed
     *
     * 2018-10-01 20:19 Hrs.  Re-factor : This code only uses one cookie ( article_columns_config ) instead of 13 cookies ( one per each column )
     * 2018-08-20 16:43 Hrs.
     */
    public function actionSetColumns($article_columns_config, $view_type='')
    {
        // 2019-01-07 : Refactored
        // $view_type == ''  : article/index view
        // $view_type == '2' : article/index2 view

        if (isset($article_columns_config)){  // If the parameter for columns config has been set, then ...
            // ... creates a new cookie named (article_columns_config / article_columns_config2) and stores the page size value in it.
            $cookie = new Cookie(['name' => 'article_columns_config'.$view_type, 'value' => $article_columns_config, 'expire' => time() + 86400 * 365,]);   // Creates a new cookie and stores the column visibility status in it.
            Yii::$app->getResponse()->getCookies()->add($cookie);
            // Send a message about the process status
            Yii::$app->session->setFlash('configProcess', Yii::t('app','La configuración del número de columnas visibles se ha modificado exitosamente').'.');
        }

        // Apply and show the newly generated changes.
        return $this->redirect(['article/index'.$view_type, 'page' => '1', 'hash' => '0']);
    }

    /**
     * Gets the article page size.
     * @param string $view_type
     * @return mixed
     *
     * 2018-08-22 20:28 Hrs.
     */
    public function actionGetPageSize($view_type='')
    {
        // Creates the new dynamic model
        $model_2 = new DynamicModel(['paginado']);
        // Adds the type rule to the new dynamic model
        $model_2->addRule(['paginado'], 'integer', ['min' => 1, 'max' => 100, 'tooSmall' => Yii::t('app', 'El valor no debe ser menor a ') . '1.', 'tooBig' => Yii::t('app', 'El valor no debe ser mayor a ') . '100.']);
        // Adds the required rule to the new dynamic model
        $model_2->addRule(['paginado'], 'required', ['message' => Yii::t('app', 'El valor no puede estar vacío').'.']); // The ->validate() can be used here to validate the user input data.

        if ($model_2->load(Yii::$app->request->post())) {
            // Saves the page size value collected through the form.
            return $this->redirect(['article/set-page-size',
                'page_size_config' => $model_2->paginado,
                'view_type' => $view_type,
            ]);
        }

        // Apply and show the newly generated changes.
        return $this->render('set_article_page_size', ['model_2' => $model_2, 'view_type' => $view_type]);
    }

    /**
     * Sets and stores the article page size.
     * @param string $page_size_config
     * @param string $view_type
     * @return mixed
     *
     * 2018-08-22 22:55 Hrs.
     */
    public function actionSetPageSize($page_size_config, $view_type='')
    {
        // 2019-01-07 : Refactored
        // $view_type == ''  : article/index view
        // $view_type == '2' : article/index2 view

        if (isset($page_size_config)){  // If the parameter for page size has been set, then ...
            // ... creates a new cookie named (article-pageSize / article-pageSize2) and stores the page size value in it.
            $cookie = new Cookie(['name' => 'article-pageSize'.$view_type, 'value' => $page_size_config, 'expire' => time() + 86400 * 365,]);
            Yii::$app->getResponse()->getCookies()->add($cookie);
            // Send a message about the process status
            Yii::$app->session->setFlash('configProcess', Yii::t('app','La configuración del tamaño de página ha sido definida en').' '.$page_size_config.' '.Yii::t('app','registro(s)').'.');
        }

        // Applies and displays the newly generated changes.
        return $this->redirect(['article/index'.$view_type, 'page' => '1', 'hash' => '0']);
    }

    /**
     * Generates a PDF file with the data of an article in printable version.
     * @param string $id
     * @param string $view_type
     * @param string $page
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     *
     * 2018-08-04 14:40 Hrs.
     */
    public function actionPrint($id, $view_type='', $page)
    {
        // 2018-08-11 : Only for debug purpose.
        // return $this->render('print_article', ['model' => $this->findModel($id),]);

        // $view_type == ''  : article/index view
        // $view_type == '2' : article/index2 view

        if (\Yii::$app->user->can('printArticle')) {
            // 2018-08-28 : Records the article print operation.
            Yii::info('[The user has printed the article record with ID='.$id.']', 'cttwapp_user');

            // Get your HTML raw content without any layouts or scripts
            $content = $this->renderPartial('print_article', ['model' => $this->findModel($id),]);

            // Defines the footer page style
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
                'filename' => 'cttwapp_article_report.pdf',
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

            // Set some mPDF properties on the fly

            // Directly use the mPDF api for various other mPDF manipulations
            // Fetches mPDF API
            $mpdf = $pdf->api;

            // Call methods or set any properties
            $mpdf->SetTitle(Yii::t('app', 'Artículo').' : '.$id);
            $mpdf->SetAuthor('ISC. Ricardo González González');
            $mpdf->SetCreator('CTTwapp v1.0');
            $mpdf->SetSubject('Reporte');
            $mpdf->SetKeywords('cttwapp, report, article, detail, pdf');
            // 2018-08-11 : Enables a water mark text
            /*
            $mpdf->showWatermarkText = true;                         // To shows the water mark text.
            $mpdf->watermarkTextAlpha = 0.1;                         // To defines the alpha value for the water mark text.
            $mpdf->watermark_font = 'Source Sans Pro';               // To defines the font type for the water mark text.
            $mpdf->SetWatermarkText(Yii::t('app', 'Confidencial'));  // To defines the legend for the water mark text.
            */
            // 2018-08-11 : Enables a water image
            $mpdf->showWatermarkImage = true;                        // To shows the water mark image.
            $mpdf->watermarkImageAlpha = 0.1;                        // To defines the alpha value for the water mark image.
            $mpdf->defaultfooterline = true;                         // To shows the water mark image.
            $mpdf->SetWatermarkImage(Url::to('/img/ctt-logo.png', true),0.2,'P',[0,-42]);   // To defines the image file for the water mark image.

            // Returns the pdf output as per the destination setting
            return $pdf->render();
        }
        else {
            // 2018-08-04 : If the user is a guest, then sends an error message to him. Otherwise it sends a warning message.
            if (Yii::$app->user->getIsGuest()) {
                Yii::$app->session->setFlash('error', Yii::t('app', 'Usted esta tratando de ingresar al sistema de forma no autorizada. Por favor, primero autentifique su acceso').'.');
                Yii::error('[Access denied to print an Article]', 'cttwapp_user');
                return $this->redirect(['site/index', 'hash' => '0']);
            }
            Yii::$app->session->setFlash('warning', Yii::t('app', 'Su perfil de acceso no le autoriza a utilizar esta acción. Por favor contacte al administrador del sistema para mayores detalles').'.');
            Yii::warning('[Unauthorized access profile to print an Article]', 'cttwapp_user');
        }

        // Redirect to the index page, according to the $view_type parameter.
        return $this->redirect(['article/index'.$view_type, 'page' => $page, 'hash' => '0']);
    }
    /**
     * Generates a PDF file with the user selected records of articles in printable version.
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     *
     * 2019-09-07 15:59 Hrs.
     */
    public function actionPrint2()
    {

        // Access to sessions through the session application component
        $session = Yii::$app->session;

        // Validate the existence and content of the session array 'keylist'.
        if (!isset($session['keylist']) || count($session['keylist'])==0){
            // Shows a flash warning message.
            Yii::$app->session->setFlash('warning', Yii::t('app', 'No ha marcado ningún registro y por ello es imposible procesar su petición').'.');
            // Redirect to the index page, according to the $view_type parameter.
            return $this->redirect(['article/index', 'page' => '1', 'hash' => '0']);
        }

        // Validate the user access to this action
        if (\Yii::$app->user->can('printArticle')) {
            // 2018-08-28 : Records the article print operation.
            Yii::info('[The user has printed the article list]', 'cttwapp_user');

            $searchModel = new ArticleSearch();
            $dataProvider = $searchModel->search(Yii::$app->request->queryParams, '1');

            // Get your HTML raw content without any layouts or scripts
            $content = $this->renderPartial('print_article_list', [
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
                'qryParams' => Yii::$app->request->queryParams,   // 2018-05-06 : This parameter is send to index_article.php view for test if 'ArticleSearch'
            ]);

            // Defines the footer page style
            $footer = "<hr style=\"color: gainsboro;\"/>\n   <table width=\"100%\" style=\"vertical-align: bottom; font-size: 9px; color: gray;\"><tr>\n   <td width=\"33%\"><span style=\"letter-spacing: 3px;\">CTTwapp ver-1.0</span></td>\n   <td width=\"33%\" align=\"center\" style=\"letter-spacing: 5px;\">".Yii::t('app','Inventarios')."</td>\n   <td width=\"33%\" style=\"text-align: right; letter-spacing: 3px;\">".Yii::t('app', 'Página')." [ {PAGENO} ]</td>\n   </tr></table>";

            // Setup kartik\mpdf\Pdf component
            $pdf = new Pdf([
                // Set to use core fonts only
                'mode' => Pdf::MODE_CORE,
                // LETTER paper format
                'format' => Pdf::FORMAT_LETTER,
                // Portrait orientation
                'orientation' => Pdf::ORIENT_LANDSCAPE,
                // Stream to browser inline
                'destination' => Pdf::DEST_BROWSER,
                // File name
                'filename' => 'cttwapp_articles_report.pdf',
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

            // Set some mPDF properties on the fly

            // Directly use the mPDF api for various other mPDF manipulations
            // Fetches mPDF API
            $mpdf = $pdf->api;

            // Call methods or set any properties
            $mpdf->SetTitle(Yii::t('app', 'Lista de Artículos'));
            $mpdf->SetAuthor('ISC. Ricardo González González');
            $mpdf->SetCreator('CTTwapp v1.0');
            $mpdf->SetSubject('Reporte');
            $mpdf->SetKeywords('cttwapp, report, article, list, pdf');
            // 2018-08-11 : Enables a water mark text
            /*
            $mpdf->showWatermarkText = true;                         // To shows the water mark text.
            $mpdf->watermarkTextAlpha = 0.1;                         // To defines the alpha value for the water mark text.
            $mpdf->watermark_font = 'Source Sans Pro';               // To defines the font type for the water mark text.
            $mpdf->SetWatermarkText(Yii::t('app', 'Confidencial'));  // To defines the legend for the water mark text.
            */
            // 2018-08-11 : Enables a water image
            $mpdf->showWatermarkImage = true;                        // To shows the water mark image.
            $mpdf->watermarkImageAlpha = 0.1;                        // To defines the alpha value for the water mark image.
            $mpdf->defaultfooterline = true;                         // To shows the water mark image.
            $mpdf->SetWatermarkImage(Url::to('/img/ctt-logo.png', true),0.2,'P',[0,-42]);   // To defines the image file for the water mark image.

            // Returns the pdf output as per the destination setting
            return $pdf->render();
        }
        else {
            // 2018-08-04 : If the user is a guest, then sends an error message to him. Otherwise it sends a warning message.
            if (Yii::$app->user->getIsGuest()) {
                Yii::$app->session->setFlash('error', Yii::t('app', 'Usted esta tratando de ingresar al sistema de forma no autorizada. Por favor, primero autentifique su acceso').'.');
                Yii::error('[Access denied to print an Article]', 'cttwapp_user');
                return $this->redirect(['site/index', 'hash' => '0']);
            }
            Yii::$app->session->setFlash('warning', Yii::t('app', 'Su perfil de acceso no le autoriza a utilizar esta acción. Por favor contacte al administrador del sistema para mayores detalles').'.');
            Yii::warning('[Unauthorized access profile to print an Article]', 'cttwapp_user');
        }

        // Redirect to the index page, according to the $view_type parameter.
        return $this->redirect(['article/index']);
    }

    /**
     * Renames a file inside the upload directory.
     * If renaming is successful, the method return true. Otherwise return false.
     * @param string $current_id
     * @param string $new_id
     * @param string $file_ext
     * @return boolean
     * @throws
     *
     * 2019-03-08 15:59 Hrs.
     */

    public function renameFile($current_id, $new_id, $file_ext)
    {
        // This code obtains the file path and the filename.
        $file_name = Yii::getAlias('@webroot').Yii::getAlias('@uploads_inv').'/'.PREFIX_IMG.$current_id.$file_ext;
        // This code sets the path of the file and the name of the new file.
        $new_file_name = Yii::getAlias('@webroot').Yii::getAlias('@uploads_inv').'/'.PREFIX_IMG.$new_id.$file_ext;
        // Test if the file exists.
        if (file_exists($file_name)){
            // Try to rename the old filename with the new filename.
            return(rename($file_name,$new_file_name));
        }

        // The default operation status
        return false;
    }

    /**
     * Deletes a file inside the upload directory.
     * If deletion is successful, the method return true. Otherwise return false.
     * @param string $current_id
     * @param string $file_ext
     * @return boolean
     * @throws
     *
     * 2019-03-08 15:59 Hrs.
     */

    public function deleteFile($current_id, $file_ext)
    {
        // This code obtains the file path and the filename.
        $file_name = Yii::getAlias('@webroot').Yii::getAlias('@uploads_inv').'/'.PREFIX_IMG.$current_id.$file_ext;
        // Test if the file exists.
        if (file_exists($file_name)){
            // Try to delete the filename in the upload directory.
            return(unlink($file_name));
        }

        // The default operation status
        return false;
    }

    /**
     * Adds a key item to the session array 'keylist'
     * The key item to adds is sent to the controller, using the http post method.
     * Returns a json response to notify the operation status
     *
     * 2019-09-06 23:19 Hrs.
     */

    public function actionAddKey(){

        // Has a new item key been sent to be stored in the session array ?
        if (isset($_POST["itemkey"])) {

            // Retrieve the new item key
            $item_id = $_POST["itemkey"];
            // Access to sessions through the session application component
            $session = Yii::$app->session;

            // If there isn't an session array named 'keylist' or there is one empty, then ...
            if (!isset($session['keylist']) || count($session['keylist'])==0)
               // Creates a new session array based on the new item key ( $item_id )
               $session['keylist'] = array($item_id);
            else {
               // Copy the actual session array 'keylist' into a temp array
               $new_key_list_array = $session['keylist'];
               // Adds the new item key into the temp array named '$new_key_list_array'
               $new_key_list_array[] = $item_id;
               // Reassigns the temporary array as a session array item called 'key list'
               $session['keylist'] = $new_key_list_array;
            }

            // The next lines prepares information ( data ) about the elements counted, the elements added and the status of the last request.
            $keylist_length = count($session['keylist']);
            $elements = Json::encode($session['keylist']);
            $status = 'success-add';
        }
        else {
            // There isn't sent a new itemkey through the post method. Then prepares information ( data ) about the error
            $item_id = -1;
            $keylist_length = 0;
            $elements = "";
            $status = 'error-add';
        };

        // Returns the information about the last operation in the json format
        echo Json::encode([
            'status' => $status,
            'value' => $item_id,
            'length' => $keylist_length,
            'elements' => $elements,
        ]);

        return;
    }

    /**
     * Removes a key item to the session array 'keylist'
     * The key item to be removed is sent to the controller using the http post method.
     * Returns a json response to notify the operation status
     *
     * 2019-09-06 23:26 Hrs.
     */
    public function actionRemoveKey(){

        // Has a new item key been sent to be stored in the session array ?
        if (isset($_POST["itemkey"])) {

           // Retrieve the new item key
           $item_id = $_POST["itemkey"];
           // Access to sessions through the session application component
           $session = Yii::$app->session;

           // If there is an session array named 'keylist' and there are elements, then ...
           if (isset($session['keylist']) && count($session['keylist'])>0){

              // Removes the itemkey from session array 'keylist' and assigns it back into a temp array named '$new_key_list_array'
              $new_key_list_array = array_values(array_diff( $session['keylist'], array($item_id) ));
              // Reassigns the temp array to as an session array named 'keylist'
              $session['keylist'] = $new_key_list_array;

              // The next lines prepares information ( data ) about the elements counted, the elements added and the status of the last request.
              $keylist_length = count($session['keylist']);
              $elements = Json::encode($session['keylist']);
              $status = 'success-remove';
           }
        }
        else {
           // The next lines prepares information ( data ) about the elements counted, the elements added and the status of the last request.
           $item_id = -1;
           $keylist_length = 0;
           $elements = "";
           $status = 'error-remove';
        }

        // Returns the information about the last operation in the json format
        echo Json::encode([
            'status' => $status,
            'value' => $item_id,
            'length' => $keylist_length,
            'elements' => $elements,
        ]);

        return;
    }

    /**
     * Cleans out the session array 'keylist'
     * Returns a json response to notify the operation status
     *
     * 2019-09-06 23:32 Hrs.
     */
    public function actionCleanKeys(){

        // Access to sessions through the session application component
        $session = Yii::$app->session;

        // Cleans out the 'keylist' session array
        if (isset($session['keylist'])){
            unset($session['keylist']);
            $session['keylist'] = array();
        }

        // Send a message about the process status
        Yii::$app->session->setFlash('configProcess', Yii::t('app','La acción para Desmarcar Todos los registros seleccionados se ha completado exitosamente.'));

        // Redirect to the index page, according to the $view_type parameter.
        return $this->redirect(['article/index', 'page' => '1', 'hash' => '0']);
    }

    /**
     * Exports Article records from the session array 'keylist' to a CSV file
     *
     * 2019-09-20 19:17 Hrs.
     */
    public function actionExportCsv(){

        // Access to sessions through the session application component
        $session = Yii::$app->session;

        // Validate the existence and content of the session array 'keylist'.
        if (!isset($session['keylist']) || count($session['keylist'])==0){
            // Shows a flash warning message.
            Yii::$app->session->setFlash('warning', Yii::t('app', 'No ha marcado ningún registro y por ello es imposible procesar su petición').'.');
            // Redirect to the index page, according to the $view_type parameter.
            return $this->redirect(['article/index', 'page' => '1', 'hash' => '0']);
        }

        // Validate the user access to this action
        if (\Yii::$app->user->can('exportArticle')) {
            // 2019-09-20 : Records the article export operation.
            Yii::info('[The user has been exported the article list to a CSV file]', 'cttwapp_user');

            // Render the page to export an article list in CSV file format.
            return $this->render('export_article_list');
        }
        else {
            // 2018-08-04 : If the user is a guest, then sends an error message to him. Otherwise it sends a warning message.
            if (Yii::$app->user->getIsGuest()) {
                Yii::$app->session->setFlash('error', Yii::t('app', 'Usted esta tratando de ingresar al sistema de forma no autorizada. Por favor, primero autentifique su acceso').'.');
                Yii::error('[Access denied to export an Article list to a CSV file]', 'cttwapp_user');
                return $this->redirect(['site/index', 'hash' => '0']);
            }
            Yii::$app->session->setFlash('warning', Yii::t('app', 'Su perfil de acceso no le autoriza a utilizar esta acción. Por favor contacte al administrador del sistema para mayores detalles').'.');
            Yii::warning('[Unauthorized access profile to export a CSV file]', 'cttwapp_user');
        }

        return $this->redirect(['article/index', 'page' => '1', 'hash' => '0']);
    }

    /**
     * Implements the actions to load and validates a CSV file. If the file is successfully loaded, then tries to validates and accomplish the import process.
     * 2019-09-22 22:42 Hrs.
     *
     * Source :  yii2/docs/guide/input-file-upload.md
     * Resource : https://github.com/yiisoft/yii2/blob/master/docs/guide/input-file-upload.md
     *
     */

    public function actionImportCsv()
    {
        // 2019-09-22 : Creates a new model to upload a file.
        $model = new UploadForm1();

        // 2018-07-27 : Yii2 Rbac - Validates the access to uploads files.
        if (\Yii::$app->user->can('uploadFile') && \Yii::$app->user->can('importArticle')) {
            if (Yii::$app->request->isPost) {
                // UploadedFile represents the information for an uploaded file.
                $model->file = UploadedFile::getInstance($model, 'file');
                // Are there loaded data ?
                if ($model->upload()) {
                    // Yes. File is uploaded successfully
                    Yii::$app->session->setFlash('success', Yii::t('app','El archivo fue validado, cargado y almacenado exitosamente').'.');

                    // 2019-09-24 : Begin the import process.

                    // Gets the path and file name for the CSV file to upload.
                    $path_name = Yii::getAlias('@webroot').Yii::getAlias('@uploads').'/';
                    $file_name = 'imported_article_list.csv';

                    // 2019-09-24 : If the file is loaded ...
                    if (file_exists($path_name.$file_name)){

                        // Import the content of the CSV file
                        // Warning : If the Article table structure changes, this changes must be implemented in the SQL COPY statement.
                        $sql = "COPY article(id,name_art,sp_desc,en_desc,type_art,price_art,currency_art,brand_id,part_num,created_at,updated_at,created_by,updated_by,catalog_id,shown_price_list,warehouse_id) FROM '$path_name$file_name' DELIMITER ',' CSV HEADER;";

                        // 2019-09-24 : Try to execute the SQL statement, then shows the process status, otherwise sends a error message.
                        try{
                            if ($rows = Yii::$app->db->createCommand($sql)->execute()) {
                                Yii::info('['.$rows.': records imported to the Article table]', 'cttwapp_user');
                                if ($rows) Yii::$app->session->setFlash('success', Yii::t('app','El archivo fue validado, cargado y almacenado exitosamente').'.'.'<br>'.Yii::t('app','Se han importado exitosamente al sistema').' '.$rows.' '.Yii::t('app','registro(s)').'.');
                            }
                            else{
                                Yii::$app->session->setFlash('error', Yii::t('app', 'Ningun registro fue importado a la tabla').'.');
                            }
                        }catch (Exception $e) {
                            // 2019-09-24 : The next statement is used to display the current error reported by SQLSTATUS : nl2br($e->errorInfo[0].' '.$e->errorInfo[2])
                            // The error info provided by a PDO exception. This is the same as returned by PDO::errorInfo.
                            switch ($e->errorInfo[0]){
                                case '23505' :
                                    Yii::info('[SQLState: 23505 - Integrity constraint violation]', 'cttwapp_user');
                                    Yii::$app->session->setFlash('error',  Yii::t('app', 'Es imposible ejecutar la acción de importar registros al sistema desde un archivo en formato CSV, debido a una violación de restricción a la integridad. Se ha intentado duplicar uno o varios registros').'.');
                                    break;
                                default :
                                    Yii::info('[SQLState: '.$e->errorInfo[0], 'cttwapp_user');
                            }
                        }
                    }
                    else{
                        // File does not exist
                        Yii::$app->session->setFlash('error', Yii::t('app','El archivo no existe, verifique por favor').'.');
                    }
                }
                else{
                    // File isn't uploaded
                    Yii::$app->session->setFlash('error', Yii::t('app','El archivo no fue cargado correctamente, por favor intente de nuevo').'.');
                }
                return $this->redirect(['article/index', 'page' => '1', 'hash' => '0']);
            }
        }
        else {
            // 2018-08-04 : If the user is a guest, then sends an error message to him. Otherwise it sends a warning message.
            if (Yii::$app->user->getIsGuest()) {
                Yii::$app->session->setFlash('error', Yii::t('app', 'Usted esta tratando de ingresar al sistema de forma no autorizada. Por favor, primero autentifique su acceso').'.');
                Yii::error('[Access denied to import Article records from a CSV file]', 'cttwapp_user');
                return $this->redirect(['site/index', 'hash' => '0']);
            }
            Yii::$app->session->setFlash('warning', Yii::t('app', 'Su perfil de acceso no le autoriza a utilizar esta acción. Por favor contacte al administrador del sistema para mayores detalles').'.');
            Yii::warning('[Unauthorized access profile to import a CSV file]', 'cttwapp_user');

            return $this->redirect(['article/index', 'page' => '1', 'hash' => '0']);
        }

        return $this->render('upload_file1', ['model' => $model]);
    }

}