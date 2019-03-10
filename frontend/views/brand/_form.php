<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Brand */
/* @var $form yii\widgets\ActiveForm */

// 2018-06-15 : If there is a page parameter, then stores and validate it.
// Verifies and validate the current page value.
$ret_page = Yii::$app->getRequest()->getQueryParam('page');
$ret_page = (empty($ret_page)?'1':$ret_page);

?>

<div class="brand-form">

    <!-- 2018-05-07 : If there is an flash message, then display it.-->
    <?php if (Yii::$app->session->hasFlash('warning')): ?>
        <div id="auto-close" class="alert alert-warning alert-dismissible fade in">
            <a href="#" class="close" data-dismiss="alert" data-toggle="tooltip" aria-label="close" title="<?= Yii::t('app','Cerrar') ?>">&times;</a>
            <h4><strong>¡ <?= Yii::t('app','Advertencia'); ?> !</strong></h4>
            <p><?= Yii::$app->session->getFlash('warning') ?></p>
        </div>
    <?php endif; ?>

    <?php $form = ActiveForm::begin(); ?>

        <?= $form->field($model, 'id')->textInput(['style' => 'text-transform: uppercase', 'maxlength' => true]) ?>
        <?= $form->field($model, 'brand_desc')->textInput(['style' => 'text-transform: uppercase', 'maxlength' => true]) ?>
        <?php

        // 2018-06-05 : Sends the current page value through a hidden input.
        echo Html::hiddenInput('page', $ret_page);

        ?>
        <div class="form-group">
            <?= Html::submitButton(Yii::t('app', 'Crear'), ['class' => 'btn btn-success btn-ctt-fixed-width']) ?>
        </div>

    <?php ActiveForm::end(); ?>

</div>