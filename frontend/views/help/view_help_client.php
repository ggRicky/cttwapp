<?php
use yii\helpers\Html;
use yii\helpers\Url;

/* @var $this yii\web\View */

$this->title = 'Ayuda';

$asset = \frontend\assets\AppAsset::register($this);
$baseUrl = $asset->baseUrl;

// 2018-06-05 : If there is a return link parameter, then skips to it using javascript code.
$url_param = Yii::$app->getRequest()->getQueryParam('url');
$anchor_param = Yii::$app->getRequest()->getQueryParam('ret');

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
            <?= Html::a(Yii::t('app','R e g r e s a r'), Url::to([$url_param]).'&ret='.$anchor_param, ['class' => 'btn btn-dark', 'title' => Yii::t('app', 'Regresar al nivel anterior')]) ?>
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
            <p><?= Yii::t('app','Módulo Administrador de Clientes');?></p>
        </div>
    </div>

    <!-- Yii2 work area -->
    <div class="row">
        <div class="col-lg-12 text-justify yii2-content">
            <h4><?= Yii::t('app','Funciones');?></h4>
            <br/>
            <div>
                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Curabitur a ultricies nisi, non aliquam lacus. Fusce tristique tempor pharetra. Duis efficitur sit amet nisi nec bibendum. Sed pharetra malesuada leo. Donec lobortis, augue in condimentum scelerisque, nulla neque varius leo, in viverra velit sapien sodales enim. Aliquam pretium turpis ut felis tincidunt, id molestie felis luctus. Sed nunc quam, tincidunt sed porttitor ultrices, dictum et ex. Aenean quis dictum magna. Nulla aliquet vitae mauris at vulputate. Quisque risus diam, iaculis eget varius in, pulvinar sit amet lorem. Pellentesque faucibus nisi lectus, a ullamcorper elit commodo at.</p>
                <p>Morbi commodo ante vel justo dignissim dapibus. Fusce vehicula tristique ipsum tempus rutrum. Nunc eget augue felis. Quisque eu egestas ex, sit amet sagittis leo. Sed sapien ipsum, porta a arcu in, pulvinar lacinia lorem. Integer pharetra pretium risus, sit amet ultricies elit molestie consectetur. Duis sagittis fermentum mauris quis tempus. Nam bibendum pulvinar feugiat. Etiam maximus tempus ligula, vitae tempor odio consequat at. Fusce quis lectus lobortis, blandit ipsum et, faucibus tortor. Suspendisse potenti. Donec a lectus consectetur, elementum ante eget, viverra sapien. Nulla maximus consequat elit in lobortis. Nunc aliquet dignissim nulla, ac porttitor ipsum ullamcorper et. Phasellus a mauris eu lectus venenatis mattis vitae id lorem. Curabitur ultrices risus vitae lacus vulputate, in finibus felis placerat.</p>
                <p>Maecenas quis egestas felis, in molestie arcu. Praesent et fringilla nibh. Nunc elementum sagittis nisl, id posuere quam efficitur ut. Morbi gravida a ante vel volutpat. Nunc congue iaculis est nec elementum. Donec vitae dolor tincidunt, fermentum leo id, sagittis augue. Vivamus sollicitudin congue felis a sodales.</p>
                <p>In placerat ultrices purus nec euismod. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aliquam gravida ligula tempus ipsum consectetur bibendum. In placerat turpis sapien, vitae porttitor nisl vestibulum et. Suspendisse in metus sollicitudin, euismod dolor ornare, facilisis nulla. Pellentesque mi eros, aliquam non dui eget, sollicitudin fermentum risus. Praesent convallis quam nec urna dictum, sed suscipit ante semper. Nunc ligula metus, elementum a lobortis in, luctus sit amet erat.</p>
                <p>Nulla molestie, ante ac suscipit posuere, est metus dignissim enim, at maximus ipsum ante eu elit. Vestibulum quis felis in justo commodo tempus id ac quam. Nunc vel ultricies nunc. Duis ligula sapien, pellentesque in dolor a, maximus mollis libero. Etiam fermentum, neque vitae sodales iaculis, nisl arcu finibus diam, quis cursus eros metus vitae turpis. In blandit id lectus non hendrerit. Fusce cursus, velit vitae tempor elementum, turpis urna pellentesque ante, et euismod lectus ante sit amet magna. Praesent dictum odio at cursus tristique.</p>
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