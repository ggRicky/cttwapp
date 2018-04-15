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

    <?php $form = ActiveForm::begin();


    ?>

    <?= $form->field($model, 'id')->textInput() ?>
    <?= $form->field($model, 'rfc')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'curp')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'taxpayer')->radioList(['M' => 'Persona Moral', 'F' => 'Persona Física']) ?>
    <?= $form->field($model, 'provenance')->radioList(['N' => 'Nacional', 'E' => 'Extranjero']) ?>
    <?= $form->field($model, 'business_name')->textInput(['maxlength' => true]) ?>

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

    echo $form->field($model, 'client_type_id')->dropDownList(ArrayHelper::map(ClientType::find()->select(['id','type_desc'])->orderBy(['id' => SORT_ASC])->all(),'id','displayTypeDesc'), ['prompt'=>'Seleccione...']);

    ?>

    <div>
        <p class="required-field">* <?= Yii::t('app','Campo Requerido') ?></p><br><br>
    </div>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Crear' : 'Actualizar', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
