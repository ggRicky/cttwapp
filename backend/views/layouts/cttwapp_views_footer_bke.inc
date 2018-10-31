<!-- End anchor -->
<section id="work-area-index-end"></section>

<!-- Footer -->
<footer>
    <div class="container">
        <div class="row">
            <div class="col-lg-10 col-lg-offset-1 text-center">

                <!-- CTT mini logo -->
                <ul class="list-inline">
                    <li>
                        <img src="<?=$baseUrl?>/img/ctt-mini-logo_1.jpg" class="center-block img-responsive" height="42" width="105" style="border-radius:4px;"/>
                    </li>
                </ul>

                <br />

                <!-- Social links -->
                <ul class="list-inline">
                    <li><a href="http://www.facebook.com/CTTEXPRENTALS"><i class="fa fa-facebook fa-fw fa-3x"></i></a></li>
                    <li><a href="https://twitter.com/cttexp"><i class="fa fa-twitter fa-fw fa-3x"></i></a></li>
                    <li><a href="http://www.linkedin.com/company/ctt-exp-&-rentals"><i class="fa fa-linkedin fa-fw fa-3x"></i></a></li>
                </ul>

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

    <!-- Orange ribbon footer decoration -->
    <section class="ctt-section-footer ctt-footer-container-bke">
        <div class="col-lg-12"></div>
    </section>

</footer>

<!-- A button for go to the page's top -->
<a id="arrow-up-fixed-button" href="#work-area-index" class="btn btn-lg" data-toggle="tooltip" title="<?= Yii::t('app', 'Ir al inicio') ?>"><i class="fa fa-3x fa-arrow-circle-up"  style="font-size:42px"></i></a>
<!-- A button for go to the page's bottom -->
<a id="arrow-down-fixed-button" href="#work-area-index-end" class="btn btn-lg" data-toggle="tooltip" title="<?= Yii::t('app', 'Ir al fin') ?>"><i class="fa fa-3x fa-arrow-circle-down"  style="font-size:42px"></i></a>

<?php
    // Used to disable temporary the debugger toolbar
    if (class_exists('yii\debug\Module')) {
        $this->off(\yii\web\View::EVENT_END_BODY, [\yii\debug\Module::getInstance(), 'renderToolbar']);
    }
?>

<!-- Ends the include file -->
