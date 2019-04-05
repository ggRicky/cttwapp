<?php

namespace frontend\controllers;

use Yii;
use app\models\Article;
use app\models\ArticleSearch;
use yii\base\DynamicModel;
use yii\db\Exception;
use yii\web\Cookie;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\helpers\Url;
use yii\filters\VerbFilter;
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
            // 2018-07-26 : If the user is a guest, then he sends an error message. Otherwise it sends a warning message.
            if (Yii::$app->user->getIsGuest()) {
                Yii::$app->session->setFlash('error', Yii::t('app', 'Usted esta tratando de ingresar al sistema de forma no autorizada. Por favor, primero autentifique su acceso.'));
                Yii::error('[Access denied to the Article Module]', 'cttwapp_user');
            } else {
                Yii::$app->session->setFlash('warning', Yii::t('app', 'Su perfil de acceso no le autoriza a utilizar esta acción. Por favor contacte al administrador del sistema para mayores detalles.'));
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
            $dataProvider = $searchModel->search(Yii::$app->request->queryParams, 'pl');

            return $this->render('index_article2', [
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
                'qryParams' => Yii::$app->request->queryParams,   // 2018-05-06 : This parameter is send to index_article.php view for test if 'ArticleSearch'
            ]);
        } else {
            // 2018-07-26 : If the user is a guest, then he sends an error message. Otherwise it sends a warning message.
            if (Yii::$app->user->getIsGuest()) {
                Yii::$app->session->setFlash('error', Yii::t('app', 'Usted esta tratando de ingresar al sistema de forma no autorizada. Por favor, primero autentifique su acceso.'));
                Yii::error('[Access denied to the Price List Module]', 'cttwapp_user');
            } else {
                Yii::$app->session->setFlash('warning', Yii::t('app', 'Su perfil de acceso no le autoriza a utilizar esta acción. Por favor contacte al administrador del sistema para mayores detalles.'));
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
            // 2018-07-26 : If the user is a guest, then he sends an error message. Otherwise it sends a warning message.
            if (Yii::$app->user->getIsGuest()) {
                Yii::$app->session->setFlash('error', Yii::t('app', 'Usted esta tratando de ingresar al sistema de forma no autorizada. Por favor, primero autentifique su acceso.'));
                Yii::error('[Access denied to view an article record]', 'cttwapp_user');
                return $this->redirect(['site/index', 'hash' => '0']);
            }
            Yii::$app->session->setFlash('warning', Yii::t('app', 'Su perfil de acceso no le autoriza a utilizar esta acción. Por favor contacte al administrador del sistema para mayores detalles.'));
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
            // 2018-07-26 : If the user is a guest, then he sends an error message. Otherwise it sends a warning message.
            if (Yii::$app->user->getIsGuest()) {
                Yii::$app->session->setFlash('error', Yii::t('app', 'Usted esta tratando de ingresar al sistema de forma no autorizada. Por favor, primero autentifique su acceso.'));
                Yii::error('[Access denied to view an article record]', 'cttwapp_user');
                return $this->redirect(['site/index', 'hash' => '0']);
            }
            Yii::$app->session->setFlash('warning', Yii::t('app', 'Su perfil de acceso no le autoriza a utilizar esta acción. Por favor contacte al administrador del sistema para mayores detalles.'));
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
                    Yii::$app->session->setFlash('success', Yii::t('app', 'El registro se ha creado exitosamente.'));
                    return $this->redirect(['view', 'id' => $model->id, 'page' => $page]);
                }
                // 2018-05-07 : An error occurred in the data capture process. A flash message is issued.

                Yii::$app->session->setFlash('warning', Yii::t('app', 'Por favor atienda las siguientes consideraciones antes de proceder a registrar la información.'));
                return $this->render('create_article', ['model' => $model, 'page' => $page]);
            }

            Yii::info('[The user gets access to create a new article record]', 'cttwapp_user');
            // Render the page to create an article.
            return $this->render('create_article', ['model' => $model, 'page' => $page]);
        } else {
            // 2018-07-27 : If the user is a guest, then he sends an error message. Otherwise it sends a warning message.
            if (Yii::$app->user->getIsGuest()) {
                Yii::$app->session->setFlash('error', Yii::t('app', 'Usted esta tratando de ingresar al sistema de forma no autorizada. Por favor, primero autentifique su acceso.'));
                Yii::error('[Access denied to create an article record]', 'cttwapp_user');
                return $this->redirect(['site/index', 'hash' => '0']);
            }
            Yii::$app->session->setFlash('warning', Yii::t('app', 'Su perfil de acceso no le autoriza a utilizar esta acción. Por favor contacte al administrador del sistema para mayores detalles.'));
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
                        $message = Yii::t('app', 'El registro se ha actualizado exitosamente.');

                        // 2019-03-07 : Rename the inventory image file ( .jpg or .png formats ) if it exists.
                        if ($this->renameFile($id, $model->id, '.jpg') || $this->renameFile($id, $model->id, '.png')) {
                            $message = $message . '<br>' . Yii::t('app', 'El archivo de imagen asociado, también se ha actualizado exitosamente.');
                        }

                        Yii::$app->session->setFlash('success', $message);
                        return $this->redirect(['view', 'id' => $model->id, 'page' => $page]);
                    } else {
                        // 2018-05-07 : An error occurred in the data capture. A flash message is issued.
                        Yii::$app->session->setFlash('warning', Yii::t('app', 'Por favor atienda las siguientes consideraciones antes de proceder a registrar la información.'));
                        return $this->render('update_article', ['model' => $model, 'page' => $page]);
                    }
                } catch (Exception $e) {
                    // 2019-03-06 : The next statement is used to display the current error reported by SQLSTATUS : nl2br($e->errorInfo[0].' '.$e->errorInfo[2])
                    // The error info provided by a PDO exception. This is the same as returned by PDO::errorInfo.
                    switch ($e->errorInfo[0]) {
                        case '23503' :
                            Yii::$app->session->setFlash('error', Yii::t('app', 'Es imposible ejecutar la acción de Actualizar o Eliminar sobre este registro, debido a una violación de llave foránea. Este registro forma parte de una referencia en otra entidad.'));

                    }
                    return $this->redirect(['article/index', 'page' => $page, 'hash' => '0']);
                }
            }

            Yii::info('[The user gets access to update an article record]', 'cttwapp_user');
            // Render the page to update an article.
            return $this->render('update_article', ['model' => $model, 'page' => $page]);
        } else {
            // 2018-07-27 : If the user is a guest, then he sends an error message. Otherwise it sends a warning message.
            if (Yii::$app->user->getIsGuest()) {
                Yii::$app->session->setFlash('error', Yii::t('app', 'Usted esta tratando de ingresar al sistema de forma no autorizada. Por favor, primero autentifique su acceso.'));
                Yii::error('[Access denied to update an article record]', 'cttwapp_user');
                return $this->redirect(['site/index', 'hash' => '0']);
            }
            Yii::$app->session->setFlash('warning', Yii::t('app', 'Su perfil de acceso no le autoriza a utilizar esta acción. Por favor contacte al administrador del sistema para mayores detalles.'));
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
            if ($model->shown_price_list=='S') $model->shown_price_list='N';
            else $model->shown_price_list='S';

            // 2019-03-07 : Try to catch any DBMS constraint violation
            try {
                if ($model->update() !== false) {
                    // 2018-10-30 : Records the catalog update operation.
                    Yii::$app->session->setFlash('success', Yii::t('app', 'El estado de visibilidad para este registro se ha actualizado exitosamente.'));
                } else {
                    // 2018-05-07 : An error occurred in the data capture. A flash message is issued.
                    Yii::$app->session->setFlash('warning', Yii::t('app', 'Por favor atienda las siguientes consideraciones antes de proceder a registrar la información.'));
                }
            } catch (Exception $e) {
                // 2019-03-06 : The next statement is used to display the current error reported by SQLSTATUS : nl2br($e->errorInfo[0].' '.$e->errorInfo[2])
                // The error info provided by a PDO exception. This is the same as returned by PDO::errorInfo.
                switch ($e->errorInfo[0]) {
                    case '23503' :
                        Yii::$app->session->setFlash('error', Yii::t('app', 'Es imposible ejecutar la acción de Actualizar o Eliminar sobre este registro, debido a una violación de llave foránea. Este registro forma parte de una referencia en otra entidad.'));

                }
            }

            Yii::info('[The user has updated the visibility status for the record with ID=' . $model->id . ']', 'cttwapp_user');
            // Redirects to show all available Products & Services at the same page.
            return $this->redirect(['article/index', 'page' => $page, 'hash' => '0']);
        } else {
            // 2018-07-27 : If the user is a guest, then he sends an error message. Otherwise it sends a warning message.
            if (Yii::$app->user->getIsGuest()) {
                Yii::$app->session->setFlash('error', Yii::t('app', 'Usted esta tratando de ingresar al sistema de forma no autorizada. Por favor, primero autentifique su acceso.'));
                Yii::error('[Access denied to update an article record]', 'cttwapp_user');
                return $this->redirect(['site/index', 'hash' => '0']);
            }
            Yii::$app->session->setFlash('warning', Yii::t('app', 'Su perfil de acceso no le autoriza a utilizar esta acción. Por favor contacte al administrador del sistema para mayores detalles.'));
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

                    $message = Yii::t('app', 'El registro se ha eliminado exitosamente.');

                    // 2019-03-07 : Try to delete the image file ( .jpg or .png formats ) if it exists
                    if ($this->deleteFile($id, '.jpg') || $this->deleteFile($id, '.png')) {
                        $message = $message . '<br>' . Yii::t('app', 'El archivo de imagen asociado, también se ha eliminado exitosamente.');
                    }

                    Yii::$app->session->setFlash('success', $message);
                }
            } catch (Exception $e) {
                // 2019-03-06 : The next statement is used to display the current error reported by SQLSTATUS : nl2br($e->errorInfo[0].' '.$e->errorInfo[2])
                // The error info provided by a PDO exception. This is the same as returned by PDO::errorInfo.
                switch ($e->errorInfo[0]) {
                    case '23503' :
                        Yii::$app->session->setFlash('error', Yii::t('app', 'Es imposible ejecutar la acción de Actualizar o Eliminar sobre este registro, debido a una violación de llave foránea. Este registro forma parte de una referencia en otra entidad.'));

                }
            }
        } else {
            // 2018-07-27 : If the user is a guest, then he sends an error message. Otherwise it sends a warning message.
            if (Yii::$app->user->getIsGuest()) {
                Yii::$app->session->setFlash('error', Yii::t('app', 'Usted esta tratando de ingresar al sistema de forma no autorizada. Por favor, primero autentifique su acceso.'));
                Yii::error('[Access denied to delete an Article]', 'cttwapp_user');
                return $this->redirect(['site/index', 'hash' => '0']);
            }
            Yii::$app->session->setFlash('warning', Yii::t('app', 'Su perfil de acceso no le autoriza a utilizar esta acción. Por favor contacte al administrador del sistema para mayores detalles.'));
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
            throw new NotFoundHttpException(Yii::t('app','La página solicitada no existe.'));
        }
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
    public function actionGetColumns($view_type)
    {
        // Creates the new dynamic model
        $model_1 = new DynamicModel(['column_0',  'column_1',  'column_2',  'column_3',  'column_4',  'column_5',  'column_6',
                                               'column_7',  'column_8',  'column_9',  'column_10', 'column_11', 'column_12',]);
        // Add the rules to the new dynamic model
        $model_1->addRule(['column_0',  'column_1',  'column_2',  'column_3',  'column_4',  'column_5',  'column_6',
                           'column_7',  'column_8',  'column_9',  'column_10', 'column_11', 'column_12'], 'string', ['max' => 1]);
        // Add the rules to the new dynamic model
        $model_1->addRule(['column_0',  'column_1',  'column_2',  'column_3',  'column_4',  'column_5',  'column_6',
                           'column_7',  'column_8',  'column_9',  'column_10', 'column_11', 'column_12'], 'required'); // The ->validate() can be used here to validate the user input data.

        if ($model_1->load(Yii::$app->request->post())) {
            // Saves all columns visibility status collected through the form.
            return $this->redirect(['article/set-columns',
                                    'article_columns_config' => $model_1->column_0. $model_1->column_1. $model_1->column_2. $model_1->column_3. $model_1->column_4.
                                                                $model_1->column_5. $model_1->column_6. $model_1->column_7. $model_1->column_8. $model_1->column_9.
                                                                $model_1->column_10.$model_1->column_11.$model_1->column_12,
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
    public function actionSetColumns($article_columns_config, $view_type)
    {
        // 2019-01-07 : Refactored
        // $view_type == 0 : article/index view
        // $view_type == 1 : article/index2 view

        if (isset($article_columns_config)){  // If the parameter for columns config has been set, then ...
            // ... creates a new cookie named (article_columns_config / article_columns_config2) and stores the page size value in it.
            $cookie = new Cookie(['name' => 'article_columns_config'.($view_type == 1 ? '2' : ''), 'value' => $article_columns_config, 'expire' => time() + 86400 * 365,]);   // Creates a new cookie and stores the column visibility status in it.
            Yii::$app->getResponse()->getCookies()->add($cookie);
        }

        // Apply and show the newly generated changes.
        return $this->redirect(['article/'.($view_type == 1 ? 'index2' : 'index'), 'page' => '1', 'hash' => '0']);
    }

    /**
     * Gets the article page size.
     * @param string $view_type
     * @return mixed
     *
     * 2018-08-22 20:28 Hrs.
     */
    public function actionGetPageSize($view_type)
    {
        // Creates the new dynamic model
        $model_2 = new DynamicModel(['paginado']);
        // Add the rules to the new dynamic model
        $model_2->addRule(['paginado'], 'integer', ['min' => 1, 'max' => 50, 'tooSmall' => Yii::t('app', 'El valor no debe ser menor a ') . '1.', 'tooBig' => Yii::t('app', 'El valor no debe ser mayor a ') . '50.']);
        // Add the rules to the new dynamic model
        $model_2->addRule(['paginado'], 'required', ['message' => Yii::t('app', 'El valor no puede estar vacío.')]); // The ->validate() can be used here to validate the user input data.

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
    public function actionSetPageSize($page_size_config, $view_type)
    {
        // 2019-01-07 : Refactored
        // $view_type == 0 : article/index view
        // $view_type == 1 : article/index2 view

        if (isset($page_size_config)){  // If the parameter for page size has been set, then ...
            // ... creates a new cookie named (article-pageSize / article-pageSize2) and stores the page size value in it.
            $cookie = new Cookie(['name' => 'article-pageSize'.($view_type == 1 ? '2' : ''), 'value' => $page_size_config, 'expire' => time() + 86400 * 365,]);
            Yii::$app->getResponse()->getCookies()->add($cookie);
        }

        // Applies and displays the newly generated changes.
        return $this->redirect(['article/'.($view_type == 1 ? 'index2' : 'index'), 'page' => '1', 'hash' => '0']);
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
    public function actionPrint($id, $view_type, $page)
    {
        // 2018-08-11 : Only for debug purpose.
        // return $this->render('print_article', ['model' => $this->findModel($id),]);

        if (\Yii::$app->user->can('printArticle')) {
            // 2018-08-28 : Records the article delete operation.
            Yii::info('[The user has printed the article record with ID='.$id.']', 'cttwapp_user');

            // Get your HTML raw content without any layouts or scripts
            $content = $this->renderPartial('print_article', ['model' => $this->findModel($id),]);
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
            // 2018-08-04 : If the user is a guest, then he sends an error message. Otherwise it sends a warning message.
            if (Yii::$app->user->getIsGuest()) {
                Yii::$app->session->setFlash('error', Yii::t('app', 'Usted esta tratando de ingresar al sistema de forma no autorizada. Por favor, primero autentifique su acceso.'));
                Yii::error('[Access denied to print an Article]', 'cttwapp_user');
                return $this->redirect(['site/index', 'hash' => '0']);
            }
            Yii::$app->session->setFlash('warning', Yii::t('app', 'Su perfil de acceso no le autoriza a utilizar esta acción. Por favor contacte al administrador del sistema para mayores detalles.'));
            Yii::warning('[Unauthorized access profile to print an Article]', 'cttwapp_user');
        }

        // Redirect to the index page, according to the $view_type parameter.
        return $this->redirect(['article/'.($view_type == 1 ? 'index2' : 'index'), 'page' => $page, 'hash' => '0']);
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
}
