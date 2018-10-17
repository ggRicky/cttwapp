<!-- Index Frontend Footer -->
<footer>
    <div class="container">
        <div class="row">
            <div class="col-lg-10 col-lg-offset-1 text-center">

                <!-- CTT logo -->
                <ul class="list-inline">
                    <li>
                        <img src="<?=$baseUrl?>/img/ctt-logo_2.png" height="128" width="90"/>
                    </li>
                </ul>

                <!-- Contact -->
                <hr class="small">
                <p>Guadalupe I. Ramírez No. 763<br />Col. Tepepan, Delegación Xochimilco, C.P. 16029</p><p>Ciudad de México, CDMX</p>

                <ul class="list-unstyled">
                    <li><i class="fa fa-phone fa-fw"></i> 01 55 5676 1113</li>
                    <li><i class="fa fa-envelope-o fa-fw"></i>  <a href="mailto:name@example.com">contacto@cttrentals.com</a></li>
                </ul>

                <br />

                <!-- Social links -->
                <ul class="list-inline">
                    <li><a href="http://www.facebook.com/CTTEXPRENTALS"><i class="fa fa-facebook fa-fw fa-3x"></i></a></li>
                    <li><a href="https://twitter.com/cttexp"><i class="fa fa-twitter fa-fw fa-3x"></i></a></li>
                    <li><a href="http://www.linkedin.com/company/ctt-exp-&-rentals"><i class="fa fa-linkedin fa-fw fa-3x"></i></a></li>
                </ul>

                <!-- 2018-05-20 : Comodo Secure Seal -->
                <div class="row">
                     <span>
                        <script language="JavaScript" type="text/javascript">
                            TrustLogo("<?=$baseUrl."/img/comodo_secure_seal_100x85_transp.png"?>", "CL1", "none");
                        </script>
                        <a href="https://www.positivessl.com/" id="comodoTL" >Positive SSL</a>
                     </span>
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
                            <span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
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
                            <span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
                            <a href="https://www.debian.org///"><img src="<?=$baseUrl?>/img/debian_logo.svg" height="45"/></a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Blue ribbon footer decoration -->
    <section class="ctt-section-footer ctt-footer-container">
        <div class="col-lg-12"></div>
    </section>

</footer>

<?php
    // Used to disable temporary the debugger toolbar
    if (class_exists('yii\debug\Module')) {
        $this->off(\yii\web\View::EVENT_END_BODY, [\yii\debug\Module::getInstance(), 'renderToolbar']);
    }
?>

<!-- Ends the include file -->
