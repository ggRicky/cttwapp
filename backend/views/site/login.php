<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \common\models\LoginForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = Yii::t('app','Autentificación');
$description = Yii::t('app','Inicie su sesión de trabajo').'.';

$asset = \frontend\assets\AppAsset::register($this);
$baseUrl = $asset->baseUrl;

// 2018-06-21 : Stores a hash parameter to jump to the requested area.
$hash_param = Yii::$app->getRequest()->getQueryParam('hash');
// 2018-06-21 : Translates the $hash_param value to the corresponding anchor to jump.
// $hash_param [ 0 - Jumps to the work area index  1 - Jumps to the panel area ]
// 2018-06-21 : Or if there is an flash message, then jump directly towards the header and go to the work-area-index using javascript.
$hash_param = (($hash_param=='0' || Yii::$app->session->hasFlash('error') || Yii::$app->session->hasFlash('warning'))?'work-area-index':($hash_param=='1'?'panel-area':null));

// 2018-06-21 : if an anchor parameter was send, then jumps to it using javascript.
if ($hash_param) {
    $script = <<< JS
    location.hash = "#$hash_param";
JS;
    $this->registerJs($script);
}

//2018-05-25 : Used to get a random int, and display a random parallax.
$randomBg = rand(1,11);;

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

<!-- Orange ribbon decoration -->
<section class="ctt-section bg-secondary">
    <div class="col-lg-12">
        <div class="row">
            <!-- CTT water mark background logo decoration -->
            <div id="work-area-index" class="ctt-water-mark"></div>
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
            <p><?= Yii::t('app',Html::encode($description));?></p>
        </div>
    </div>

    <!-- Yii2 work area -->
    <div class="row">
        <div class="col-lg-12 text-justify yii2-content">

            <!-- 2018-04-08 : If there is a flash error message display it.-->
            <?php if (Yii::$app->session->hasFlash('error')): ?>
                <div class="alert alert-error alert-dismissible fade in slow-close">
                    <a href="#" class="close link-close" data-toggle="tooltip" aria-label="close" title="<?= Yii::t('app','Cerrar') ?>">&times;</a>
                    <h4><strong>¡ <?= Yii::t('app','Error'); ?> !</strong></h4>
                    <p><?= Yii::$app->session->getFlash('error') ?></p>
                </div>
            <?php endif; ?>

            <!-- 2018-05-25 : If there is a flash warning message displays it. -->
            <?php if (Yii::$app->session->hasFlash('warning')): ?>
                <div class="alert alert-warning alert-dismissible fade in slow-close">
                    <a href="#" class="close link-close" data-toggle="tooltip" aria-label="close" title="<?= Yii::t('app','Cerrar') ?>">&times;</a>
                    <h4><strong>¡ <?= Yii::t('app','Advertencia'); ?> !</strong></h4>
                    <p><?= Yii::$app->session->getFlash('warning') ?></p>
                </div>
            <?php endif; ?>

            <!-- 2018-07-02 : If there is a flash success message displays it. -->
            <?php if (Yii::$app->session->hasFlash('success')): ?>
                <div class="alert alert-success alert-dismissible fade in slow-close">
                    <a href="#" class="close link-close" data-toggle="tooltip" aria-label="close" title="<?= Yii::t('app','Cerrar') ?>">&times;</a>
                    <h4><strong>¡ <?= Yii::t('app','Información'); ?> !</strong></h4>
                    <p><?= Yii::$app->session->getFlash('success') ?></p>
                </div>
            <?php endif; ?>

            <p><?= Yii::t('app','Para iniciar su sesión de trabajo, por favor ingrese sus datos de autentificación en los siguientes campos :'); ?></p>

            <div class="site-login">
                <div class="row">
                    <div class="col-lg-5">
                        <?php $form = ActiveForm::begin(['id' => 'login-form']); ?>

                        <?= $form->field($model, 'username')->textInput() ?>

                        <?= $form->field($model, 'password')->passwordInput() ?>

                        <?= $form->field($model, 'rememberMe')->checkbox() ?>

                        <div class="form-group">
                            <?= Html::submitButton(Yii::t('app','Ingresar'), ['class' => 'btn btn-primary btn-ctt-fixed-width', 'name' => 'login-button']) ?>
                        </div>

                        <?php ActiveForm::end(); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

</section>

<!-- Includes the view's footer file -->
<?php include(Yii::getAlias('@app').'/views/layouts/cttwapp_views_footer_bke.inc'); ?>