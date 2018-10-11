<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* 2018-03-17 : Used to display Description Type for the actual client record */
use yii\helpers\ArrayHelper;
use yii\helpers\VarDumper;
use yii\widgets\Pjax;
use yii\helpers\Url;
use app\models\ClientType;

/* @var $this yii\web\View */
/* @var $searchModel app\models\ClientSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $qryParams */

$this->title = 'Clientes';
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
$randomBg = rand(1,11);

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

            <!-- Used to jump to the right position when 'Code with colors' option is turned -->
            <span id="panel-area"></span>

            <!-- 2018-05-28 : Begin the ajax functionality to refresh only the GridView widget contents. -->
            <?php Pjax::begin(); ?>

                <p>
                    <?= Html::a(Yii::t('app', 'Crear Cliente'), ['create', 'page'=>$curr_page], ['class' => 'btn btn-success btn-ctt-fixed-width', 'data-toggle' => 'tooltip',  'title' => Yii::t('app', 'Crear un nuevo registro de cliente')]) ?>
                    <!-- 2018-06-07 : To disable pjax for a specific link inside the container adding data-pjax="0" attribute to this link.-->
                    <?= Html::a(Yii::t('app', 'Tipos de Clientes'), ['client-type/index'], ['data-pjax' => '0', 'target' => '_self', 'class' => 'btn btn-primary btn-ctt-fixed-width', 'data-toggle' => 'tooltip', 'title' => Yii::t('app', 'Administrar los tipos de clientes')]) ?>
                </p>

                <?php

                // 2018-09-30 : Gets the visibility status for all columns from the cookies and put it into the $c variable.
                if (Yii::$app->getRequest()->getCookies()->has('client_columns_config')) {
                    $c = Yii::$app->getRequest()->getCookies()->getValue('client_columns_config');
                    // 2018-09-30 : Only for debug purpose. Shows the var content.
                    // VarDumper::dump($c);
                }
                else
                    // 2018-09-30 : If there isn't the client_columns_config cookie, then by default shows all the columns.
                    $c = '1111111111111111111111111';

                // 2018-09-30 : Gets the value from the cookie and assign it to the $dataProvider->pageSize.
                if (Yii::$app->getRequest()->getCookies()->has('client-pageSize'))
                    $dataProvider->pagination->pageSize = Yii::$app->getRequest()->getCookies()->getValue('client-pageSize');
                else
                    // 2018-09-30 : Sets the $dataProvider->pageSize to a default value
                    $dataProvider->pagination->pageSize = 10;
                ?>

                <!-- 2018-04-13 : The next div including the id and class elements, enable the vertical and horizontal scrollbars. -->
                <div id="div-scroll" class="div-scroll-area-horizon">

                    <?= GridView::widget([
                        'dataProvider' => $dataProvider,
                        'filterModel' => $searchModel,
                        'rowOptions' => function($model){
                            // 2018-04-23 : The next conditional statement enable colored rows based on specific database value
                            // 2018-05-14 : Improvement. The color on/off status is stored in a cookie.
                            if (Yii::$app->getRequest()->getCookies()->has('client-color') &&
                                Yii::$app->getRequest()->getCookies()->getValue('client-color') == '1'){
                                // 2018-04-15 : Change the row background color based on the client_type_id value.
                                if ($model->client_type_id == 1)
                                {
                                    return ['class' => 'blue-light'];
                                }else if ($model->client_type_id == 2)
                                {
                                    return ['class' => 'red-light'];
                                }else if ($model->client_type_id == 3)
                                {
                                    return ['class' => 'teal-light'];
                                }else if ($model->client_type_id == 4)
                                {
                                    return ['class' => 'lime-light'];
                                }else if ($model->client_type_id == 5)
                                {
                                    return ['class' => 'orange-light'];
                                };
                                return [];
                            }
                            return [];
                        },

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
                                // 2018-05-28 : Adds an url that includes the current page in GridView widget.
                                'urlCreator' => function ($action, $model)  use ($dataProvider) {
                                    if ($action === 'delete') {
                                         $url = Url::to(['client/delete', 'id' => $model->id, 'page' => ($dataProvider->pagination->page + 1)]);
                                    }
                                    elseif ($action === 'view') {
                                         $url = Url::to(['client/view', 'id' => $model->id, 'page' => ($dataProvider->pagination->page + 1)]);
                                    }
                                    elseif ($action === 'update') {
                                         $url = Url::to(['client/update', 'id' => $model->id, 'page' => ($dataProvider->pagination->page + 1)]);
                                    }
                                    else $url = null;

                                    // 2018-05-29 : If null value is returned, the url created have only home page address plus &page parameter. The right value is return $url.
                                    return $url;
                                }
                            ],

                            [
                                'class' => 'yii\grid\SerialColumn',
                                'headerOptions' => ['style' => 'width:3%'],
                            ],

                            [
                                'attribute' => 'id',
                                'headerOptions' => ['style' => 'width:5%'],
                            ],

                            'rfc',

                            [
                                'attribute' => 'curp',
                                'visible' => ($c[0]== '1' ? true : false),     // 2018-09-30 : Set the column visibility status
                            ],

                            // 2018-04-10 : New fields add to client table in refactoring action.

                            [
                                'attribute' => 'business_name',
                                'visible' => ($c[1]== '1' ? true : false),     // 2018-09-30 : Set the column visibility status
                                'contentOptions' => ['style' => 'color:red'],
                            ],

                            // 2018-04-23 : To the taxpayer type, the right legend is displayed and colored properly.

                            [
                                'attribute' => 'taxpayer',
                                'visible' => ($c[2]== '1' ? true : false),     // 2018-09-30 : Set the column visibility status
                                'value' => function($model){
                                    return ($model->taxpayer=='M'?'PERSONA MORAL':'PERSONA FÍSICA');
                                },
                                'contentOptions' => function ($model, $key, $index, $column) {
                                    return ['style' => 'color:'. ($model->taxpayer=='M'?'grey':'#428bca')];
                                },
                            ],

                            [
                                'attribute' => 'corporate',
                                'visible' => ($c[3]== '1' ? true : false),     // 2018-09-30 : Set the column visibility status
                            ],

                            // 2018-04-23 : For provenance type, the right legend is displayed.

                            [
                                'attribute' => 'provenance',
                                'visible' => ($c[4]== '1' ? true : false),     // 2018-09-30 : Set the column visibility status
                                'value' => function($model){
                                    return ($model->provenance=='N'?'NACIONAL':'EXTRANJERO');
                                },
                            ],

                            [
                                'attribute' => 'contact_name',
                                'visible' => ($c[5]== '1' ? true : false),     // 2018-09-30 : Set the column visibility status
                            ],

                            [
                                'attribute' => 'contact_email',
                                'visible' => ($c[6]== '1' ? true : false),     // 2018-09-30 : Set the column visibility status
                            ],

                            [
                                'attribute' => 'street',
                                'visible' => ($c[7]== '1' ? true : false),     // 2018-09-30 : Set the column visibility status
                            ],

                            [
                                'attribute' => 'outdoor_number',
                                'visible' => ($c[8]== '1' ? true : false),     // 2018-09-30 : Set the column visibility status
                            ],

                            [
                                'attribute' => 'interior_number',
                                'visible' => ($c[9]== '1' ? true : false),     // 2018-09-30 : Set the column visibility status
                            ],

                            [
                                'attribute' => 'suburb',
                                'visible' => ($c[10]== '1' ? true : false),     // 2018-09-30 : Set the column visibility status
                            ],

                            [
                                'attribute' => 'municipality',
                                'visible' => ($c[11]== '1' ? true : false),     // 2018-09-30 : Set the column visibility status
                            ],

                            [
                                'attribute' => 'delegation',
                                'visible' => ($c[12]== '1' ? true : false),     // 2018-09-30 : Set the column visibility status
                            ],

                            [
                                'attribute' => 'state',
                                'visible' => ($c[13]== '1' ? true : false),     // 2018-09-30 : Set the column visibility status
                            ],

                            [
                                'attribute' => 'zip_code',
                                'visible' => ($c[14]== '1' ? true : false),     // 2018-09-30 : Set the column visibility status
                            ],

                            [
                                'attribute' => 'phone_number_1',
                                'visible' => ($c[15]== '1' ? true : false),     // 2018-09-30 : Set the column visibility status
                            ],

                            [
                                'attribute' => 'phone_number_2',
                                'visible' => ($c[16]== '1' ? true : false),     // 2018-09-30 : Set the column visibility status
                            ],

                            [
                                'attribute' => 'web_page',
                                'visible' => ($c[17]== '1' ? true : false),     // 2018-09-30 : Set the column visibility status
                            ],

                            [
                                'attribute' => 'client_email',
                                'visible' => ($c[18]== '1' ? true : false),     // 2018-09-30 : Set the column visibility status
                            ],

                            [
                                'attribute' => 'considerations',
                                'visible' => ($c[19]== '1' ? true : false),     // 2018-09-30 : Set the column visibility status
                            ],

                            [
                                'attribute' => 'created_at',
                                'visible' => ($c[20]== '1' ? true : false),     // 2018-09-30 : Set the column visibility status
                            ],

                            [
                                'attribute' => 'updated_at',
                                'visible' => ($c[21]== '1' ? true : false),     // 2018-09-30 : Set the column visibility status
                            ],

                            [
                                'attribute' => 'created_by',
                                'visible' => ($c[22]== '1' ? true : false),     // 2018-09-30 : Set the column visibility status
                            ],

                            [
                                'attribute' => 'updated_by',
                                'visible' => ($c[23]== '1' ? true : false),     // 2018-09-30 : Set the column visibility status
                            ],

                            // 2018-03-17 : Modified to display the ID and the Client Type Description instead of the ID only.
                            [
                                'attribute' => 'client_type_id',
                                'visible' => ($c[24]== '1' ? true : false),     // 2018-09-30 : Set the column visibility status
                                'headerOptions' => ['style' => 'width:12%'],
                                'value' => function($model){
                                    return implode(",",ArrayHelper::map(ClientType::find()->where(['id' =>  $model->client_type_id])->all(),'id','displayTypeDesc'));
                                }
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
                               echo Html::a('', ['help/view', 'theme' => '_client', 'ret_url' => 'client/index', 'ret_hash' => '0' ], ['class' => 'btn glyphicon glyphicon-question-sign', 'data-toggle' => 'tooltip', 'title' => Yii::t('app', 'Ayuda')]);
                               echo '<span>'.Yii::t('app', 'Ayuda').'</span>';
                           ?>
                       </span>
                       <!-- Color Tool -->
                       <span>
                           <!-- 2018-05-14 : Improvement. The next two <a> tags call the color action from clientController and pass the color parameter to it. -->
                           <?php
                               $color_expr = Yii::$app->getRequest()->getCookies()->has('client-color') && Yii::$app->getRequest()->getCookies()->getValue('client-color') == '0';
                               if ($color_expr){
                                   echo Html::a('', ['client/set-color', 'color' => '1'], ['class' => 'btn glyphicon glyphicon-tint', 'data-toggle' => 'tooltip', 'title' => Yii::t('app', 'Activar código de colores')]);
                                   echo '<span>'.Yii::t('app', 'Colores').'</span>';
                               }
                               else{
                                   echo Html::a('', ['client/set-color', 'color' => '0'], ['class' => 'btn glyphicon glyphicon-tint', 'data-toggle' => 'tooltip', 'title' => Yii::t('app', 'Desactivar código de colores')]);
                                   echo '<span>'.Yii::t('app', 'Colores').'</span>';
                               }
                           ?>
                       </span>
                        <!-- Columns Selector Tool -->
                        <span>
                           <?php
                           echo Html::a('', ['client/select-columns', 'ret_url' => 'client/index', 'ret_hash' => '0' ], ['class' => 'btn glyphicon glyphicon-list-alt', 'data-toggle' => 'tooltip', 'title' => Yii::t('app', 'Selector de Columnas')]);
                           echo '<span>'.Yii::t('app', 'Columnas').'</span>';
                           ?>
                       </span>
                        <!-- Page Size Tool -->
                        <span>
                           <?php
                           echo Html::a('', ['client/get-page-size', 'ret_url' => 'client/index', 'ret_hash' => '0' ], ['class' => 'btn glyphicon glyphicon-th-list', 'data-toggle' => 'tooltip', 'title' => Yii::t('app', 'Tamaño del Paginado')]);
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

<!-- Includes the modal window to confirm the delete operation-->
<?php include(Yii::getAlias('@app').'/views/layouts/cttwapp_views_confirm_delete.inc'); ?>