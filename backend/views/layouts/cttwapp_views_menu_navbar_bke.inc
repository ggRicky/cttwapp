<!-- Navigation -->
<!-- Open menu button -->
<a id="menu-toggle" href="#" class="btn btn-dark btn-lg btn-toggle" data-toggle="tooltip" data-placement="bottom" title="<?= Yii::t('app','Abrir Panel de Navegación'); ?>"><i class="fa fa-bars"></i></a>

<nav id="sidebar-wrapper">
    <ul class="sidebar-nav">
        <!-- Close menu button -->
        <div class="sidebar-top">
            <a id="menu-close" href="#" class="btn btn-light btn-lg pull-right btn-toggle" data-toggle="tooltip" data-placement="bottom" title="<?= Yii::t('app','Cerrar Panel de Navegación'); ?>"><i class="fa fa-times"></i></a>
        </div>

        <!-- CTT mini-logo ribbon -->
        <div class="container-fluid ctt-mini-logo-top">
            <img src="<?=$baseUrl?>/img/ctt-mini-logo_1.jpg" class="pull-left img-responsive" height="42" width="105"/>
        </div>

        <!-- Includes the menu options file -->
        <?php include(Yii::getAlias('@app').'/views/layouts/cttwapp_views_menu_options_bke.inc'); ?>
    </ul>
</nav>

<!-- Ends the include file -->
