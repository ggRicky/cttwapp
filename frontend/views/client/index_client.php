<?php

use yii\helpers\Html;
use yii\grid\GridView;
use kartik\dialog\Dialog;

/* 2018-03-17 : Used to display Description Type for the actual client record */
use yii\helpers\ArrayHelper;
use app\models\ClientType;


/* @var $this yii\web\View */

$this->title = 'Clientes';
$asset = \frontend\assets\AppAsset::register($this);
$baseUrl = $asset->baseUrl;

// 2018-04-11 : If there are a query or a sort criteria in process, then skip the header and go to the work-area-index using javascript code.
If (array_key_exists('ClientSearch',$qryParams) || array_key_exists('sort',$qryParams))
{
$script = <<< JS
    location.hash = "#work-area-index";
JS;
$this->registerJs($script);
}

?>

<!-- Header -->
<header id="top">
    <div class="row"> <!-- Bootstrap's row -->
        <div class="col-lg-12"> <!-- Bootstrap's col -->
            <!-- CTT logo to display over the parallax efect with opacity level -->
            <img src="<?=$baseUrl?>/img/ctt-logo_1.png" class="ctt-logo">
            <!-- Parallax Efect -->
            <div id="parallax1" class="parallax-section" data-stellar-background-ratio="0.5">
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
            <?= Html::a('R e g r e s a r', ['site/index'], ['class' => 'btn btn-dark']) ?>
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
            <p>Listado Nominal</p>
        </div>
    </div>

    <!-- Yii2 work area -->
    <div class="row">
        <div class="col-lg-12 text-justify yii2-content">
            <p>
                <?= Html::a('Crear Cliente', ['create'], ['class' => 'btn btn-success']) ?>
                <?= Html::a('Tipos de Clientes', ['client-type/index', '#' => 'work-area-index-cte'], ['class' => 'btn btn-primary']) ?>
            </p>

            <!-- 2018-04-13 : The next div, including the id and class elements, enable the vertical and horizontal scrollbars. -->
            <div id="div-scroll" class="div-scroll-area">

                <?= GridView::widget([
                    'dataProvider' => $dataProvider,
                    'filterModel' => $searchModel,
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

                        'rfc',
                        'curp',
                        [
                          'attribute' => 'taxpayer',
                          'value' => function($model){
                                return ($model->taxpayer=='M'?'Moral':'Física');
                           },
                          'contentOptions' => function ($model, $key, $index, $column) {
                                return ['style' => 'color:'. ($model->taxpayer=='M'?'grey':'#428bca')];
                           },
                        ],

                        // 2018-04-10 : New fields add to client table in refactoring action.

                        [
                          'attribute' => 'business_name',
                          'contentOptions' => ['style' => 'color:red'],
                        ],

                        'corporate',
                        'provenance',
                        'contact_name',
                        'contact_email',
                        'tax_residence',
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
                          'headerOptions' => ['style' => 'width:12%'],
                          'value' => function($model){
                                        return implode(",",ArrayHelper::map(ClientType::find()->where(['id' =>  $model->client_type_id])->all(),'id','displayTypeDesc'));
                                     }
                        ],
                    ],
                ]);?>

            </div>
        </div>
    </div>
</section>

<section>
    <!-- A button for go to the page's top -->
    <div class="col-lg-10 col-lg-offset-1 text-center up-btn-area">
        <a class="tooltip-conf" href="#work-area-index" data-toggle="tooltip" title="Ir al inicio">
           <span class="glyphicon glyphicon-circle-arrow-up"></span>
        </a>
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