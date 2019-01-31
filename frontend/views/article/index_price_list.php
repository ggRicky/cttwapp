<?php

use yii\helpers\Html;
/* use yii\grid\GridView; // 2019-01-17 : Disable the base class reference */

/* 2018-05-06 : Used to display the catalog name for the actual article record */
use yii\helpers\ArrayHelper;
use yii\widgets\Pjax;
use yii\helpers\Url;
use yii\web\View;
use app\models\Catalog;
use app\models\Brand;

/* 2019-01-17 : Used to extend the GridView class */
use frontend\components\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\ArticleSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $qryParams */

$this->title = 'Lista de Precios';
$description = 'Listado Nominal';

// Register the cttwapp project asset bundle
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

// 2018-04-26 : Used to get a random int, and display a random parallax.
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

            <!-- 2018-05-24 : If there is an flash message, then display it.-->
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

            <!-- Used to jump to the right position when 'Code with colors' option is enabled or disabled -->
            <span id="panel-area"></span>

            <!-- 2018-05-28 : Begin the ajax functionality to refresh only the GridView widget contents. -->
            <?php Pjax::begin(); ?>

                <?php
                // 2018-09-30 : Gets the visibility status for all columns from the cookies and put it into the $c variable.
                if (Yii::$app->getRequest()->getCookies()->has('article_columns_config2')) {
                    $c = Yii::$app->getRequest()->getCookies()->getValue('article_columns_config2');
                    // 2018-09-30 : Only for debug purpose. Shows the var content.
                    // VarDumper::dump($c);
                }
                else
                    // 2018-09-30 : If there isn't the article_columns_config cookie, then by default shows all the columns.
                    $c = '1111111111111111111111111';

                // 2018-08-22 : Gets the value from the cookie and assign it to the $dataProvider->pageSize.
                if (Yii::$app->getRequest()->getCookies()->has('article-pageSize2'))
                    $dataProvider->pagination->pageSize = Yii::$app->getRequest()->getCookies()->getValue('article-pageSize2');
                // 2018-08-22 : Sets the $dataProvider->pageSize to a default value
                else
                    $dataProvider->pagination->pageSize = 7;
                ?>

                <?= GridView::widget([
                    'dataProvider' => $dataProvider,
                    'filterModel' => $searchModel,

                    // 2019-01-17 : Sets the id to 'dataTable' and the css table classes to display the right colors.
                    'tableOptions' => ['id' => 'dataTable', 'class' => 'table-striped table-bordered tablescroll_colors tablescroll_colors-hover'],

                    // 2019-01-12 : Some options to custom the table header
                    // 'headerRowOptions' => ['style' => 'background-color:lightgray'],

                    'rowOptions' => function($model){
                        // 2018-04-23 : The next conditional statement enable colored rows based on specific database value
                        // 2018-05-14 : Improvement. The color on/off status is stored in a cookie.
                        if (Yii::$app->getRequest()->getCookies()->has('article-color2') &&
                            Yii::$app->getRequest()->getCookies()->getValue('article-color2') == '1'){
                            // 2018-05-06 : Change the row background color based on the type_art value.
                            if ($model->type_art == 'V')  // 'V'- Venta  'R' - Renta
                            {
                                return ['class' => 'yellow-light'];
                            };
                            return [];
                        }
                        return [];
                    },

                    'columns' => [
                        // 2018-06-03 : This code adds the current page as an URL parameter to the view, update and delete buttons in the column actions.
                        // 2018-06-03 : A new action is implemented to pass the page number parameter and return to the current page in GridView widget.

                        [
                            // 2019-01-12 : Some options to custom the table header
                            'class' => 'yii\grid\ActionColumn',
                            'header' => '<span>Acción</span>',
                            'headerOptions' => ['style' => 'color:#8b8787;'],
                            'template' => '{show} {view}',
                            'buttons' => [
                                // 2018-06-03 : Adds the title property to show the right tooltip when mouse is hover the glyphicon.
                                'view' => function ($url) {
                                    return Html::a('<span class="glyphicon glyphicon-eye-open"></span>', $url, [
                                        'data-toggle' => 'tooltip',
                                        'title' => Yii::t('app', 'Ver'),           // 2018-06-03 : Adds the tooltip View
                                    ]);
                                },

                                // 2018-07-11 : Adds a new show action to display the related image in a bootstrap modal window.
                                'show' => function ($url, $model, $key) {
                                    // 2018-07-10 : To get the image path and filename.
                                    $file_name = Yii::getAlias('@webroot').Yii::getAlias('@uploads_inv'.'/').PREFIX_IMG.$model->id;
                                    // 2018-07-10 : Check the existence of a correct file type and determine its extension if there is one.
                                    $file_ext = (file_exists($file_name.'.jpg') ? '.jpg': (file_exists($file_name.'.png') ? '.png': null));

                                    if (!is_null($file_ext)) {
                                        return Html::a('<span class="glyphicon glyphicon-camera"></span>', '#', [
                                            'class'       => 'detail-view-link',
                                            'style'       => 'color:#337ab7;',                            // 2018-07-11 : Display the glyphicon-camera in default color.
                                            'onMouseOver' => 'this.style.color=\'#ff8e00\'',              // 2018-07-11 : When mouse is hover on the link, the color changes to orange advising an available operation.
                                            'onMouseOut'  => 'this.style.color=\'#337ab7\'',
                                            'data-toggle' => 'tooltip',
                                            'title' => Yii::t('app', 'Mostrar'),         // 2018-06-03 : Adds the tooltip View
                                            'data-target' => '#ctt-modal-show-art',
                                            'data' => [
                                                'title' => Yii::t('app', 'Vista Detallada').' : '.($model->id),
                                                'name'  => ($model->name_art),
                                                'url'   => Url::to('@uploads_inv'.'/').PREFIX_IMG.$model->id.'.jpg',
                                            ],
                                            'data-id'     => $key,
                                            'data-pjax'   => '0',
                                        ]);
                                    }

                                    return null;
                                },
                            ],

                            // 2018-06-03 : Adds an url that includes the current page in GridView widget.
                            'urlCreator' => function ($action, $model) use ($dataProvider) {
                                if ($action === 'view') {
                                    $url = Url::to(['article/view2', 'id' => $model->id, 'page' => ($dataProvider->pagination->page + 1)]);
                                }
                                else $url = null;

                                // 2018-06-03 : If null value is returned, the url created have only home page address plus &page parameter. The right value is return $url.
                                return $url;
                            }
                        ],

                        [
                            'class' => 'yii\grid\SerialColumn',
                            'headerOptions' => ['style' => 'width:1.5%; color:#8b8787;'],
                        ],

                        [
                            // 2018-07-10 : Include a new column with an article's thumbnail image.
                            'attribute' => Yii::t('app','Imagen'),
                            'headerOptions' => ['style' => 'width:4%; color:#8b8787;'],
                            'contentOptions' => ['class' => 'text-center'],
                            'format' => 'raw',
                            'value' => function ($model) {
                                // 2018-07-10 : To get the image path and filename.
                                $file_name =  Yii::getAlias('@webroot').Yii::getAlias('@uploads_inv').'/'.PREFIX_IMG.$model->id;
                                // 2018-07-10 : To get the image url.
                                $url_image = Url::to(Yii::getAlias('@uploads_inv').'/').PREFIX_IMG.$model->id;
                                // 2018-07-11 : To get the no image url.
                                $url_no_image = Url::to(Yii::getAlias('@uploads_inv').'/').'ctt_no_image.jpg';
                                // 2018-07-10 : Test for the right file type
                                if (file_exists($file_name.'.jpg'))
                                    return '<img src="'.$url_image.'.jpg" width="auto" height="50px">';
                                else if (file_exists($file_name.'.png'))
                                    return '<img src="'.$url_image.'.png" width="auto" height="50px">';
                                else
                                    return '<img src="'.$url_no_image.'" width="auto" height="50px">';
                            },
                        ],

                        [
                            'attribute' => 'id',
                            'headerOptions' => ['style' => 'width:3%'],
                        ],

                        // 2018-05-06 : Modified to display the ID and the Catalog Description instead of the ID only.

                        [
                            'attribute' => 'catalog_id',
                            'visible' => ($c[0] == '1' ? true : false),     // 2018-08-20 : Set the column visibility status
                            'headerOptions' => ['style' => 'width:12%;'],
                            // 2018-08-21 : Modified to display a DropDownList with the available catalogs, using the filter option.
                            'filter' => Html::activeDropDownList($searchModel, 'catalog_id', ArrayHelper::map(Catalog::find()->select(['id','name_cat'])->orderBy(['id' => SORT_ASC])->all(),'id','displayNameCat'), ['prompt' => Yii::t('app','Seleccionar...'), 'data-toggle' => 'tooltip', 'title' => Yii::t('app', 'Catálogos Disponibles')]),
                            'value' => function($model){
                                return implode(",",ArrayHelper::map(Catalog::find()->where(['id' =>  $model->catalog_id])->all(),'id','displayNameCat'));
                            }
                        ],

                        // 2018-05-06 : Displays the name_art field in red text color.

                        [
                            'attribute' => 'name_art',
                            'contentOptions' => ['style' => 'color:red'],
                            'visible' => ($c[1]== '1' ? true : false),     // 2018-08-20 : Set the column visibility status
                        ],

                        [
                            'attribute' => 'sp_desc',
                            'visible' => ($c[2]== '1' ? true : false),     // 2018-08-20 : Set the column visibility status
                        ],

                        [
                            'attribute' => 'en_desc',
                            'visible' => ($c[3]== '1' ? true : false),     // 2018-08-20 : Set the column visibility status
                        ],

                        // 2018-05-06 : For type_art field, the right legend is displayed and colored properly.

                        [
                            'attribute' => 'type_art',
                            // 2018-08-21 : Modified to display a DropDownList with the available article typs list, using the filter option.
                            'filter' => Html::activeDropDownList($searchModel, 'type_art', ['R' => 'RENTA', 'V' => 'VENTA'], ['prompt' => Yii::t('app','Seleccionar...'), 'data-toggle' => 'tooltip', 'title' => Yii::t('app', 'Tipos Disponibles')]),
                            'value' => function($model){
                                return ($model->type_art=='R'?'RENTA':'VENTA');
                            },
                            'contentOptions' => function ($model, $key, $index, $column) {
                                return ['style' => 'color:'. ($model->type_art=='V'?'#337ab7':'#428bca')];
                            },
                            // 2018-08-20 : Set the column visibility status
                            'visible' => ($c[4]== '1' ? true : false),
                        ],

                        [
                            'attribute' => 'price_art',
                            // 2018-08-20 : Set the column visibility status
                            'visible' => ($c[5]== '1' ? true : false),
                        ],

                        // 2018-04-23 : To the provenance type, the right legend is displayed.

                        [
                            'attribute' => 'currency_art',
                            'value' => function($model){
                                return ($model->currency_art=='P'?'PESOS':'DÓLARES');
                            },
                            // 2018-08-20 : Set the column visibility status
                            'visible' => ($c[6]== '1' ? true : false),
                        ],

                        // 2018-05-06 : Modified to display the ID and the Catalog Description instead of the ID only.
                        [
                            'attribute' => 'brand_id',
                            // 2018-08-21 : Modified to display a DropDownList with the available catalogs, using the filter option.
                            'filter' => Html::activeDropDownList($searchModel, 'brand_id', ArrayHelper::map(Brand::find()->select(['id','brand_desc'])->orderBy(['id' => SORT_ASC])->all(),'id','displayBrandDesc'), ['prompt' => Yii::t('app','Seleccionar...'), 'data-toggle' => 'tooltip', 'title' => Yii::t('app', 'Marcas Disponibles')]),
                            'value' =>
                                function($model){
                                    return (implode(",",ArrayHelper::map(Brand::find()->where(['id' => $model->brand_id])->all(),'id','displayBrandDesc')));
                                },
                            // 2018-08-20 : Set the column visibility status
                            'visible' => ($c[7]== '1' ? true : false),
                        ],

                        [
                            'attribute' => 'part_num',
                            // 2018-08-20 : Set the column visibility status
                            'visible' => ($c[8]== '1' ? true : false),
                        ],

                        [
                            'attribute' => 'created_at',
                            // 2018-08-20 : Set the column visibility status
                            'visible' => ($c[9] == '1' ? true : false),
                        ],

                        [
                            'attribute' => 'updated_at',
                            // 2018-08-20 : Set the column visibility status
                            'visible' => ($c[10] == '1' ? true : false),
                        ],

                        [
                            'attribute' => 'created_by',
                            // 2018-08-20 : Set the column visibility status
                            'visible' => ($c[11] == '1' ? true : false),
                        ],

                        [
                            'attribute' => 'updated_by',
                            // 2018-08-20 : Set the column visibility status
                            'visible' => ($c[12] == '1' ? true : false),
                        ],

                    ],

                    'layout' => '{items}{summary}{pager}',
                ]);?>

                <!-- 2018-07-13 : This jQuery's piece of code implements the modal window for show the article image.-->
                <?php $this->registerJs(
                    /** @lang jQuery */
                "$('.detail-view-link').click(function(e) {

                        // 2018-10-23 : If this method is called, the default action of the event will not be triggered.
                        e.preventDefault();
                        // 2018-10-23 : Prevents the event from bubbling up the DOM tree, preventing any parent handlers from being notified of the event.
                        e.stopPropagation();
                        // 2018-10-23 : Closes the sidebar menu if this is opened.
                        if ($('#sidebar-wrapper').hasClass('active')) 
                            $('#sidebar-wrapper').toggleClass('active');
                        
                        // Gets the modal window title. 
                        var p_title = $(this).data(\"title\");
                        // Gets the article name. 
                        var p_name = $(this).data(\"name\");
                        // Gets the image url to display. 
                        var p_url_image = $(this).data(\"url\");
                        // Shows the modal window.
                        var modal = $('#ctt-modal-show-art').modal('show');
    
                        // Inserts the title message in the html content-title area. 
                        modal.find('#content-title').html('<h5 class=\"modal-title\">' + p_title + '</h5>');
                        // Inserts the image url in the html content-body area.
                        modal.find('#content-body').html('<div><img src=\"'+p_url_image+'\" style=\"max-height:100%; max-width:100%\"></div><br/><div align=\"center\">'+p_name+'</div>');
    
                    });
                    
                    // This code is implemented for re-activate several functionalities after each Pjax request.
                    $(document).on('pjax:success', function(event) {
                    
                        // 2018-08-23 : Re-activate the Bootstrap Tooltips.
                        $('[data-toggle=\"tooltip\"]').tooltip({trigger:'hover', animation:true, delay:{show:1000, hide:100}});

                        // 2019-01-17 : Re-activate the tableScroll plugin.
                        $(\"#dataTable\").tableScroll({height:300, width:5500});

                    });"
                );

                ?>

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
                           echo Html::a('', ['help/view', 'theme' => '_price_list', 'ret_url' => 'article/show-price-list', 'ret_hash' => '0' ], ['class' => 'btn glyphicon glyphicon-question-sign', 'data-toggle' => 'tooltip', 'title' => Yii::t('app', 'Ayuda')]);
                           echo '<span>'.Yii::t('app', 'Ayuda').'</span>';
                           ?>
                        </span>
                        <!-- Color Tool -->
                        <span>
                           <!-- 2018-05-14 : Improvement. The next two <a> tags call the color action from clientController and pass the color parameter to it. -->
                            <?php
                            $color_expr = Yii::$app->getRequest()->getCookies()->has('article-color2') && Yii::$app->getRequest()->getCookies()->getValue('article-color2') == '0';
                            if ($color_expr){
                                echo Html::a('', ['article/set-color2', 'color' => '1'], ['class' => 'btn glyphicon glyphicon-tint', 'data-toggle' => 'tooltip', 'title' => Yii::t('app', 'Activar código de colores')]);
                                echo '<span>'.Yii::t('app', 'Colores').'</span>';
                            }
                            else{
                                echo Html::a('', ['article/set-color2', 'color' => '0'], ['class' => 'btn glyphicon glyphicon-tint', 'data-toggle' => 'tooltip', 'title' => Yii::t('app', 'Desactivar código de colores')]);
                                echo '<span>'.Yii::t('app', 'Colores').'</span>';
                            }
                            ?>
                        </span>
                        <!-- Columns Selector Tool -->
                        <span>
                           <?php
                           echo Html::a('', ['article/get-columns', 'view_type' => '1'], ['class' => 'btn glyphicon glyphicon-list-alt', 'data-toggle' => 'tooltip', 'title' => Yii::t('app', 'Selector de Columnas')]);
                           echo '<span>'.Yii::t('app', 'Columnas').'</span>';
                           ?>
                       </span>
                        <!-- Page Size Tool -->
                        <span>
                           <?php
                           echo Html::a('', ['article/get-page-size', 'view_type' => '1'], ['class' => 'btn glyphicon glyphicon-th-list', 'data-toggle' => 'tooltip', 'title' => Yii::t('app', 'Tamaño del Paginado')]);
                           echo '<span>'.Yii::t('app', 'Paginado').'</span>';
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

<!-- Includes the modal window to confirm the delete operation -->
<?php include(Yii::getAlias('@app').'/views/layouts/cttwapp_views_confirm_delete.inc'); ?>

<!-- Includes the modal window to show an article image -->
<?php include(Yii::getAlias('@app').'/views/layouts/cttwapp_views_show_image.inc'); ?>

<!-- Includes the jQuery tableScroll plugin -->
<?php $this->registerJs(/** @lang jquery */"jQuery(document).ready(function() { $(\"#dataTable\").tableScroll({height:300, width:5500}); });",View::POS_READY,'fix-Header'); ?>
