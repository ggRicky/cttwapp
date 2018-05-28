<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* 2018-05-06 : Used for built a list of available Catalogs and Brands records */
use yii\helpers\ArrayHelper;
use app\models\Catalog;
use app\models\Brand;

/* @var $this yii\web\View */
/* @var $model app\models\Article */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="article-form">

    <!-- 2018-05-07 : If there is an flash message, then display it.-->
    <?php if (Yii::$app->session->hasFlash('error')): ?>
        <div class="alert alert-warning alert-dismissible fade in">
            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
            <h4><strong>¡ <?= Yii::t('app','Advertencia'); ?> !</strong></h4>
            <p><?= Yii::$app->session->getFlash('error') ?></p>
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
        $model->sp_desc = $model->en_desc = $model->part_num = "N/D";
    }

    ?>

    <?= $form->field($model, 'id')->textInput(['style' => 'text-transform: uppercase', 'maxlength' => true]) ?>
    <?= $form->field($model, 'name_art')->textInput(['style' => 'text-transform: uppercase', 'maxlength' => true]) ?>
    <?= $form->field($model, 'sp_desc')->textInput(['style' => 'text-transform: uppercase', 'maxlength' => true]) ?>
    <?= $form->field($model, 'en_desc')->textInput(['style' => 'text-transform: uppercase', 'maxlength' => true]) ?>
    <?= $form->field($model, 'type_art')->radioList(['V' => 'Venta', 'R' => 'Renta']) ?>
    <?= $form->field($model, 'price_art')->textInput() ?>
    <?= $form->field($model, 'currency_art')->radioList(['P' => 'Pesos', 'D' => 'Dólares']) ?>

    <!-- Brand Selector  -->
    <?php

    echo $form->field($model, 'brand_id')->dropDownList(ArrayHelper::map(Brand::find()->select(['id','brand_desc'])->orderBy(['id' => SORT_ASC])->all(),'id','displayBrandDesc'), ['prompt' => Yii::t('app','Seleccione...')]);

    ?>

    <?= $form->field($model, 'part_num')->textInput(['style' => 'text-transform: uppercase', 'maxlength' => true]) ?>

    <!-- Catalog Selector  -->

    <?php

    echo $form->field($model, 'catalog_id')->dropDownList(ArrayHelper::map(Catalog::find()->select(['id','name_cat'])->orderBy(['id' => SORT_ASC])->all(),'id','displayNameCat'), ['prompt' => Yii::t('app','Seleccione...')]);

    ?>

    <!-- The next four fields are read only and filled automatically -->

    <?= $form->field($model, 'created_at')->textInput(['readonly' => true]) ?>
    <?= $form->field($model, 'updated_at')->textInput(['readonly' => true]) ?>
    <?= $form->field($model, 'created_by')->textInput(['readonly' => true]) ?>
    <?= $form->field($model, 'updated_by')->textInput(['readonly' => true]) ?>

    <div>
        <p class="required-field">* <?= Yii::t('app','Campo Requerido') ?></p><br><br>
    </div>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app','Crear') : Yii::t('app','Actualizar'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>