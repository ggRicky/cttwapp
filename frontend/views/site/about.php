<?php

use yii\helpers\Html;

/* @var $this yii\web\View */

$this->title = 'Acerca';
$description = 'CTT Web Application v-1.001 Beta';

$asset = \frontend\assets\AppAsset::register($this);
$baseUrl = $asset->baseUrl;

//2018-04-26 : Used to get a random int, and display a random parallax.
$randomBg = rand(1,11);

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
            <p><?= Yii::t('app',Html::encode($description));?></p>
        </div>
    </div>

    <!-- Yii2 work area -->
    <div class="row">
        <div class="col-lg-12 text-justify yii2-content">
            <div class="table-responsive">
                <table class="table-bordered table-striped table-hover table-about">
                    <tbody>
                    <tr>
                        <th><?= Yii::t('app','Clave') ?></th><td>CTTwapp</td>
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
                        <th><?= Yii::t('app','Última Actualización') ?></th><td>2019-03-31 &nbsp;&nbsp;&nbsp; 20:12 Hrs.</td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</section>

<!-- Includes the view's footer file -->
<?php include(Yii::getAlias('@app').'/views/layouts/cttwapp_views_footer.inc'); ?>