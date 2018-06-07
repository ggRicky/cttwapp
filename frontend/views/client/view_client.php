<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* 2018-03-17 : Used to display Description Type for the actual client record */
use yii\helpers\ArrayHelper;
use app\models\ClientType;

/* @var $this yii\web\View */
/* @var $model app\models\Client */

$this->title = 'Cliente';
$asset = \frontend\assets\AppAsset::register($this);
$baseUrl = $asset->baseUrl;

// 2018-06-05 : If there is a page parameter, then stores and validate it.
// Verifies and validate the current page value.
$curr_page = Yii::$app->getRequest()->getQueryParam('page');
$curr_page = (empty($curr_page)?'1':$curr_page);

// 2018-05-07 : If there is an flash message, then skip the header and go to the error-area using javascript.
If (Yii::$app->session->hasFlash('error'))
{
    $script = <<< JS
    location.hash = "#work-area-view";
JS;
    $this->registerJs($script);
}

?>

<!-- Blue ribbon decoration -->
<section id="work-area-view" class="ctt-section bg-primary">
    <div class="col-lg-12">
        <div class="row">
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
            <?= Html::a(Yii::t('app','R e g r e s a r'), ['client/index', 'page' => $curr_page, 'ret' => '0'], ['class' => 'btn btn-dark', 'title' => Yii::t('app', 'Regresar al nivel anterior')]) ?>
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
            <p><?= Yii::t('app','Vista del Cliente');?></p>
        </div>
    </div>

    <!-- Yii2 work area -->
    <div class="row">
        <div class="col-lg-12 text-justify yii2-content">

            <!-- Business logic for view a client -->
            <div class="client-update">

                <p>
                    <?= Html::a(Yii::t('app','Actualizar'), ['update', 'id' => $model->id, 'page' => $curr_page], ['class' => 'btn btn-primary']) ?>
                    <?= Html::a(Yii::t('app','Eliminar'), ['delete', 'id' => $model->id, 'page' => $curr_page],   ['class' => 'btn btn-danger',
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

<section>
    <!-- A button for go to the page's top -->
    <div class="col-lg-10 col-lg-offset-1 text-center up-btn-area">
        <div class="tooltip-conf">
            <span class="tooltip-text"><?=Yii::t('app', 'Ir al inicio');?></span>
            <a href="#work-area-view">
                <span class="glyphicon glyphicon-circle-arrow-up"></span>
            </a>
        </div>
    </div>
</section>

<!-- Footer -->
<footer>
    <div class="container">
        <div class="row">
            <div class="col-lg-10 col-lg-offset-1 text-center">
                <!-- CTT mini logo -->
                <div class="col-lg-12">
                    <img src="<?=$baseUrl?>/img/ctt-mini-logo_1.jpg" class="center-block img-responsive" height="42" width="105"/>
                </div>

                <!-- Credits layer -->
                <div class="row">
                    <div class="col-lg-10 col-lg-offset-1 text-center tsr-content">
                        <hr class="small">
                        <p class="text-muted"><?= Yii::t('app','Todos los derechos reservados &copy;') ?> 2017-<?= date("Y"); ?><br/>T S R&nbsp;&nbsp;&nbsp;&nbsp;D e v e l o p m e n t&nbsp;&nbsp;&nbsp;&nbsp;S o f t w a r e</p>
                        <hr class="small">
                        <p class="text-muted"><?= Yii::t('app','Soportado por') ?></p>
                        <hr class="small">
                        <p>
                            <a href="https://www.yiiframework.com/"><img src="<?=$baseUrl?>/img/yii_logo_light.svg" height="30"/></a>
                            <span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
                            <a href="https://www.jetbrains.com/"><img src="<?=$baseUrl?>/img/jetbrains.svg" height="45"/></a>
                            <span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
                            <a href="https://www.jetbrains.com/phpstorm/"><img src="<?=$baseUrl?>/img/phpstorm_logo.svg" height="45"/></a>
                            <span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
                            <a href="https://www.github.com/"><img src="<?=$baseUrl?>/img/github_logo.svg" height="40"/></a>
                            <span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
                            <a href="https://git-scm.com//"><img src="<?=$baseUrl?>/img/git_logo.svg" height="40"/></a>
                            <span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
                            <a href="https://nginx.com//"><img src="<?=$baseUrl?>/img/nginx_logo.svg" height="17"/></a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Blue ribbon footer decoration -->
    <section class="ctt-section bg-primary">
        <div class="col-lg-12">
            <div class="row"></div>
        </div>
    </section>
</footer>

<!-- Modal Question : Used to confirm or cancel the delete action -->
<div id="confirm-delete" tabindex="-1" class="modal fade" role="dialog" data-backdrop="true">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content modal-backdrop">

            <!-- Modal Header -->
            <div class="modal-shadow-effect modal-header-water-mark">
                <div class="modal-header modal-header-config ctt-modal-header-question">
                    <div class="row">
                        <!--
                             ctt-modal-header-info        glyphicon-info-sign
                             ctt-modal-header-success     glyphicon-ok-sign
                             ctt-modal-header-question    glyphicon-question-sign
                             ctt-modal-header-warning     glyphicon-warning-sign
                             ctt-modal-header-error       glyphicon-exclamation-sign
                        -->
                        <div class="col-sm-1"><span class="glyphicon glyphicon-question-sign"></span></div>
                        <div class="col-sm-7"><h4 class="modal-title"><?= Yii::t('app','Pregunta') ?></h4></div>
                        <div class="col-sm-4"><button type="button" class="close" data-dismiss="modal">&times;</button></div>
                    </div>
                </div>

                <!-- Modal Content -->
                <div id="content-body" class="modal-body modal-body-config"></div>

                <!-- Modal Footer -->
                <div class="modal-footer modal-footer-config">
                    <div class="row">
                        <div class="col-sm-6"><img align="left" src="<?=$baseUrl?>/img/ctt-mini-logo_1.jpg" height="42" width="105"/></div>
                        <div class="col-sm-6">
                            <button type="button" class="btn btn-default" data-dismiss="modal" title="[ Esc ] - <?= Yii::t('app','Descarta la operación') ?>"><?= Yii::t('app','Cancelar') ?></button>
                            <button id="delete-ok" type="button" class="btn btn-danger btn-ok" title="<?= Yii::t('app','Procede la operación') ?>"><?= Yii::t('app','Aceptar') ?></button>
                        </div>
                    </div>
                </div>

                <!-- Modal Header -->
            </div>

            <!-- Modal content-->
        </div>

    </div>
</div>