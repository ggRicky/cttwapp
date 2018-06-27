<?php

use yii\helpers\Html;
use yii\web\View;

/* @var $this yii\web\View */

$this->title = 'CTTWApp';
$subtitle    = 'B a c k e n d';
$description = 'Sistema Gestor de Operaciones';

$asset = \frontend\assets\AppAsset::register($this);
$baseUrl = $asset->baseUrl;

// 2018-06-16 : Used to get a random int, and display a random background image.
$randomBg = rand(1,11);;

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

        <!-- Includes the menu options file -->
        <?php include(Yii::getAlias('@app').'/views/layouts/cttwapp_menu_options_bke.inc'); ?>
    </ul>
</nav>

<!-- Header -->
<header id="top">
    <div class="row"> <!-- Bootstrap's row -->
        <div class="col-lg-12"> <!-- Bootstrap's col -->
            <!-- CTT logo to display over the CTT's crane video with opacity level -->
            <img src="<?=$baseUrl?>/img/ctt-logo_1.png" class="ctt-logo">
            <div class="ctt-mask">  <!-- Defines an optionally mask to cover and color the video -->
                <!-- Video settings to autoplay and infinite loop -->
                <video class="crop-video" poster="<?=$baseUrl?>/img/ctt-poster.jpg" autoplay loop>
                    <source src="<?=$baseUrl?>/mov/ctt-grua-scorpio.webm" type="video/webm">  <!-- The webm video format is the best for high performance downloads -->
                </video>
            </div>
        </div>
    </div>
</header>

<!-- Orange ribbon decoration -->
<section id="work-area-index" class="ctt-section bg-secondary">
    <div class="col-lg-12">
        <!-- CTT water mark background logo decoration -->
        <div class="row"><div class="ctt-water-mark"></div></div>
    </div>
</section>

<!-- Yii2 Content -->
<section id="yii2" class="yii2-page">
    <!-- Yii2 Title layout -->
    <div class="row"><div class="col-lg-10 yii2-header"><?= Yii::t('app',Html::encode($this->title)) ?></div></div>
    <div class="row"><div class="yii2-message-area"><p><?= Yii::t('app',Html::encode($subtitle)) ?></p></div></div>

    <!-- Yii2 complementary description -->
    <div class="row">
        <div class="col-lg-10 text-info yii2-description"><p><?= Yii::t('app',Html::encode($description)) ?></p></div>
    </div>

    <div class="row">
        <div class="yii2-message-area">
            <!-- Builds a language options ribbon -->
            <?php
            echo "|&nbsp;";
            foreach(Yii::$app->params['languages'] as $key => $language){
                echo "<a href=\"#lang-". $key ."\" class=\"language\" id='".$key."'>".trim($language)."</a>" . "&nbsp;|&nbsp;" ;
            }
            ?>
        </div>
        <div class="col-lg-10 yii2-message-area"><h2 class="barcode-font">ISC-RGG</h2></div>
    </div>

    <!-- Yii2 work area -->
    <div class="row"><div class="col-lg-12 text-justify yii2-content" style="height: 300px"></div></div>
</section>

<?php

// Includes the index's footer file
include(Yii::getAlias('@app').'/views/layouts/cttwapp_index_footer_bke.inc');

// Include the index's modals file
include(Yii::getAlias('@app').'/views/layouts/cttwapp_index_modals_bke.inc');

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