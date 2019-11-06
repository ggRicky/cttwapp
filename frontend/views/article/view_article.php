<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\DetailView;
use yii\helpers\ArrayHelper;    /* 2018-06-05 : Used to display Catalog Name for the actual article record */
use app\models\Catalog;
use app\models\Brand;
use app\models\Warehouse;
use app\models\ArticleType;

/* @var $this yii\web\View */
/* @var $model app\models\Article */

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
                            // 2018-06-03 : A data set may be send like parameters to the overwritten function yii.confirm. And in the function, the data may be retrieved
                            // and displayed in the modal window.
                            'data' => [
                                'color' => 4,  // Red color header in modal window.
                            ],
                            // 2019-11-04 : Important : The 'data-confirm' parameter must be there, because it trigger a modal confirmation window before run the action delete.
                            // In the same way, through this parameter can be pass the user's message to the overwritten function yii.confirm, located in the cttwapp-stylish.css file.
                            // Another way to sends user's data (p.e. color code ) to the overwritten function yii.confirm, is through a data array like showed above.
                            // On the next line, the confirmation message is passed to the modal dialog window via the parameter 'confirm-data' just before starting the deletion action.
                            'data-confirm' => Yii::t('app', '¿ Está seguro de eliminar este elemento ?').'<br>'.$model->id.'&nbsp;-&nbsp;'.$model->name_art,
                            // 2018-06-03 : The next two parameters are needed to complete the right call to the action delete, because it will be made using the post method.
                            'data-method' => 'post',
                            // 2018-06-03 : The Pjax widget allows you to update a certain section of a page instead of reloading the entire page. You can use it to update only
                            // the GridView content when using filters. But this might be a problem for the links of an ActionColumn. To prevent this, add the HTML attribute
                            // data-pjax="0" to the links when you edit the ActionColumn::$buttons property.

                            // You may configure $linkSelector to specify which links should trigger pjax, and configure $formSelector to specify which form submission may trigger pjax.
                            // You may disable pjax for a specific link inside the container by adding data-pjax="0" attribute to this link.
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

                            // 2019-11-02 : Modified to display the alternative id
                            [
                                'attribute' => 'id_alt',
                                'value' => function($model){
                                    return (empty($model->id_alt)?'N/D':$model->id_alt);
                                },
                                'contentOptions' => ['style' => 'text-transform:uppercase;'],  // 2019-11-02 : Transforms all characters to uppercase
                            ],

                            // 2019-11-01 : Modified to display the article remarks text
                            [
                                'attribute' => 'remarks_art',
                                'value' => function($model){
                                    return (empty($model->remarks_art)?'N/D':$model->remarks_art);
                                },
                                'contentOptions' => ['style' => 'text-transform:uppercase;'],  // 2019-11-02 : Transforms all characters to uppercase
                            ],

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

                            [
                                'attribute' => 'article_type_id',
                                'value' => implode(",",ArrayHelper::map(ArticleType::find()->where(['id' => $model->article_type_id])->all(),'id','displayTypeDesc')),
                            ],

                            [
                                'attribute' => 'price_art',
                                'value' => function($model){
                                    // Sets the currency code based on the currency_art field value.
                                    if ($model->currency_art=='1') Yii::$app->formatter->currencyCode = 'MXN';
                                    elseif ($model->currency_art=='2') Yii::$app->formatter->currencyCode = 'USD';

                                    return (Yii::$app->formatter->asCurrency($model->price_art));
                                },
                            ],

                            // 2018-05-06 : For currency art, the right legend is displayed and colored properly.
                            [
                                'attribute' => 'currency_art',
                                'value' => function($model){
                                    return ($model->currency_art=='1'?'PESOS':'DÓLARES');
                                },
                                'contentOptions' => function ($model, $key, $index, $column) {
                                    return ['style' => 'color:'. ($model->currency_art=='1'?'grey':'#337ab7')];
                                },
                            ],

                            'part_num',

                            // 2018-05-06 : Modified to display the ID and the Brand Description instead of the ID only.
                            [
                                'attribute' => 'brand_id',
                                'value' => implode(",",ArrayHelper::map(Brand::find()->where(['id' => $model->brand_id])->all(),'id','displayBrandDesc')),
                            ],

                            // 2019-08-14 : Modified to display the ID and the Warehouse Description instead of the ID only.
                            [
                                'attribute' => 'warehouse_id',
                                'value' => implode(",",ArrayHelper::map(Warehouse::find()->where(['id' => $model->warehouse_id])->all(),'id','displayDescWarehouse')),
                            ],

                            // 2019-03-31 : Display the show price list status
                            [
                                'attribute' => 'shown_price_list',
                                'value' => function($model){
                                    return ($model->shown_price_list=='0'?'NO':'SI');
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
