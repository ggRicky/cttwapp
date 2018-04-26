<?php

use yii\helpers\Html;

/* @var $this yii\web\View */

$this->title = 'Ayuda';
$asset = \frontend\assets\AppAsset::register($this);
$baseUrl = $asset->baseUrl;

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
            <p>Tópicos Generales</p>
        </div>
    </div>

    <!-- Yii2 work area -->
    <div class="row">
        <div class="col-lg-12 text-justify yii2-content">
            <h4>C o n t e n t e n i d o</h4>
            <br/>
            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus ultricies id lorem in bibendum. Phasellus leo diam, posuere non dolor sed, cursus ultricies mi. Praesent malesuada a urna vitae suscipit. Vestibulum ullamcorper leo dolor, quis faucibus arcu euismod et. Curabitur sed diam interdum, cursus dui a, elementum dui. Curabitur eget eros arcu. Duis lobortis, neque ac maximus ornare, erat lectus consectetur neque, nec egestas lectus dui vel eros. In orci lorem, ultricies faucibus lectus in, volutpat mattis libero. Ut sit amet ante at augue lobortis elementum. Cras turpis lacus, pellentesque vitae lacinia nec, tempus vel nisl. Nullam ornare luctus odio, dapibus convallis eros vestibulum in. Quisque id libero eleifend nibh suscipit convallis. Nam eu aliquam mauris, ut semper est. </p>
            <p>Sed et eros luctus, convallis sem vitae, pharetra mi. Praesent gravida vehicula dolor non semper. Quisque et sagittis mauris. Quisque id nibh nec odio venenatis aliquam id vel neque. Etiam lacinia maximus nisi eu suscipit. Vestibulum eu suscipit arcu, et mollis enim. Vestibulum a odio ac ante hendrerit pharetra. Suspendisse sollicitudin at risus nec feugiat. Phasellus in lacus quis nulla feugiat scelerisque. Aliquam aliquet lacinia semper. Suspendisse at dui consectetur, elementum est cursus, tristique mauris. Aenean libero massa, pellentesque et mattis ac, pulvinar id magna. Donec ut dapibus velit, quis placerat tellus. Fusce velit felis, feugiat eget vestibulum nec, ornare sed purus. Nulla facilisi. </p>
            <p>Quisque iaculis sapien eget massa fringilla, bibendum tristique justo tristique. Quisque congue sit amet nunc sed condimentum. Integer et enim eros. Duis sed quam in ipsum vestibulum gravida. Nulla ornare odio non egestas malesuada. Nunc quis urna id augue scelerisque vehicula. Etiam imperdiet porta finibus. Curabitur mollis blandit dui eu ullamcorper. Ut sed est ullamcorper, maximus erat sed, efficitur erat. Donec dolor augue, euismod vitae tristique sit amet, maximus sed mi. Pellentesque porttitor non lorem id malesuada. </p>
            <p>Cras quis urna posuere, faucibus leo at, rhoncus mi. Duis a rhoncus nulla. Integer semper turpis dictum massa pulvinar placerat. In sit amet dictum elit. Proin lobortis diam id elit gravida egestas. Curabitur dapibus auctor lacus et gravida. Aliquam eleifend congue libero, at vulputate leo finibus non. Ut luctus lacus quis est luctus ultrices. </p>
            <p>Pellentesque nec mauris nisl. Morbi auctor orci dignissim orci hendrerit pretium. Quisque mattis posuere orci, ut aliquam ante rhoncus id. Cras tincidunt vulputate nisl id eleifend. Fusce turpis tortor, pharetra ac turpis accumsan, sodales tempus mi. Curabitur vestibulum, neque et tristique finibus, felis lorem elementum risus, non rhoncus ipsum mi eget mauris. Suspendisse vel blandit lacus, a pellentesque turpis. Curabitur dapibus, nisi at eleifend feugiat, ipsum dui vehicula nisl, at vulputate velit massa quis orci. Phasellus eget finibus arcu. Etiam lorem sapien, dignissim ut ultrices id, pretium nec lorem. Quisque pretium laoreet rutrum. Ut et venenatis enim, non laoreet lacus. In eu consequat nibh. Aliquam sit amet efficitur augue. </p>
        </div>
    </div>

</section>

<section>
    <!-- A button for go to the page's top -->
    <div class="col-lg-10 col-lg-offset-1 text-center up-btn-area">
        <a class="tooltip-conf" href="#work-area-index" data-toggle="tooltip" data-placement="right" title="Ir al inicio">
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
