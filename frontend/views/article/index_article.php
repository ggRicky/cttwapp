<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* 2018-05-06 : Used to display the catalog name for the actual article record */
use yii\helpers\ArrayHelper;
use app\models\Catalog;
use app\models\Brand;

/* @var $this yii\web\View */

$this->title = 'Artículos';
$asset = \frontend\assets\AppAsset::register($this);
$baseUrl = $asset->baseUrl;

// 2018-05-06 : If there are a query or sort criteria is in progress, then skip the header and go just to the work-area-index using javascript code.
$search_param = \yii\helpers\ArrayHelper::keyExists('ArticleSearch',$qryParams);
$sort_param   = \yii\helpers\ArrayHelper::keyExists('sort',$qryParams);
$skip_param   = (\yii\helpers\ArrayHelper::getValue($qryParams, '1.#')=='work-area-index'?true:false);

// 2018-05-06 : If an url color param was send, then skip the header and go just to the work-area-index using javascript code.
$color_param  = Yii::$app->getRequest()->getQueryParam('c', null);

If ($search_param || $sort_param || $skip_param || $color_param)
{
$script = <<< JS
    location.hash = "#work-area-index";
JS;
$this->registerJs($script);
}

//2018-04-26 : Used to get a random int, and display a random parallax.
$randomBg = rand(1,13);

?>

<!-- Header -->
<header id="top">
    <div class="row"> <!-- Bootstrap's row -->
        <div class="col-lg-12"> <!-- Bootstrap's col -->
            <!-- CTT logo to display over the parallax efect with opacity level -->
            <img src="<?=$baseUrl?>/img/ctt-logo_1.png" class="ctt-logo">
            <!-- Parallax Efect -->
            <div id="parallax<?=$randomBg?>" class="parallax-section" data-stellar-background-ratio="0.5">
                <div class="row"></div>
            </div>
        </div>
    </div>
</header>

<!-- Blue ribbon decoration -->
<section id="work-area-index" class="ctt-section bg-primary">
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
            <?= Html::a(Yii::t('app','R e g r e s a r'), ['site/index'], ['class' => 'btn btn-dark']) ?>
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
            <p><?= Yii::t('app','Listado Nominal');?></p>
        </div>
    </div>

    <!-- Yii2 work area -->
    <div class="row">
        <div class="col-lg-12 text-justify yii2-content">

            <p>
                <?= Html::a(Yii::t('app', 'Crear Artículo'), ['create'], ['class' => 'btn btn-success']) ?>
                <?= Html::a(Yii::t('app', 'Catálogos'), ['catalog/index', ['#' => 'work-area-index']], ['class' => 'btn btn-primary']) ?>
                <?= Html::a(Yii::t('app', 'Marcas'), ['brand/index', ['#' => 'work-area-index']], ['class' => 'btn btn-warning']) ?>
            </p>

            <!-- 2018-04-13 : The next div, including the id and class elements, enable the vertical and horizontal scrollbars. -->
            <div id="div-scroll" class="div-scroll-area">

                <?= GridView::widget([
                    'dataProvider' => $dataProvider,
                    'filterModel' => $searchModel,
                    'rowOptions' => function($model){
                        // 2018-04-23 : The next conditional statement enable colored rows based on specific database value
                        // 2018-05-14 : Improvement. The color on/off status is stored in a cookie.
                        if (Yii::$app->getRequest()->getCookies()->has('article-color') &&
                            Yii::$app->getRequest()->getCookies()->getValue('article-color') == '1'){
                           // 2018-05-06 : Change the row background color based on the type_art value.
                           if ($model->type_art == 'V')  // 'V'- Venta  'R' - Renta
                           {
                               return ['class' => 'yellow-light'];
                           };
                           return [];
                        }
                        return [];
                    },

                    'columns' => [
                        [ 'class' => 'yii\grid\ActionColumn',
                            'headerOptions' => ['style' => 'width:4%'],
                        ],

                        [ 'class' => 'yii\grid\SerialColumn',
                          'headerOptions' => ['style' => 'width:3%'],
                        ],

                        [
                          'attribute' => 'id',
                          'headerOptions' => ['style' => 'width:3%'],
                        ],

                        // 2018-05-06 : Modified to display the ID and the Catalog Description instead of the ID only.
                        [
                            'attribute' => 'catalog_id',
                            'headerOptions' => ['style' => 'width:12%'],
                            'value' => function($model){
                                return implode(",",ArrayHelper::map(Catalog::find()->where(['id' =>  $model->catalog_id])->all(),'id','displayNameCat'));
                            }
                        ],

                        // 2018-05-06 : The name_art field in red text color.

                        [
                            'attribute' => 'name_art',
                            'contentOptions' => ['style' => 'color:red'],
                        ],

                        'sp_desc',
                        'en_desc',

                        // 2018-05-06 : For type_art field, the right legend is displayed and colored properly.

                        [
                            'attribute' => 'type_art',
                            'value' => function($model){
                                return ($model->type_art=='R'?'RENTA':'VENTA');
                            },
                            'contentOptions' => function ($model, $key, $index, $column) {
                                return ['style' => 'color:'. ($model->type_art=='V'?'#337AB7':'#428bca')];
                            },
                        ],

                        'price_art',

                        // 2018-04-23 : For provenance type, the right legend is displayed.

                        [
                            'attribute' => 'currency_art',
                            'value' => function($model){
                                return ($model->currency_art=='P'?'PESOS':'DÓLARES');
                            },
                        ],

                        'part_num',

                        // 2018-05-06 : Modified to display the ID and the Catalog Description instead of the ID only.
                        [
                            'attribute' => 'brand_id',
                            'value' =>
                                function($model){
                                    return (implode(",",ArrayHelper::map(Brand::find()->where(['id' => $model->brand_id])->all(),'id','displayBrandDesc')));
                            },
                        ],

                        'created_at',
                        'updated_at',
                        'created_by',
                        'updated_by',

                    ],
                ]);?>

            </div>

            <p>
                <br/>
                <!-- 2018-05-14 : Improvement. The next two <a> tags call the color action from articleController and pass the color parameter to it. -->
                <?= Html::a(Yii::t('app', 'Codificar con colores'), ['article/color', 'color' => '1'], ['class' => 'btn btn-ctt-warning']) ?>
                <?= Html::a('', ['article/color', 'color' => '0'], ['class' => 'btn glyphicon glyphicon-remove-circle']) ?>
            </p>

            <div class="well well-sm text-info"><?= Yii::t('app', 'IMPORTANTE : La información que se muestra en la relación, corresponde a datos experimentales de prueba.');?></div>

        </div>
    </div>

</section>

<section>
    <!-- A button for go to the page's top -->
    <div class="col-lg-10 col-lg-offset-1 text-center up-btn-area">
        <div class="tooltip-conf">
            <span class="tooltip-text"><?=Yii::t('app', 'Ir al inicio');?></span>
            <a href="#work-area-index">
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
                        <p class="text-muted"><?= Yii::t('app','Todos los derechos reservados &copy;') ?> 2017-<?= date("Y"); ?><br/>T S R&nbsp;&nbsp;&nbsp;&nbsp;D e v e l o p m e n t&nbsp;&nbsp;&nbsp;&nbsp;S o f t w a r e</p>
                        <hr class="small">
                        <p class="text-muted"><?= Yii::t('app','Soportado por') ?></p>
                        <hr class="small">
                        <p>
                            <a href="https://www.yiiframework.com/"><img src="<?=$baseUrl?>/img/yii_logo_light.svg" height="30"/></a>
                            <span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
                            <a href="https://www.jetbrains.com/"><img src="<?=$baseUrl?>/img/jetbrains.svg" height="45"/></a>
                            <span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
                            <a href="https://www.jetbrains.com/phpstorm/"><img src="<?=$baseUrl?>/img/phpstorm_logo.svg" height="45"/></a>
                            <span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
                            <a href="https://www.github.com/"><img src="<?=$baseUrl?>/img/github_logo.svg" height="40"/></a>
                            <span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
                            <a href="https://git-scm.com//"><img src="<?=$baseUrl?>/img/git_logo.svg" height="40"/></a>
                            <span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
                            <a href="https://nginx.com//"><img src="<?=$baseUrl?>/img/nginx_logo.svg" height="17"/></a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Blue ribbon footer decoration -->
    <section class="ctt-section-footer ctt-footer-container">
        <div class="col-lg-12">
            <div class="row "></div>
        </div>
    </section>
</footer>