<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* 2018-03-17 : Used to display Description Type for the actual client record */
use yii\helpers\ArrayHelper;
use app\models\ClientType;
use yii\widgets\Pjax;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel app\models\ClientSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */


$this->title = 'Clientes';
$asset = \frontend\assets\AppAsset::register($this);
$baseUrl = $asset->baseUrl;

// 2018-05-06 : If there are a query or sort criteria is in progress, then skip the header and go just to the work-area-index using javascript code.
$search_param = \yii\helpers\ArrayHelper::keyExists('ClientSearch',$qryParams);
$sort_param   = \yii\helpers\ArrayHelper::keyExists('sort',$qryParams);
$skip_param   = (\yii\helpers\ArrayHelper::getValue($qryParams, '1.#')=='work-area-index'?true:false);

// 2018-05-06 : If an url color param was send, then skip the header and go just to the work-area-index using javascript code.
$color_param  = Yii::$app->getRequest()->getQueryParam('c', null);

If ($search_param || $sort_param || $skip_param || $color_param || Yii::$app->session->hasFlash('error'))
{
$script = <<< JS
    location.hash = "#work-area-index";
JS;
    $this->registerJs($script);
}

//2018-04-26 : Used to get a random int, and display a random parallax.
$randomBg = rand(1,11);;

?>

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
            <?= Html::a(Yii::t('app','R e g r e s a r'), ['site/index'], ['class' => 'btn btn-dark btn-ctt-fixed-width', 'data-toggle' => 'tooltip', 'title' => Yii::t('app', 'Regresar al nivel anterior')]) ?>
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
                <div id="auto-close" class="alert alert-warning alert-dismissible fade in">
                    <a href="#" class="close" data-dismiss="alert" data-toggle="tooltip" aria-label="close" title="<?= Yii::t('app','Cerrar') ?>">&times;</a>
                    <h4><strong>¡ <?= Yii::t('app','Advertencia'); ?> !</strong></h4>
                    <p><?= Yii::$app->session->getFlash('error') ?></p>
                </div>
            <!-- 2018-05-25 : Flash success message. -->
            <?php elseif (Yii::$app->session->hasFlash('success')): ?>
                <div id="auto-close" class="alert alert-success alert-dismissible fade in">
                    <a href="#" class="close" data-dismiss="alert" data-toggle="tooltip" aria-label="close" title="<?= Yii::t('app','Cerrar') ?>">&times;</a>
                    <h4><strong>¡ <?= Yii::t('app','Información'); ?> !</strong></h4>
                    <p><?= Yii::$app->session->getFlash('success') ?></p>
                </div>
            <?php endif; ?>

            <!-- 2018-05-23 : Yii2 Rbac - Validates the access. -->
            <?php if (\Yii::$app->user->can('listClient')): ?>

                <p>
                    <?= Html::a(Yii::t('app', 'Crear Cliente'), ['create', 'page'=>Yii::$app->getRequest()->getQueryParam('page')], ['class' => 'btn btn-success']) ?>
                    <?= Html::a(Yii::t('app', 'Tipos de Clientes'), ['client-type/index' , 'page'=>Yii::$app->getRequest()->getQueryParam('page'), ['#' => 'work-area-index']], ['class' => 'btn btn-primary']) ?>
                </p>

                <?php Pjax::begin(); ?>

                <!-- 2018-04-13 : The next div, including the id and class elements, enable the vertical and horizontal scrollbars. -->
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
                                }else  if ($model->client_type_id == 5)
                                {
                                    return ['class' => 'orange-light'];
                                };
                                return [];
                            }
                            return [];
                        },

                        'columns' => [
                            // 2018-05-27 : This code adds the current page as an URL parameter to the update and view buttons in the column actions.
                            [
                                'class' => 'yii\grid\ActionColumn',
                                'headerOptions' => ['style' => 'width:4%'],
                                'template' => '{view} {update} {delete}',
                                'buttons' => [
                                    'update' => function ($url) use ($dataProvider) {
                                        $url .= '&page=' . ($dataProvider->pagination->page + 1);
                                        return Html::a('<span class="glyphicon glyphicon-pencil"></span>', $url, [
                                            'data-toggle' => 'tooltip',
                                            'title' => Yii::t('app', 'Actualizar'),    // 2018-07-21 : Adds the tooltip Update
                                        ]);
                                    },
                                    'view' => function ($url) use ($dataProvider) {
                                        $url .= '&page=' . ($dataProvider->pagination->page + 1);
                                        return Html::a('<span class="glyphicon glyphicon-eye-open"></span>', $url, [
                                            'data-toggle' => 'tooltip',
                                            'title' => Yii::t('app', 'Ver'),           // 2018-07-21 : Adds the tooltip View
                                        ]);
                                    },
                                ],
                            ],

                            [ 'class' => 'yii\grid\SerialColumn',
                                'headerOptions' => ['style' => 'width:3%'],
                            ],

                            [
                                'attribute' => 'id',
                                'headerOptions' => ['style' => 'width:3%'],
                            ],

                            'rfc',
                            'curp',

                            // 2018-04-10 : New fields add to client table in refactoring action.

                            [
                                'attribute' => 'business_name',
                                'contentOptions' => ['style' => 'color:red'],
                            ],

                            // 2018-04-23 : For taxpayer type, the right legend is displayed and colored properly.

                            [
                                'attribute' => 'taxpayer',
                                'value' => function($model){
                                    return ($model->taxpayer=='M'?'PERSONA MORAL':'PERSONA FÍSICA');
                                },
                                'contentOptions' => function ($model, $key, $index, $column) {
                                    return ['style' => 'color:'. ($model->taxpayer=='M'?'grey':'#428bca')];
                                },
                            ],

                            'corporate',

                            // 2018-04-23 : For provenance type, the right legend is displayed.

                            [
                                'attribute' => 'provenance',
                                'value' => function($model){
                                    return ($model->provenance=='N'?'NACIONAL':'EXTRANJERO');
                                },
                            ],

                            'contact_name',
                            'contact_email',
                            'street',
                            'outdoor_number',
                            'interior_number',
                            'suburb',
                            'municipality',
                            'delegation',
                            'state',
                            'zip_code',
                            'phone_number_1',
                            'phone_number_2',
                            'web_page',
                            'client_email',
                            'considerations',

                            'created_at',
                            'updated_at',
                            'created_by',
                            'updated_by',

                            // 2018-03-17 : Modified to display the ID and the Client Type Description instead of the ID only.
                            [
                                'attribute' => 'client_type_id',
                                'headerOptions' => ['style' => 'width:12%'],
                                'value' => function($model){
                                    return implode(",",ArrayHelper::map(ClientType::find()->where(['id' =>  $model->client_type_id])->all(),'id','displayTypeDesc'));
                                }
                            ],
                        ],
                        'layout' => '{summary}{items}{pager}',
                    ]);?>


                </div>

                <?php Pjax::end(); ?>

                <p>
                    <br/>
                    <!-- 2018-05-14 : Improvement. The next two <a> tags call the color action from clientController and pass the color parameter to it. -->
                    <?= Html::a(Yii::t('app', 'Codificar con colores'), ['client/color', 'color' => '1'], ['class' => 'btn btn-ctt-warning']) ?>
                    <?= Html::a('', ['client/color', 'color' => '0'], ['class' => 'btn glyphicon glyphicon-remove-circle']) ?>
                </p>

                <div class="well well-sm text-info"><?= Yii::t('app', 'IMPORTANTE : La información que se muestra en la relación, corresponde a datos experimentales de prueba').'.';?></div>

            <?php else: ?>

                <?php Yii::$app->session->setFlash('error', Yii::t('app', 'Su perfil de acceso no le autoriza a utilizar esta acción. Por favor contacte al administrador del sistema para mayores detalles').'.'); ?>

                <div id="auto-close" class="alert alert-warning alert-dismissible fade in">
                    <a href="#" class="close" data-dismiss="alert" data-toggle="tooltip" aria-label="close" title="<?= Yii::t('app','Cerrar') ?>">&times;</a>
                    <h4><strong>¡ <?= Yii::t('app','Advertencia'); ?> !</strong></h4>
                    <p><?= Yii::$app->session->getFlash('error') ?></p>
                </div>

            <?php endif; ?>

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