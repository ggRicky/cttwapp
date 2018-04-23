<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\date\DatePicker;

/* 2018-03-14 : Used for built a list of available ClientType records */
use yii\helpers\ArrayHelper;
use app\models\ClientType;

/* @var $this yii\web\View */
/* @var $model app\models\Client */
/* @var $form yii\widgets\ActiveForm */


?>

<div class="client-form">

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

    ?>

    <?= $form->field($model, 'id')->textInput() ?>
    <?= $form->field($model, 'rfc')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'curp')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'taxpayer')->radioList(['M' => 'Persona Moral', 'F' => 'Persona Física']) ?>

    <!-- 2018-04-10 : New fields add to client table in refactoring action.-->

    <?= $form->field($model, 'provenance')->radioList(['N' => 'Nacional', 'E' => 'Extranjero']) ?>
    <?= $form->field($model, 'business_name')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'corporate')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'contact_name')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'contact_email')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'street')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'outdoor_number')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'interior_number')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'suburb')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'municipality')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'delegation')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'state')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'zip_code')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'phone_number_1')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'phone_number_2')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'web_page')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'client_email')->textInput(['maxlength' => true]) ?>

    <!-- The next four fields are read only and filled automatically -->

    <?= $form->field($model, 'created_at')->textInput(['readonly' => true]) ?>
    <?= $form->field($model, 'updated_at')->textInput(['readonly' => true]) ?>
    <?= $form->field($model, 'created_by')->textInput(['readonly' => true]) ?>
    <?= $form->field($model, 'updated_by')->textInput(['readonly' => true]) ?>

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
