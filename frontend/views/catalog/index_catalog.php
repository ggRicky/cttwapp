<?php

use yii\helpers\Html;
use yii\widgets\Pjax;
use yii\helpers\Url;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\CatalogSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Catálogos';
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

// 2018-06-05 : if an anchor parameter was send, then jumps to it using javascript.
if ($hash_param) {
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
            <?= Html::a(Yii::t('app','R e g r e s a r'), ['site/index'], ['target' => '_self', 'class' => 'btn btn-dark btn-ctt-fixed-width', 'data-toggle' => 'tooltip', 'title' => Yii::t('app', 'Regresar al nivel anterior')]) ?>
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

            <!-- Flash messages area -->

            <!-- 2019-03-05 : Flash error message. No auto closable  -->
            <?php if (Yii::$app->session->hasFlash('error')): ?>
                <div class="alert alert-error alert-dismissible fade in slow-close">
                    <a href="#" class="close link-close" data-toggle="tooltip" aria-label="close" title="<?= Yii::t('app','Cerrar') ?>">&times;</a>
                    <h4><strong>¡ <?= Yii::t('app','Error'); ?> !</strong></h4>
                    <p><?= Yii::$app->session->getFlash('error') ?></p>
                </div>
            <?php endif; ?>

            <!-- 2018-05-24 : Flash warning message. Auto closable -->
            <?php if (Yii::$app->session->hasFlash('warning')): ?>
                <div id="auto-close" class="alert alert-warning alert-dismissible fade in">
                    <a href="#" class="close" data-dismiss="alert" data-toggle="tooltip" aria-label="close" title="<?= Yii::t('app','Cerrar') ?>">&times;</a>
                    <h4><strong>¡ <?= Yii::t('app','Advertencia'); ?> !</strong></h4>
                    <p><?= Yii::$app->session->getFlash('warning') ?></p>
                </div>
            <?php endif; ?>

            <!-- 2018-05-25 : Flash success message. Auto closable -->
            <?php if (Yii::$app->session->hasFlash('success')): ?>
                <div id="auto-close" class="alert alert-success alert-dismissible fade in">
                    <a href="#" class="close" data-dismiss="alert" data-toggle="tooltip" aria-label="close" title="<?= Yii::t('app','Cerrar') ?>">&times;</a>
                    <h4><strong>¡ <?= Yii::t('app','Información'); ?> !</strong></h4>
                    <p><?= Yii::$app->session->getFlash('success') ?></p>
                </div>
            <?php endif; ?>

            <!-- 2018-06-13 : Begin the ajax functionality to refresh only the GridView widget contents. -->
            <?php Pjax::begin(); ?>

                <p>
                    <?= Html::a(Yii::t('app', 'Crear Catálogo'), ['create', 'page'=>$curr_page], ['class' => 'btn btn-success btn-ctt-fixed-width', 'data-toggle' => 'tooltip', 'title' => Yii::t('app', 'Crear un nuevo registro de catálogo')]) ?>
                </p>

                <!-- 2018-04-13 : The next div, including the id and class elements, enable the vertical and horizontal scrollbars. -->
                <div id="div-scroll" class="div-scroll-area-horizon">

                    <?= GridView::widget([
                        'dataProvider' => $dataProvider,
                        'filterModel' => $searchModel,

                        'columns' => [
                            // 2018-05-27 : This code adds the current page as an URL parameter to the view, update and delete buttons in the column actions.
                            // 2018-05-28 : A new action is implemented to pass the page number parameter and return to the current page in GridView widget.
                            [
                                'class' => 'yii\grid\ActionColumn',
                                'headerOptions' => ['style' => 'width:4%'],

                                // 2018-05-28 : Redefines the default {delete} action from the template and adds the new behaviors like an customized modal window.
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
                                                    // 2019-04-04 : Adds to the modal content, the record id and other description like a warning message.
                                                    'message' => Yii::t('app', '¿ Está seguro de eliminar este elemento ?').'<br>'.$model->id.'&nbsp;-&nbsp;'.$model->name_cat,
                                                    'color' => 4,   // Red color header in modal window.
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
                                         $url = Url::to(['catalog/delete', 'id' => $model->id, 'page' => ($dataProvider->pagination->page + 1)]);
                                    }
                                    elseif ($action === 'view') {
                                         $url = Url::to(['catalog/view', 'id' => $model->id, 'page' => ($dataProvider->pagination->page + 1)]);
                                    }
                                    elseif ($action === 'update') {
                                         $url = Url::to(['catalog/update', 'id' => $model->id, 'page' => ($dataProvider->pagination->page + 1)]);
                                    }
                                    else $url = null;

                                    // 2018-05-29 : If null value is returned, the url created have only home page address plus &page parameter. The right value is return $url.
                                    return $url;
                                }
                            ],

                            [ 'class' => 'yii\grid\SerialColumn',
                                'headerOptions' => ['style' => 'width:3%'],
                            ],

                            [
                                'attribute' => 'id',
                                'headerOptions' => ['style' => 'width:3%'],
                            ],

                            // 2018-05-07 : The name_cat field in red text color.

                            [
                                'attribute' => 'name_cat',
                                'contentOptions' => ['style' => 'color:red'],
                            ],

                            'sp_desc',
                            'en_desc',

                            'created_at',
                            'updated_at',
                            'created_by',
                            'updated_by',

                        ],

                        'layout' => '{summary}{items}{pager}',

                    ]);?>

                </div>

            <!-- 2018-06-13 : Ends the ajax functionality to refresh only the GridView widget contents. -->
            <?php Pjax::end(); ?>

            <br/>

            <!-- 2018-06-13 : Toolbox -->
            <div class="panel panel-default">
                <div class="panel-heading"><span data-toggle="tooltip" title="<?=  Yii::t('app', 'Panel de Herramientas') ?>"><button class="btn btn-light" data-toggle="collapse" data-target="#tools"><span class="text-info"><?= Yii::t('app', 'Herramientas') ?></span>&nbsp;&nbsp;<span><i class="fa fa-refresh fa-spin fa-1x fa-fw text-info"></i></span></button></span></div>
                <div id="tools" class="panel-collapse collapse">
                    <div class="panel-body">
                        <!-- Help Tool -->
                        <span>
                           <?php
                               echo Html::a('', ['help/view', 'theme' => '_catalog', 'ret_url' => 'catalog/index', 'ret_hash' => '0' ], ['class' => 'btn glyphicon glyphicon-question-sign', 'data-toggle' => 'tooltip', 'title' => Yii::t('app', 'Ayuda')]);
                               echo '<span>'.Yii::t('app', 'Ayuda').'</span>';
                           ?>
                       </span>
                    </div>
                </div>
            </div>

            <div class="well well-sm text-info"><?= Yii::t('app', 'IMPORTANTE : La información que se muestra en la relación, corresponde a datos experimentales de prueba.');?></div>

        </div>
    </div>

</section>

<!-- Includes the view's footer file -->
<?php include(Yii::getAlias('@app').'/views/layouts/cttwapp_views_footer.inc'); ?>

<!-- Includes the custom modal window to confirm the GridView actions-->
<?php include(Yii::getAlias('@app').'/views/layouts/cttwapp_views_modal_confirm.inc'); ?>

<!-- Includes the modal warning window to display functionality not implemented yet -->
<?php include(Yii::getAlias('@app').'/views/layouts/cttwapp_views_index_modals.inc'); ?>
