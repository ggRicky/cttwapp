<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Catalog */
/* @var $form yii\widgets\ActiveForm */

// 2018-06-05 : If there is a page parameter, then stores and validate it.
// Verifies and validate the current page value.
$ret_page = Yii::$app->getRequest()->getQueryParam('page');
$ret_page = (empty($ret_page)?'1':$ret_page);

?>

<div class="catalog-form">

    <!-- 2018-05-07 : If there is an flash message, then display it.-->
    <?php if (Yii::$app->session->hasFlash('warning')): ?>
        <div id="auto-close" class="alert alert-warning alert-dismissible fade in">
            <a href="#" class="close" data-dismiss="alert" aria-label="close" title="<?= Yii::t('app','Cerrar') ?>">&times;</a>
            <h4><strong>¡ <?= Yii::t('app','Advertencia'); ?> !</strong></h4>
            <p><?= Yii::$app->session->getFlash('warning') ?></p>
        </div>
    <?php endif; ?>

    <?php $form = ActiveForm::begin();

    // Init the model's fields, with the today's date data.

    $model->created_at = ($model->isNewRecord ? date('Y-m-d G:i:s') : $model->created_at);
    $model->updated_at = date('Y-m-d G:i:s');

    // Init the model's fields, with the user's data.

    if (isset(Yii::$app->user->identity)) {

        // If the user identity object is created, then init the model fields with the user Id

        $model->created_by = ($model->isNewRecord ? Yii::$app->user->identity->getId() : $model->created_by);
        $model->updated_by = Yii::$app->user->identity->getId();

    }
    else{

        // If the user identity object isn't created, then init the model fields with -1 ( User undefined yet )

        // Important : In the future, any record ( inserted or updated ) will be done by one authenticated user.

        $model->created_by = -1;
        $model->updated_by = -1;

    }

    // 2018-05-06 : Init some model fields to default values if new record.

    if ($model->isNewRecord) {
        $model->sp_desc = $model->en_desc = "N/D";
    }

    ?>

    <?= $form->field($model, 'id')->textInput(['style' => 'text-transform: uppercase', 'maxlength' => true]) ?>
    <?= $form->field($model, 'name_cat')->textInput(['style' => 'text-transform: uppercase', 'maxlength' => true]) ?>
    <?= $form->field($model, 'sp_desc')->textInput(['style' => 'text-transform: uppercase', 'maxlength' => true]) ?>
    <?= $form->field($model, 'en_desc')->textInput(['style' => 'text-transform: uppercase', 'maxlength' => true]) ?>

    <!-- The next four fields are read only and filled automatically -->

    <?= $form->field($model, 'created_at')->textInput(['readonly' => true]) ?>
    <?= $form->field($model, 'updated_at')->textInput(['readonly' => true]) ?>
    <?= $form->field($model, 'created_by')->textInput(['readonly' => true]) ?>
    <?= $form->field($model, 'updated_by')->textInput(['readonly' => true]) ?>

    <?php
    // 2018-06-05 : Sends the current page value through a hidden input.
    echo Html::hiddenInput('page', $ret_page);
    ?>
    <div>
        <p class="required-field">* <?= Yii::t('app','Campo Requerido') ?></p><br><br>
    </div>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app','Crear') : Yii::t('app','Actualizar'), ['class' => $model->isNewRecord ? 'btn btn-success btn-ctt-fixed-width' : 'btn btn-primary btn-ctt-fixed-width']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>