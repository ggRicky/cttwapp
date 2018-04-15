<?php

use yii\helpers\Html;

/* @var $this yii\web\View */

$this->title = 'Cliente';
$asset = \frontend\assets\AppAsset::register($this);
$baseUrl = $asset->baseUrl;

?>

<!-- Blue ribbon decoration -->
<section id="work-area-view" class="ctt-section bg-primary">
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
            <?= Html::a('R e g r e s a r', ['client/index', '#' => 'work-area-index'], ['class' => 'btn btn-dark']) ?>
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
            <p>Crear nuevo Cliente</p>
        </div>
    </div>

    <!-- Yii2 work area -->
    <div class="row">
        <div class="col-lg-12 text-justify yii2-content">

            <!-- Business logic for create a client -->
            <div class="render-area">

                <?= $this->render('_form', [
                    'model' => $model,
                ]) ?>

            </div>

        </div>
    </div>
</section>

<section>
    <!-- A button for go to the page's top -->
    <div class="col-lg-10 col-lg-offset-1 text-center up-btn-area">
        <a class="tooltip-conf" href="#work-area-view" data-toggle="tooltip" title="Ir al inicio">
            <span class="glyphicon glyphicon-circle-arrow-up"></span>
        </a>
    </div>
</section>

<!-- Footer -->
<footer >
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
                        <p class="text-muted">Copyright &copy; 2017-<?= date("Y"); ?><br/>TSR Development Software</p>
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