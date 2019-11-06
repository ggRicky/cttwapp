<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* 2018-03-17 : Used to display Description Type for the actual client record */
use yii\helpers\ArrayHelper;
use app\models\ClientType;

/* @var $this yii\web\View */
/* @var $model app\models\Client */

$this->title = 'Cliente';
$description = 'Vista del Cliente';

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
            <?= Html::a(Yii::t('app','R e g r e s a r'), ['client/index', 'page' => $ret_page, 'hash' => '0'], ['class' => 'btn btn-dark btn-ctt-fixed-width', 'data-toggle' => 'tooltip', 'title' => Yii::t('app', 'Regresar al nivel anterior')]) ?>
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

            <!-- Business logic for view a client -->
            <div class="client-view">

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
                        'data-confirm' => Yii::t('app', '¿ Está seguro de eliminar este elemento ?').'<br>'.$model->id.'&nbsp;-&nbsp;'.$model->business_name,
                        // 2018-06-03 : The next two parameters are needed to complete the right call to the action delete, because it will be made using the post method.
                        'data-method' => 'post',
                        // 2018-06-03 : The Pjax widget allows you to update a certain section of a page instead of reloading the entire page. You can use it to update only
                        // the GridView content when using filters. But this might be a problem for the links of an ActionColumn. To prevent this, add the HTML attribute
                        // data-pjax="0" to the links when you edit the ActionColumn::$buttons property.

                        // You may configure $linkSelector to specify which links should trigger pjax, and configure $formSelector to specify which form submission may trigger pjax.
                        // You may disable pjax for a specific link inside the container by adding data-pjax="0" attribute to this link.
                        'data-pjax' => '0',
                    ]) ?>
                    <!-- 2018-09-30 : Send the newly generated PDF file to a new browser tab through 'target' => '_blank' -->
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
                        'id',
                        'rfc',
                        'curp',

                        // 2018-04-23 : For taxpayer type, the right legend is displayed and colored properly.

                        [
                          'attribute' => 'taxpayer',
                          'value' => function($model){
                              return ($model->taxpayer=='M'?'PERSONA MORAL':'PERSONA FÍSICA');
                          },
                          'contentOptions' => function ($model, $key, $index, $column) {
                              return ['style' => 'color:'. ($model->taxpayer=='M'?'grey':'#428bca')];
                          },
                        ],

                        // 2018-04-10 : New fields add to client table in refactoring action.

                        'business_name',
                        'corporate',

                        // 2018-04-23 : For provenance type, the right legend is displayed.

                        [
                          'attribute' => 'provenance',
                          'value' => function($model){
                              return ($model->provenance=='N'?'NACIONAL':'EXTRANJERO');
                          },
                        ],

                        'contact_name',
                        'contact_email',
                        'street',
                        'outdoor_number',
                        'interior_number',
                        'suburb',
                        'municipality',
                        'delegation',
                        'state',
                        'zip_code',
                        'phone_number_1',
                        'phone_number_2',
                        'web_page',
                        'client_email',

                        'created_at',
                        'updated_at',
                        'created_by',
                        'updated_by',

                        // 2018-03-17 : Modified to display the ID and the Client Type Description instead of the ID only.

                        [
                          'attribute' => 'client_type_id',
                          'value' => implode(",",ArrayHelper::map(ClientType::find()->where(['id' => $model->client_type_id])->all(),'id','displayTypeDesc')),
                        ],
                     ],
                ]); ?>

            </div>
        </div>
    </div>
</section>

<!-- Includes the actions view's footer file -->
<?php include(Yii::getAlias('@app').'/views/layouts/cttwapp_views_actions_footer.inc'); ?>

<!-- Includes the custom modal window to confirm the GridView actions-->
<?php include(Yii::getAlias('@app').'/views/layouts/cttwapp_views_modal_confirm.inc'); ?>