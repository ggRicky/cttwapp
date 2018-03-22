<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* 2018-03-14 : Used for built a list of available ClientType records */
use yii\helpers\ArrayHelper;
use app\models\ClientType;

/* @var $this yii\web\View */
/* @var $model app\models\Client */
/* @var $form yii\widgets\ActiveForm */


?>

<div class="client-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'id')->textInput() ?>

    <?= $form->field($model, 'rfc')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'curp')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'moral')->checkbox() ?>

    <?= $form->field($model, 'first_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'paternal_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'maternal_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'created_at')->textInput() ?>

    <?= $form->field($model, 'updated_at')->textInput() ?>

    <?= $form->field($model, 'created_by')->textInput() ?>

    <?= $form->field($model, 'updated_by')->textInput() ?>

    <?php

        // v1.0

        // 2018-03-14 : Get all records from ClientType model.
        // 2018-03-14 : Build an data array in pairs ['id']['type_desc'].
        // 2018-03-14 : Add a dropDownList ClientType record selector.

        // echo $form->field($model, 'client_type_id')->dropDownList(ArrayHelper::map(ClientType::find()->all(),'id','type_desc'), ['prompt'=>'Seleccione...']);

        // v2.0

        // 2018-03-16 : Change find()->all() by find()->select(). This approach is more suitable because select only the requested columns.

        // echo $form->field($model, 'client_type_id')->dropDownList(ArrayHelper::map(ClientType::find()->select(['id','type_desc'])->all(),'id','type_desc'), ['prompt'=>'Seleccione...']);

        // v3.0

        // 2018-03-16 : Use a function callback ('displayTypeDesc') to return the Id and Description Type for this field ('client_type_id').

        echo $form->field($model, 'client_type_id')->dropDownList(ArrayHelper::map(ClientType::find()->select(['id','type_desc'])->all(),'id','displayTypeDesc'), ['prompt'=>'Seleccione...']);

    ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Crear' : 'Actualizar', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
