<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $model_1 \yii\base\DynamicModel */
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

    // Defines the values list for the dropDownList control.
    $listData = ['0' => Yii::t('app','Ocultar'), '1' => Yii::t('app','Mostrar')];

    // Defines the css class to apply for each item in the dropDownList control.
    $options  = [
        '0' => ['class' => 'dropDownList-item-0-css'],
        '1' => ['class' => 'dropDownList-item-1-css'],
    ];

    // catalog_id : Gets the value from the cookie and assign it to the model column_1. Default value to : '1' [ Shows ].
    $model_1->column_1 = (Yii::$app->getRequest()->getCookies()->has('article-c1') ? Yii::$app->getRequest()->getCookies()->getValue('article-c1') : '1');
    // It determines and stores the right css class to apply in the dropDownList control.
    $css_rules = ($model_1->column_1=='1'?'dropDownList-1-css':'dropDownList-0-css');
    // Shows the dropDownList control for the model column_1.
    echo $form->field($model_1, 'column_1')->dropDownList($listData,['options'=>$options, 'class'=>$css_rules])->label(Yii::t('app','Catálogo'));

    // name_art : Gets the value from the cookie and assign it to the model column_2. Default value to : '1' [ Shows ].
    $model_1->column_2 = (Yii::$app->getRequest()->getCookies()->has('article-c2') ? Yii::$app->getRequest()->getCookies()->getValue('article-c2') : '1');
    // It determines and stores the right css class to apply in the dropDownList control.
    $css_rules = ($model_1->column_2=='1'?'dropDownList-1-css':'dropDownList-0-css');
    // Shows the dropDownList control for the model column_2.
    echo $form->field($model_1, 'column_2')->dropDownList($listData,['options'=>$options, 'class'=>$css_rules])->label(Yii::t('app','Nombre del Artículo'));

    // sp_desc : Gets the value from the cookie and assign it to the model column_3. Default value to : '1' [ Shows ].
    $model_1->column_3 = (Yii::$app->getRequest()->getCookies()->has('article-c3') ? Yii::$app->getRequest()->getCookies()->getValue('article-c3') : '1');
    // It determines and stores the right css class to apply in the dropDownList control.
    $css_rules = ($model_1->column_3=='1'?'dropDownList-1-css':'dropDownList-0-css');
    // Shows the dropDownList control for the model column_3.
    echo $form->field($model_1, 'column_3')->dropDownList($listData,['options'=>$options, 'class'=>$css_rules])->label(Yii::t('app', 'Descripción en Español'));

    // en_desc : Gets the value from the cookie and assign it to the model column_4. Default value to : '1' [ Shows ].
    $model_1->column_4 = (Yii::$app->getRequest()->getCookies()->has('article-c4') ? Yii::$app->getRequest()->getCookies()->getValue('article-c4') : '1');
    // It determines and stores the right css class to apply in the dropDownList control.
    $css_rules = ($model_1->column_4=='1'?'dropDownList-1-css':'dropDownList-0-css');
    // Shows the dropDownList control for the model column_4.
    echo $form->field($model_1, 'column_4')->dropDownList($listData,['options'=>$options, 'class'=>$css_rules])->label(Yii::t('app', 'Descripción en Inglés'));

    // type_art : Gets the value from the cookie and assign it to the model column_5. Default value to : '1' [ Shows ].
    $model_1->column_5 = (Yii::$app->getRequest()->getCookies()->has('article-c5') ? Yii::$app->getRequest()->getCookies()->getValue('article-c5') : '1');
    // It determines and stores the right css class to apply in the dropDownList control.
    $css_rules = ($model_1->column_5=='1'?'dropDownList-1-css':'dropDownList-0-css');
    // Shows the dropDownList control for the model column_5.
    echo $form->field($model_1, 'column_5')->dropDownList($listData,['options'=>$options, 'class'=>$css_rules])->label(Yii::t('app', 'Tipo de Artículo'));

    // price_art : Gets the value from the cookie and assign it to the model column_6. Default value to : '1' [ Shows ].
    $model_1->column_6 = (Yii::$app->getRequest()->getCookies()->has('article-c6') ? Yii::$app->getRequest()->getCookies()->getValue('article-c6') : '1');
    // It determines and stores the right css class to apply in the dropDownList control.
    $css_rules = ($model_1->column_6=='1'?'dropDownList-1-css':'dropDownList-0-css');
    // Shows the dropDownList control for the model column_6.
    echo $form->field($model_1, 'column_6')->dropDownList($listData,['options'=>$options, 'class'=>$css_rules])->label(Yii::t('app', 'Precio'));

    // currency_art : Gets the value from the cookie and assign it to the model column_7. Default value to : '1' [ Shows ].
    $model_1->column_7 = (Yii::$app->getRequest()->getCookies()->has('article-c7') ? Yii::$app->getRequest()->getCookies()->getValue('article-c7') : '1');
    // It determines and stores the right css class to apply in the dropDownList control.
    $css_rules = ($model_1->column_7=='1'?'dropDownList-1-css':'dropDownList-0-css');
    // Shows the dropDownList control for the model column_7.
    echo $form->field($model_1, 'column_7')->dropDownList($listData,['options'=>$options, 'class'=>$css_rules])->label(Yii::t('app', 'Moneda'));

    // brand_id : Gets the value from the cookie and assign it to the model column_8. Default value to : '1' [ Shows ].
    $model_1->column_8 = (Yii::$app->getRequest()->getCookies()->has('article-c8') ? Yii::$app->getRequest()->getCookies()->getValue('article-c8') : '1');
    // It determines and stores the right css class to apply in the dropDownList control.
    $css_rules = ($model_1->column_8=='1'?'dropDownList-1-css':'dropDownList-0-css');
    // Shows the dropDownList control for the model column_8.
    echo $form->field($model_1, 'column_8')->dropDownList($listData,['options'=>$options, 'class'=>$css_rules])->label(Yii::t('app', 'Marca'));

    // part_num : Gets the value from the cookie and assign it to the model column_9. Default value to : '1' [ Shows ].
    $model_1->column_9 = (Yii::$app->getRequest()->getCookies()->has('article-c9') ? Yii::$app->getRequest()->getCookies()->getValue('article-c9') : '1');
    // It determines and stores the right css class to apply in the dropDownList control.
    $css_rules = ($model_1->column_9=='1'?'dropDownList-1-css':'dropDownList-0-css');
    // Shows the dropDownList control for the model column_9.
    echo $form->field($model_1, 'column_9')->dropDownList($listData,['options'=>$options, 'class'=>$css_rules])->label(Yii::t('app', 'Número de Parte'));

    // created_at : Gets the value from the cookie and assign it to the model column_10. Default value to : '1' [ Shows ].
    $model_1->column_10 = (Yii::$app->getRequest()->getCookies()->has('article-c10') ? Yii::$app->getRequest()->getCookies()->getValue('article-c10') : '1');
    // It determines and stores the right css class to apply in the dropDownList control.
    $css_rules = ($model_1->column_10=='1'?'dropDownList-1-css':'dropDownList-0-css');
    // Shows the dropDownList control for the model column_10.
    echo $form->field($model_1, 'column_10')->dropDownList($listData,['options'=>$options, 'class'=>$css_rules])->label(Yii::t('app', 'Creado en'));

    // updated_at : Gets the value from the cookie and assign it to the model column_11. Default value to : '1' [ Shows ].
    $model_1->column_11 = (Yii::$app->getRequest()->getCookies()->has('article-c11') ? Yii::$app->getRequest()->getCookies()->getValue('article-c11') : '1');
    // It determines and stores the right css class to apply in the dropDownList control.
    $css_rules = ($model_1->column_11=='1'?'dropDownList-1-css':'dropDownList-0-css');
    // Shows the dropDownList control for the model column_11.
    echo $form->field($model_1, 'column_11')->dropDownList($listData,['options'=>$options, 'class'=>$css_rules])->label(Yii::t('app', 'Actualizado en'));

    // created_by : Gets the value from the cookie and assign it to the model column_12. Default value to : '1' [ Shows ].
    $model_1->column_12 = (Yii::$app->getRequest()->getCookies()->has('article-c12') ? Yii::$app->getRequest()->getCookies()->getValue('article-c12') : '1');
    // It determines and stores the right css class to apply in the dropDownList control.
    $css_rules = ($model_1->column_12=='1'?'dropDownList-1-css':'dropDownList-0-css');
    // Shows the dropDownList control for the model column_12.
    echo $form->field($model_1, 'column_12')->dropDownList($listData,['options'=>$options, 'class'=>$css_rules])->label(Yii::t('app', 'Creado por'));

    // updated_by : Gets the value from the cookie and assign it to the model column_13. Default value to : '1' [ Shows ].
    $model_1->column_13 = (Yii::$app->getRequest()->getCookies()->has('article-c13') ? Yii::$app->getRequest()->getCookies()->getValue('article-c13') : '1');
    // It determines and stores the right css class to apply in the dropDownList control.
    $css_rules = ($model_1->column_13=='1'?'dropDownList-1-css':'dropDownList-0-css');
    // Shows the dropDownList control for the model column_13.
    echo $form->field($model_1, 'column_13')->dropDownList($listData,['options'=>$options, 'class'=>$css_rules])->label(Yii::t('app', 'Actualizado por'));

    ?>

    <div>
        <br><br><p class="required-field">* <?= Yii::t('app','Campo Requerido') ?></p><br><br>
    </div>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app','Actualizar'), ['class' => 'btn btn-primary btn-ctt-fixed-width']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
