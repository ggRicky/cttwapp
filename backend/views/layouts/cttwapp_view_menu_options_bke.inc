<!-- CTT default actions ribbon -->
<?php
    use yii\helpers\Url;
    use yii\helpers\Html;

    // 2018-04-08 : This code was refactored, using only Html helper
    // 2018-05-24 : Remove guest entry for Rbac security.
    echo Html::begintag('div', ['class' => 'ctt-mini-bar-top']);
    echo Html::beginForm(['/site/logout'], 'post');
    echo Html::submitButton(Yii::t('app','<span><i class="fa fa-power-off fa-lg"></i></span>'), ['class' => 'btn btn-dark', 'data-toggle' => 'tooltip', 'title' => Yii::t('app','Cerrar Sesión')]) . "&nbsp;&nbsp;&nbsp;";
    echo Html::tag('label', Yii::$app->user->identity->username, ['style' => ['color' => 'white', 'font-size' => 'medium', 'font-weight' => 'normal']]);
    echo Html::endForm();
    echo Html::endtag('div');

?>

<!-- Content menu -->

<!-- 2018-05-24 : Special Option - Only the admin user can create an new user. -->
<?php if (\Yii::$app->user->can('adminSite') && (Yii::$app->requestedRoute == 'site/index' || empty(Yii::$app->requestedRoute))): ?>

    <li>
        <div class="ctt-mini-bar-spc-opts">
            <?= "<a href='".Url::to(['auth-item/index'])."'>".Yii::t('app','Objetos de Autorización')."</a>" ?>
        </div>
    </li>

<?php endif; ?>