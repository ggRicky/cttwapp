<?php

use yii\helpers\Html;

/* 2018-03-17 : Used to display Description Type for the actual client record */
use yii\helpers\ArrayHelper;
use yii\widgets\Pjax;
use yii\helpers\Url;
use yii\web\View;
use app\models\ClientType;

/* 2019-04-05 : Used to extend the GridView class */
use frontend\components\GridView;

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

            <!-- 2018-05-23 : Flash warning message. Auto closable -->
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

                <?php
                    // 2019-01-04 : Only for debug purpose
                    // $file = "/var/www/web/cttwapp/frontend/views/client/index_client.php";
                    // $line = 161;
                    // print "<a href='phpstorm://open?url=file://$file&line=$line'>Open with PhpStorm</a>";
                ?>

                <?= GridView::widget([
                    'dataProvider' => $dataProvider,
                    'filterModel' => $searchModel,

                    // 2019-01-17 : Sets the id to 'dataTable' and the css table classes to display the right colors.
                    'tableOptions' => ['id' => 'dataTable', 'class' => 'table-striped table-bordered tablescroll_colors tablescroll_colors-hover'],

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
                            'header' => '<span>'.Yii::t('app','Acción').'</span>',
                            // 2019-04-05 : Determines the Action column wide ( 1.5% ) in the GridView control
                            'headerOptions' => ['style' => 'width:1.5%; color:#8b8787;'],
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
                                            'data-confirm' => Yii::t('app', '¿ Está seguro de eliminar este elemento ?').'<br>'.$model->id.'&nbsp;-&nbsp;'.$model->business_name,
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
                            'headerOptions' => ['style' => 'width:1.5%; color:#8b8787;'],
                            'contentOptions' => ['class' => 'text-center', 'style' => 'height:30px;'],   // 2019-07-21 : Determines the rows height ( 30px ) in the GridView control
                        ],

                        [
                            'attribute' => 'id',
                            'headerOptions' => ['style' => 'width:5%'],
                        ],

                        [
                            'attribute' =>'rfc',
                            'contentOptions' => ['style' => 'text-transform:uppercase;'],  // 2019-07-29 : Transforms all characters to uppercase
                        ],

                        [
                            'attribute' => 'curp',
                            'visible' => ($c[0]== '1' ? true : false),     // 2018-09-30 : Set the column visibility status
                            'contentOptions' => ['style' => 'text-transform:uppercase;'],  // 2019-07-29 : Transforms all characters to uppercase
                        ],

                        // 2018-04-10 : New fields add to client table in refactoring action.

                        [
                            'attribute' => 'business_name',
                            'visible' => ($c[1]== '1' ? true : false),     // 2018-09-30 : Set the column visibility status
                            'contentOptions' => ['style' => 'color:red; text-transform:uppercase;'],  // 2019-07-29 : Transforms all characters to uppercase
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
                            'contentOptions' => ['style' => 'text-transform:uppercase;'],  // 2019-07-29 : Transforms all characters to uppercase
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
                            'contentOptions' => ['style' => 'text-transform:uppercase;'],  // 2019-07-29 : Transforms all characters to uppercase
                        ],

                        [
                            'attribute' => 'contact_email',
                            'visible' => ($c[6]== '1' ? true : false),     // 2018-09-30 : Set the column visibility status
                        ],

                        [
                            'attribute' => 'street',
                            'visible' => ($c[7]== '1' ? true : false),     // 2018-09-30 : Set the column visibility status
                            'contentOptions' => ['style' => 'text-transform:uppercase;'],  // 2019-07-29 : Transforms all characters to uppercase
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
                            'contentOptions' => ['style' => 'text-transform:uppercase;'],  // 2019-07-29 : Transforms all characters to uppercase
                        ],

                        [
                            'attribute' => 'municipality',
                            'visible' => ($c[11]== '1' ? true : false),     // 2018-09-30 : Set the column visibility status
                            'contentOptions' => ['style' => 'text-transform:uppercase;'],  // 2019-07-29 : Transforms all characters to uppercase
                        ],

                        [
                            'attribute' => 'delegation',
                            'visible' => ($c[12]== '1' ? true : false),     // 2018-09-30 : Set the column visibility status
                            'contentOptions' => ['style' => 'text-transform:uppercase;'],  // 2019-07-29 : Transforms all characters to uppercase
                        ],

                        [
                            'attribute' => 'state',
                            'visible' => ($c[13]== '1' ? true : false),     // 2018-09-30 : Set the column visibility status
                            'contentOptions' => ['style' => 'text-transform:uppercase;'],  // 2019-07-29 : Transforms all characters to uppercase
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
                            'contentOptions' => ['style' => 'text-transform:uppercase;'],  // 2019-07-29 : Transforms all characters to uppercase
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
                            // 2019-10-24 : Adds the 'filter' option to display a DropDownList with the available client types.
                            'filter' => Html::activeDropDownList($searchModel, 'client_type_id', ArrayHelper::map(ClientType::find()->select(['id','type_desc'])->orderBy(['id' => SORT_ASC])->all(),'id','displayTypeDesc'), ['prompt' => Yii::t('app','Ver Todos...'), 'data-toggle' => 'tooltip', 'title' => Yii::t('app', 'Tipos Disponibles')]),
                            'attribute' => 'client_type_id',
                            'visible' => ($c[24]== '1' ? true : false),     // 2018-09-30 : Set the column visibility status
                            'headerOptions' => ['style' => 'width:12%'],
                            'value' => function($model){
                                return implode(",",ArrayHelper::map(ClientType::find()->where(['id' =>  $model->client_type_id])->all(),'id','displayTypeDesc'));
                            }

                        ],
                    ],

                    'layout' => '{items}{summary}{pager}',
                ]);?>

                <!-- 2019-04-05 : This jQuery's piece of code implements re-start several functionalities -->
                <?php $this->registerJs(
                    /** @lang jQuery */
                "// This code is implemented for re-start several functionalities after each Pjax request.
                    $(document).on('pjax:success', function(event) {

                        // 2018-08-23 : Re-start the Bootstrap Tooltips.
                        $('[data-toggle=\"tooltip\"]').tooltip({trigger:'hover', animation:true, delay:{show:1000, hide:100}});

                        // 2019-01-17 : Re-start the tableScroll plugin. Sets the height and width values to grow up or grow down the size of table window. 
                        $(\"#dataTable\").tableScroll({height:500, width:4500});
                        
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
                           echo Html::a('', ['client/get-page-size'], ['class' => 'btn glyphicon glyphicon-th-list', 'data-toggle' => 'tooltip', 'title' => Yii::t('app', 'Tamaño del Paginado')]);
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

<!-- Includes the custom modal window to confirm the GridView actions-->
<?php include(Yii::getAlias('@app').'/views/layouts/cttwapp_views_modal_confirm.inc'); ?>

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