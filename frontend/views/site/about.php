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
            <div class="ctt-mask-1">  <!-- Blue mask over CDMX video -->
                <!-- Video settings to autoplay and infinite loop -->
                <video class="crop-video-1" poster="<?=$baseUrl?>/img/poster_1.jpg" autoplay loop>
                    <source src="<?=$baseUrl?>/mov/ctt-grua.webm" type="video/webm">  <!-- The webm video format is the best for high performance downloads -->
                </video>
            </div>
            <!-- CTT logo to display over the CTT's crane video with opacity level -->
            <img src="<?=$baseUrl?>/img/ctt-logo_1.png" class="ctt-logo">
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
            <?= Html::a('R e g r e s a r', ['site/index'], ['class' => 'btn btn-dark']) ?>
        </div>
    </div>

    <!-- Yii2 Title layout -->
    <div class="row">
        <div class="col-lg-10 yii2-header">
            <p><?= Html::encode($this->title) ?></p>
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
            <table>
                <tr>
                    <td>Nombre clave</td><td> &nbsp;&nbsp;:&nbsp;&nbsp;CTTWapp</td>
                </tr>
                <tr>
                    <td>Descripción</td><td> &nbsp;&nbsp;:&nbsp;&nbsp;Sistema de Administración de Procesos</td>
                </tr>
                <tr>
                    <td>Plataforma</td><td> &nbsp;&nbsp;:&nbsp;&nbsp;Yii versión 2.0</td>
                </tr>
                <tr>
                    <td>Última actualización</td><td> &nbsp;&nbsp;:&nbsp;&nbsp;2018-01-16 21:06 Hrs.</td>
                </tr>
                <tr>
                    <td>Versión Prototipo</td><td> &nbsp;&nbsp;:&nbsp;&nbsp;001</td>
                </tr>
            </table>
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
                        <p class="text-muted"><img src="<?=$baseUrl?>/img/yii2_logo.png" height="37" width="120"/></p>
                        <p class="text-muted">Copyright &copy; 2017-2018 <br/>TSR Development Software</p>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <!-- Blue ribbon decoration -->
    <section class="ctt-section bg-primary">
        <div class="col-lg-12">
            <div class="row"></div>
        </div>
    </section>
</footer>
