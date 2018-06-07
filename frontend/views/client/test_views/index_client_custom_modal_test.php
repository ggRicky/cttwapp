<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\Modal;
use yii\grid\GridView;

/* @var $this yii\web\View */

$this->title = 'Clientes';
$asset = \frontend\assets\AppAsset::register($this);
$baseUrl = $asset->baseUrl;

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
            <p>Listado Nominal</p>
        </div>
    </div>

    <!-- Yii2 work area -->
    <div class="row">
        <div class="col-lg-12 text-justify yii2-content">
            <div class="client-index">

                <p>
                    <?= Html::a('Crear Cliente', ['create'], ['class' => 'btn btn-success']) ?>
                    <?= Html::a('Tipos de Clientes', ['client-type/index', '#' => 'work-area-index-cte'], ['class' => 'btn btn-primary']) ?>
                </p>

                <?= GridView::widget([
                    'dataProvider' => $dataProvider,
                    'filterModel' => $searchModel,
                    'columns' => [
                        ['class' => 'yii\grid\SerialColumn'],

                        'id',
                        'rfc',
                        'curp',
                        'moral',
                        'first_name',
                        'paternal_name',
                        'maternal_name',
                        'created_at',
                        'updated_at',
                        'created_by',
                        'updated_by',
                        'client_type_id',

                        ['class' => 'yii\grid\ActionColumn',
                         'buttons' => ['delete' => function ($url, $model) {
                                                            return Html::a('', $url, ['class' => 'btn btn-danger btn-xs glyphicon glyphicon-trash popup-modal',
                                                                                          'data-toggle' => 'modal',
                                                                                          'data-target' => '#modal',
                                                                                          'data-id'     => $model->id,
                                                                                          'data-name'   => $model->rfc,
                                                                                          'id'          => 'popupModal', ]);
                                                            },],
                         'urlCreator' => function ($action, $model, $key, $index) {
                                                  $url = Url::to(['client/delete', 'id' => $model->id]);
                                                  return $url;
                                         },],
                        ],
                    ]);
                ?>

                <?php Modal::begin([
                    'id'      => 'modal-delete',
                    'headerOptions' => ['class' => 'modal-header-water-mark modal-header modal-header-config ctt-modal-header-question'],
                    'header'  => '<div class="row"><div class="col-sm-1"><span class="glyphicon glyphicon-question-sign"></span></div><div class="col-sm-7"><h4 class="modal-title">Pregunta</h4></div></div>',
                    'footerOptions' => ['class' => 'modal-footer modal-footer-config'],
                    'footer'  => '<div class="row"><div class="col-sm-6"><img align="left" src="'.$baseUrl.'/img/ctt-mini-logo_1.jpg" height="42" width="105"/></div><div class="col-sm-6"><button id="delete-confirm" type="button" class="btn btn-danger" data-dismiss="modal">Eliminar</button></div></div>',
                ]); ?>

                <?= 'Realmente desea eliminar este registro ?'; ?>

                <?php Modal::end(); ?>

                <?php
                $this->registerJs("
                    $(function() {
                        $('.popup-modal').click(function(e) {
                            e.preventDefault();
                            var modal = $('#modal-delete').modal('show');
                            modal.find('.modal-body').load($('.modal-dialog'));
                            var that = $(this);
                            var id = that.data('id');
                            //var name = that.data('name');
                            //modal.find('.modal-title').text('Supprimer la ressource \"' + name + '\"');
                
                            $('#delete-confirm').click(function(e) {
                                e.preventDefault();
                                alert('client/delete?id='+id);
                                //window.location = 'client/delete?id='+id;
                            });
                        });
                    });"
                );
                ?>
            </div>
        </div>
    </div>
</section>

<!-- Modal Question -->
<div id="ctt-modal-question" class="modal fade" role="dialog">
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
                        <div class="col-sm-7"><h4 class="modal-title">Pregunta</h4></div>
                        <div class="col-sm-4"><button type="button" class="close" data-dismiss="modal">&times;</button></div>
                    </div>
                </div>

                <!-- Modal Content -->
                <div class="modal-body modal-body-config">
                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus ultricies id lorem in bibendum. Phasellus leo diam, posuere non dolor sed, cursus ultricies mi. Praesent malesuada a urna vitae suscipit. Vestibulum ullamcorper leo dolor, quis faucibus arcu euismod et. Curabitur sed diam interdum, cursus dui a, elementum dui. Curabitur eget eros arcu. Duis lobortis, neque ac maximus ornare, erat lectus consectetur neque, nec egestas lectus dui vel eros.</p>
                </div>

                <!-- Modal Footer -->
                <div class="modal-footer modal-footer-config">
                    <div class="row">
                        <div class="col-sm-6"><img align="left" src="<?=$baseUrl?>/img/ctt-mini-logo_1.jpg" height="42" width="105"/></div>
                        <div class="col-sm-6"><button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button></div>
                    </div>
                </div>
            </div>

        </div>

    </div>
</div>

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