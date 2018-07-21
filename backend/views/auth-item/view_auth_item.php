<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\AuthItem */

// 2018-06-21 : If the user isn't authenticated, then redirect him to the login form.
if (Yii::$app->user->getIsGuest()){
    Yii::$app->session->setFlash('error', Yii::t('app', 'Usted esta tratando de ingresar al sistema de forma no autorizada. Por favor, primero autentifique su acceso.'));
    Yii::$app->response->redirect(Url::to(['site/login'], true));
    return;
}

$this->title = 'Objeto de Autorización';
$description = 'Vista de un Objeto de Autorización';

$asset = \frontend\assets\AppAsset::register($this);
$baseUrl = $asset->baseUrl;

// 2018-06-21 : If there is a page parameter, then stores and validate it.
// Verifies and validate the current page value.
$ret_page = Yii::$app->getRequest()->getQueryParam('page');
$ret_page = (empty($ret_page)?'1':$ret_page);

?>

<!-- Blue ribbon decoration -->
<section class="ctt-section bg-secondary">
    <div class="col-lg-12">
        <div id="work-view-area" class="row">
            <!-- CTT water mark background logo decoration -->
            <div class="ctt-water-mark"></div>
        </div>
    </div>
</section>

<!-- Yii2 Content -->
<section id="yii2" class="yii2-page">

    <!-- Main menu return -->
    <div class="row">
        <div class="col-lg-10 col-lg-offset-1 text-center">
            <?= Html::a(Yii::t('app','R e g r e s a r'), ['auth-item/index', 'page' => $ret_page, 'hash' => '0'], ['class' => 'btn btn-dark btn-ctt-fixed-width', 'title' => Yii::t('app', 'Regresar al nivel anterior')]) ?>
        </div>
    </div>

    <!-- Yii2 Title layout -->
    <div class="row">
        <div class="col-lg-10 yii2-header">
            <p><?= Yii::t('app',Html::encode($this->title)); ?></p>
        </div>
    </div>

    <!-- Yii2 complementary description -->
    <div class="row">
        <div class="col-lg-10 text-info yii2-description">
            <p><?= Yii::t('app',Html::encode($description));?></p>
        </div>
    </div>

    <!-- Yii2 work area -->
    <div class="row">
        <div class="col-lg-12 text-justify yii2-content">

            <!-- Business logic for view an auth item -->
            <div class="auth-item-view">

                <p>
                    <?= Html::a(Yii::t('app','Actualizar'), ['update', 'id' => $model->name], ['class' => 'btn btn-primary btn-ctt-fixed-width']) ?>
                    <?= Html::a(Yii::t('app','Eliminar'), ['delete', 'id' => $model->name],   ['class' => 'btn btn-danger btn-ctt-fixed-width',
                        'data' => [
                            // 2018-05-28 : Adds to the modal title the row id, like a warning information.
                            'message' => Yii::t('app', '¿ Está seguro de eliminar este elemento ?').'  :  '.($model->name),
                        ],
                        // 2018-05-31 : Important : The 'data-confirm' parameter must be there, because it trigger a modal confirmation window before run the action delete.
                        // In the same way, through this parameter can be pass the user's message to the overwritten function yii.confirm, located in the cttwapp-stylish.css file.
                        // An other way to send the user's message to the overwritten function yii.confirm, is through a data array, like showed above.
                        // In this case the 'data-confirm' parameter must be empty.
                        'data-confirm' => '',
                        //  2018-05-31 : The next two parameters are needed to complete teh right call to the action delete, because it will be made using the post method.
                        'data-method' => 'post',
                        'data-pjax' => '0',
                    ]) ?>
                </p>

                <?= DetailView::widget([
                    'model' => $model,
                    'attributes' => [
                        'name',
                        'type',
                        'description:ntext',
                        'rule_name',
                        'data',

                        // 2018-05-27 : For created_at, updated_at, convert the timestamp to date properly.

                        [
                            'attribute' => 'created_at',
                            'value' => function($model){
                                return (date('Y-m-d G:i:s', $model->created_at));
                            },
                        ],
                        [
                            'attribute' => 'updated_at',
                            'value' => function($model){
                                return (date('Y-m-d G:i:s', $model->updated_at));
                            },
                        ],

                    ],
                ]); ?>

            </div>
        </div>
    </div>
</section>

<!-- Includes the actions view's footer file -->
<?php include(Yii::getAlias('@app').'/views/layouts/cttwapp_views_actions_footer_bke.inc'); ?>

<!-- Includes the modal window to confirm the delete operation-->
<?php include(Yii::getAlias('@app').'/views/layouts/cttwapp_views_confirm_delete_bke.inc'); ?>
