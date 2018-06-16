<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\AuthItemSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Objetos de Autorización';
$asset = \frontend\assets\AppAsset::register($this);
$baseUrl = $asset->baseUrl;

// 2018-05-06 : If there are a query or sort criteria is in progress, then skip the header and go just to the work-area-index using javascript code.
$search_param = \yii\helpers\ArrayHelper::keyExists('AuthItemSearch',$qryParams);
$sort_param   = \yii\helpers\ArrayHelper::keyExists('sort',$qryParams);
$skip_param   = (\yii\helpers\ArrayHelper::getValue($qryParams, '1.#')=='work-area-index'?true:false);

If ($search_param || $sort_param || $skip_param || Yii::$app->session->hasFlash('warning'))
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
<section id="work-area-index" class="ctt-section bg-secondary">
    <div class="col-lg-12">
        <div class="row">
            <!-- 2018-06-09: Includes the logout button and display the user name -->
            <?php
                // 2018-04-08 : This code was refactored, using only Html helper
                // 2018-05-24 : Remove guest entry for rbac security.
                echo Html::begintag('div', ['class' => 'ctt-user-logout-ribbon']);
                echo Html::beginForm(['/site/logout'], 'post');
                echo Html::submitButton(Yii::t('app','<span><i class="fa fa-power-off fa-lg"></i></span>'), ['class' => 'btn btn-dark', 'title' => Yii::t('app','Cerrar Sesión')]) . "&nbsp;&nbsp;&nbsp;";
                echo Html::tag('label', Yii::$app->user->identity->username, ['style' => ['color' => 'white', 'font-size' => 'medium', 'font-weight' => 'normal']]);
                echo Html::endForm();
                echo Html::endtag('div');
            ?>
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
            <p><?= Yii::t('app', $this->title); ?></p>
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
                    ]); ?>
                </div>
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
    <section class="ctt-section-footer ctt-footer-container-bke">
        <div class="col-lg-12">
            <div class="row "></div>
        </div>
    </section>
</footer>


