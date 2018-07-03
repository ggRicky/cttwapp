<?php
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $user common\models\User */

$resetLink = Yii::$app->urlManager->createAbsoluteUrl(['site/reset-password', 'token' => $user->password_reset_token]);

?>
<div class="password-reset">

    <p><?= Yii::t('app','Hola').' : ' ?> <?= Html::encode($user->username) ?>,</p>
    <p><?= Yii::t('app','Por favor use el siguiente enlace para restablecer su contraseña').' : ' ?></p>
    <p><?= Html::a(Html::encode($resetLink), $resetLink) ?></p>

    <p><img src="https://ctt-app.com/ctt-logo.png" class="ctt-logo"></p>
    <h3>CTTWapp V1.0</h3>
    <h4>Servicio de Soporte al Cliente</h4>
    <h5><em>TSR Development Software</em></h5><br/><br/>

</div>
