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
            throw new NotFoundHttpException( Yii::t('app','La página solicitada no existe.'));
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
                'cssInline' => '.kv-heading-1{font-size:22px; color: #15598c} .kv-heading-2{font-size:10px; color:red; letter-spacing: 3px}',
                // Call mPDF methods on the fly
                'methods' => [
                    'SetHeader'=>[Yii::t('app', 'Detalles')],
                    'SetFooter'=>['{PAGENO}'],
                ]
            ]);

            // Set mPDF properties on the fly

            // Directly use the mPDF api for various other mPDF manipulations
            // Fetches mPDF API
            $mpdf = $pdf->api;

            // Call methods or set any properties
            $mpdf->SetTitle('Informacion del Articulo');
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
}
