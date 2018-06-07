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

$this->title = 'Artículos';
$asset = \frontend\assets\AppAsset::register($this);
$baseUrl = $asset->baseUrl;

// 2018-05-06 : If there are a query or sort criteria is in progress, then skip the header and go just to the work-area-index using javascript code.
$search_param = \yii\helpers\ArrayHelper::keyExists('ArticleSearch',$qryParams);
$sort_param   = \yii\helpers\ArrayHelper::keyExists('sort',$qryParams);
$skip_param   = (\yii\helpers\ArrayHelper::getValue($qryParams, '1.#')=='work-area-index'?true:false);

// 2018-06-03 : if any of the following conditions are met, then jump to the work-area-index anchor.
If ($search_param || $sort_param || $skip_param || Yii::$app->session->hasFlash('error'))
{
$script = <<< JS
    location.hash = "#work-area-index";
JS;
    $this->registerJs($script);
}

// 2018-04-26 : Used to get a random int, and display a random parallax.
$randomBg = rand(1,13);

?>

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
            <?= Html::a(Yii::t('app','R e g r e s a r'), ['site/index'], ['class' => 'btn btn-dark', 'title' => Yii::t('app', 'Regresar al nivel anterior')]) ?>
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
            <p><?= Yii::t('app','Listado Nominal');?></p>
        </div>
    </div>

    <!-- Yii2 work area -->
    <div class="row">
        <div class="col-lg-12 text-justify yii2-content">

            <!-- 2018-06-03 : Begin the ajax functionality to refresh only the GridView widget contents. -->
            <?php Pjax::begin(); ?>

            <!-- 2018-05-24 : If there is an flash message, then display it.-->
            <?php if (Yii::$app->session->hasFlash('error')): ?>
                <div class="alert alert-warning alert-dismissible fade in">
                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                    <h4><strong>¡ <?= Yii::t('app','Advertencia'); ?> !</strong></h4>
                    <p><?= Yii::$app->session->getFlash('error') ?></p>
                </div>
                <!-- 2018-05-25 : Flash success message. -->
            <?php elseif (Yii::$app->session->hasFlash('success')): ?>
                <div class="alert alert-success alert-dismissible fade in">
                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                    <h4><strong>¡ <?= Yii::t('app','Información'); ?> !</strong></h4>
                    <p><?= Yii::$app->session->getFlash('success') ?></p>
                </div>
            <?php endif; ?>

            <!-- Used to jump to the right position when 'Code with colors' option is enabled or disabled -->
            <span id="panel-area"></span>

            <!-- 2018-05-23 : Yii2 Rbac - Validates the access. -->
            <?php if (\Yii::$app->user->can('listArticle')): ?>

                <p>
                    <?= Html::a(Yii::t('app', 'Crear Artículo'), ['create', 'page'=>Yii::$app->getRequest()->getQueryParam('page')], ['class' => 'btn btn-success', 'title' => Yii::t('app', 'Crear un nuevo artículo')]) ?>
                    <?= Html::a(Yii::t('app', 'Catálogos'), ['catalog/index', 'page'=>Yii::$app->getRequest()->getQueryParam('page'), ['#' => 'work-area-index']], ['class' => 'btn btn-primary', 'title' => Yii::t('app', 'Administrar los catálogos')]) ?>
                    <?= Html::a(Yii::t('app', 'Marcas'), ['brand/index', 'page'=>Yii::$app->getRequest()->getQueryParam('page'), ['#' => 'work-area-index']], ['class' => 'btn btn-warning', 'title' => Yii::t('app', 'Administrar las marcas')]) ?>
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
                                                'style'   => 'color:red',   // 2018-05-28 : Display the glyphicon-trash in red color like a warning signal.
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

            <?php else: ?>

                <?php Yii::$app->session->setFlash('error', Yii::t('app', 'Su perfil de acceso no le autoriza a utilizar esta acción. Por favor contacte al administrador del sistema para mayores detalles.')); ?>

                <div class="alert alert-warning alert-dismissible fade in">
                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                    <h4><strong>¡ <?= Yii::t('app','Advertencia'); ?> !</strong></h4>
                    <p><?= Yii::$app->session->getFlash('error') ?></p>
                </div>

            <?php endif; ?>

            <!-- 2018-05-28 : Ends the ajax functionality to refresh only the GridView widget contents. -->
            <?php Pjax::end(); ?>

            <br/>
            <!-- 2018-05-14 : Improvement. The next two <a> tags call the color action from articleController and pass the color parameter to it. -->
            <div class="panel panel-default">
                <div class="panel-heading"><span class="text-info"><?= Yii::t('app', 'Herramientas') ?></span></div>
                <div class="panel-body">
                   <span>
                   <?php
                       $color_expr = Yii::$app->getRequest()->getCookies()->has('article-color') && Yii::$app->getRequest()->getCookies()->getValue('article-color') == '0';
                       if ($color_expr){ echo Html::a('', ['article/color', 'color' => '1'], ['class' => 'btn glyphicon glyphicon-tint', 'style' => 'color:#999', 'title' => Yii::t('app', 'Activar código de colores')]); }
                       else{ echo Html::a('', ['article/color', 'color' => '0'], ['class' => 'btn glyphicon glyphicon-tint', 'style' => 'color:#ff0000', 'title' => Yii::t('app', 'Desactivar código de colores')]); }
                       echo 'Color';
                   ?>
                   </span>
                </div>
            </div>

            <div class="well well-sm text-info"><span><?= Yii::t('app', 'IMPORTANTE : La información que se muestra en la relación, corresponde a datos experimentales de prueba.');?></span></div>

        </div>
    </div>

</section>

<section>
    <!-- A button for go to the page's top -->
    <div class="col-lg-10 col-lg-offset-1 text-center up-btn-area">
        <div class="tooltip-conf">
            <span class="tooltip-text"><?=Yii::t('app', 'Ir al inicio');?></span>
            <a href="#work-area-index">
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
    <section class="ctt-section-footer ctt-footer-container">
        <div class="col-lg-12">
            <div class="row "></div>
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