<?php

namespace frontend\controllers;

use Yii;
use app\models\Catalog;
use app\models\CatalogSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * HelpController implements the actions to manager the cttwapp system help.
 */
class HelpController extends Controller
{
    /**
     * Displays a single help page.
     * @param string $theme
     * @param string $url
     */
    public function actionView($theme, $url)
    {
        if (\Yii::$app->user->can('viewHelp')) {
            return $this->render('view_help'.$theme, ['url' => $url]);
        }
        else {
            Yii::$app->session->setFlash('error', Yii::t('app', 'Su perfil de acceso no le autoriza a utilizar esta acción. Por favor contacte al administrador del sistema para mayores detalles.'));
        }
        return $this->redirect([$url]);
    }

}
