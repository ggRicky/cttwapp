<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $model_2 \yii\base\DynamicModel */
/* @var $form yii\bootstrap\ActiveForm */

?>

<div class="columns-form">

    <!-- Defines and config an ActiveForm widget in horizontal layout -->
    <?php $form = ActiveForm::begin([
        'layout' => 'horizontal',
        'fieldConfig' => [
            'horizontalCssClasses' => [
                'template' => "{label}\n{beginWrapper}\n{input}\n{hint}\n{error}\n{endWrapper}",
                'label' => 'col-sm-1',
                'offset' => 'col-sm-offset-4',
                'wrapper' => 'col-sm-8',
                'error' => '',
                'hint' => '',
            ],
        ],
    ]);

    // 2018-09-30 : Gets the value from the cookie and assign it to the model field 'paginado'. Default value to : 10 [ Records / Page ].
    $model_2->paginado = (Yii::$app->getRequest()->getCookies()->has('client-pageSize') ? Yii::$app->getRequest()->getCookies()->getValue('client-pageSize') : 10);

    // 2018-09-30 : Shows the TextInput control to save the new value for the field 'paginado', defined in the dynamic model.
    echo $form->field($model_2, 'paginado')->textInput(['style'=>'width:30%'])->label(Yii::t('app','Tamaño del Paginado'))->hint(Yii::t('app','Tamaño del Paginado').' : [ 1 - 100 ]');

    ?>

    <div>
        <br><br><p class="required-field">* <?= Yii::t('app','Campo Requerido') ?></p><br><br>
    </div>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app','Actualizar'), ['class' => 'btn btn-primary btn-ctt-fixed-width']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
