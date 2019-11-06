<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\AuthItem */

$this->title = 'Objeto de Autorización';
$description = 'Vista de un Objeto de Autorización';

$asset = \frontend\assets\AppAsset::register($this);
$baseUrl = $asset->baseUrl;

// 2018-06-21 : If there is a page parameter, then stores and validate it.
// Verifies and validate the current page value.
$ret_page = Yii::$app->getRequest()->getQueryParam('page');
$ret_page = (empty($ret_page)?'1':$ret_page);

?>

<!-- Blue ribbon decoration -->
<section class="ctt-section bg-secondary">
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
            <?= Html::a(Yii::t('app','R e g r e s a r'), ['auth-item/index', 'page' => $ret_page, 'hash' => '0'], ['class' => 'btn btn-dark btn-ctt-fixed-width', 'data-toggle' => 'tooltip', 'title' => Yii::t('app', 'Regresar al nivel anterior')]) ?>
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

            <!-- Business logic for view an auth item -->
            <div class="auth-item-view">

                <p>
                    <?= Html::a(Yii::t('app','Actualizar'), ['update', 'id' => $model->name, 'page' => $ret_page], ['class' => 'btn btn-primary btn-ctt-fixed-width']) ?>
                    <?= Html::a(Yii::t('app','Eliminar'), ['delete', 'id' => $model->name, 'page' => $ret_page],   ['class' => 'btn btn-danger btn-ctt-fixed-width',
                        // 2018-06-03 : A data set may be send like parameters to the overwritten function yii.confirm. And in the function, the data may be retrieved
                        // and displayed in the modal window.
                        'data' => [
                            'color' => 4,  // Red color header in modal window.
                        ],
                        // 2019-11-04 : Important : The 'data-confirm' parameter must be there, because it trigger a modal confirmation window before run the action delete.
                        // In the same way, through this parameter can be pass the user's message to the overwritten function yii.confirm, located in the cttwapp-stylish.css file.
                        // Another way to sends user's data (p.e. color code ) to the overwritten function yii.confirm, is through a data array like showed above.
                        // On the next line, the confirmation message is passed to the modal dialog window via the parameter 'confirm-data' just before starting the deletion action.
                        'data-confirm' => Yii::t('app', '¿ Está seguro de eliminar este elemento ?').'<br>'.$model->name.'&nbsp;-&nbsp;'.$model->description,
                        // 2018-06-03 : The next two parameters are needed to complete the right call to the action delete, because it will be made using the post method.
                        'data-method' => 'post',
                        // 2018-06-03 : The Pjax widget allows you to update a certain section of a page instead of reloading the entire page. You can use it to update only
                        // the GridView content when using filters. But this might be a problem for the links of an ActionColumn. To prevent this, add the HTML attribute
                        // data-pjax="0" to the links when you edit the ActionColumn::$buttons property.

                        // You may configure $linkSelector to specify which links should trigger pjax, and configure $formSelector to specify which form submission may trigger pjax.
                        // You may disable pjax for a specific link inside the container by adding data-pjax="0" attribute to this link.
                        'data-pjax' => '0',
                    ]) ?>
                </p>

                <?= DetailView::widget([
                    'model' => $model,
                    'attributes' => [
                        'name',
                        'type',
                        'description:ntext',
                        'rule_name',
                        'data',

                        // 2018-05-27 : For created_at, updated_at, convert the timestamp to date properly.

                        [
                            'attribute' => 'created_at',
                            'value' => function($model){
                                return (date('Y-m-d G:i:s', $model->created_at));
                            },
                        ],
                        [
                            'attribute' => 'updated_at',
                            'value' => function($model){
                                return (date('Y-m-d G:i:s', $model->updated_at));
                            },
                        ],

                    ],
                ]); ?>

            </div>
        </div>
    </div>
</section>

<!-- Includes the actions view's footer file -->
<?php include(Yii::getAlias('@app').'/views/layouts/cttwapp_views_actions_footer_bke.inc'); ?>

<!-- Includes the custom modal window to confirm the GridView actions-->
<?php include(Yii::getAlias('@app').'/views/layouts/cttwapp_views_modal_confirm_bke.inc'); ?>
