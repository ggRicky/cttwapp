<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\DetailView;

/* 2018-06-05 : Used to display Catalog Name for the actual article record */

use yii\helpers\ArrayHelper;
use app\models\Catalog;
use app\models\Brand;

/* @var $this yii\web\View */
/* @var $model app\models\Article */

// 2018-06-09 : If the user isn't authenticated, then redirect him to the login form.

$this->title = 'Producto / Servicio';
$description = 'Vista Detallada';

$asset = \frontend\assets\AppAsset::register($this);
$baseUrl = $asset->baseUrl;

// 2018-06-11 : If there is a page parameter, then stores and validate it.
// Verifies and validate the current page value.
$ret_page = Yii::$app->getRequest()->getQueryParam('page');
$ret_page = (empty($ret_page)?'1':$ret_page);

// 2018-07-16 : To get the image path and filename.
$file_name = Yii::getAlias('@webroot').Yii::getAlias('@uploads_inv').'/'.PREFIX_IMG.$model->id;
// 2018-07-16 : Check the existence of a correct file type and determine its extension if there is one.
$file_ext = (file_exists($file_name.'.jpg') ? '.jpg': (file_exists($file_name.'.png') ? '.png': null));
// 2018-07-16 : Check the existence of a correct file type and determine its extension if there is one.
$url_image = Url::to(Yii::getAlias('@uploads_inv').'/').PREFIX_IMG.$model->id.$file_ext;

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

                <!-- Flash messages area -->

                <!-- 2019-03-05 : Flash error message no auto-closable. -->
                <?php if (Yii::$app->session->hasFlash('error')): ?>
                    <div class="alert alert-error alert-dismissible fade in slow-close">
                        <a href="#" class="close link-close" data-toggle="tooltip" aria-label="close" title="<?= Yii::t('app','Cerrar') ?>">&times;</a>
                        <h4><strong>¡ <?= Yii::t('app','Error'); ?> !</strong></h4>
                        <p><?= Yii::$app->session->getFlash('error') ?></p>
                    </div>
                <?php endif; ?>

                <!-- 2018-05-23 : Flash warning message. Auto closable -->
                <?php if (Yii::$app->session->hasFlash('warning')): ?>
                    <div id="auto-close" class="alert alert-warning alert-dismissible fade in">
                        <a href="#" class="close" data-dismiss="alert" data-toggle="tooltip" aria-label="close" title="<?= Yii::t('app','Cerrar') ?>">&times;</a>
                        <h4><strong>¡ <?= Yii::t('app','Advertencia'); ?> !</strong></h4>
                        <p><?= Yii::$app->session->getFlash('warning') ?></p>
                    </div>
                <?php endif; ?>

                <!-- 2018-05-25 : Flash success message. Auto closable -->
                <?php if (Yii::$app->session->hasFlash('success')): ?>
                    <div id="auto-close" class="alert alert-success alert-dismissible fade in">
                        <a href="#" class="close" data-dismiss="alert" data-toggle="tooltip" aria-label="close" title="<?= Yii::t('app','Cerrar') ?>">&times;</a>
                        <h4><strong>¡ <?= Yii::t('app','Información'); ?> !</strong></h4>
                        <p><?= Yii::$app->session->getFlash('success') ?></p>
                    </div>
                <?php endif; ?>

                <!-- Business logic for view an article  -->
                <div class="article-view">

                    <p>
                        <?= Html::a(Yii::t('app','Actualizar'), ['update', 'id' => $model->id, 'page' => $ret_page], ['class' => 'btn btn-primary btn-ctt-fixed-width']) ?>
                        <?= Html::a(Yii::t('app','Eliminar'), ['delete', 'id' => $model->id, 'page' => $ret_page],   ['class' => 'btn btn-danger btn-ctt-fixed-width',
                            'data' => [
                                // 2019-04-04 : Adds to the modal content, the record id and other description like a warning message.
                                'message' => Yii::t('app', '¿ Está seguro de eliminar este elemento ?').'<br>'.$model->id.'&nbsp;-&nbsp;'.$model->name_art,
                                'color' => 4,   // Red color header in modal window.
                            ],
                            // 2018-05-31 : Important : The 'data-confirm' parameter must be there, because it trigger a modal confirmation window before run the action delete.
                            // In the same way, through this parameter can be pass the user's message to the overwritten function yii.confirm, located in the cttwapp-stylish.css file.
                            // An other way to send the user's message to the overwritten function yii.confirm, is through a data array, like showed above.
                            // In this case the 'data-confirm' parameter must be empty.
                            'data-confirm' => '',
                            //  2018-05-31 : The next two parameters are needed to complete teh right call to the action delete, because it will be made using the post method.
                            'data-method' => 'post',
                            'data-pjax' => '0',
                        ]) ?>
                        <!-- 2018-08-25 : Send the newly generated PDF file to a new browser tab through 'target' => '_blank' -->
                        <?= Html::a(Yii::t('app','Imprimir'), ['print', 'id' => $model->id, 'page' => $ret_page], ['target'=>'_blank', 'class' => 'btn btn-ctt-warning btn-ctt-fixed-width']) ?>
                    </p>

                    <br/>

                    <?= DetailView::widget([
                        'model' => $model,
                        'options' => [
                            // 2018-08-11 : Defines the styles for customize the DetailView widget.
                            'class' => 'detail-view-style',
                        ],
                        'attributes' => [
                            [
                                'attribute' => 'id',
                            ],

                            // 2018-05-06 : Modified to display the ID and the Catalog Description instead of the ID only.
                            [
                                'attribute' => 'catalog_id',
                                'value' => implode(",",ArrayHelper::map(Catalog::find()->where(['id' => $model->catalog_id])->all(),'id','displayNameCat')),
                            ],

                            'name_art',
                            'sp_desc',
                            'en_desc',

                            // 2018-08-03 : To displays the image.
                            [
                                'attribute' => 'photo',
                                'format' => 'raw',
                                'value' => function ($model) {
                                    // 2018-07-10 : To get the image path and the filename.
                                    $file_name = Yii::getAlias('@webroot').Yii::getAlias('@uploads_inv').'/'.PREFIX_IMG.$model->id;
                                    // 2018-07-10 : To get the image url.
                                    $url_image = Url::to(Yii::getAlias('@uploads_inv').'/').PREFIX_IMG.$model->id;
                                    // 2018-07-11 : To get the no image url.
                                    $url_no_image = Url::to(Yii::getAlias('@uploads_inv').'/').'ctt_no_image.jpg';
                                    // 2018-07-10 : Test for the right file type
                                    if (file_exists($file_name.'.jpg'))
                                        return '<img src="'.$url_image.'.jpg" width="auto" style="max-height:100%; max-width:100%">';
                                    else if (file_exists($file_name.'.png'))
                                        return '<img src="'.$url_image.'.png" width="auto" style="max-height:100%; max-width:100%">';
                                    else
                                        return '<img src="'.$url_no_image.'" width="auto" style="max-height:100%; max-width:100%">';
                                },
                            ],

                            // 2018-05-06 : For type art, the right legend is displayed and colored properly.
                            [
                                'attribute' => 'type_art',
                                'value' => function($model){
                                    return ($model->type_art=='R'?'RENTA':'VENTA');
                                },
                                'contentOptions' => function ($model, $key, $index, $column) {
                                    return ['style' => 'color:'. ($model->type_art=='R'?'grey':'#337ab7')];
                                },
                            ],

                            'price_art',

                            // 2018-05-06 : For currency art, the right legend is displayed and colored properly.
                            [
                                'attribute' => 'currency_art',
                                'value' => function($model){
                                    return ($model->currency_art=='P'?'PESOS':'DÓLARES');
                                },
                                'contentOptions' => function ($model, $key, $index, $column) {
                                    return ['style' => 'color:'. ($model->currency_art=='P'?'grey':'#337ab7')];
                                },
                            ],

                            'part_num',

                            // 2018-05-06 : Modified to display the ID and the Catalog Description instead of the ID only.
                            [
                                'attribute' => 'brand_id',
                                'value' => implode(",",ArrayHelper::map(Brand::find()->where(['id' => $model->brand_id])->all(),'id','displayBrandDesc')),
                            ],

                            // 2019-03-31 : Display the show price list status
                            [
                                'attribute' => 'shown_price_list',
                                'value' => function($model){
                                    return ($model->shown_price_list=='S'?'Si':'No');
                                },
                            ],

                            'created_at',
                            'updated_at',
                            'created_by',
                            'updated_by',
                        ],
                    ]) ?>

                </div>
            </div>
        </div>
    </section>

<!-- Includes the actions view's footer file -->
<?php include(Yii::getAlias('@app').'/views/layouts/cttwapp_views_actions_footer.inc'); ?>

<!-- Includes the custom modal window to confirm the GridView actions-->
<?php include(Yii::getAlias('@app').'/views/layouts/cttwapp_views_modal_confirm.inc'); ?>
