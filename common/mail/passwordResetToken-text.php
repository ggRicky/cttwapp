<?php

/* @var $this yii\web\View */
/* @var $user common\models\User */

$resetLink = Yii::$app->urlManager->createAbsoluteUrl(['site/reset-password', 'token' => $user->password_reset_token]);
?>
<?= Yii::t('app','Hola').' : ' ?> <?= $user->username ?>,

<?= Yii::t('app','Por favor use el siguiente enlace para restablecer su contraseña').' : ' ?>

<?= $resetLink ?>
