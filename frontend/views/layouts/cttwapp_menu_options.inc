<!-- CTT default actions ribbon -->
<?php
    use yii\helpers\Url;
    use yii\helpers\Html;

    // 2018-04-08 : This code was refactored, using only Html helper
    // 2018-05-24 : Remove guest entry for Rbac security.
    echo Html::begintag('div', ['class' => 'ctt-mini-bar-top']);
    echo Html::beginForm(['/site/logout'], 'post');
    echo Html::submitButton(Yii::t('app','<span><i class="fa fa-power-off fa-lg"></i></span>'), ['class' => 'btn btn-dark', 'title' => Yii::t('app','Cerrar Sesión')]) . "&nbsp;&nbsp;&nbsp;";
    echo Html::tag('label', Yii::$app->user->identity->username, ['style' => ['color' => 'white', 'font-size' => 'medium', 'font-weight' => 'normal']]);
    echo Html::endForm();
    echo Html::endtag('div');

?>

<!-- Content menu -->

<!-- 2018-06-19 : This options are only available in the main index. -->
<?php if (Yii::$app->requestedRoute == 'site/index' || empty(Yii::$app->requestedRoute)): ?>

    <li><div class="ctt-mini-bar-opts"><?= "<a href='".Url::to(['site/about'])."'>".Yii::t('app','Acerca')."</a>" ?></div></li>
    <li><div class="ctt-mini-bar-opts"><?= "<a href='".Url::to(['site/help'])."'>".Yii::t('app','Ayuda')."</a>" ?></div></li>
    <li><div class="ctt-mini-bar-opts"><?= "<a href='".Url::to(['site/contact'])."'>".Yii::t('app','Contacto')."</a>" ?></div></li>

<?php endif; ?>

<!-- 2018-05-24 : Special Option - Only the admin user can create an new user and this option is only available in the main index. -->
<?php if (\Yii::$app->user->can('adminProcess') && (Yii::$app->requestedRoute == 'site/index' || empty(Yii::$app->requestedRoute))): ?>

    <li><div class="ctt-mini-bar-spc-opts"><?= "<a href='".Url::to(['site/signup'])."'>".Yii::t('app','Registro')."</a>" ?></div></li>

<?php endif; ?>

<!--2018-06-19 : Access to the Client module and only available if isn't in the same view. -->
<?php if (\Yii::$app->user->can('listClient') && Yii::$app->requestedRoute != 'client/index'): ?>

    <li><?= "<a href='".Url::to(['client/index'])."'>".Yii::t('app','Clientes')."</a>" ?></li>

<?php endif; ?>

<!--2018-06-19 : Access to the Catalog module and only available if isn't in the same view. -->
<?php if (\Yii::$app->user->can('listCatalog') && Yii::$app->requestedRoute != 'catalog/index' && Yii::$app->requestedRoute != 'article/index'): ?>

    <li><?= "<a href='".Url::to(['catalog/index'])."'>".Yii::t('app','Catálogos')."</a>" ?></li>

<?php endif; ?>

<!--2018-06-19 : Access to the Article module and only available if isn't in the same view. -->
<?php if (\Yii::$app->user->can('listArticle') && Yii::$app->requestedRoute != 'article/index'): ?>

    <li><?= "<a href='".Url::to(['article/index'])."'>".Yii::t('app','Artículos')."</a>" ?></li>

<?php endif; ?>

<!--2018-06-19 : Access to the Inventory module and only available if isn't in the same view. -->
<?php if (\Yii::$app->user->can('listInventory') && Yii::$app->requestedRoute != 'inventory/index'): ?>

    <li><a href="#" data-toggle="modal" data-target="#ctt-modal-in-construction"><?= Yii::t('app','Inventarios'); ?></a></li>

<?php endif; ?>

<!--2018-06-19 : Access to the Projects module and only available if isn't in the same view. -->
<?php if (\Yii::$app->user->can('listProject') && Yii::$app->requestedRoute != 'project/index'): ?>

    <li><a href="#" data-toggle="modal" data-target="#ctt-modal-in-construction"><?= Yii::t('app','Proyectos'); ?></a></li>

<?php endif; ?>

<!--2018-06-19 : Access to the Reservations module and only available if isn't in the same view. -->
<?php if (\Yii::$app->user->can('listReservation') && Yii::$app->requestedRoute != 'reservation/index'): ?>

    <li><a href="#" data-toggle="modal" data-target="#ctt-modal-in-construction"><?= Yii::t('app','Reservaciones'); ?></a></li>

<?php endif; ?>

<!--2018-06-19 : Access to the Market Rates module and only available if isn't in the same view. -->
<?php if (\Yii::$app->user->can('listMarketRate') && Yii::$app->requestedRoute != 'market-rate/index'): ?>

    <li><a href="#" data-toggle="modal" data-target="#ctt-modal-in-construction"><?= Yii::t('app','Cotizaciones'); ?></a></li>

<?php endif; ?>