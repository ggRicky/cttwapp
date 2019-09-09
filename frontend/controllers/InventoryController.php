<?php
/**
 * Created by PhpStorm.
 * User: ricardo
 * Date: 20/02/19
 * Time: 10:01 AM
 */

namespace frontend\controllers;
use Yii;
use yii\web\Controller;
use yii\filters\VerbFilter;

/**
 * InventoryController implements the CRUD actions for Inventory model.
 */

class InventoryController extends Controller
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
     * Lists all Inventory options.
     * @return mixed
     */
    public function actionIndex()
    {
        if (\Yii::$app->user->can('listInventory')) {
            // 2018-08-28 : Records the access to Article module.
            Yii::info('[The user gets access to the Inventory Module]', 'cttwapp_user');

            return $this->render('index_inventory');
        }
        else {
            // 2018-07-26 : If the user is a guest, then sends an error message to him. Otherwise it sends a warning message.
            if (Yii::$app->user->getIsGuest()) {
                Yii::$app->session->setFlash('error', Yii::t('app', 'Usted esta tratando de ingresar al sistema de forma no autorizada. Por favor, primero autentifique su acceso.'));
                Yii::error('[Access denied to the Inventory Module]', 'cttwapp_user');
            }
            else {
                Yii::$app->session->setFlash('warning', Yii::t('app', 'Su perfil de acceso no le autoriza a utilizar esta acción. Por favor contacte al administrador del sistema para mayores detalles.'));
                Yii::warning('[Unauthorized access profile to the Inventory Module]', 'cttwapp_user');
            }
        }
        return $this->redirect(['site/index', 'hash' => '0']);
    }


}