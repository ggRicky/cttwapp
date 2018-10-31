<?php
namespace backend\controllers;

use yii\web\Controller;

/**
 * Logs controller
 */
class LogsController extends Controller
{

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        // 2018-10-29 : Yii2 Rbac - Validates the access to the main page.
        if (\Yii::$app->user->can('accessMain')) {
            return $this->render('index_logs');
        }

        return $this->redirect(['site/login']);
    }

}