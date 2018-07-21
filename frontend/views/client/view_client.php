<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\DetailView;

/* 2018-03-17 : Used to display Description Type for the actual client record */
use yii\helpers\ArrayHelper;
use app\models\ClientType;

/* @var $this yii\web\View */
/* @var $model app\models\Client */

// 2018-06-09 : If the user isn't authenticated, then redirect him to the login form.
if (Yii::$app->user->getIsGuest()){
    Yii::$app->session->setFlash('error', Yii::t('app', 'Usted esta tratando de ingresar al sistema de forma no autorizada. Por favor, primero autentifique su acceso.'));
    Yii::$app->response->redirect(Url::to(['site/login'], true));
    return;
}

$this->title = 'Cliente';
$description = 'Vista del Cliente';

$asset = \frontend\assets\AppAsset::register($this);
$baseUrl = $asset->baseUrl;

// 2018-06-05 : If there is a page parameter, then stores and validate it.
// Verifies and validate the current page value.
$ret_page = Yii::$app->getRequest()->getQueryParam('page');
$ret_page = (empty($ret_page)?'1':$ret_page);

?>

<!-- Blue ribbon decoration -->
<section class="ctt-section bg-primary">
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
            <?= Html::a(Yii::t('app','R e g r e s a r'), ['client/index', 'page' => $ret_page, 'hash' => '0'], ['class' => 'btn btn-dark btn-ctt-fixed-width', 'title' => Yii::t('app', 'Regresar al nivel anterior')]) ?>
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

            <!-- Business logic for view a client -->
            <div class="client-update">

                <p>
                    <?= Html::a(Yii::t('app','Actualizar'), ['update', 'id' => $model->id, 'page' => $ret_page], ['class' => 'btn btn-primary btn-ctt-fixed-width']) ?>
                    <?= Html::a(Yii::t('app','Eliminar'), ['delete', 'id' => $model->id, 'page' => $ret_page],   ['class' => 'btn btn-danger btn-ctt-fixed-width',
                        'data' => [
                            // 2018-05-28 : Adds to the modal title the row id, like a warning information.
                            'message' => Yii::t('app', '¿ Está seguro de eliminar este elemento ?').'  :  '.($model->id),
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
                        'id',
                        'rfc',
                        'curp',

                        // 2018-04-23 : For taxpayer type, the right legend is displayed and colored properly.

                        [
                          'attribute' => 'taxpayer',
                          'value' => function($model){
                              return ($model->taxpayer=='M'?'PERSONA MORAL':'PERSONA FÍSICA');
                          },
                          'contentOptions' => function ($model, $key, $index, $column) {
                              return ['style' => 'color:'. ($model->taxpayer=='M'?'grey':'#428bca')];
                          },
                        ],

                        // 2018-04-10 : New fields add to client table in refactoring action.

                        'business_name',
                        'corporate',

                        // 2018-04-23 : For provenance type, the right legend is displayed.

                        [
                          'attribute' => 'provenance',
                          'value' => function($model){
                              return ($model->provenance=='N'?'NACIONAL':'EXTRANJERO');
                          },
                        ],

                        'contact_name',
                        'contact_email',
                        'street',
                        'outdoor_number',
                        'interior_number',
                        'suburb',
                        'municipality',
                        'delegation',
                        'state',
                        'zip_code',
                        'phone_number_1',
                        'phone_number_2',
                        'web_page',
                        'client_email',

                        'created_at',
                        'updated_at',
                        'created_by',
                        'updated_by',

                        // 2018-03-17 : Modified to display the ID and the Client Type Description instead of the ID only.

                        [
                          'attribute' => 'client_type_id',
                          'value' => implode(",",ArrayHelper::map(ClientType::find()->where(['id' => $model->client_type_id])->all(),'id','displayTypeDesc')),
                        ],
                     ],
                ]); ?>

            </div>
        </div>
    </div>
</section>

<!-- Includes the actions view's footer file -->
<?php include(Yii::getAlias('@app').'/views/layouts/cttwapp_views_actions_footer.inc'); ?>

<!-- Includes the modal window to confirm the delete operation-->
<?php include(Yii::getAlias('@app').'/views/layouts/cttwapp_views_confirm_delete.inc'); ?>