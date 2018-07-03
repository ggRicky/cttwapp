<?php
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $user common\models\User */

$resetLink = Yii::$app->urlManager->createAbsoluteUrl(['site/reset-password', 'token' => $user->password_reset_token]);

?>
<div class="password-reset">

    <!-- 2018-07-01 : Customizes the mail content in the reset-password message.-->
    <p><?= Yii::t('app','Hola').' : ' ?> <?= Html::encode($user->username) ?>,</p>
    <p><?= Yii::t('app','Por favor use el siguiente enlace para restablecer su contraseña').' : ' ?></p>
    <p><?= Html::a(Html::encode($resetLink), $resetLink) ?></p>

    <!-- 2018-07-02 : Customizes the mail footer in the reset-password message.-->
    <br/>
    <div style="position: relative;"><img src="https://ctt-app.com/ctt-logo.png"></div>
    <h3><b>CTTwapp V1.0</b></h3>
    <h4>Servicio de Soporte al Cliente<br/><em>TSR Development Software</em></h4>

</div>
