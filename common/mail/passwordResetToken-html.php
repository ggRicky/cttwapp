<?php
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $user common\models\User */

$resetLink = Yii::$app->urlManager->createAbsoluteUrl(['site/reset-password', 'token' => $user->password_reset_token]);

$asset = \frontend\assets\AppAsset::register($this);
$baseUrl = $asset->baseUrl;
?>
<div class="password-reset">

    <p><img src="<?=$baseUrl?>/img/ctt-logo_1.png" class="ctt-logo"></p>

    <p><?= Yii::t('app','Hola').' : ' ?> <?= Html::encode($user->username) ?>,</p>

    <p><?= Yii::t('app','Por favor use el siguiente enlace para restablecer su contraseña').' : ' ?></p>

    <p><?= Html::a(Html::encode($resetLink), $resetLink) ?></p>
</div>
