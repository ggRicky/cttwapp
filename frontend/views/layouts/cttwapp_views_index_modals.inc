<!-- Modal Warning ; Functionality not implemented yet  -->
<div id="ctt-modal-in-construction" class="modal fade" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content modal-backdrop">

            <!-- Modal Header -->
            <div class="modal-shadow-effect modal-header-water-mark">
                <div class="modal-header modal-header-config ctt-modal-header-warning">
                    <div class="row">
                        <!--
                             ctt-modal-header-info        glyphicon-info-sign
                             ctt-modal-header-success     glyphicon-ok-sign
                             ctt-modal-header-question    glyphicon-question-sign
                             ctt-modal-header-warning     glyphicon-warning-sign
                             ctt-modal-header-error       glyphicon-exclamation-sign
                        -->
                        <div class="col-sm-1"><span class="glyphicon glyphicon-warning-sign"></span></div>
                        <div class="col-sm-7"><h4 class="modal-title"><?= Yii::t('app','Advertencia') ?></h4></div>
                        <div class="col-sm-4"><button type="button" class="close" data-dismiss="modal" data-toggle="tooltip" title="<?= Yii::t('app','Cerrar') ?>">&times;</button></div>
                    </div>
                </div>

                <!-- Modal Content -->
                <div class="modal-body modal-body-config">
                    <!-- 2019-04-11 : Refactoring this section by adding a table with an animated icon and the text of the message separated in each cell. -->
                    <table class="table-modal-content"><tbody><tr><th><span><i class="fa fa-spinner fa-pulse fa-2x fa-fw" style="color:#999"></i></th><td><?= Yii::t('app','Esta funcionalidad se encuentra en construcción y aún no está implementada en su totalidad.'); ?></td></tr></tbody></table>
                </div>

                <!-- Modal Footer -->
                <div class="modal-footer modal-footer-config">
                    <div class="row">
                        <div class="col-sm-6"><img align="left" src="<?=$baseUrl?>/img/ctt-mini-logo_1.jpg" height="42" width="105"/></div>
                        <div class="col-sm-6"><button type="button" class="btn btn-default" data-dismiss="modal"><?= Yii::t('app','Cerrar') ?></button></div>
                    </div>
                </div>
            </div>

        </div>

    </div>
</div>

<!-- 2018-02-09 : Modal Success [ User Logged  ]-->
<div id="ctt-modal-usr-logged" class="modal fade" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content modal-backdrop">

            <!-- Modal Header -->
            <div class="modal-shadow-effect modal-header-water-mark">
                <div class="modal-header modal-header-config ctt-modal-header-success">
                    <div class="row">
                        <!--
                             ctt-modal-header-info        glyphicon-info-sign
                             ctt-modal-header-success     glyphicon-ok-sign
                             ctt-modal-header-question    glyphicon-question-sign
                             ctt-modal-header-warning     glyphicon-warning-sign
                             ctt-modal-header-error       glyphicon-exclamation-sign
                        -->
                        <div class="col-sm-1"><span class="glyphicon glyphicon-ok-sign"></span></div>
                        <div class="col-sm-7"><h4 class="modal-title"><?= Yii::t('app','Éxito') ?></h4></div>
                        <div class="col-sm-4"><button type="button" class="close" data-dismiss="modal" data-toggle="tooltip" title="<?= Yii::t('app','Cerrar') ?>">&times;</button></div>
                    </div>
                </div>

                <!-- Modal Content -->
                <div class="modal-body modal-body-config">
                    <!-- 2019-04-11 : Refactoring this section by adding a table with an animated icon and the text of the message separated in each cell. -->
                    <table class="table-modal-content"><tbody><tr><th><span><i class="fa fa-spinner fa-pulse fa-2x fa-fw" style="color:#999"></i></th><td><?= Yii::$app->session->getFlash('successLogin'); ?></td></tr></tbody></table>
                </div>

                <!-- Modal Footer -->
                <div class="modal-footer modal-footer-config">
                    <div class="row">
                        <div class="col-sm-6"><img align="left" src="<?=$baseUrl?>/img/ctt-mini-logo_1.jpg" height="42" width="105"/></div>
                        <div class="col-sm-6"><button type="button" class="btn btn-default" data-dismiss="modal"><?= Yii::t('app','Cerrar') ?></button></div>
                    </div>
                </div>
            </div>

        </div>

    </div>
</div>

<!-- 2019-04-04 : Modal Info [ Configuration Process ]-->
<div id="ctt-modal-config" class="modal fade" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content modal-backdrop">

            <!-- Modal Header -->
            <div class="modal-shadow-effect modal-header-water-mark">
                <div class="modal-header modal-header-config ctt-modal-header-info">
                    <div class="row">
                        <!--
                             ctt-modal-header-info        glyphicon-info-sign
                             ctt-modal-header-success     glyphicon-ok-sign
                             ctt-modal-header-question    glyphicon-question-sign
                             ctt-modal-header-warning     glyphicon-warning-sign
                             ctt-modal-header-error       glyphicon-exclamation-sign
                        -->
                        <div class="col-sm-1"><span class="glyphicon glyphicon-ok-sign"></span></div>
                        <div class="col-sm-7"><h4 class="modal-title"><?= Yii::t('app','Configuración') ?></h4></div>
                        <div class="col-sm-4"><button type="button" class="close" data-dismiss="modal" data-toggle="tooltip" title="<?= Yii::t('app','Cerrar') ?>">&times;</button></div>
                    </div>
                </div>

                <!-- Modal Content -->
                <div class="modal-body modal-body-config">
                    <!-- 2019-04-11 : Refactoring this section by adding a table with an animated icon and the text of the message separated in each cell. -->
                    <table class="table-modal-content"><tbody><tr><th><span><i class="fa fa-spinner fa-pulse fa-2x fa-fw" style="color:#999"></i></th><td><?= Yii::$app->session->getFlash('configProcess'); ?></td></tr></tbody></table>
                </div>

                <!-- Modal Footer -->
                <div class="modal-footer modal-footer-config">
                    <div class="row">
                        <div class="col-sm-6"><img align="left" src="<?=$baseUrl?>/img/ctt-mini-logo_1.jpg" height="42" width="105"/></div>
                        <div class="col-sm-6"><button type="button" class="btn btn-default" data-dismiss="modal"><?= Yii::t('app','Cerrar') ?></button></div>
                    </div>
                </div>
            </div>

        </div>

    </div>
</div>

<!-- Ends the include file -->
