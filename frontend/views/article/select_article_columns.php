<?php
/**
 * Created by PhpStorm.
 * User: ricardo
 * Date: 20/08/18
 * Time: 04:54 PM
 */

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model_1 \yii\base\DynamicModel */

$this->title = 'Artículo';
$description = 'Selector de Columnas';

$asset = \frontend\assets\AppAsset::register($this);
$baseUrl = $asset->baseUrl;

// 2018-06-11 : If there is a page parameter, then stores and validate it.
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
                <?= Html::a(Yii::t('app','R e g r e s a r'), ['article/index', 'page' => $ret_page, 'hash' => '0'], ['class' => 'btn btn-dark btn-ctt-fixed-width', 'data-toggle' => 'tooltip', 'title' => Yii::t('app', 'Regresar al nivel anterior')]) ?>
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

                <!-- Business logic for selects the article's columns -->
                <div class="article-columns">

                    <!-- Info section -->
                    <div class="well well-lg text-info">
                        <a href="#" class="close" data-dismiss="alert" data-toggle="tooltip" aria-label="close" title="<?= Yii::t('app','Cerrar') ?>">&times;</a>
                        <h4><strong><?= Yii::t('app','Instrucciones'); ?></strong></h4>
                        <p><?= Yii::t('app','Seleccione y marque las columnas que desea Mostrar o bien Ocultar en este módulo. Por último, al guardar los cambios que realizó, éstos serán aplicados de inmediato al mismo.'); ?></p>
                    </div>

                    <!-- Styles the form -->
                    <div style="padding-left: 5px; padding-top: 20px;">
                        <?= $this->render('_form1', [
                            'model_1' => $model_1,
                        ]) ?>
                    </div>

                </div>

            </div>
        </div>
    </section>

<!-- Includes the actions view's footer file -->
<?php include(Yii::getAlias('@app').'/views/layouts/cttwapp_views_actions_footer.inc'); ?>