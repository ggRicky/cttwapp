<?php

use yii\helpers\Html;
use yii\widgets\Pjax;
use yii\helpers\Url;
use yii\web\View;

// use yii\grid\GridView;           /* 2019-07-21 : Disable the base class reference */
use frontend\components\GridView;   /* 2019-07-21 : Used to extend the GridView class */

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
            <?= Html::a(Yii::t('app','R e g r e s a r'), ['site/index', 'hash' => '0'], ['target' => '_self', 'class' => 'btn btn-dark btn-ctt-fixed-width', 'data-toggle' => 'tooltip', 'title' => Yii::t('app', 'Regresar al nivel anterior')]) ?>
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

                <?= GridView::widget([
                    'dataProvider' => $dataProvider,
                    'filterModel' => $searchModel,

                    // 2019-07-21 : Sets the id to 'dataTable' and the css table classes to display the right colors.
                    'tableOptions' => ['id' => 'dataTable', 'class' => 'table-striped table-bordered tablescroll_colors tablescroll_colors-hover'],

                    'columns' => [
                        // 2018-05-27 : This code adds the current page as an URL parameter to the view, update and delete buttons in the column actions.
                        // 2018-05-28 : A new action is implemented to pass the page number parameter and return to the current page in GridView widget.
                        [
                            'class' => 'yii\grid\ActionColumn',
                            // 2019-07-21 : Determines the headers height ( 60px ) in the GridView control
                            'headerOptions' => ['style' => 'width:5.0%; height:60px; color:#8b8787;'],

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
                                            // 2018-06-03 : A data set may be send like parameters to the overwritten function yii.confirm. And in the function, the data may be retrieved
                                            // and displayed in the modal window.
                                            'data' => [
                                                'color' => 4,  // Red color header in modal window.
                                            ],
                                            // 2019-11-04 : Important : The 'data-confirm' parameter must be there, because it trigger a modal confirmation window before run the action delete.
                                            // In the same way, through this parameter can be pass the user's message to the overwritten function yii.confirm, located in the cttwapp-stylish.css file.
                                            // Another way to sends user's data (p.e. color code ) to the overwritten function yii.confirm, is through a data array like showed above.
                                            // On the next line, the confirmation message is passed to the modal dialog window via the parameter 'confirm-data' just before starting the deletion action.
                                            'data-confirm' => Yii::t('app', '¿ Está seguro de eliminar este elemento ?').'<br>'.$model->id.'&nbsp;-&nbsp;'.$model->name_cat,
                                            // 2018-06-03 : The next two parameters are needed to complete the right call to the action delete, because it will be made using the post method.
                                            'data-method' => 'post',
                                            // 2018-06-03 : The Pjax widget allows you to update a certain section of a page instead of reloading the entire page. You can use it to update only
                                            // the GridView content when using filters. But this might be a problem for the links of an ActionColumn. To prevent this, add the HTML attribute
                                            // data-pjax="0" to the links when you edit the ActionColumn::$buttons property.

                                            // You may configure $linkSelector to specify which links should trigger pjax, and configure $formSelector to specify which form submission may trigger pjax.
                                            // You may disable pjax for a specific link inside the container by adding data-pjax="0" attribute to this link.
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

                        [
                            'class' => 'yii\grid\SerialColumn',
                            'headerOptions' => ['style' => 'width:3%; color:#8b8787;'],
                            // 2019-07-21 : Determines the rows height ( 30px ) in the GridView control
                            'contentOptions' => ['class' => 'text-center', 'style' => 'height:30px;'],
                        ],

                        [
                            'attribute' => 'id',
                            'headerOptions' => ['style' => 'width:3%'],
                        ],

                        [
                            'attribute' => 'name_cat',  // 2018-05-07 : The name_cat field in red text color.
                            'contentOptions' => ['style' => 'color:red; text-transform:uppercase;'],  // 2019-07-29 : Transforms all characters to uppercase
                        ],

                        [
                            'attribute' => 'sp_desc',
                            'contentOptions' => ['style' => 'text-transform:uppercase;'],  // 2019-07-29 : Transforms all characters to uppercase
                        ],

                        [
                            'attribute' => 'en_desc',
                            'contentOptions' => ['style' => 'text-transform:uppercase;'],  // 2019-07-29 : Transforms all characters to uppercase
                        ],

                        'created_at',
                        'updated_at',
                        'created_by',
                        'updated_by',

                    ],

                    'layout' => '{items}{summary}{pager}',
                ]);?>

                <!-- 2019-07-21 : This jQuery's piece of code implements the modal window for show the article image.-->
                <?php $this->registerJs(
                /** @lang jQuery */
                    "// This code is implemented for re-start several functionalities after each Pjax request.
                            $(document).on('pjax:success', function(event) {
        
                                // 2018-08-23 : Re-start the Bootstrap Tooltips.
                                $('[data-toggle=\"tooltip\"]').tooltip({trigger:'hover', animation:true, delay:{show:1000, hide:100}});
        
                                // 2019-01-17 : Re-start the tableScroll plugin. Sets the height and width values to grow up or grow down the size of table window.
                                $(\"#dataTable\").tableScroll({height:500, width:1830});
                                
                            });"
                );
                ?>

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

            <div class="well well-sm text-info"><?= Yii::t('app', 'IMPORTANTE : La información que se muestra en la relación, corresponde a datos experimentales de prueba').'.';?></div>

        </div>
    </div>

</section>

<!-- Includes the view's footer file -->
<?php include(Yii::getAlias('@app').'/views/layouts/cttwapp_views_footer.inc'); ?>

<!-- Includes the custom modal window to confirm the GridView actions-->
<?php include(Yii::getAlias('@app').'/views/layouts/cttwapp_views_modal_confirm.inc'); ?>

<!-- Includes the modal warning window to display functionality not implemented yet -->
<?php include(Yii::getAlias('@app').'/views/layouts/cttwapp_views_index_modals.inc'); ?>

<!-- Includes the jQuery tableScroll plugin and configuring the height and width initial values for the size of the table window -->
<?php $this->registerJs(/** @lang jquery */"jQuery(document).ready(function() { $(\"#dataTable\").tableScroll({height:500, width:1830}); });",View::POS_READY,'fix-Header'); ?>
