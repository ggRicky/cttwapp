<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* 2018-06-05 : Used to display Catalog Name for the actual article record */

use yii\helpers\ArrayHelper;
use app\models\Catalog;
use app\models\Brand;

/* @var $this yii\web\View */
/* @var $model app\models\Article */

$this->title = 'Artículo';
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
            <?= Html::a(Yii::t('app','R e g r e s a r'), ['article/index', '#' => 'work-area-index'], ['class' => 'btn btn-dark']) ?>
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
            <p><?= Yii::t('app','Vista del Artículo');?></p>
        </div>
    </div>

    <!-- Yii2 work area -->
    <div class="row">
        <div class="col-lg-12 text-justify yii2-content">

            <!-- Business logic for view an article  -->
            <div class="article-update">

                <p>
                    <?= Html::a(Yii::t('app','Actualizar'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
                    <?= Html::a(Yii::t('app','Eliminar'), ['delete', 'id' => $model->id],   ['class' => 'btn btn-danger',
                        'data' => [
                            'confirm' => Yii::t('app','¿ Está seguro de eliminar este elemento ?'),
                            'method' => 'post',
                        ],
                    ]) ?>
                </p>

                <?= DetailView::widget([
                    'model' => $model,
                    'attributes' => [
                        'id',

                        // 2018-05-06 : Modified to display the ID and the Catalog Description instead of the ID only.
                        [
                            'attribute' => 'catalog_id',
                            'value' => implode(",",ArrayHelper::map(Catalog::find()->where(['id' => $model->catalog_id])->all(),'id','displayNameCat')),
                        ],

                        'name_art',
                        'sp_desc',
                        'en_desc',

                        // 2018-05-06 : For type art, the right legend is displayed and colored properly.
                        [
                            'attribute' => 'type_art',
                            'value' => function($model){
                                return ($model->type_art=='R'?'RENTA':'VENTA');
                            },
                            'contentOptions' => function ($model, $key, $index, $column) {
                                return ['style' => 'color:'. ($model->type_art=='R'?'grey':'#337AB7')];
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
                                return ['style' => 'color:'. ($model->currency_art=='P'?'grey':'#337AB7')];
                            },
                        ],

                        'part_num',

                        // 2018-05-06 : Modified to display the ID and the Catalog Description instead of the ID only.
                        [
                            'attribute' => 'brand_id',
                            'value' => implode(",",ArrayHelper::map(Brand::find()->where(['id' => $model->brand_id])->all(),'id','displayBrandDesc')),
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

<section>
    <!-- A button for go to the page's top -->
    <div class="col-lg-10 col-lg-offset-1 text-center up-btn-area">
        <div class="tooltip-conf">
            <span class="tooltip-text"><?=Yii::t('app', 'Ir al inicio');?></span>
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
                        <p class="text-muted">Copyright &copy; 2017-<?= date("Y"); ?><br/>T S R&nbsp;&nbsp;&nbsp;&nbsp;D e v e l o p m e n t&nbsp;&nbsp;&nbsp;&nbsp;S o f t w a r e</p>
                        <hr class="small">
                        <p class="text-muted">Supported by</p>
                        <p>
                            <a href="https://www.yiiframework.com/"><img src="<?=$baseUrl?>/img/yii_logo_light.svg" height="30"/></a>
                            <span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
                            <a href="https://www.jetbrains.com/"><img src="<?=$baseUrl?>/img/jetbrains.svg" height="40"/></a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Blue ribbon footer decoration -->
    <section class="ctt-section bg-primary">
        <div class="col-lg-12">
            <div class="row"></div>
        </div>
    </section>
</footer>