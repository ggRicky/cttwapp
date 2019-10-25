<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\ArticleType */
/* @var $form yii\widgets\ActiveForm */

// 2018-06-10 : If there is a page parameter, then stores and validate it.
// Verifies and validate the current page value.
$ret_page = Yii::$app->getRequest()->getQueryParam('page');
$ret_page = (empty($ret_page)?'1':$ret_page);

?>

<div class="article-type-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'type_desc')->textInput(['maxlength' => true]) ?>

    <?php
        // 2018-06-10 : Sends the current page value through a hidden input.
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
