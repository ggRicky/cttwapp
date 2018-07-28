<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\AuthItem */
/* @var $form yii\widgets\ActiveForm */

// 2018-07-27 : If there is a page parameter, then stores and validate it.
// Verifies and validate the current page value.
$ret_page = Yii::$app->getRequest()->getQueryParam('page');
$ret_page = (empty($ret_page)?'1':$ret_page);

// Init the model's fields, with the today's date data.

$model->created_at = ($model->isNewRecord ? time() : $model->created_at);
$model->updated_at = time();

// Init the model's fields, with the current data.

$model->rule_name = ($model->isNewRecord ? null : $model->rule_name);

?>

<div class="auth-item-form">

    <!-- 2018-07-27 : If there is an flash message, then display it.-->
    <?php if (Yii::$app->session->hasFlash('warning')): ?>
        <div id="auto-close" class="alert alert-warning alert-dismissible fade in">
            <a href="#" class="close" data-dismiss="alert" data-toggle="tooltip" aria-label="close" title="<?= Yii::t('app','Cerrar') ?>">&times;</a>
            <h4><strong>¡ <?= Yii::t('app','Advertencia'); ?> !</strong></h4>
            <p><?= Yii::$app->session->getFlash('warning') ?></p>
        </div>
    <?php endif; ?>

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'type')->radioList(['1' => 'Rol', '2' => Yii::t('app', 'Permiso') ]) ?>

    <?= $form->field($model, 'description')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'rule_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'data')->textInput() ?>

    <!--2018-05-27 : The two next hidden inputs are used to send via post the created_at and updated_at fields -->

    <?= $form->field($model, 'created_at')->hiddenInput()->label(false); ?>

    <?= $form->field($model, 'updated_at')->hiddenInput()->label(false); ?>

    <!--2018-05-27 : The created_at and updated_at fields are displayed for read-only purpose -->

    <?=  '<b>'.Yii::t('app','Creado en') .'</b> : <br/><br/>' ?>

    <!--2018-05-27 : Covert created_at field to date format and displayed for read-only purpose -->

    <div class="well">
        <?= date('Y-m-d G:i:s', $model->created_at); ?>
    </div>

    <?=  '<b>'.Yii::t('app','Actualizado en').'</b>  : <br/><br/>' ?>

    <!--2018-05-27 : Covert updated_at field to date format and displayed for read-only purpose -->

    <div class="well">
        <?= date('Y-m-d G:i:s', $model->updated_at); ?>
    </div>

    <!-- 2018-07-27 : Sends the current page value through a hidden input.-->

    <?= Html::hiddenInput('page', $ret_page); ?>

    <div>
        <p class="required-field">* <?= Yii::t('app','Campo Requerido') ?></p><br><br>
    </div>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app','Crear') : Yii::t('app','Actualizar'), ['class' => $model->isNewRecord ? 'btn btn-success btn-ctt-fixed-width' : 'btn btn-primary btn-ctt-fixed-width']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
