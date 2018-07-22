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

// 2018-06-05 : If there is a page parameter, then stores and validate it.
// Verifies and validate the current page value.
$ret_page = Yii::$app->getRequest()->getQueryParam('page');
$ret_page = (empty($ret_page)?'1':$ret_page);

?>

<div class="article-form">

    <!-- 2018-05-07 : If there is an flash message, then display it.-->
    <?php if (Yii::$app->session->hasFlash('warning')): ?>
        <div id="auto-close" class="alert alert-warning alert-dismissible fade in">
            <a href="#" class="close" data-dismiss="alert" data-toggle="tooltip" aria-label="close" title="<?= Yii::t('app','Cerrar') ?>">&times;</a>
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

    <?php
        // 2018-06-05 : Sends the current page value through an hidden input.
        echo Html::hiddenInput('page', $ret_page);
    ?>

    <div>
        <p class="required-field">* <?= Yii::t('app','Campo Requerido') ?></p><br><br>
    </div>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app','Crear') : Yii::t('app','Actualizar'), ['class' => $model->isNewRecord ? 'btn btn-success btn-ctt-fixed-width' : 'btn btn-primary btn-ctt-fixed-width']) ?>
    </div>

    <?php ActiveForm::end(); ?>

    <?php
        // 2018-07-08 : Uploads the inventory's picture if the user is in modify mode.
        if (!$model->isNewRecord) {
            echo Html::a(Yii::t('app','Asignar Imagen'), ['site/upload', 'id' => $model->id, 'page' => $ret_page], ['class' => 'btn btn-ctt-warning btn-ctt-fixed-width', 'data-toggle' => 'tooltip', 'title' => Yii::t('app', 'Cargar la imagen para este artículo.')]);

            // 2018-07-10 : To get the image path and filename.
            $file_name = Yii::getAlias('@webroot').UPLOAD_DIR.UPLOAD_INV_PICS_DIR.PREFIX_IMG.$model->id;
            // 2018-07-10 : Test for the right file type
            if (file_exists($file_name.'.jpg') || file_exists($file_name.'.png'))
                echo Html::tag('span', '', ['class' => 'btn glyphicon glyphicon-camera', 'data-toggle' => 'tooltip', 'title' => Yii::t('app', 'Artículo con imagen asignada.')]);
        }
    ?>
</div>