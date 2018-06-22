<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* 2018-05-06 : Used to display the catalog name for the actual article record */
use yii\helpers\ArrayHelper;
use yii\widgets\Pjax;
use yii\helpers\Url;
use app\models\Catalog;
use app\models\Brand;

/* @var $this yii\web\View */
/* @var $searchModel app\models\ArticleSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $qryParams */

// 2018-06-09 : If the user isn't authenticated, then redirect him to the login form.
if (Yii::$app->user->getIsGuest()){
    Yii::$app->session->setFlash('error', Yii::t('app', 'Usted esta tratando de ingresar al sistema de forma no autorizada. Por favor, primero autentifique su acceso.'));
    Yii::$app->response->redirect(Url::to(['site/login'], true));
    return;
}

$this->title = 'Artículos';
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

<!-- Navigation -->
<!-- Open menu button -->
<a id="menu-toggle" href="#" class="btn btn-dark btn-lg btn-toggle"><i class="fa fa-bars"></i></a>

<nav id="sidebar-wrapper">
    <ul class="sidebar-nav">
        <!-- Close menu button -->
        <div class="sidebar-top">
            <a id="menu-close" href="#" class="btn btn-light btn-lg pull-right btn-toggle"><i class="fa fa-times"></i></a>
        </div>

        <!-- CTT mini-logo ribbon -->
        <div class="container-fluid ctt-mini-logo-top">
            <img src="<?=$baseUrl?>/img/ctt-mini-logo_1.jpg" class="pull-left img-responsive" height="42" width="105"/>
        </div>

        <!-- Includes the menu options file -->
        <?php include(Yii::getAlias('@app').'/views/layouts/cttwapp_menu_options.inc'); ?>
    </ul>
</nav>

<!-- Header -->
<header id="top">
    <div class="row"> <!-- Bootstrap's row -->
        <div class="col-lg-12"> <!-- Bootstrap's col -->
            <!-- CTT logo to display over the parallax efect with opacity level -->
            <img src="<?=$baseUrl?>/img/ctt-logo_1.png" class="ctt-logo">
            <!-- Parallax Efect -->
            <div id="parallax<?=$randomBg?>" class="parallax-section" data-stellar-background-ratio="0.5">
                <div class="row"></div>
            </div>
        </div>
    </div>
</header>

<!-- Blue ribbon decoration -->
<section id="work-area-index" class="ctt-section bg-primary">
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
            <?= Html::a(Yii::t('app','R e g r e s a r'), ['site/index'], ['target' => '_self', 'class' => 'btn btn-dark btn-ctt-fixed-width', 'title' => Yii::t('app', 'Regresar al nivel anterior')]) ?>
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
                    <a href="#" class="close" data-dismiss="alert" aria-label="close" title="<?= Yii::t('app','Cerrar') ?>">&times;</a>
                    <h4><strong>¡ <?= Yii::t('app','Advertencia'); ?> !</strong></h4>
                    <p><?= Yii::$app->session->getFlash('warning') ?></p>
                </div>
            <!-- 2018-05-25 : Flash success message. -->
            <?php elseif (Yii::$app->session->hasFlash('success')): ?>
                <div id="auto-close" class="alert alert-success alert-dismissible fade in">
                    <a href="#" class="close" data-dismiss="alert" aria-label="close" title="<?= Yii::t('app','Cerrar') ?>">&times;</a>
                    <h4><strong>¡ <?= Yii::t('app','Información'); ?> !</strong></h4>
                    <p><?= Yii::$app->session->getFlash('success') ?></p>
                </div>
            <?php endif; ?>

            <!-- Used to jump to the right position when 'Code with colors' option is enabled or disabled -->
            <span id="panel-area"></span>

            <!-- 2018-05-23 : Yii2 Rbac - Validates the access. -->
            <?php if (\Yii::$app->user->can('listArticle')): ?>

                <!-- 2018-05-28 : Begin the ajax functionality to refresh only the GridView widget contents. -->
                <?php Pjax::begin(); ?>

                <p>
                    <?= Html::a(Yii::t('app', 'Crear Artículo'), ['create', 'page'=>$curr_page], ['class' => 'btn btn-success btn-ctt-fixed-width', 'title' => Yii::t('app', 'Crear un nuevo registro de artículo')]) ?>
                    <!-- 2018-06-07 : To disable pjax for a specific link inside the container adding data-pjax="0" attribute to this link.-->
                    <?= Html::a(Yii::t('app', 'Catálogos'), ['catalog/index'], ['data-pjax' => '0', 'target' => '_self', 'class' => 'btn btn-primary btn-ctt-fixed-width', 'title' => Yii::t('app', 'Administrar los catálogos')]) ?>
                    <!-- 2018-06-07 : To disable pjax for a specific link inside the container adding data-pjax="0" attribute to this link.-->
                    <?= Html::a(Yii::t('app', 'Marcas'), ['brand/index'], ['data-pjax' => '0', 'target' => '_self', 'class' => 'btn btn-primary btn-ctt-fixed-width', 'title' => Yii::t('app', 'Administrar las marcas')]) ?>
                </p>

                <!-- 2018-04-13 : The next div, including the id and class elements, enable the vertical and horizontal scrollbars. -->
                <div id="div-scroll" class="div-scroll-area-horizon">

                    <?= GridView::widget([
                        'dataProvider' => $dataProvider,
                        'filterModel' => $searchModel,
                        'rowOptions' => function($model){
                            // 2018-04-23 : The next conditional statement enable colored rows based on specific database value
                            // 2018-05-14 : Improvement. The color on/off status is stored in a cookie.
                            if (Yii::$app->getRequest()->getCookies()->has('article-color') &&
                                Yii::$app->getRequest()->getCookies()->getValue('article-color') == '1'){
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
                                'class' => 'yii\grid\ActionColumn',
                                'headerOptions' => ['style' => 'width:4%'],
                                // 2018-06-03 : Redefines the default {delete} action from the template and adds the new behaviors like an customized modal window.
                                'template' => '{view} {update} {delete}',
                                'buttons' => [
                                    // 2018-06-03 : Adds the title property to show the right tooltip when mouse is hover the glyphicon.
                                    'view' => function ($url) {
                                        return Html::a('<span class="glyphicon glyphicon-eye-open"></span>', $url, [
                                            'title' => Yii::t('app', 'Ver'),           // 2018-06-03 : Adds the tooltip View
                                        ]);
                                    },
                                    // 2018-06-03 : Adds the title property to show the right tooltip when mouse is hover the glyphicon.
                                    'update' => function ($url) {
                                        return Html::a('<span class="glyphicon glyphicon-pencil"></span>', $url, [
                                            'title' => Yii::t('app', 'Modificar') ,     // 2018-06-03 : Adds the tooltip Modify
                                        ]);
                                    },
                                    // 2018-06-03 : Adds a new delete action to customize the window modal alert.
                                    'delete' => function($url, $model) {
                                        return Html::a('<span class="glyphicon glyphicon-trash"></span>', $url,
                                            [
                                                'title'   => Yii::t('app', 'Eliminar'),      // 2018-06-03 : Adds the tooltip Delete
                                                'style'       => 'color:#337ab7, ',                            // 2018-05-28 : Display the glyphicon-trash in red color like a warning signal.
                                                'onMouseOver' => 'this.style.color=\'#f00\'',                  // 2018-06-06 : When mouse is hover on the link, the color changes
                                                'onMouseOut'  => 'this.style.color=\'#337ab7\'',               //              to red advising danger in delete operation.
                                                // 2018-06-03 : A data set may be send like parameters to the overwritten function yii.confirm. And in the function, the data may be retrieved
                                                // and displayed in the modal window.
                                                'data' => [
                                                    // 2018-06-03 : Adds to the modal title the row id, like a warning information.
                                                    'message' => Yii::t('app', '¿ Está seguro de eliminar este elemento ?').'  :  '.($model->id),
                                                ],
                                                // 2018-06-03 : Important : The 'data-confirm' parameter must be there, because it trigger a modal confirmation window before run the action delete.
                                                // In the same way, through this parameter can be pass the user's message to the overwritten function yii.confirm, located in the cttwapp-stylish.css file.
                                                // An other way to send the user's message to the overwritten function yii.confirm, is through a data array, like showed above.
                                                // In this case the 'data-confirm' parameter must be empty.
                                                'data-confirm' => '',
                                                //  2018-06-03 : The next two parameters are needed to complete teh right call to the action delete, because it will be made using the post method.
                                                'data-method' => 'post',
                                                'data-pjax' => '0',
                                            ]);
                                    },
                                ],
                                // 2018-06-03 : Adds an url that include the current page in GridView widget.
                                'urlCreator' => function ($action, $model)  use ($dataProvider) {
                                    if ($action === 'delete') {
                                        $url = Url::to(['article/delete', 'id' => $model->id, 'page' => ($dataProvider->pagination->page + 1)]);
                                    }
                                    elseif ($action === 'view') {
                                        $url = Url::to(['article/view', 'id' => $model->id, 'page' => ($dataProvider->pagination->page + 1)]);
                                    }
                                    elseif ($action === 'update') {
                                        $url = Url::to(['article/update', 'id' => $model->id, 'page' => ($dataProvider->pagination->page + 1)]);
                                    }
                                    else $url = null;

                                    // 2018-06-03 : If null value is returned, the url created have only home page address plus &page parameter. The right value is return $url.
                                    return $url;
                                }
                            ],

                            [
                                'class' => 'yii\grid\SerialColumn',
                                'headerOptions' => ['style' => 'width:3%'],
                            ],

                            [
                                'attribute' => 'id',
                                'headerOptions' => ['style' => 'width:3%'],
                            ],

                            // 2018-05-06 : Modified to display the ID and the Catalog Description instead of the ID only.
                            [
                                 'attribute' => 'catalog_id',
                                 'headerOptions' => ['style' => 'width:12%'],
                                 'value' => function($model){
                                     return implode(",",ArrayHelper::map(Catalog::find()->where(['id' =>  $model->catalog_id])->all(),'id','displayNameCat'));
                                 }
                            ],

                            // 2018-05-06 : The name_art field in red text color.

                            [
                                'attribute' => 'name_art',
                                'contentOptions' => ['style' => 'color:red'],
                            ],

                            'sp_desc',
                            'en_desc',

                            // 2018-05-06 : For type_art field, the right legend is displayed and colored properly.

                            [
                                'attribute' => 'type_art',
                                'value' => function($model){
                                    return ($model->type_art=='R'?'RENTA':'VENTA');
                                },
                                'contentOptions' => function ($model, $key, $index, $column) {
                                    return ['style' => 'color:'. ($model->type_art=='V'?'#337AB7':'#428bca')];
                                },
                            ],

                            'price_art',

                            // 2018-04-23 : To the provenance type, the right legend is displayed.

                            [
                                'attribute' => 'currency_art',
                                'value' => function($model){
                                    return ($model->currency_art=='P'?'PESOS':'DÓLARES');
                                },
                            ],

                            'part_num',

                            // 2018-05-06 : Modified to display the ID and the Catalog Description instead of the ID only.
                            [
                                'attribute' => 'brand_id',
                                'value' =>
                                    function($model){
                                        return (implode(",",ArrayHelper::map(Brand::find()->where(['id' => $model->brand_id])->all(),'id','displayBrandDesc')));
                                },
                            ],

                            'created_at',
                            'updated_at',
                            'created_by',
                            'updated_by',

                        ],

                        'layout' => '{summary}{items}{pager}',
                    ]);?>

                </div>

                <!-- 2018-05-28 : Ends the ajax functionality to refresh only the GridView widget contents. -->
                <?php Pjax::end(); ?>

            <?php else: ?>

                <?php Yii::$app->session->setFlash('warning', Yii::t('app', 'Su perfil de acceso no le autoriza a utilizar esta acción. Por favor contacte al administrador del sistema para mayores detalles.')); ?>

                <div id="auto-close" class="alert alert-warning alert-dismissible fade in">
                    <a href="#" class="close" data-dismiss="alert" aria-label="close" title="<?= Yii::t('app','Cerrar') ?>">&times;</a>
                    <h4><strong>¡ <?= Yii::t('app','Advertencia'); ?> !</strong></h4>
                    <p><?= Yii::$app->session->getFlash('warning') ?></p>
                </div>

            <?php endif; ?>

            <br/>

            <!-- 2018-06-03 : Toolbox -->
            <div class="panel panel-default">
                <div class="panel-heading"><button class="btn btn-light" data-toggle="collapse" data-target="#tools" title="<?=  Yii::t('app', 'Panel de Herramientas') ?>"><span class="text-info"><?= Yii::t('app', 'Herramientas') ?></span>&nbsp;&nbsp;<span><i class="fa fa-refresh fa-spin fa-1x fa-fw text-info"></i></span></button></div>
                <div id="tools" class="panel-collapse collapse">
                    <div class="panel-body">
                        <!-- Help Tool -->
                        <span>
                           <?php
                               echo Html::a('', ['help/view', 'theme' => '_article', 'ret_url' => 'article/index', 'ret_hash' => '0' ], ['class' => 'btn glyphicon glyphicon-question-sign', 'title' => Yii::t('app', 'Ayuda')]);
                               echo '<span>'.Yii::t('app', 'Ayuda').'</span>';
                           ?>
                       </span>
                        <!-- Color Tool -->
                        <span>
                           <!-- 2018-05-14 : Improvement. The next two <a> tags call the color action from clientController and pass the color parameter to it. -->
                            <?php
                            $color_expr = Yii::$app->getRequest()->getCookies()->has('article-color') && Yii::$app->getRequest()->getCookies()->getValue('article-color') == '0';
                            if ($color_expr){
                                echo Html::a('', ['article/color', 'color' => '1'], ['class' => 'btn glyphicon glyphicon-tint', 'title' => Yii::t('app', 'Activar código de colores')]);
                                echo '<span>'.Yii::t('app', 'Interruptor de Color').'</span>';
                            }
                            else{
                                echo Html::a('', ['article/color', 'color' => '0'], ['class' => 'btn glyphicon glyphicon-tint', 'title' => Yii::t('app', 'Desactivar código de colores')]);
                                echo '<span>'.Yii::t('app', 'Interruptor de Color').'</span>';
                            }
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
<?php include(Yii::getAlias('@app').'/views/layouts/cttwapp_confirm_delete.inc'); ?>