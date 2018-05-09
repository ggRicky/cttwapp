<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Article */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="article-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'id')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'name_art')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'sp_desc')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'en_desc')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'type_art')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'price_art')->textInput() ?>

    <?= $form->field($model, 'currency_art')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'brand_id')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'part_num')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'created_at')->textInput() ?>

    <?= $form->field($model, 'updated_at')->textInput() ?>

    <?= $form->field($model, 'created_by')->textInput() ?>

    <?= $form->field($model, 'updated_by')->textInput() ?>

    <?= $form->field($model, 'catalog_id')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
