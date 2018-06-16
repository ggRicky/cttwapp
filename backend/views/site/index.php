<?php

use yii\helpers\Url;
use yii\helpers\Html;

/* @var $this yii\web\View */

$this->title = 'CTTWApp - Backend';
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

        <!-- CTT default actions ribbon -->
        <?php
            // 2018-04-08 : This code was refactored, using only Html helper
            // 2018-05-24 : Remove guest entry for rbac security.
            echo Html::begintag('div', ['class' => 'ctt-mini-bar-top']);
            echo Html::beginForm(['/site/logout'], 'post');
            echo Html::submitButton(Yii::t('app','<span><i class="fa fa-power-off fa-lg"></i></span>'), ['class' => 'btn btn-dark', 'title' => Yii::t('app','Cerrar Sesión')]) . "&nbsp;&nbsp;&nbsp;";
            echo Html::tag('label', Yii::$app->user->identity->username, ['style' => ['color' => 'white', 'font-size' => 'medium', 'font-weight' => 'normal']]);
            echo Html::endForm();
            echo Html::endtag('div');
        ?>

        <!-- Content menu -->

        <!-- 2018-05-24 : Special Option - Only the admin user can create an new user. -->
        <?php if (\Yii::$app->user->can('adminSite')): ?>

            <li>
                <div class="ctt-mini-bar-spc-opts">
                    <?= "<a href='".Url::to(['auth-item/index'])."'>".Yii::t('app','Objetos de Autorización')."</a>" ?>
                </div>
            </li>

        <?php endif; ?>

    </ul>
</nav>

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

<!-- Orange ribbon decoration -->
<section class="ctt-section bg-secondary">
    <div class="col-lg-12">
        <!-- CTT water mark background logo decoration -->
        <div class="row"><div class="ctt-water-mark"></div></div>
    </div>
</section>

<!-- Yii2 Content -->
<section id="yii2" class="yii2-page">
    <!-- Yii2 Title layout -->
    <div class="row"><div class="col-lg-10 yii2-header"><?= Yii::t('app',Html::encode($this->title)) ?></div></div>

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
    <div class="row"><div class="col-lg-12 text-justify yii2-content"></div></div>
</section>

<?php

// Includes the index's footer file
include(Yii::getAlias('@app').'/views/layouts/cttwapp_index_footer_bke.inc');

?>