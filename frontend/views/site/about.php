<?php

use yii\helpers\Html;

/* @var $this yii\web\View */

$this->title = 'Acerca';
$asset = \frontend\assets\AppAsset::register($this);
$baseUrl = $asset->baseUrl;

?>
<!-- Header -->
<header id="top">
    <div class="row"> <!-- Bootstrap's row -->
        <div class="col-lg-12"> <!-- Bootstrap's col -->
            <!-- CTT logo to display over the CTT's crane video with opacity level -->
            <img src="<?=$baseUrl?>/img/ctt-logo_1.png" class="ctt-logo">
            <div class="ctt-mask-1">  <!-- Blue mask over CDMX video -->
                <!-- Video settings to autoplay and infinite loop -->
                <video class="crop-video-1" poster="<?=$baseUrl?>/img/poster_1.jpg" autoplay loop>
                    <source src="<?=$baseUrl?>/mov/ctt-grua.webm" type="video/webm">  <!-- The webm video format is the best for high performance downloads -->
                </video>
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
            <?= Html::a(Yii::t('app','R e g r e s a r'), ['site/index'], ['class' => 'btn btn-dark']) ?>
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
            <p>CTT Web Application v-1.001 Beta</p>
        </div>
    </div>

    <!-- Yii2 work area -->
    <div class="row">
        <div class="col-lg-12 text-justify yii2-content">
            <div class="table-responsive">
                <table class="table-bordered table-striped table-hover">
                    <tbody>
                    <tr>
                        <th><?= Yii::t('app','Clave') ?></th><td>CTTWapp</td>
                    </tr>
                    <tr>
                        <th><?= Yii::t('app','Nombre Clave') ?></th><td>CTT Web Application</td>
                    </tr>
                    <tr>
                        <th><?= Yii::t('app','Versión Prototipo') ?></th><td>001</td>
                    </tr>
                    <tr>
                        <th><?= Yii::t('app','Descripción') ?></th><td><?= Yii::t('app','Sistema Gestor de Operaciones') ?></td>
                    </tr>
                    <tr>
                        <th><?= Yii::t('app','Plataforma') ?></th><td><?= Yii::t('app','Yii versión 2.0') ?></td>
                    </tr>
                    <tr>
                        <th><?= Yii::t('app','Última Actualización') ?></th><td>2018-05-06 &nbsp;&nbsp;&nbsp; 23:30 Hrs.</td>
                    </tr>
                    </tbody>
                </table>
            </div>
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
                        <p class="text-muted">Copyright &copy; 2017-<?= date("Y"); ?><br/>T S R&nbsp;&nbsp;&nbsp;&nbsp;D e v e l o p m e n t&nbsp;&nbsp;&nbsp;&nbsp;S o f t w a r e</p>
                        <hr class="small">
                        <p class="text-muted">Supported by</p>
                        <p>
                            <a href="https://www.yiiframework.com/"><img src="<?=$baseUrl?>/img/yii_logo_light.svg" height="30"/></a>
                            <span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
                            <a href="https://www.jetbrains.com/"><img src="<?=$baseUrl?>/img/jetbrains.svg" height="40"/></a>
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
