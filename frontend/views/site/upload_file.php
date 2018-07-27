<?php

use yii\helpers\Html;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model app\models\Article */
/* @var $id */

$this->title = 'Artículo';
$description = 'Cargar una fotografía para el artículo';

$asset = \frontend\assets\AppAsset::register($this);
$baseUrl = $asset->baseUrl;

// 2018-06-05 : If there is a page parameter, then stores and validate it.
// Verifies and validate the current page value.
$ret_page = Yii::$app->getRequest()->getQueryParam('page');
$ret_page = (empty($ret_page)?'1':$ret_page);

?>

<!-- Blue ribbon decoration -->
<section class="ctt-section bg-primary">
    <div class="col-lg-12">
        <div id="work-view-area" class="row">
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
            <?= Html::a(Yii::t('app','R e g r e s a r'), ['article/update', 'id' => $id, 'page' => $ret_page, 'hash' => '1'], ['class' => 'btn btn-dark btn-ctt-fixed-width', 'data-toggle' => 'tooltip', 'title' => Yii::t('app', 'Regresar al nivel anterior')]) ?>
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
            <p><?= Yii::t('app',Html::encode($description)).' : '.$id; ?></p>
        </div>
    </div>

    <!-- Yii2 work area -->
    <div class="row">

        <div class="col-lg-12 text-justify yii2-content">
            <!-- 2018-07-08 : If there is a flash error message display it.-->
            <?php if (Yii::$app->session->hasFlash('error')): ?>
                <div class="alert alert-error alert-dismissible fade in">
                    <a href="#" class="close" data-dismiss="alert" data-toggle="tooltip" aria-label="close" title="<?= Yii::t('app','Cerrar') ?>">&times;</a>
                    <h4><strong>¡ <?= Yii::t('app','Error'); ?> !</strong></h4>
                    <p><?= Yii::$app->session->getFlash('error') ?></p>
                </div>
            <!-- 2018-07-08 : If there is a flash warning message displays it. -->
            <?php elseif (Yii::$app->session->hasFlash('warning')): ?>
                <div class="alert alert-warning alert-dismissible fade in">
                    <a href="#" class="close" data-dismiss="alert" data-toggle="tooltip" aria-label="close" title="<?= Yii::t('app','Cerrar') ?>">&times;</a>
                    <h4><strong>¡ <?= Yii::t('app','Advertencia'); ?> !</strong></h4>
                    <p><?= Yii::$app->session->getFlash('warning') ?></p>
                </div>
            <!-- 2018-07-08 : If there is a flash success message displays it. -->
            <?php elseif (Yii::$app->session->hasFlash('success')): ?>
                <div class="alert alert-success alert-dismissible fade in">
                    <a href="#" class="close" data-dismiss="alert" data-toggle="tooltip" aria-label="close" title="<?= Yii::t('app','Cerrar') ?>">&times;</a>
                    <h4><strong>¡ <?= Yii::t('app','Información'); ?> !</strong></h4>
                    <p><?= Yii::$app->session->getFlash('success') ?></p>
                </div>
            <?php else: ?>
                <!-- Business logic for upload a file -->
                <div class="article-update">
                    <?= $this->render('_upload', [
                        'model' => $model,
                        'page'  => $ret_page,
                    ]) ?>
                </div>
            <?php endif; ?>

        </div>
    </div>
</section>

<!-- Includes the actions view's footer file -->
<?php include(Yii::getAlias('@app').'/views/layouts/cttwapp_views_actions_footer.inc'); ?>