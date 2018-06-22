<?php

/* @var $this yii\web\View */
/* @var $name string */
/* @var $message string */
/* @var $exception Exception */

use yii\helpers\Html;

/* @var $this yii\web\View */

$this->title = 'Error';
$description = 'Fallo en la operación';

$asset = \frontend\assets\AppAsset::register($this);
$baseUrl = $asset->baseUrl;

?>
<!-- Blue ribbon decoration -->
<section id="work-view-area" class="ctt-section bg-primary">
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
            <p><?= Yii::t('app',Html::encode($description)); ?></p>
        </div>
    </div>

    <!-- Yii2 work area -->
    <div class="row">
        <div class="col-lg-12 text-justify yii2-content">

            <div class="site-error">

                <div class="alert alert-danger">
                    <p><h4><?= nl2br(Html::encode($name)) ?></h4></p>
                    <p><?= nl2br(Html::encode($message)) ?></p>

                    <!-- If in development environment mode, then shows the exception details. -->
<!--                    --><?php //if(YII_ENV_DEV) :?>
                        <p><?= nl2br(Html::encode($exception)) ?></p>
<!--                    --><?php //endif;?>
                </div>

                <p><?= Yii::t('app','El error que se indica arriba, ocurrió mientras el servidor web procesaba su solicitud.'); ?></p>
                <p><?= Yii::t('app','Por favor contáctenos si considera que se trata de un error en el servidor. Gracias.'); ?></p>

            </div>

        </div>
    </div>
</section>

<!-- Includes the view's footer file -->
<?php include(Yii::getAlias('@app').'/views/layouts/cttwapp_views_actions_footer.inc'); ?>