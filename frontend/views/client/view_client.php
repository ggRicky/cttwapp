<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* 2018-03-17 : Used to display Description Type for the actual client record */
use yii\helpers\ArrayHelper;
use app\models\ClientType;

/* @var $this yii\web\View */

$this->title = 'Cliente';
$asset = \frontend\assets\AppAsset::register($this);
$baseUrl = $asset->baseUrl;

?>

<!-- Blue ribbon decoration -->
<section id="work-area-view" class="ctt-section bg-primary">
    <div class="col-lg-12">
        <div class="row">
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
            <?= Html::a('R e g r e s a r', ['client/index', '#' => 'work-area-index'], ['class' => 'btn btn-dark']) ?>
        </div>
    </div>

    <!-- Yii2 Title layout -->
    <div class="row">
        <div class="col-lg-10 yii2-header">
            <p><?= Html::encode($this->title) ?></p>
        </div>
    </div>

    <!-- Yii2 complementary description -->
    <div class="row">
        <div class="col-lg-10 text-info yii2-description">
            <p>Vista del Cliente</p>
        </div>
    </div>

    <!-- Yii2 work area -->
    <div class="row">
        <div class="col-lg-12 text-justify yii2-content">

            <!-- Business logic for view a client -->
            <div class="client-update">

                <p>
                    <?= Html::a('Actualizar', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
                    <?= Html::a('Eliminar', ['delete', 'id' => $model->id],   ['class' => 'btn btn-danger',
                        'data' => [
                            'confirm' => Yii::t('app','¿Está seguro de eliminar este elemento?'),
                            'method' => 'post',
                        ],
                    ]) ?>
                </p>

                <?= DetailView::widget([
                    'model' => $model,
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

<section>
    <!-- A button for go to the page's top -->
    <div class="col-lg-10 col-lg-offset-1 text-center up-btn-area">
        <div class="tooltip-conf">
            <span class="tooltip-text">Ir al inicio</span>
            <a href="#work-area-view">
                <span class="glyphicon glyphicon-circle-arrow-up"></span>
            </a>
        </div>
    </div>
</section>

<!-- Footer -->
<footer>
    <div class="container">
        <div class="row">
            <div class="col-lg-10 col-lg-offset-1 text-center">
                <!-- CTT mini logo -->
                <div class="col-lg-12">
                    <img src="<?=$baseUrl?>/img/ctt-mini-logo_1.jpg" class="center-block img-responsive" height="42" width="105"/>
                </div>

                <!-- Credits layer -->
                <div class="row">
                    <div class="col-lg-10 col-lg-offset-1 text-center tsr-content">
                        <hr class="small">
                        <p class="text-muted"><img src="<?=$baseUrl?>/img/yii2_logo.png" height="37" width="120"/></p>
                        <p class="text-muted">Copyright &copy; 2017-<?= date("Y"); ?><br/>TSR Development Software</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Blue ribbon decoration -->
    <section class="ctt-section bg-primary">
        <div class="col-lg-12">
            <div class="row"></div>
        </div>
    </section>
</footer>
