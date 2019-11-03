<!-- 2019-10-31 : Modal Info : Used to displays the record's remarks -->
<div id="ctt-modal-display-remark" tabindex="-1" class="modal fade" role="dialog" data-backdrop="true">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content modal-backdrop">

            <!-- Modal Header -->
            <div class="modal-shadow-effect modal-header-water-mark">
                <div class="modal-header modal-header-config ctt-modal-header-warning"> <!-- 2019-11-02 : The ctt-modal-header-warning class is used to shows the header in orange color -->
                    <div class="row">
                        <!--
                             ctt-modal-header-info        glyphicon-info-sign
                             ctt-modal-header-success     glyphicon-ok-sign
                             ctt-modal-header-question    glyphicon-question-sign
                             ctt-modal-header-warning     glyphicon-warning-sign
                             ctt-modal-header-error       glyphicon-exclamation-sign
                        -->
                        <div class="col-sm-1"><span class="glyphicon glyphicon-info-sign"></span></div>
                        <div id="content-title" class="col-sm-8"></div>
                        <div class="col-sm-3"><button type="button" class="close" data-dismiss="modal" data-toggle="tooltip" title="<?= Yii::t('app','Cerrar') ?>">&times;</button></div>
                    </div>
                </div>

                <!-- Modal Content -->
                <div id="content-body" class="modal-body modal-body-config"><div class="col-sm-6"></div></div>

                <!-- Modal Footer -->
                <div class="modal-footer modal-footer-config">
                    <div class="row">
                        <div class="col-sm-6"><img align="left" src="<?=$baseUrl?>/img/ctt-mini-logo_1.jpg" height="42" width="105"/></div>
                        <div class="col-sm-6">
                            <button id="close-ok" type="button" class="btn btn-default" data-dismiss="modal" data-toggle="tooltip" title="[ Esc ] - <?= Yii::t('app','Cerrar la vista de observaciones') ?>"><?= Yii::t('app','Cerrar') ?></button>
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
