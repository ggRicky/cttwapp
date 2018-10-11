<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel app\models\ClientTypeSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $qryParams */

$this->title = 'Tipos de Clientes';
$description = 'Listado Nominal';

$asset = \frontend\assets\AppAsset::register($this);
$baseUrl = $asset->baseUrl;

// 2018-06-07 : Stores a return url parameter.
$ret_url_param = Yii::$app->getRequest()->getQueryParam('ret_url');
// 2018-06-07 : Stores a return hash parameter.
$ret_hash_param = Yii::$app->getRequest()->getQueryParam('ret_hash');
// 2018-06-07 : Stores a page parameter to return to it.
$ret_page = Yii::$app->getRequest()->getQueryParam('ret_page');
// 2018-06-07 : If there is a page parameter, then stores and validate it.
// Verifies and validate the current page value.
$ret_page = (empty($ret_page)?'1':$ret_page);

// 2018-06-07 : Stores a hash parameter to jump to the requested area.
$hash_param = Yii::$app->getRequest()->getQueryParam('hash');
// 2018-06-07 : Translates the $hash_param value to the corresponding anchor to jump.
// $hash_param [ 0 - Jumps to the work area index  1 - Jumps to the panel area ]
$hash_param = ($hash_param=='0'?'work-area-index':($hash_param=='1'?'panel-area':null));

// 2018-06-05 : If there is a page parameter, then stores and validate it.
// Verifies and validate the current page value.
$curr_page = Yii::$app->getRequest()->getQueryParam('page');
$curr_page = (empty($curr_page)?'1':$curr_page);

// 2018-06-07 : if an anchor parameter was send, then jumps to it using javascript.
if  ($hash_param) {
    $script = <<< JS
    location.hash = "#$hash_param";
JS;
    $this->registerJs($script);
}

//2018-04-26 : Used to get a random int, and display a random parallax.
$randomBg = rand(1,11);;

?>

<!-- Includes Navigation Bar -->
<?php include(Yii::getAlias('@app').'/views/layouts/cttwapp_views_menu_navbar.inc'); ?>

<!-- Header -->
<header id="top">
    <div class="row"> <!-- Bootstrap's row -->
        <div class="col-lg-12"> <!-- Bootstrap's col -->
            <!-- CTT logo to display over the parallax effect with opacity level -->
            <img src="<?=$baseUrl?>/img/ctt-logo_1.png" class="ctt-logo">
            <!-- Parallax Efect -->
            <div id="parallax<?=$randomBg?>" class="parallax-section" data-stellar-background-ratio="0.5">
                <div class="row"></div>
            </div>
        </div>
    </div>
</header>

<!-- Blue ribbon decoration -->
<section class="ctt-section bg-primary">
    <div class="col-lg-12">
        <div id="work-area-index" class="row">
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
            <?= Html::a(Yii::t('app','R e g r e s a r'), Url::to(['client/index', 'page' => '1', 'hash' => '0']), ['target' => '_self', 'class' => 'btn btn-dark btn-ctt-fixed-width', 'data-toggle' => 'tooltip', 'title' => Yii::t('app', 'Regresar al nivel anterior')]) ?>
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

            <!-- 2018-05-23 : If there is an flash message, then display it.-->
            <?php if (Yii::$app->session->hasFlash('warning')): ?>
                <div id="auto-close" class="alert alert-warning alert-dismissible fade in">
                    <a href="#" class="close" data-dismiss="alert" data-toggle="tooltip" aria-label="close" title="<?= Yii::t('app','Cerrar') ?>">&times;</a>
                    <h4><strong>¡ <?= Yii::t('app','Advertencia'); ?> !</strong></h4>
                    <p><?= Yii::$app->session->getFlash('warning') ?></p>
                </div>
            <!-- 2018-05-25 : Flash success message. -->
            <?php elseif (Yii::$app->session->hasFlash('success')): ?>
                <div id="auto-close" class="alert alert-success alert-dismissible fade in">
                    <a href="#" class="close" data-dismiss="alert" data-toggle="tooltip" aria-label="close" title="<?= Yii::t('app','Cerrar') ?>">&times;</a>
                    <h4><strong>¡ <?= Yii::t('app','Información'); ?> !</strong></h4>
                    <p><?= Yii::$app->session->getFlash('success') ?></p>
                </div>
            <?php endif; ?>

            <!-- 2018-05-28 : Begin the ajax functionality to refresh only the GridView widget contents. -->
            <?php Pjax::begin(); ?>

                <p>
                    <?= Html::a(Yii::t('app', 'Crear Nuevo Tipo de Cliente'), ['create', 'page'=>$curr_page], ['class' => 'btn btn-success', 'data-toggle' => 'tooltip', 'title' => Yii::t('app', 'Crear un nuevo registro de tipo de cliente')]) ?>
                </p>

                <!-- 2018-04-13 : The next div including the id and class elements, enable the vertical and horizontal scrollbars. -->
                <div id="div-scroll" class="div-scroll-area-horizon">

                    <?= GridView::widget([
                        'dataProvider' => $dataProvider,
                        'filterModel' => $searchModel,
                        'columns' => [
                            [
                                'class' => 'yii\grid\ActionColumn',
                                'headerOptions' => ['style' => 'width:5%'],
                                'template' => '{view} {update} {delete}',
                                'buttons' => [
                                    // 2018-05-27 : Adds the title property to show the right tooltip when mouse is hover the glyphicon.
                                    'view' => function ($url) {
                                        return Html::a('<span class="glyphicon glyphicon-eye-open"></span>', $url, [
                                            'data-toggle' => 'tooltip',
                                            'title' => Yii::t('app', 'Ver'),           // 2018-05-28 : Adds the tooltip View
                                        ]);
                                    },
                                    // 2018-05-27 : Adds the title property to show the right tooltip when mouse is hover the glyphicon.
                                    'update' => function ($url) {
                                        return Html::a('<span class="glyphicon glyphicon-pencil"></span>', $url, [
                                            'data-toggle' => 'tooltip',
                                            'title' => Yii::t('app', 'Actualizar') ,     // 2018-05-28 : Adds the tooltip Modify
                                        ]);
                                    },
                                    // 2018-05-29 : Adds a new delete action to customize the window modal alert.
                                    'delete' => function($url, $model) {
                                        return Html::a('<span class="glyphicon glyphicon-trash"></span>', $url,
                                            [
                                                'data-toggle' => 'tooltip',
                                                'title'       => Yii::t('app', 'Eliminar'),   // 2018-05-28 : Adds the tooltip Delete
                                                'style'       => 'color:#337ab7, ',                            // 2018-05-28 : Display the glyphicon-trash in red color like a warning signal.
                                                'onMouseOver' => 'this.style.color=\'#f00\'',                  // 2018-06-06 : When mouse is hover on the link, the color changes
                                                'onMouseOut'  => 'this.style.color=\'#337ab7\'',               //              to red advising danger in delete operation.
                                                // 2018-05-31 : A data set may be send like parameters to the overwritten function yii.confirm. And in the function, the data may be retrieved
                                                // and displayed in the modal window.
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
                                            ]);
                                    },
                                ],
                                // 2018-05-28 : Adds an url that include the current page in GridView widget.
                                'urlCreator' => function ($action, $model)  use ($dataProvider) {
                                    if ($action === 'delete') {
                                        $url = Url::to(['client-type/delete', 'id' => $model->id, 'page' => ($dataProvider->pagination->page + 1)]);
                                    }
                                    elseif ($action === 'view') {
                                        $url = Url::to(['client-type/view', 'id' => $model->id, 'page' => ($dataProvider->pagination->page + 1)]);
                                    }
                                    elseif ($action === 'update') {
                                        $url = Url::to(['client-type/update', 'id' => $model->id, 'page' => ($dataProvider->pagination->page + 1)]);
                                    }
                                    else $url = null;

                                    // 2018-05-29 : If null value is returned, the url created have only home page address plus &page parameter. The right value is return $url.
                                    return $url;
                                }
                            ],

                            [
                                'class' => 'yii\grid\SerialColumn',
                                'headerOptions' => ['style' => 'width:5%'],
                            ],

                            [
                                'attribute' => 'id',
                                'headerOptions' => ['style' => 'width:5%'],
                            ],

                            [
                                'attribute' => 'type_desc',
                                'headerOptions' => ['style' => 'width:85%'],
                            ],
                        ],

                        'layout' => '{summary}{items}{pager}',
                    ]);?>

                </div>

            <!-- 2018-05-28 : Ends the ajax functionality to refresh only the GridView widget contents. -->
            <?php Pjax::end(); ?>

            <br/>

            <!-- 2018-06-03 : Toolbox -->
            <div class="panel panel-default">
                <div class="panel-heading"><span data-toggle="tooltip" title="<?=  Yii::t('app', 'Panel de Herramientas') ?>"><button class="btn btn-light" data-toggle="collapse" data-target="#tools"><span class="text-info"><?= Yii::t('app', 'Herramientas') ?></span>&nbsp;&nbsp;<span><i class="fa fa-refresh fa-spin fa-1x fa-fw text-info"></i></span></button></span></div>
                <div id="tools" class="panel-collapse collapse">
                    <div class="panel-body">
                        <!-- Help Tool -->
                        <span>
                           <?php
                               echo Html::a('', ['help/view', 'theme' => '_client_type', 'ret_url' => 'client-type/index', 'ret_hash' => '0' ], ['class' => 'btn glyphicon glyphicon-question-sign', 'data-toggle' => 'tooltip', 'title' => Yii::t('app', 'Ayuda')]);
                               echo '<span>'.Yii::t('app', 'Ayuda').'</span>';
                           ?>
                       </span>
                    </div>
                </div>
            </div>

            <div class="well well-sm text-info"><span><?= Yii::t('app', 'IMPORTANTE : La información que se muestra en la relación, corresponde a datos experimentales de prueba.');?></span></div>

        </div>
    </div>
</section>

<!-- Includes the view's footer file -->
<?php include(Yii::getAlias('@app').'/views/layouts/cttwapp_views_footer.inc'); ?>

<!-- Includes the modal window to confirm the delete operation-->
<?php include(Yii::getAlias('@app').'/views/layouts/cttwapp_views_confirm_delete.inc'); ?>