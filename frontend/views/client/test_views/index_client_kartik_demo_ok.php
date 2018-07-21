<?php

use yii\helpers\Html;
use yii\grid\GridView;
use kartik\dialog\Dialog;

/* @var $this yii\web\View */

$this->title = 'Clientes';
$asset = \frontend\assets\AppAsset::register($this);
$baseUrl = $asset->baseUrl;

//2018-04-26 : Used to get a random int, and display a random parallax.
$randomBg = rand(1,11);;

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
<section class="ctt-section bg-primary">
    <div class="col-lg-12">
        <div id="work-area-index" class="row">
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
            <?= Html::a(Yii::t('app','R e g r e s a r'), ['site/index'], ['class' => 'btn btn-dark btn-ctt-fixed-width', 'title' => Yii::t('app', 'Regresar al nivel anterior')]) ?>
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
            <p>Listado Nominal</p>
        </div>
    </div>

    <!-- Yii2 work area -->
    <div class="row">
        <div class="col-lg-12 text-justify yii2-content">
            <div class="client-index">

<p>

<?php

// Widget with default options
echo Dialog::widget();

// Buttons for testing the krajee dialog boxes
$btns = /** @lang text */
    <<< HTML
<button type="button" id="btn-alert" class="btn btn-info">Alert</button>
<button type="button" id="btn-confirm" class="btn btn-warning">Confirm</button>
<button type="button" id="btn-prompt-1" class="btn btn-primary">Prompt-1</button>
<button type="button" id="btn-prompt-2" class="btn btn-primary">Prompt-2</button>
<button type="button" id="btn-dialog" class="btn btn-default">Dialog</button>
<hr>
<label>Test Yii Confirm (Click Link): </label>
<!-- Yii Links Confirmation Dialog Override Example Markup -->
<a href="http://demos.krajee.com" id="btn-yii-link" data-confirm="Are you sure you want to navigate to Krajee Demos Home Page?">Krajee Demos Home</a>
HTML;
echo $btns;

// Javascript for triggering the dialogs
$js = <<< JS
     $("#btn-alert").on("click", function() {
           krajeeDialog.alert("This is a Krajee Dialog Alert!")
    });
    $("#btn-confirm").on("click", function() {
           krajeeDialog.confirm("Are you sure you want to proceed?", function (result) {
              if (result) {
                 alert('Great! You accepted!');
              } else {
                   alert('Oops! You declined!');
              }
           });
    });
    $("#btn-prompt-1").on("click", function() {
           krajeeDialog.prompt({label:'Provide reason', value: 'This is an initial reason.', placeholder:'Upto 30 characters...', maxlength: 30}, function (result) {
              if (result) {
                 if (result === 'This is an initial reason.') {
                    alert('Ok! Accepting the initial reason');
              } else {
                   alert('Great! You provided a reason: \\n\\n' + result);
              }
            } else {
                 alert('Oops! You declined!');
            }
       });
    });
    $("#btn-prompt-2").on("click", function() {
           krajeeDialog.prompt({type: 'password', label:'Authenticate', placeholder:'Enter password to authenticate...'}, function (result) {
           if (result) {
              alert('Great! You provided a password: \\n\\n' + result);
           } else {
              alert('Oops! You declined to provide a password!');
           }
       });
    });
    $("#btn-dialog").on("click", function() {
           krajeeDialog.dialog(
               'This is a <b>custom dialog</b>. The dialog box is <em>draggable</em> by default and <em>closable</em> ' +
               '(try it). Note that the Ok and Cancel buttons will do nothing here until you write the relevant JS code ' +
               'for the buttons within "options". Exit the dialog by clicking the cross icon on the top right.',
           function (result) {alert(result);}  );
    });

JS;
// Register your Javascript
$this->registerJs($js);

?>

</p>

                <p>
                    <?= Html::a('Crear Cliente', ['create'], ['class' => 'btn btn-success']) ?>
                    <?= Html::a('Tipos de Clientes', ['client-type/index', '#' => 'work-area-index-cte'], ['class' => 'btn btn-primary']) ?>
                </p>

                <?= GridView::widget([
                    'dataProvider' => $dataProvider,
                    'filterModel' => $searchModel,
                    'columns' => [
                        ['class' => 'yii\grid\SerialColumn'],

                        'id',
                        'rfc',
                        'curp',
                        'taxpayer',
                        'business_name',
                        'contact_name',
                        'corporate',
                        'created_at',
                        'updated_at',
                        'created_by',
                        'updated_by',
                        'client_type_id',

                        ['class' => 'yii\grid\ActionColumn'],
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
