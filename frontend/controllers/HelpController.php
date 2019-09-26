<?php

namespace frontend\controllers;

use Yii;
use yii\web\Controller;

/**
 * 2018-06-06 : HelpController implements the actions to manager the cttwapp system help.
 */
class HelpController extends Controller
{
    /**
     * Displays the requested theme in help page pass to it the return url and hash.
     * @param string $theme
     * @param string $ret_url
     * @param string $ret_hash
     */
    public function actionView($theme, $ret_url, $ret_hash)
    {
        if (\Yii::$app->user->can('viewHelp')) {
            // 2018-10-30 : Records the access to Help module.
            Yii::info("[The user get access to the Help Theme : $theme]", 'cttwapp_user');
            return $this->render('view_help'.$theme, ['ret_url' => $ret_url, 'ret_hash' => $ret_hash]);
        }
        else {
            // 2018-07-27 : If the user is a guest, then sends an error message to him. Otherwise it sends a warning message.
            if (Yii::$app->user->getIsGuest()) {
                Yii::$app->session->setFlash('error', Yii::t('app', 'Usted esta tratando de ingresar al sistema de forma no autorizada. Por favor, primero autentifique su acceso').'.');
                return $this->redirect(['site/index', 'hash' => '0']);
            }
            Yii::$app->session->setFlash('warning', Yii::t('app', 'Su perfil de acceso no le autoriza a utilizar esta acción. Por favor contacte al administrador del sistema para mayores detalles').'.');
        }
        return $this->redirect([$ret_url, 'hash' => $ret_hash]);
    }

    /**
     * Displays the requested info in a help page.
     * @param string $topic
     */
    public function actionInfo($topic)
    {
       return $this->render('view_help'.$topic);
    }
}