<?php

namespace frontend\controllers;

use Yii;
use app\models\Article;
use app\models\ArticleSearch;
use yii\web\Controller;
use yii\helpers\Url;
use yii\web\NotFoundHttpException;
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
            throw new NotFoundHttpException(Yii::t('app','La página solicitada no existe.'));
        }
    }

    /**
     * Switch and stores the article colored status in a cookie.
     * @param string $color
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     *
     * 2018-05-14 22:31 Hrs.
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

    /**
     * Generates a PDF file with the data of an article in printable version.
     * @param string $id
     * @param string $page
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     *
     * 2018-08-04 14:40 Hrs.
     */
    public function actionPrint($id, $page)
    {
        // 2018-08-11 : Only for debug purpose.
        // return $this->render('print_article', ['model' => $this->findModel($id),]);

        if (\Yii::$app->user->can('printArticle')) {
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

            // Set mPDF properties on the fly

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
        return $this->redirect(['article/index', 'page' => $page, 'hash' => '0']);
    }

    /**
     * Sets and stores each article column visibility status in cookies.
     * @param string $c1,$c2,$c3,$c4,$c5,$c6,$c7,$c8,$c9,$c10,$c11,$c12,$c13
     * @return mixed
     *
     * 2018-08-20 16:43 Hrs.
     */
    public function actionSetColumns($c1,$c2,$c3,$c4,$c5,$c6,$c7,$c8,$c9,$c10,$c11,$c12,$c13)
    {
        if (isset($c1)){  // If the parameter for column 1 has been set, then ....
            $cookie = new \yii\web\Cookie(['name' => 'article-c1', 'value' => $c1]);   // Creates a new cookie and stores the column visibility status in it.
            Yii::$app->getResponse()->getCookies()->add($cookie);
        }

        if (isset($c2)){  // If the parameter for column 2 has been set, then ....
            $cookie = new \yii\web\Cookie(['name' => 'article-c2', 'value' => $c2]);   // Creates a new cookie and stores the column visibility status in it.
            Yii::$app->getResponse()->getCookies()->add($cookie);
        }

        if (isset($c3)){  // If the parameter for column 3 has been set, then ....
            $cookie = new \yii\web\Cookie(['name' => 'article-c3', 'value' => $c3]);   // Creates a new cookie and stores the column visibility status in it.
            Yii::$app->getResponse()->getCookies()->add($cookie);
        }

        if (isset($c4)){  // If the parameter for column 4 has been set, then ....
            $cookie = new \yii\web\Cookie(['name' => 'article-c4', 'value' => $c4]);   // Creates a new cookie and stores the column visibility status in it.
            Yii::$app->getResponse()->getCookies()->add($cookie);
        }

        if (isset($c5)){  // If the parameter for column 5 has been set, then ....
            $cookie = new \yii\web\Cookie(['name' => 'article-c5', 'value' => $c5]);   // Creates a new cookie and stores the column visibility status in it.
            Yii::$app->getResponse()->getCookies()->add($cookie);
        }

        if (isset($c6)){  // If the parameter for column 6 has been set, then ....
            $cookie = new \yii\web\Cookie(['name' => 'article-c6', 'value' => $c6]);   // Creates a new cookie and stores the column visibility status in it.
            Yii::$app->getResponse()->getCookies()->add($cookie);
        }

        if (isset($c7)){  // If the parameter for column 7 has been set, then ....
            $cookie = new \yii\web\Cookie(['name' => 'article-c7', 'value' => $c7]);   // Creates a new cookie and stores the column visibility status in it.
            Yii::$app->getResponse()->getCookies()->add($cookie);
        }

        if (isset($c8)){  // If the parameter for column 8 has been set, then ....
            $cookie = new \yii\web\Cookie(['name' => 'article-c8', 'value' => $c8]);   // Creates a new cookie and stores the column visibility status in it.
            Yii::$app->getResponse()->getCookies()->add($cookie);
        }

        if (isset($c9)){  // If the parameter for column 9 has been set, then ....
            $cookie = new \yii\web\Cookie(['name' => 'article-c9', 'value' => $c9]);   // Creates a new cookie and stores the column visibility status in it.
            Yii::$app->getResponse()->getCookies()->add($cookie);
        }

        if (isset($c10)){  // If the parameter for column 10 has been set, then ....
            $cookie = new \yii\web\Cookie(['name' => 'article-c10', 'value' => $c10]);  // Creates a new cookie and stores the column visibility status in it.
            Yii::$app->getResponse()->getCookies()->add($cookie);
        }

        if (isset($c11)){  // If the parameter for column 11 has been set, then ....
            $cookie = new \yii\web\Cookie(['name' => 'article-c11', 'value' => $c11]);  // Creates a new cookie and stores the column visibility status in it.
            Yii::$app->getResponse()->getCookies()->add($cookie);
        }

        if (isset($c12)){  // If the parameter for column 12 has been set, then ....
            $cookie = new \yii\web\Cookie(['name' => 'article-c12', 'value' => $c12]);  // Creates a new cookie and stores the column visibility status in it.
            Yii::$app->getResponse()->getCookies()->add($cookie);
        }

        if (isset($c13)){  // If the parameter for column 13 has been set, then ....
            $cookie = new \yii\web\Cookie(['name' => 'article-c13', 'value' => $c13]);  // Creates a new cookie and stores the column visibility status in it.
            Yii::$app->getResponse()->getCookies()->add($cookie);
        }

        // Apply and show the newly generated changes.
        return $this->redirect(['article/index', 'page' => '1', 'hash' => '0']);
    }

    /**
     * Shows the Column-Selector and sets the article columns visibility status.
     * @return mixed
     *
     * 2018-08-20 16:50 Hrs.
     */
    public function actionSelectColumns(){

        // Creates the new dynamic model
        $model_1 = new \yii\base\DynamicModel(['column_1', 'column_2', 'column_3',  'column_4',  'column_5',  'column_6', 'column_7',
                                               'column_8', 'column_9', 'column_10', 'column_11', 'column_12', 'column_13']);
        // Add the rules to the new dynamic model
        $model_1->addRule(['column_1', 'column_2', 'column_3',  'column_4',  'column_5',  'column_6', 'column_7',
                           'column_8', 'column_9', 'column_10', 'column_11', 'column_12', 'column_13'], 'string', ['max' => 1]);
        // Add the rules to the new dynamic model
        $model_1->addRule(['column_1', 'column_2', 'column_3',  'column_4',  'column_5',  'column_6', 'column_7',
                           'column_8', 'column_9', 'column_10', 'column_11', 'column_12', 'column_13'], 'required'); // The ->validate() can be used her to validate the user input data.

        if ($model_1->load(Yii::$app->request->post())) {
            // Saves all columns visibility status collected through the form.
            return $this->redirect(['article/set-columns',
                                    'c1'  => $model_1->column_1, 'c2' => $model_1->column_2, 'c3' => $model_1->column_3, 'c4' => $model_1->column_4, 'c5'  => $model_1->column_5,
                                    'c6'  => $model_1->column_6, 'c7' => $model_1->column_7, 'c8' => $model_1->column_8, 'c9' => $model_1->column_9, 'c10' => $model_1->column_10,
                                    'c11' => $model_1->column_11,'c12'=> $model_1->column_12,'c13'=> $model_1->column_13,
            ]);
        }

        // Shows the Column-Selector view and pass to this the new model.
        return $this->render('select_article_columns',['model_1' => $model_1]);
    }

    /**
     * Gets the article page size.
     * @return mixed
     *
     * 2018-08-22 20:28 Hrs.
     */
    public function actionGetPageSize(){

        // Creates the new dynamic model
        $model_2 = new \yii\base\DynamicModel(['pageSizeValue']);
        // Add the rules to the new dynamic model
        $model_2->addRule(['pageSizeValue'], 'integer', ['min' => 1, 'max' => 50]);
        // Add the rules to the new dynamic model
        $model_2->addRule(['pageSizeValue'], 'required'); // The ->validate() can be used her to validate the user input data.

        if ($model_2->load(Yii::$app->request->post())) {
            // Saves the page size value collected through the form.
            return $this->redirect(['article/set-page-size',
                'pageSize' => $model_2->pageSizeValue,
            ]);
        }

        // Apply and show the newly generated changes.
        return $this->render('set_article_page_size', ['model_2' => $model_2]);
    }

    /**
     * Sets and stores the article page size.
     * @param string $pageSize
     * @return mixed
     *
     * 2018-08-22 22:55 Hrs.
     */
    public function actionSetPageSize($pageSize)
    {
        if (isset($pageSize)){  // If the parameter for page size has been set, then ....
            $cookie = new \yii\web\Cookie(['name' => 'article-pageSize', 'value' => $pageSize, 'expire' => time() + 86400 * 365,]);   // Creates a new cookie and stores the page size value in it.
            Yii::$app->getResponse()->getCookies()->add($cookie);
        }

        // Apply and show the newly generated changes.
        return $this->redirect(['article/index', 'page' => '1', 'hash' => '0']);
    }

}
