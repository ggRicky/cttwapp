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
$asset = \frontend\assets\AppAsset::register($this);
$baseUrl = $asset->baseUrl;

// 2018-04-11 : If there are a query or sort criteria is in progress, then skip the header and go just to the work-area-index using javascript code.
$search_param = \yii\helpers\ArrayHelper::keyExists('ClientTypeSearch',$qryParams);
$sort_param   = \yii\helpers\ArrayHelper::keyExists('sort',$qryParams);
$skip_param   = (\yii\helpers\ArrayHelper::getValue($qryParams, '#')=='work-area-index'?true:false);

If ($search_param || $sort_param || $skip_param)
{
    $script = <<< JS
    location.hash = "#work-area-index";
JS;
    $this->registerJs($script);
}

//2018-04-26 : Used to get a random int, and display a random parallax.
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
            <?= Html::a(Yii::t('app','R e g r e s a r'), ['client/index', 'ret' => '1'], ['class' => 'btn btn-dark', 'title' => Yii::t('app', 'Regresar al nivel anterior')]) ?>
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

            <!-- 2018-05-23 : If there is an flash message, then display it.-->
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

            <!-- 2018-05-23 : Yii2 Rbac - Validates the access. -->
            <?php if (\Yii::$app->user->can('listClientType')): ?>

                <p>
                    <?= Html::a(Yii::t('app','Crear Tipo de Cliente'), ['create'], ['class' => 'btn btn-success']) ?>
                </p>

                <!-- 2018-04-13 : The next div including the id and class elements, enable the vertical and horizontal scrollbars. -->
                <div id="div-scroll" class="div-scroll-area-horizon">

                    <!-- 2018-05-28 : Begin the ajax functionality to refresh only the GridView widget contents. -->
                    <?php Pjax::begin(); ?>

                        <?= GridView::widget([
                        'dataProvider' => $dataProvider,
                        'filterModel' => $searchModel,
                        'columns' => [
                            [ 'class' => 'yii\grid\ActionColumn',
                                'headerOptions' => ['style' => 'width:5%'],
                                'template' => '{view} {update} {delete}',
                                'buttons' => [
                                    // 2018-05-27 : Adds the title property to show the right tooltip when mouse is hover the glyphicon.
                                    'view' => function ($url) {
                                        return Html::a('<span class="glyphicon glyphicon-eye-open"></span>', $url, [
                                            'title' => Yii::t('app', 'Ver'),           // 2018-05-28 : Adds the tooltip View
                                        ]);
                                    },
                                    // 2018-05-27 : Adds the title property to show the right tooltip when mouse is hover the glyphicon.
                                    'update' => function ($url) {
                                        return Html::a('<span class="glyphicon glyphicon-pencil"></span>', $url, [
                                            'title' => Yii::t('app', 'Modificar') ,     // 2018-05-28 : Adds the tooltip Modify
                                        ]);
                                    },
                                    // 2018-05-29 : Adds a new delete action to customize the window modal alert.
                                    'delete' => function($url, $model) {
                                        return Html::a('<span class="glyphicon glyphicon-trash"></span>', $url,
                                            [
                                                'title'   => Yii::t('app', 'Eliminar'),      // 2018-05-28 : Adds the tooltip Delete
                                                'style'   => 'color:red',   // 2018-05-28 : Display the glyphicon-trash in red color like a warning signal.
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

                            [ 'class' => 'yii\grid\SerialColumn',
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
                        ]); ?>

                    <!-- 2018-05-28 : Ends the ajax functionality to refresh only the GridView widget contents. -->
                    <?php Pjax::end(); ?>

                </div>

            <?php else: ?>

                <?php Yii::$app->session->setFlash('error', Yii::t('app', 'Su perfil de acceso no le autoriza a utilizar esta acción. Por favor contacte al administrador del sistema para mayores detalles.')); ?>

                <div class="alert alert-warning alert-dismissible fade in">
                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                    <h4><strong>¡ <?= Yii::t('app','Advertencia'); ?> !</strong></h4>
                    <p><?= Yii::$app->session->getFlash('error') ?></p>
                </div>

            <?php endif; ?>

            <br/>

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