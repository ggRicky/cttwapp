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
                    <p><?= Yii::t('app','Esta funcionalidad se encuentra en construcción y aún no está implementada en su totalidad').'.' ?></p>
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
                    <p><?= Yii::$app->session->getFlash('successLogin'); ?></p>
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
