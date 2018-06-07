<?php

use yii\helpers\Url;
use yii\helpers\Html;
use yii\web\View;

/* @var $this yii\web\View */

$this->title = 'CTTWApp - Frontend';
$asset = \frontend\assets\AppAsset::register($this);
$baseUrl = $asset->baseUrl;

// 2018-04-26 : Used to get a random int, and display a random parallax.
$randomBg = rand(1,13);

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

        <!-- CTT default actions ribbon -->
        <?php
            // 2018-04-08 : This code was refactored, using only Html helper
            // 2018-05-24 : Remove guest entry for rbac security.
            echo Html::begintag('div', ['class' => 'ctt-mini-bar-top']);
            echo Html::beginForm(['/site/logout'], 'post');
            echo Html::tag('label', Yii::$app->user->identity->username, ['style' => ['color' => 'white', 'font-size' => 'medium', 'font-weight' => 'normal']]) . "&nbsp;&nbsp;&nbsp;";
            echo Html::submitButton(Yii::t('app','Terminar'), ['class' => 'btn btn-primary']);
            echo Html::endForm();
            echo Html::endtag('div');
        ?>

        <!-- Content menu -->
        <li><div class="ctt-mini-bar-opts"><?= "<a href='".Url::to(['site/about'])."'>".Yii::t('app','Acerca')."</a>" ?></div></li>
        <li><div class="ctt-mini-bar-opts"><?= "<a href='".Url::to(['site/help'])."'>".Yii::t('app','Ayuda')."</a>" ?></div></li>
        <li><div class="ctt-mini-bar-opts"><?= "<a href='".Url::to(['site/contact'])."'>".Yii::t('app','Contacto')."</a>" ?></div></li>

        <!-- 2018-05-24 : Special Option - Only the admin user can create an new user. -->
        <?php if (\Yii::$app->user->can('adminProcess')): ?>

        <li><div class="ctt-mini-bar-spc-opts"><?= "<a href='".Url::to(['site/signup'])."'>".Yii::t('app','Registro')."</a>" ?></div></li>

        <?php endif; ?>

        <li><?= "<a href='".Url::to(['client/index'])."'>".Yii::t('app','Clientes')."</a>" ?></li>
        <li><?= "<a href='".Url::to(['catalog/index'])."'>".Yii::t('app','Catálogos')."</a>" ?></li>
        <li><?= "<a href='".Url::to(['article/index'])."'>".Yii::t('app','Artículos')."</a>" ?></li>
        <li><a href="#" data-toggle="modal" data-target="#ctt-modal-in-construction"><?= Yii::t('app','Inventarios'); ?></a></li>
        <li><a href="#" data-toggle="modal" data-target="#ctt-modal-in-construction"><?= Yii::t('app','Proyectos'); ?></a></li>
        <li><a href="#" data-toggle="modal" data-target="#ctt-modal-in-construction"><?= Yii::t('app','Reservaciones'); ?></a></li>
        <li><a href="#" data-toggle="modal" data-target="#ctt-modal-in-construction"><?= Yii::t('app','Cotizaciones'); ?></a></li>
    </ul>
</nav>

<!-- Header -->
<header id="top">
    <div class="row"> <!-- Bootstrap's row -->
        <div class="col-lg-12"> <!-- Bootstrap's col -->
            <!-- CTT logo to display over the CDMX video with opacity level -->
            <img src="<?=$baseUrl?>/img/ctt-logo_1.png" class="ctt-logo">
            <div class="ctt-mask">  <!-- Blue mask over CDMX video -->
                <!-- Video settings to autoplay and infinite loop -->
                <video class="crop-video" poster="<?=$baseUrl?>/img/poster_0.jpg" autoplay loop>
                    <source src="<?=$baseUrl?>/mov/ctt-cdmx.webm" type="video/webm">  <!-- The webm video format is the best for high performance downloads -->
                </video>
            </div>
        </div>
    </div>
</header>

<!-- CTT about section -->
<section id="about" class="about">
    <div>
        <div class="row text-center">
            <div class="col-lg-12">
                <h2>CTT Web Application v-1.0</h2>

                <!-- Call to Yii translation function for automated message translation -->
                <p class="lead"><?= Yii::t('app','Sistema Gestor de Operaciones') ?></p>

                <!-- Builds a language options ribbon -->
                <div>
                    <?php
                        echo "|&nbsp;";
                        foreach(Yii::$app->params['languages'] as $key => $language){
                            echo "<a href=\"#lang-". $key ."\" class=\"language\" id='".$key."'>".trim($language)."</a>" . "&nbsp;|&nbsp;" ;
                        }
                    ?>
                </div>

                <h2 class="barcode-font">ISC-RGG</h2>
            </div>
        </div>
        <!-- CTT mini-logo -->
        <div class="row">
            <div class="col-lg-12">
                <img src="<?=$baseUrl?>/img/ctt-mini-logo_1.jpg" class="center-block img-responsive" height="42" width="105"/>
            </div>
        </div>
    </div>
</section>

<!-- CTT Operation links -->
<!-- The circle icons use Font Awesome's stacked icon classes. For more information, visit http://fontawesome.io/examples/ -->
<section id="services" class="ctt-operations bg-primary">
    <div class="container">
        <div class="row text-center">
            <div class="col-lg-10 col-lg-offset-1">
                <h2><?= Yii::t('app','Operaciones') ?></h2>
                <hr class="small">
                <div class="row">
                    <div class="col-md-3 col-sm-6">
                        <div class="ctt-operations-item">
                                <span class="fa-stack fa-4x">
                                    <i class="fa fa-circle fa-stack-2x"></i>
                                    <i class="fa fa-file-movie-o fa-stack-1x text-primary"></i>
                                </span>
                            <h4>
                                <strong><?= Yii::t('app','Proyectos') ?></strong>
                            </h4>
                            <hr class="small">
                            <p></p>
                            <a href="#" class="btn btn-light" data-toggle="modal" data-target="#ctt-modal-in-construction"><?= Yii::t('app','I n g r e s a r') ?></a>
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-6">
                        <div class="ctt-operations-item">
                                <span class="fa-stack fa-4x">
                                    <i class="fa fa-circle fa-stack-2x"></i>
                                    <i class="fa fa-calendar fa-stack-1x text-primary"></i>
                                </span>
                            <h4>
                                <strong><?= Yii::t('app','Gestión') ?></strong>
                            </h4>
                            <hr class="small">
                            <p></p>
                            <a href="#" class="btn btn-light" data-toggle="modal" data-target="#ctt-modal-in-construction"><?= Yii::t('app','I n g r e s a r') ?></a>
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-6">
                        <div class="ctt-operations-item">
                                <span class="fa-stack fa-4x">
                                    <i class="fa fa-circle fa-stack-2x"></i>
                                    <i class="fa fa-barcode fa-stack-1x text-primary"></i>
                                </span>
                            <h4>
                                <strong><?= Yii::t('app','Operaciones') ?></strong>
                            </h4>
                            <hr class="small">
                            <p></p>
                            <a href="#" class="btn btn-light" data-toggle="modal" data-target="#ctt-modal-in-construction"><?= Yii::t('app','I n g r e s a r') ?></a>
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-6">
                        <div class="ctt-operations-item">
                                <span class="fa-stack fa-4x">
                                    <i class="fa fa-circle fa-stack-2x"></i>
                                    <i class="fa fa-info fa-stack-1x text-primary"></i>
                                </span>
                            <h4>
                                <strong><?= Yii::t('app','Reportes') ?></strong>
                            </h4>
                            <hr class="small">
                            <p></p>
                            <a href="#" class="btn btn-light" data-toggle="modal" data-target="#ctt-modal-in-construction"><?= Yii::t('app','I n g r e s a r') ?></a>
                        </div>
                    </div>
                </div>
                <!-- /.row (nested) -->
            </div>
            <!-- /.col-lg-10 -->
        </div>
        <!-- /.row -->
    </div>
    <!-- /.container -->
</section>

<!-- Parallax Efect -->
<section id="parallax1" class="parallax-section" data-stellar-background-ratio="0.5">
    <div class="text-vertical-center">
        <h1></h1>  <!-- Reserved for including text inside the parallax window -->
    </div>
</section>

<!-- CTT Portfolio -->
<section id="ctt-portfolio" class="arri-portfolio">
    <div class="container">
        <div class="row">
            <div class="col-lg-10 col-lg-offset-1 text-center">
                <h2><?= Yii::t('app','Nuestro Equipo') ?></h2>
                <hr class="small">
                <div class="row">
                    <div class="col-md-6">
                        <div class="arri-portfolio-item">
                            <a href="#">
                                <img class="img-arri-portfolio img-responsive" src="<?=$baseUrl?>/img/img_1.jpg">
                            </a>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="arri-portfolio-item">
                            <a href="#">
                                <img class="img-arri-portfolio img-responsive" src="<?=$baseUrl?>/img/img_2.jpg">
                            </a>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="arri-portfolio-item">
                            <a href="#">
                                <img class="img-arri-portfolio img-responsive" src="<?=$baseUrl?>/img/img_3.jpg">
                            </a>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="arri-portfolio-item">
                            <a href="#">
                                <img class="img-arri-portfolio img-responsive" src="<?=$baseUrl?>/img/img_4.jpg">
                            </a>
                        </div>
                    </div>
                </div>
                <!-- /.row (nested) -->
                <a href="#" class="btn btn-dark" data-toggle="modal" data-target="#ctt-modal-in-construction"><?= Yii::t('app','R e s e r v a c i o n e s') ?></a>
            </div>
            <!-- /.col-lg-10 -->
        </div>
        <!-- /.row -->
    </div>
    <!-- /.container -->
</section>

<!-- Google ribbon -->
<aside class="ctt-map-ribbon bg-primary">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 text-center">
                <h3 class="ctt-title-spacing">Google Maps</h3>
            </div>
        </div>
    </div>
</aside>

<!-- Google Map  CTT's loction -->
<section id="contact" class="ctt-map">
    <iframe width="100%" height="100%" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d15065.048251249942!2d-99.1300126!3d19.2709666!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x348e42d70e47e22e!2sCTT+EXP+%26+RENTALS!5e0!3m2!1ses-419!2smx!4v1516220271074" style="border:0" allowfullscreen></iframe>
    <br />
    <div class="col-lg-12" >
        <small>
            <a href="https://www.google.com.mx/maps/@19.2709666,-99.1300126,15z/data=!4m2!7m1!2e1"><?= Yii::t('app','Ubicación de') ?> CTT Exp. & Rentals.</a>
        </small>
    </div>
</section>

<!-- Footer -->
<footer>
    <div class="container">
        <div class="row">
            <div class="col-lg-10 col-lg-offset-1 text-center">

                <ul class="list-inline">
                    <li>
                        <img src="<?=$baseUrl?>/img/ctt-logo_2.png" height="128" width="90"/>
                    </li>
                </ul>

                <hr class="small">
                <p>Guadalupe I. Ramírez No. 763<br />Col. Tepepan, Delegación Xochimilco, C.P. 16029</p><p>Ciudad de México, CDMX</p>

                <ul class="list-unstyled">
                    <li><i class="fa fa-phone fa-fw"></i> 01 55 5676 1113</li>
                    <li><i class="fa fa-envelope-o fa-fw"></i>  <a href="mailto:name@example.com">contacto@cttrentals.com</a></li>
                </ul>

                <br />

                <ul class="list-inline">
                    <li><a href="http://www.facebook.com/CTTEXPRENTALS"><i class="fa fa-facebook fa-fw fa-3x"></i></a></li>
                    <li><a href="https://twitter.com/cttexp"><i class="fa fa-twitter fa-fw fa-3x"></i></a></li>
                    <li><a href="http://www.linkedin.com/company/ctt-exp-&-rentals"><i class="fa fa-linkedin fa-fw fa-3x"></i></a></li>
                </ul>

                <!-- 2018-05-20 : Comodo Secure Seal -->
                <div class="row">
                     <span>
                        <script language="JavaScript" type="text/javascript">
                            TrustLogo("https://www.ctt-app.com/assets/bf100e74/img/comodo_secure_seal_100x85_transp.png", "CL1", "none");
                        </script>
                        <a href="https://www.positivessl.com/" id="comodoTL" >Positive SSL</a>
                     </span>
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
                            <span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
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
                            <span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
                            <a href="https://www.debian.org///"><img src="<?=$baseUrl?>/img/debian_logo.svg" height="45"/></a>
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

<!-- Modal Warning ; Functionality not implemented yet  -->
<div id="ctt-modal-in-construction" class="modal fade" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content modal-backdrop">

            <!-- Modal Header -->
            <div class="modal-shadow-effect modal-header-water-mark">
                <div class="modal-header modal-header-config ctt-modal-header-warning">
                    <div class="row">
                        <!--
                             ctt-modal-header-info        glyphicon-info-sign
                             ctt-modal-header-success     glyphicon-ok-sign
                             ctt-modal-header-question    glyphicon-question-sign
                             ctt-modal-header-warning     glyphicon-warning-sign
                             ctt-modal-header-error       glyphicon-exclamation-sign
                        -->
                        <div class="col-sm-1"><span class="glyphicon glyphicon-warning-sign"></span></div>
                        <div class="col-sm-7"><h4 class="modal-title"><?= Yii::t('app','Advertencia') ?></h4></div>
                        <div class="col-sm-4"><button type="button" class="close" data-dismiss="modal">&times;</button></div>
                    </div>
                </div>

                <!-- Modal Content -->
                <div class="modal-body modal-body-config">
                    <p><?= Yii::t('app','Esta funcionalidad se encuentra en construcción y aún no está implementada en su totalidad.') ?></p>
                </div>

                <!-- Modal Footer -->
                <div class="modal-footer modal-footer-config">
                    <div class="row">
                        <div class="col-sm-6"><img align="left" src="<?=$baseUrl?>/img/ctt-mini-logo_1.jpg" height="42" width="105"/></div>
                        <div class="col-sm-6"><button type="button" class="btn btn-default" data-dismiss="modal"><?= Yii::t('app','Cerrar') ?></button></div>
                    </div>
                </div>
            </div>

        </div>

    </div>
</div>

<!-- 2018-02-09 : Modal Success [ User Logged  ]-->
<div id="ctt-modal-usr-logged" class="modal fade" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content modal-backdrop">

            <!-- Modal Header -->
            <div class="modal-shadow-effect modal-header-water-mark">
                <div class="modal-header modal-header-config ctt-modal-header-success">
                    <div class="row">
                        <!--
                             ctt-modal-header-info        glyphicon-info-sign
                             ctt-modal-header-success     glyphicon-ok-sign
                             ctt-modal-header-question    glyphicon-question-sign
                             ctt-modal-header-warning     glyphicon-warning-sign
                             ctt-modal-header-error       glyphicon-exclamation-sign
                        -->
                        <div class="col-sm-1"><span class="glyphicon glyphicon-ok-sign"></span></div>
                        <div class="col-sm-7"><h4 class="modal-title"><?= Yii::t('app','Éxito') ?></h4></div>
                        <div class="col-sm-4"><button type="button" class="close" data-dismiss="modal">&times;</button></div>
                    </div>
                </div>

                <!-- Modal Content -->
                <div class="modal-body modal-body-config">
                    <p><?= Yii::$app->session->getFlash('successLogin'); ?></p>
                </div>

                <!-- Modal Footer -->
                <div class="modal-footer modal-footer-config">
                    <div class="row">
                        <div class="col-sm-6"><img align="left" src="<?=$baseUrl?>/img/ctt-mini-logo_1.jpg" height="42" width="105"/></div>
                        <div class="col-sm-6"><button type="button" class="btn btn-default" data-dismiss="modal"><?= Yii::t('app','Cerrar') ?></button></div>
                    </div>
                </div>
            </div>

        </div>

    </div>
</div>

<!-- 2018-05-25 : Modal Warning [ Forbidden Access ]-->
<div id="ctt-modal-forbidden-access" class="modal fade" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content modal-backdrop">

            <!-- Modal Header -->
            <div class="modal-shadow-effect modal-header-water-mark">
                <div class="modal-header modal-header-config ctt-modal-header-warning">
                    <div class="row">
                        <!--
                             ctt-modal-header-info        glyphicon-info-sign
                             ctt-modal-header-success     glyphicon-ok-sign
                             ctt-modal-header-question    glyphicon-question-sign
                             ctt-modal-header-warning     glyphicon-warning-sign
                             ctt-modal-header-error       glyphicon-exclamation-sign
                        -->
                        <div class="col-sm-1"><span class="glyphicon glyphicon-warning-sign"></span></div>
                        <div class="col-sm-7"><h4 class="modal-title"><?= Yii::t('app','Advertencia') ?></h4></div>
                        <div class="col-sm-4"><button type="button" class="close" data-dismiss="modal">&times;</button></div>
                    </div>
                </div>

                <!-- Modal Content -->
                <div class="modal-body modal-body-config">
                    <p><?= Yii::$app->session->getFlash('forbiddenAccess'); ?></p>
                </div>

                <!-- Modal Footer -->
                <div class="modal-footer modal-footer-config">
                    <div class="row">
                        <div class="col-sm-6"><img align="left" src="<?=$baseUrl?>/img/ctt-mini-logo_1.jpg" height="42" width="105"/></div>
                        <div class="col-sm-6"><button type="button" class="btn btn-default" data-dismiss="modal"><?= Yii::t('app','Cerrar') ?></button></div>
                    </div>
                </div>
            </div>

        </div>

    </div>
</div>

<?php

// 2018-02-09 : If the user was logged successfully, then display the modal window notification, using PHP & jQuery

$session = Yii::$app->session;

if ($session->has('successLogin')) {

    $script = "jQuery(document).ready(function () { $(\"#ctt-modal-usr-logged\").modal({show: true, backdrop: \"static\"}); });";
    $this->registerJs($script, View::POS_READY);

}

// 2018-05-25 : If the user haven't access to an site action, then display the modal window notification, using PHP & jQuery

if (Yii::$app->session->hasFlash('forbiddenAccess')){

    $script = "jQuery(document).ready(function () { $(\"#ctt-modal-forbidden-access\").modal({show: true, backdrop: \"static\"}); });";
    $this->registerJs($script, View::POS_READY);

}

?>