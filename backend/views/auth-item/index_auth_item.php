<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\AuthItemSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

// 2018-06-21 : If the user isn't authenticated, then redirect him to the login form.
if (Yii::$app->user->getIsGuest()){
    Yii::$app->session->setFlash('error', Yii::t('app', 'Usted esta tratando de ingresar al sistema de forma no autorizada. Por favor, primero autentifique su acceso.'));
    Yii::$app->response->redirect(Url::to(['site/login'], true));
    return;
}

$this->title = 'Objetos de Autorización';
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

// 2018-04-26 : Used to get a random int, and display a random parallax.
$randomBg = rand(1,11);

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
        <?php include(Yii::getAlias('@app').'/views/layouts/cttwapp_view_menu_options_bke.inc'); ?>
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

<!-- Orange ribbon decoration -->
<section id="work-area-index" class="ctt-section bg-secondary">
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
            <?= Html::a(Yii::t('app','R e g r e s a r'), ['site/index'], ['class' => 'btn btn-dark btn-ctt-fixed-width', 'title' => Yii::t('app', 'Regresar al nivel anterior')]) ?>
        </div>
    </div>

    <!-- Yii2 Title layout -->
    <div class="row">
        <div class="col-lg-10 yii2-header">
            <p><?= Yii::t('app', $this->title); ?></p>
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

            <!-- 2018-05-26 : If there is an flash message, then display it.-->
            <?php if (Yii::$app->session->hasFlash('warning')): ?>
                <div id="auto-close" class="alert alert-warning alert-dismissible fade in">
                    <a href="#" class="close" data-dismiss="alert" aria-label="close" title="<?= Yii::t('app','Cerrar') ?>">&times;</a>
                    <h4><strong>¡ <?= Yii::t('app','Advertencia'); ?> !</strong></h4>
                    <p><?= Yii::$app->session->getFlash('warning') ?></p>
                </div>
                <!-- 2018-05-26 : Flash success message. -->
            <?php elseif (Yii::$app->session->hasFlash('success')): ?>
                <div id="auto-close" class="alert alert-success alert-dismissible fade in">
                    <a href="#" class="close" data-dismiss="alert" aria-label="close" title="<?= Yii::t('app','Cerrar') ?>">&times;</a>
                    <h4><strong>¡ <?= Yii::t('app','Información'); ?> !</strong></h4>
                    <p><?= Yii::$app->session->getFlash('success') ?></p>
                </div>
            <?php endif; ?>

            <!-- 2018-06-21 : Yii2 Rbac - Validates the access. -->
            <?php if (\Yii::$app->user->can('adminProcess')): ?>

                <!-- 2018-05-28 : Begin the ajax functionality to refresh only the GridView widget contents. -->
                <?php Pjax::begin(); ?>

                    <p>
                        <?= Html::a(Yii::t('app', 'Crear') ." ". Yii::t('app', 'Objeto de Autorización'), ['create', 'page'=>Yii::$app->getRequest()->getQueryParam('page')], ['class' => 'btn btn-success']) ?>
                    </p>

                    <div id="div-scroll" class="div-scroll-area-horizon">

                        <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

                        <?= GridView::widget([
                            'dataProvider' => $dataProvider,
                            'filterModel' => $searchModel,
                            'rowOptions' => function($model){

                                // 2018-05-27 : Change the row background color based on the type attribute value.

                                if ($model->type == 1){
                                    return ['class' => 'teal-light'];
                                }
                                else{
                                    return ['class' => 'lime-light'];
                                }
                            },

                            'columns' => [

                                // 2018-05-27 : This code adds the current page as an URL parameter to the update and view buttons in the column actions.
                                [
                                    'class' => 'yii\grid\ActionColumn',
                                    'template' => '{view} {update} {delete}',
                                    'buttons' => [
                                        'update' => function ($url) use ($dataProvider) {
                                            $url .= '&page=' . ($dataProvider->pagination->page + 1);
                                            return Html::a('<span class="glyphicon glyphicon-pencil"></span>', $url);
                                        },
                                        'view' => function ($url) use ($dataProvider) {
                                            $url .= '&page=' . ($dataProvider->pagination->page + 1);
                                            return Html::a('<span class="glyphicon glyphicon-eye-open"></span>', $url);
                                        },
                                        // 2018-05-29 : Adds a new delete action to customize the window modal alert.
                                        'delete' => function($url, $model) {
                                            return Html::a('<span class="glyphicon glyphicon-trash"></span>', $url,
                                                [
                                                    'title'       => Yii::t('app', 'Eliminar'),   // 2018-05-28 : Adds the tooltip Delete
                                                    'style'       => 'color:#337ab7, ',                            // 2018-05-28 : Display the glyphicon-trash in red color like a warning signal.
                                                    'onMouseOver' => 'this.style.color=\'#f00\'',                  // 2018-06-06 : When mouse is hover on the link, the color changes
                                                    'onMouseOut'  => 'this.style.color=\'#337ab7\'',               //              to red advising danger in delete operation.
                                                    // 2018-05-31 : A data set may be send like parameters to the overwritten function yii.confirm. And in the function, the data may be retrieved
                                                    // and displayed in the modal window.
                                                    'data' => [
                                                        // 2018-05-28 : Adds to the modal title the row id, like a warning information.
                                                        'message' => Yii::t('app', '¿ Está seguro de eliminar este elemento ?').'  :  '.($model->name),
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
                                ],
                                ['class' => 'yii\grid\SerialColumn'],

                                'name',

                                // 2018-05-26 : For type attribute color.

                                [
                                    'attribute' => 'type',
                                    'headerOptions' => ['style' => 'width:3%'],
                                    'value' => function($model){
                                        return ($model->type=='1'?'Rol':Yii::t('app', 'Permiso'));
                                    },
                                    'contentOptions' => function ($model, $key, $index, $column) {
                                        return ['style' => 'color:'. ($model->type=='1'?'#428bca':'red')];
                                    },
                                ],

                                'description:ntext',
                                'rule_name',

                                [
                                    'attribute' => 'created_at',
                                    'value' => function($model){
                                        return (date('Y-m-d G:i:s', $model->created_at));
                                    },
                                ],
                                [
                                    'attribute' => 'updated_at',
                                    'value' => function($model){
                                        return (date('Y-m-d G:i:s', $model->updated_at));
                                    },
                                ],

                                'data',
                            ],

                            'layout' => '{summary}{items}{pager}',

                        ]); ?>
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

        </div>
    </div>
</section>

<!-- Includes the view's footer file -->
<?php include(Yii::getAlias('@app').'/views/layouts/cttwapp_views_footer_bke.inc'); ?>

<!-- Includes the modal window to confirm the delete operation-->
<?php include(Yii::getAlias('@app').'/views/layouts/cttwapp_views_confirm_delete_bke.inc'); ?>
