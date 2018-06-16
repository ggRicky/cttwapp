<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \common\models\LoginForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Autentificación';
$asset = \frontend\assets\AppAsset::register($this);
$baseUrl = $asset->baseUrl;

// 2018-04-26 : Used to get a random int, and display a random parallax.
$randomBg = rand(1,11);;

// 2018-05-06 : If there is an flash message, then jump directly towards the header and go to the work-area-index using javascript.
If (Yii::$app->session->hasFlash('error') || Yii::$app->session->hasFlash('warning'))
{
    $script = <<< JS
    location.hash = "#work-area-index"; 
JS;
    $this->registerJs($script);
}

?>

<!-- Header -->
<header id="top">
    <div class="row"> <!-- Bootstrap's row -->
        <div class="col-lg-12"> <!-- Bootstrap's col -->
            <!-- CTT logo to display over the CTT's crane video with opacity level -->
            <img src="<?=$baseUrl?>/img/ctt-logo_1.png" class="ctt-logo">
            <div class="ctt-mask">  <!-- Blue mask to cover the video -->
                <!-- Video settings to autoplay and infinite loop -->
                <video class="crop-video" poster="<?=$baseUrl?>/img/ctt-poster.jpg" autoplay loop>
                    <source src="<?=$baseUrl?>/mov/ctt-grua-scorpio.webm" type="video/webm">  <!-- The webm video format is the best for high performance downloads -->
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

    <!-- Yii2 Title layout -->
    <div class="row">
        <div class="col-lg-10 yii2-header">
            <p><?= Yii::t('app',Html::encode($this->title)); ?></p>
        </div>
    </div>

    <!-- Yii2 complementary description -->
    <div class="row">
        <div class="col-lg-10 text-info yii2-description">
            <p><?= Yii::t('app','Inicie su sesión de trabajo.'); ?></p>
        </div>
    </div>

    <!-- Yii2 work area -->
    <div class="row">
        <div class="col-lg-12 text-justify yii2-content">

            <p><?= Yii::t('app','Para iniciar su sesión de trabajo, por favor ingrese sus datos de autentificación en los siguientes campos :'); ?></p>

            <!-- 2018-04-08 : If there is an flash error message, then display it.-->
            <?php if (Yii::$app->session->hasFlash('error')): ?>
                <div id="auto-close" class="alert alert-error alert-dismissible fade in">
                    <a href="#" class="close" data-dismiss="alert" aria-label="close" title="<?= Yii::t('app','Cerrar') ?>">&times;</a>
                    <h4><strong>¡ <?= Yii::t('app','Error'); ?> !</strong></h4>
                    <p><?= Yii::$app->session->getFlash('error') ?></p>
                </div>
            <!-- 2018-05-25 : Flash warning message. -->
            <?php elseif (Yii::$app->session->hasFlash('warning')): ?>
                <div id="auto-close" class="alert alert-warning alert-dismissible fade in">
                    <a href="#" class="close" data-dismiss="alert" aria-label="close" title="<?= Yii::t('app','Cerrar') ?>">&times;</a>
                    <h4><strong>¡ <?= Yii::t('app','Advertencia'); ?> !</strong></h4>
                    <p><?= Yii::$app->session->getFlash('warning') ?></p>
                </div>
            <?php endif; ?>

            <div class="site-login">
                <div class="row">
                    <div class="col-lg-5">
                        <?php $form = ActiveForm::begin(['id' => 'login-form']); ?>

                        <?= $form->field($model, 'username')->textInput() ?>

                        <?= $form->field($model, 'password')->passwordInput() ?>

                        <?= $form->field($model, 'rememberMe')->checkbox() ?>

                        <div style="color:#999;margin:1em 0">
                            <?= Yii::t('app','Para restablecer su contraseña en caso de olvido, '); ?><?= Html::a(Yii::t('app','haga clic en esta liga.'), ['site/request-password-reset']) ?>
                        </div>

                        <div class="form-group">
                            <?= Html::submitButton(Yii::t('app','Ingresar'), ['class' => 'btn btn-primary', 'name' => 'login-button']) ?>
                        </div>

                        <?php ActiveForm::end(); ?>
                    </div>
                </div>
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