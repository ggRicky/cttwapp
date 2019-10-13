<?php

use yii\helpers\Html;
use yii\web\View;

/* @var $this yii\web\View */

$this->title = 'CTTwapp';
$subtitle    = 'F r o n t e n d';
$description = 'Sistema Gestor de Operaciones';

$asset = \frontend\assets\AppAsset::register($this);
$baseUrl = $asset->baseUrl;

// 2018-07-27 : Stores a hash parameter to jump to the requested area.
$hash_param = Yii::$app->getRequest()->getQueryParam('hash');
// 2018-07-27 : Translates the $hash_param value to the corresponding anchor to jump.
// $hash_param [ 0 - Jumps to the work area index  1 - Jumps to the panel area ]
// 2018-07-27 : Or if there is an flash message, then jump directly towards the header and go to the work-area-index using javascript.
$hash_param = (($hash_param=='0' || Yii::$app->session->hasFlash('error') || Yii::$app->session->hasFlash('warning'))?'work-area-index':($hash_param=='1'?'panel-area':null));

// 2018-07-27 : if an anchor parameter was send, then jumps to it using javascript.
if ($hash_param) {
    $script = <<< JS
    location.hash = "#$hash_param";
JS;
    $this->registerJs($script);
}

// 2018-04-26 : Used to get a random int, and display a random parallax.
$randomBg = rand(1,11);

?>

<!-- Includes Navigation Bar -->
<?php include(Yii::getAlias('@app').'/views/layouts/cttwapp_views_menu_navbar.inc'); ?>

<!-- Header -->
<header id="top">
    <div class="row"> <!-- Bootstrap's row -->
        <div class="col-lg-12"> <!-- Bootstrap's col -->
            <!-- CTT logo to display over the video with opacity level -->
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
    <!-- Yii2 Title layout -->
    <div class="row"><div class="col-lg-10 yii2-header"><?= Yii::t('app',Html::encode($this->title)) ?></div></div>
    <div class="row"><div class="yii2-message-area"><p><?= Yii::t('app',Html::encode($subtitle)) ?></p></div></div>

    <!-- Yii2 complementary description -->
    <div class="row"><div class="col-lg-10 text-info yii2-description"><p><?= Yii::t('app',Html::encode($description)) ?></p></div></div>

    <div class="row">
        <div class="yii2-message-area">
            <!-- Builds a language options ribbon -->
            <?php
                echo "|&nbsp;";
                foreach(Yii::$app->params['languages'] as $key => $language){
                    echo "<a href=\"#lang-".$key."\" class=\"language\" data-toggle=\"tooltip\" title=\"".Yii::t('app','Cambiar Idioma')."\" id='".$key."'>".trim($language)."</a>" . "&nbsp;|&nbsp;" ;
                }
            ?>
        </div>
        <div class="col-lg-10 yii2-message-area"><h2 class="barcode-font">ISC-RGG</h2>
            <?= Html::a(Yii::t('app','Última Actualización'), ['site/about', 'hash' => '0']) ?>
        </div>
    </div>

    <!-- Yii2 work area -->
    <div class="row">
        <div class="col-lg-12 text-justify yii2-content" style="height: 300px">

            <!-- Flash messages area -->

            <!-- 2018-06-23 : Flash error message no auto-closable. -->
            <?php if (Yii::$app->session->hasFlash('error')): ?>
                <div class="alert alert-error alert-dismissible fade in slow-close">
                    <a href="#" class="close link-close" data-toggle="tooltip" aria-label="close" title="<?= Yii::t('app','Cerrar') ?>">&times;</a>
                    <h4><strong>¡ <?= Yii::t('app','Error'); ?> !</strong></h4>
                    <p><?= Yii::$app->session->getFlash('error') ?></p>
                </div>
            <?php endif; ?>

            <!-- 2018-06-23 : Flash warning message no auto-closable. -->
            <?php if (Yii::$app->session->hasFlash('warning')): ?>
                <div class="alert alert-warning alert-dismissible fade in slow-close">
                    <a href="#" class="close link-close" data-toggle="tooltip" aria-label="close" title="<?= Yii::t('app','Cerrar') ?>">&times;</a>
                    <h4><strong>¡ <?= Yii::t('app','Advertencia'); ?> !</strong></h4>
                    <p><?= Yii::$app->session->getFlash('warning') ?></p>
                </div>
            <?php endif; ?>

            <!-- 2018-06-23 : Flash success message no auto-closable. -->
            <?php if (Yii::$app->session->hasFlash('success')): ?>
                <div class="alert alert-success alert-dismissible fade in slow-close">
                    <a href="#" class="close link-close" data-toggle="tooltip" aria-label="close" title="<?= Yii::t('app','Cerrar') ?>">&times;</a>
                    <h4><strong>¡ <?= Yii::t('app','Información'); ?> !</strong></h4>
                    <p><?= Yii::$app->session->getFlash('success') ?></p>
                </div>
            <?php endif; ?>

        </div>
    </div>

</section>

<?php

    // Include the index's footer file
    include(Yii::getAlias('@app').'/views/layouts/cttwapp_views_index_footer.inc');

    // Include the index's modals file
    include(Yii::getAlias('@app').'/views/layouts/cttwapp_views_index_modals.inc');

    // 2018-02-09 : If the user was logged successfully, then display the modal window notification, using PHP & jQuery
    $session = Yii::$app->session;

    if ($session->has('successLogin')) {

        $script = "jQuery(document).ready(function () { $(\"#ctt-modal-usr-logged\").modal({show: true, backdrop: \"static\"}); });";
        $this->registerJs($script, View::POS_READY);

    }

?>