<?php

use yii\helpers\Html;
/* use yii\grid\GridView; // 2019-07-21 : Disable the base class reference */

/* 2018-05-06 : Used to display the catalog name for the actual article record */
use yii\helpers\ArrayHelper;
use yii\widgets\Pjax;
use yii\helpers\Url;
use yii\web\View;
use app\models\Catalog;
use app\models\Brand;
use app\models\Warehouse;
use app\models\ArticleType;

/* 2019-07-21 : Used to extend the GridView class */
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
                // 2018-09-30 : If there isn't the article_columns_config cookie, then by default shows all the columns.
                $c = $m = '1111111111111111111111111';  // 2019-08-14 : $m - This variable is the mask for fills the undefined columns.

                // 2018-09-30 : Gets the visibility status for all columns from the cookies and put it into the $c variable.
                if (Yii::$app->getRequest()->getCookies()->has('article_columns_config2')) {
                    $c = Yii::$app->getRequest()->getCookies()->getValue('article_columns_config2');

                    // 2019-08-14 : Fills the string variable $c up to 25 characters
                    $c = ($m & $c).str_repeat('0',abs(strlen($m)-strlen($c)));

                    // 2018-09-30 : Only for debug purpose. Shows the var content.
                    // VarDumper::dump($c);
                }

                    // 2018-08-22 : Gets the value from the cookie and assign it to the $dataProvider->pageSize.
                    if (Yii::$app->getRequest()->getCookies()->has('article-pageSize2'))
                        $dataProvider->pagination->pageSize = Yii::$app->getRequest()->getCookies()->getValue('article-pageSize2');
                    // 2018-08-22 : Sets the $dataProvider->pageSize to a default value
                    else
                        $dataProvider->pagination->pageSize = 50;   // 2019-07-21 : updated by requirements
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
                            // 2018-05-06 : Change the row background color based on the article_type_id value.

                            if ($model->article_type_id == '2')          // '2' - Venta  ( '1' - Renta )
                            {
                                return ['class' => 'yellow-light'];
                            }else if ($model->article_type_id == '3')    // '3' - Freelance
                            {
                                return ['class' => 'blue-light'];
                            }else if ($model->article_type_id == '4')    // '4' - Movil
                            {
                                return ['class' => 'red-light'];
                            }else if ($model->article_type_id == '5')    // '5' - Planta
                            {
                                return ['class' => 'teal-light'];
                            }else if ($model->article_type_id == '6')    // '6' - Daños
                            {
                                return ['class' => 'lime-light'];
                            }else if ($model->article_type_id == '7')    // '7' - Viatcos
                            {
                                return ['class' => 'orange-light'];
                            };
                        }
                        return [];
                    },

                    'columns' => [
                        // 2018-06-03 : This code adds the current page as an URL parameter to the view, update and delete buttons in the column actions.
                        // 2018-06-03 : A new action is implemented to pass the page number parameter and return to the current page in GridView widget.

                        [
                            // 2019-01-12 : Some options to custom the table header
                            'class' => 'yii\grid\ActionColumn',
                            'header' => '<span>'.Yii::t('app','Acción').'</span>',
                            // 2019-07-21 : Determines the headers height ( 60px ) in the GridView control
                            'headerOptions' => ['style' => 'width:1.5%; height:60px; color:#8b8787;'],
                            // 2018-06-03 : Redefines the default {delete} action from the template and adds the new behaviors like an customized modal window.
                            // 2019-11-01 : Modified to display the article remarks text
                            'template' => '{view} {show} {display}',
                            'buttons' => [
                                // 2018-06-03 : Adds the title property to show the right tooltip when mouse is hover the glyphicon.
                                'view' => function ($url) {
                                    return Html::a('<span class="glyphicon glyphicon-eye-open"></span>', $url, [
                                        'data-toggle' => 'tooltip',
                                        'title' => Yii::t('app', 'Ver'),           // 2018-06-03 : Adds the tooltip View
                                        'onMouseOver' => 'this.style.color=\'#606060\'',            // 2018-06-06 : When mouse is hover on the link, the color changes
                                        'onMouseOut'  => 'this.style.color=\'#337ab7\'',            //              to gray advising warning in update operation.
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
                                            'onMouseOver' => 'this.style.color=\'#0088ff\'',              // 2018-07-11 : When mouse is hover on the link, the color changes to blue advising an available operation.
                                            'onMouseOut'  => 'this.style.color=\'#337ab7\'',
                                            'data-toggle' => 'tooltip',
                                            'title' => Yii::t('app', 'Mostrar'),         // 2018-06-03 : Adds the tooltip View
                                            'data-target' => '#ctt-modal-show-art',
                                            'data' => [
                                                'title'   => Yii::t('app', 'Vista Detallada').' : '.($model->id),
                                                'name'    => ($model->name_art),
                                                'url'     => Url::to('@uploads_inv'.'/').PREFIX_IMG.$model->id.'.jpg',
                                            ],
                                            'data-id'     => $key,
                                            'data-pjax'   => '0',
                                        ]);
                                    }

                                    return null;
                                },

                                // 2019-10-31 : Adds a new display action to shows the associated remarks in a bootstrap modal window.
                                'display' => function ($url, $model, $key) {
                                    // 2019-10-31 : Check if there is one remarks.
                                    if (!is_null($model->remarks_art) && !empty($model->remarks_art)) {
                                        return Html::a('<span class="glyphicon glyphicon-comment" data-toggle="tooltip" title="'.Yii::t('app', 'Desplegar').'"></span>', '#', [
                                            'class'       => 'art-remarks-link',
                                            'style'       => 'color:#337ab7, ',               // 2018-07-11 : Display the glyphicon-comment in default color.
                                            'onMouseOver' => 'this.style.color=\'#ff8e00\'',  // 2019-10-31 : When mouse is hover on the link, the color changes to orange advising an available operation.
                                            'onMouseOut'  => 'this.style.color=\'#337ab7\'',
                                            'data-toggle' => 'modal',                         // 2019-04-01 : It is a HTML5 data attribute that automatically hooks up the element to the type of widget it is.
                                            //              Some samples : data-toggle="modal", data-toggle="collapse", data-toggle="dropdown", data-toggle="tab"
                                            // In summary : Activate a modal without writing JavaScript. Set data-toggle="modal" on a controller element,
                                            //              like a button, along with a data-target="#foo" or href="#foo" to target a specific modal to toggle.

                                            'data-target' => '#ctt-modal-display-remark',     // 2019-10-31 : The target to displays as a modal window
                                            'data' => [
                                                'title'   => Yii::t('app', 'Observaciones').' : '.($model->id),    // 2019-10-31 : Title header
                                                'name'    => ($model->name_art),              // 2019-10-31 : Article name
                                                'remarks' => ($model->remarks_art),           // 2019-10-31 : The article remarks
                                            ],
                                            'data-id'     => $key,                            // 2019-04-02 : Adds the article ID to the <a> tag as a unique descriptor.
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
                            'headerOptions' => ['style' => 'width:1.5%; color:#8b8787;'], // 2019-07-21 : Determines the rows height ( 30px ) in the GridView control
                            'contentOptions' => ['class' => 'text-center', 'style' => 'height:30px;'],
                        ],

                        [
                            'attribute' => 'id',
                            'headerOptions' => ['style' => 'width:3%'],
                        ],

                        // 2018-05-06 : Modified to display the ID and the Catalog Description instead of the ID only.

                        [
                            'attribute' => 'catalog_id',
                            'visible' => ($c[0] == '1' ? true : false),    // 2018-08-20 : Set the column visibility status
                            'headerOptions' => ['style' => 'width:6%;'],
                            // 2018-08-21 : Modified to display a DropDownList with the available catalogs, using the filter option.
                            'filter' => Html::activeDropDownList($searchModel, 'catalog_id', ArrayHelper::map(Catalog::find()->select(['id','name_cat'])->orderBy(['id' => SORT_ASC])->all(),'id','displayNameCat'), ['prompt' => Yii::t('app','Ver Todos...'), 'data-toggle' => 'tooltip', 'title' => Yii::t('app', 'Catálogos Disponibles')]),
                            'value' => function($model){
                                return implode(",",ArrayHelper::map(Catalog::find()->where(['id' =>  $model->catalog_id])->all(),'id','displayNameCat'));
                            }
                        ],

                        // 2019-08-14 : Added to display the ID and the Warehouse Description instead of the ID only.

                        [
                            'attribute' => 'warehouse_id',
                            'visible' => ($c[13] == '1' ? true : false),   // 2019-08-14 : Set the column visibility status
                            'headerOptions' => ['style' => 'width:6%;'],
                            // 2019-08-14 : Modified to display a DropDownList with the available warehouses, using the filter option.
                            'filter' => Html::activeDropDownList($searchModel, 'warehouse_id', ArrayHelper::map(Warehouse::find()->select(['id','desc_warehouse'])->orderBy(['id' => SORT_ASC])->all(),'id','displayDescWarehouse'), ['prompt' => Yii::t('app','Ver Todos...'), 'data-toggle' => 'tooltip', 'title' => Yii::t('app', 'Almacenes Disponibles')]),
                            'value' => function($model){
                                return implode(",",ArrayHelper::map(Warehouse::find()->where(['id' =>  $model->warehouse_id])->all(),'id','displayDescWarehouse'));
                            }
                        ],

                        // 2018-05-06 : Displays the name_art field in red text color.

                        [
                            'attribute' => 'name_art',
                            'visible' => ($c[1]== '1' ? true : false),     // 2018-08-20 : Set the column visibility status
                            'headerOptions' => ['style' => 'width:10%;'],
                            'contentOptions' => ['style' => 'color:red; text-transform:uppercase;'],  // 2019-07-29 : Transforms all characters to uppercase
                        ],

                        [
                            'attribute' => 'sp_desc',
                            'visible' => ($c[2]== '1' ? true : false),     // 2018-08-20 : Set the column visibility status
                            'contentOptions' => ['style' => 'text-transform:uppercase;'],  // 2019-07-29 : Transforms all characters to uppercase
                        ],

                        [
                            'attribute' => 'en_desc',
                            'visible' => ($c[3]== '1' ? true : false),     // 2018-08-20 : Set the column visibility status
                            'contentOptions' => ['style' => 'text-transform:uppercase;'],  // 2019-07-29 : Transforms all characters to uppercase
                        ],

                        // 2019-11-02 : Modified to display the alternative id
                        [
                            'attribute' => 'id_alt',
                            'visible' => ($c[14] == '1' ? true : false),   // 2019-11-02 : Set the column visibility status
                            'headerOptions' => ['style' => 'width:3%'],
                            'contentOptions' => ['style' => 'text-transform:uppercase;'],  // 2019-11-02 : Transforms all characters to uppercase
                            'value' => function($model){
                                return (trim($model->id_alt)==false ? 'N/D' : $model->id_alt);
                            },
                        ],

                        // 2018-05-06 : For article_type_id field, the right legend is displayed and colored properly.
                        [
                            'attribute' => 'article_type_id',
                            'visible' => ($c[4] == '1' ? true : false),    // 2018-08-20 : Set the column visibility status
                            'headerOptions' => ['style' => 'width:4%;'],
                            // 2019-10-23 : Modified to display a DropDownList with the available article types, using the filter option.
                            'filter' => Html::activeDropDownList($searchModel, 'article_type_id', ArrayHelper::map(ArticleType::find()->select(['id','type_desc'])->orderBy(['id' => SORT_ASC])->all(),'id','displayTypeDesc'), ['prompt' => Yii::t('app','Ver Todos...'), 'data-toggle' => 'tooltip', 'title' => Yii::t('app', 'Tipos Disponibles')]),
                            'value' => function($model){
                                return (implode(",",ArrayHelper::map(ArticleType::find()->where(['id' => $model->article_type_id])->all(),'id','displayTypeDesc')));
                            },
                        ],

                        [
                            'attribute' => 'price_art',
                            'visible' => ($c[5] == '1' ? true : false),    // 2018-08-20 : Set the column visibility status
                            'headerOptions' => ['style' => 'width:4%;'],
                            'value' => function($model){
                                // Sets the currency code based on the currency_art field value.
                                if ($model->currency_art=='1') Yii::$app->formatter->currencyCode = 'MXN';
                                elseif ($model->currency_art=='2') Yii::$app->formatter->currencyCode = 'USD';
                                return (Yii::$app->formatter->asCurrency($model->price_art));
                            },
                        ],

                        // 2018-04-23 : To the provenance type, the right legend is displayed.

                        [
                            'attribute' => 'currency_art',
                            'visible' => ($c[6]== '1' ? true : false),     // 2018-08-20 : Set the column visibility status
                            'headerOptions' => ['style' => 'width:4%;'],
                            'value' => function($model){
                                return ($model->currency_art=='1'?'PESOS':'DÓLARES');
                            },
                        ],

                        // 2018-05-06 : Modified to display the ID and the Catalog Description instead of the ID only.
                        [
                            'attribute' => 'brand_id',
                            'visible' => ($c[7]== '1' ? true : false),     // 2018-08-20 : Set the column visibility status
                            'headerOptions' => ['style' => 'width:4%;'],
                            // 2018-08-21 : Modified to display a DropDownList with the available catalogs, using the filter option.
                            'filter' => Html::activeDropDownList($searchModel, 'brand_id', ArrayHelper::map(Brand::find()->select(['id','brand_desc'])->orderBy(['id' => SORT_ASC])->all(),'id','displayBrandDesc'), ['prompt' => Yii::t('app','Ver Todos...'), 'data-toggle' => 'tooltip', 'title' => Yii::t('app', 'Marcas Disponibles')]),
                            'value' =>
                                function($model){
                                    return (implode(",",ArrayHelper::map(Brand::find()->where(['id' => $model->brand_id])->all(),'id','displayBrandDesc')));
                                },
                        ],

                        [
                            'attribute' => 'part_num',
                            'visible' => ($c[8]== '1' ? true : false),     // 2018-08-20 : Set the column visibility status
                            'headerOptions' => ['style' => 'width:4%;'],
                        ],

                        [
                            'attribute' => 'created_at',
                            'visible' => ($c[9] == '1' ? true : false),    // 2018-08-20 : Set the column visibility status
                            'headerOptions' => ['style' => 'width:4%;'],
                        ],

                        [
                            'attribute' => 'updated_at',
                            'visible' => ($c[10] == '1' ? true : false),   // 2018-08-20 : Set the column visibility status
                            'headerOptions' => ['style' => 'width:4%;'],
                        ],

                        [
                            'attribute' => 'created_by',
                            'visible' => ($c[11] == '1' ? true : false),   // 2018-08-20 : Set the column visibility status
                            'headerOptions' => ['style' => 'width:4%;'],
                        ],

                        [
                            'attribute' => 'updated_by',
                            'visible' => ($c[12] == '1' ? true : false),   // 2018-08-20 : Set the column visibility status
                            'headerOptions' => ['style' => 'width:4%;'],
                        ],

                    ],

                    'layout' => '{items}{summary}{pager}',
                ]);?>

                <!-- 2018-07-13 : This jQuery's piece of code implements the modal window for show the article image.-->
                <?php $this->registerJs(
                    /** @lang jQuery */
                "// 2018-08-23 : This code is implemented to show the article image in a modal window
                    $('.detail-view-link').click(function(e) {

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

                    //  2019-10-31 : This code is implemented to display the article remarks in a modal window
                    $('.art-remarks-link').click(function(e) {

                        // 2019-10-31 : If this method is called, the default action of the event will not be triggered.
                        e.preventDefault();
                        // 2019-10-31 : Prevents the event from bubbling up the DOM tree, preventing any parent handlers from being notified of the event.
                        e.stopPropagation();
                        // 2019-10-31 : Closes the sidebar menu if this is opened.
                        if ($('#sidebar-wrapper').hasClass('active')) 
                            $('#sidebar-wrapper').toggleClass('active');
                        
                        // Gets the modal window title. 
                        var p_title = $(this).data(\"title\");
                        // Gets the article name. 
                        var p_name = $(this).data(\"name\");
                        // Gets the record remarks to display. 
                        var p_remarks = $(this).data(\"remarks\");
                        // Shows the modal window.
                        var modal = $('#ctt-modal-display-remark').modal('show');
    
                        // Inserts the title message in the html content-title area. 
                        modal.find('#content-title').html('<h5 class=\"modal-title\">' + p_title + '</h5>');
                        // Inserts the image url in the html content-body area.
                        modal.find('#content-body').html('<div><textarea rows=\"10\" style=\"width:100%; resize:none; background-color:#eff0f1\">'+p_remarks+'</textarea></div><br/><div align=\"center\">'+p_name+'</div>');
    
                    });
                    
                    // 2018-08-23 : This code is implemented to show the article image in a modal windowThis code is implemented for re-start several functionalities after each Pjax request.
                    $(document).on('pjax:success', function(event) {
                    
                        // 2018-08-23 : Re-start the Bootstrap Tooltips.
                        $('[data-toggle=\"tooltip\"]').tooltip({trigger:'hover', animation:true, delay:{show:1000, hide:100}});

                        // 2019-01-17 : Re-start the tableScroll plugin. Sets the height and width values to grow up or grow down the size of table window.
                        $(\"#dataTable\").tableScroll({height:500, width:5500});

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
                           echo Html::a('', ['help/view', 'theme' => '_price_list', 'ret_url' => 'article/index2', 'ret_hash' => '0' ], ['class' => 'btn glyphicon glyphicon-question-sign', 'data-toggle' => 'tooltip', 'title' => Yii::t('app', 'Ayuda')]);
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
                           echo Html::a('', ['article/get-columns', 'view_type' => '2'], ['class' => 'btn glyphicon glyphicon-list-alt', 'data-toggle' => 'tooltip', 'title' => Yii::t('app', 'Selector de Columnas')]);
                           echo '<span>'.Yii::t('app', 'Columnas').'</span>';
                           ?>
                       </span>
                        <!-- Page Size Tool -->
                        <span>
                           <?php
                           echo Html::a('', ['article/get-page-size', 'view_type' => '2'], ['class' => 'btn glyphicon glyphicon-th-list', 'data-toggle' => 'tooltip', 'title' => Yii::t('app', 'Tamaño del Paginado')]);
                           echo '<span>'.Yii::t('app', 'Paginado').'</span>';
                           ?>
                       </span>
                    </div>
                </div>
            </div>

            <div class="well well-sm text-info"><span><?= Yii::t('app', 'IMPORTANTE : La información que se muestra en la relación, corresponde a datos experimentales de prueba').'.';?></span></div>

        </div>
    </div>

</section>

<!-- Includes the modal success, warning and config window to show several kinds of messages -->
<?php include(Yii::getAlias('@app').'/views/layouts/cttwapp_views_index_modals.inc'); ?>

<!-- Includes the view's footer file -->
<?php include(Yii::getAlias('@app').'/views/layouts/cttwapp_views_footer.inc'); ?>

<!-- Includes the custom modal window to confirm the GridView actions -->
<?php include(Yii::getAlias('@app').'/views/layouts/cttwapp_views_modal_confirm.inc'); ?>

<!-- Includes the modal window to show an article image -->
<?php include(Yii::getAlias('@app').'/views/layouts/cttwapp_views_show_image.inc'); ?>

<!-- Includes the modal window to display the record remarks -->
<?php include(Yii::getAlias('@app').'/views/layouts/cttwapp_views_display_remarks.inc'); ?>

<!-- Includes the jQuery tableScroll plugin and configuring the height and width initial values for the size of the table window -->
<?php $this->registerJs(/** @lang jquery */"jQuery(document).ready(function() { $(\"#dataTable\").tableScroll({height:500, width:5500}); });",View::POS_READY,'fix-Header'); ?>

<?php
    // 2019-04-04 : Display a notification message in the modal window using PHP & jQuery. This occurs when a config process is done.
    $session = Yii::$app->session;

    if ($session->has('configProcess')) {

        $script = "jQuery(document).ready(function () { $(\"#ctt-modal-config\").modal({show: true, backdrop: \"static\"}); });";
        $this->registerJs($script, View::POS_READY);

    }
?>