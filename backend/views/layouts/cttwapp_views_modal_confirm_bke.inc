<!-- Modal Confirm : Used to confirm or cancel a Yii2 GridView action -->
<div id="ctt-modal-confirm" tabindex="-1" class="modal fade" role="dialog" data-backdrop="true">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content modal-backdrop">

            <!-- Modal Header -->
            <div class="modal-shadow-effect modal-header-water-mark">
                <div class="modal-header modal-header-config ctt-modal-header-error">
                    <div class="row">
                        <!--
                             ctt-modal-header-info        glyphicon-info-sign
                             ctt-modal-header-success     glyphicon-ok-sign
                             ctt-modal-header-question    glyphicon-question-sign
                             ctt-modal-header-warning     glyphicon-warning-sign
                             ctt-modal-header-error       glyphicon-exclamation-sign
                        -->
                        <div class="col-sm-1"><span class="glyphicon glyphicon-question-sign"></span></div>
                        <div class="col-sm-7"><h4 class="modal-title"><?= Yii::t('app','Pregunta') ?></h4></div>
                        <div class="col-sm-4"><button type="button" class="close" data-dismiss="modal" data-toggle="tooltip" title="<?= Yii::t('app','Cerrar') ?>">&times;</button></div>
                    </div>
                </div>

                <!-- Modal Content -->
                <div id="content-body" class="modal-body modal-body-config"></div>

                <!-- Modal Footer -->
                <div class="modal-footer modal-footer-config">
                    <div class="row">
                        <div class="col-sm-6"><img align="left" src="<?=$baseUrl?>/img/ctt-mini-logo_1.jpg" height="42" width="105"/></div>
                        <div class="col-sm-6">
                            <span><button type="button" class="btn btn-default" data-dismiss="modal" data-toggle="tooltip" title="[ Esc ] - <?= Yii::t('app','Descarta la operación') ?>"><?= Yii::t('app','Cancelar') ?></button></span>
                            <span><button type="button" class="btn btn-danger btn-ok" id="button-ok" data-toggle="tooltip" title="<?= Yii::t('app','Procede la operación') ?>"><?= Yii::t('app','Aceptar') ?></button></span>
                        </div>
                    </div>
                </div>

                <!-- Modal Header -->
            </div>

            <!-- Modal content-->
        </div>

    </div>
</div>

<!-- Ends the include file -->
