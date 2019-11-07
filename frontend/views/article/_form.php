<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;          // 2018-05-06 : Used for built a list of available Catalogs and Brands records
use app\models\Catalog;
use app\models\Brand;
use app\models\Warehouse;
use app\models\ArticleType;
use kartik\number\NumberControl;      // 2019-11-06 : kartik-v/yii2-number (v1.0.5)

/* @var $this yii\web\View */
/* @var $model app\models\Article */
/* @var $form yii\widgets\ActiveForm */

// Products & Services : This form is used to gets the data for each one column the article record.

// 2018-06-05 : If there is a page parameter, then stores and validate it.
// Verifies and validate the current page value.
$ret_page = Yii::$app->getRequest()->getQueryParam('page');
$ret_page = (empty($ret_page)?'1':$ret_page);

// 2018-07-08 : Stores a hash parameter to jump to the requested area.
$hash_param = Yii::$app->getRequest()->getQueryParam('hash');
// 2018-07-08 : Translates the $hash_param value to the corresponding anchor to jump.
// $hash_param [ 0 - Jumps to the work area index  1 - Jumps to the upload button ]
$hash_param = ($hash_param=='1'?'upload-area':null);

// 2018-07-08 : if an anchor parameter was send, then jumps to it using javascript.
if ($hash_param) {
    $script = <<< JS
    location.hash = "#$hash_param";
JS;
    $this->registerJs($script);
}
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

    if (isset(Yii::$app->user->identity)){

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

    if ($model->isNewRecord){

        $model->sp_desc = $model->en_desc = $model->part_num = $model->id_alt = 'N/D';
        $model->shown_price_list = "0";  // 0-No shows, 1-Shows
        $model->price_art = 0.0;         // Yii::$app->formatter->asCurrency(0.0,'USD');
        $model->currency_art = "1";      // 1-Pesos, 2-Dollars

    }
    else{

        // 2019-11-02 : Update Record

        $model->id_alt   = (is_null($model->id_alt)   || empty($model->id_alt)   ? 'N/D' : $model->id_alt);
        $model->sp_desc  = (is_null($model->sp_desc)  || empty($model->sp_desc)  ? 'N/D' : $model->sp_desc);
        $model->en_desc  = (is_null($model->en_desc)  || empty($model->en_desc)  ? 'N/D' : $model->en_desc);
        $model->part_num = (is_null($model->part_num) || empty($model->part_num) ? 'N/D' : $model->part_num);

    }

    ?>

    <!-- ID input text  -->
    <?= $form->field($model, 'id')->textInput(['style' => 'text-transform: uppercase', 'maxlength' => true]) ?>
    <!-- Name Article input text  -->
    <?= $form->field($model, 'name_art')->textInput(['style' => 'text-transform: uppercase', 'maxlength' => true]) ?>
    <!-- Spanish input text  -->
    <?= $form->field($model, 'sp_desc')->textInput(['style' => 'text-transform: uppercase', 'maxlength' => true]) ?>
    <!-- English input text  -->
    <?= $form->field($model, 'en_desc')->textInput(['style' => 'text-transform: uppercase', 'maxlength' => true]) ?>
    <!-- Alternative ID input text  -->
    <?= $form->field($model, 'id_alt')->textInput(['style' => 'text-transform: uppercase', 'maxlength' => true]) ?>
    <!-- 2019-10-31 : Remarks text area -->
    <?= $form->field($model, 'remarks_art')->textArea(['style' => 'text-transform: uppercase', 'maxlength' => true]) ?>

    <!-- The anchor to show the Upload button -->
    <spam id="upload-area"></spam>

    <!-- Article Image -->
    <?php

    // 2018-08-03 : Uploads the inventory's picture if the user is in modify mode.
    if (!$model->isNewRecord) {
        // 2018-08-03 : To displays the image in modify process.
        echo '<p><b>'.Yii::t('app','Fotografía del Artículo').'</b></p>';

        // 2018-08-03 : To get the image path and filename.
        $file_name = Yii::getAlias('@webroot').Yii::getAlias('@uploads_inv').'/'.PREFIX_IMG.$model->id;

        // 2018-08-03 : To get the image url.
        $url_image = Url::to(Yii::getAlias('@uploads_inv').'/').PREFIX_IMG.$model->id;

        // 2018-08-03 : To get the no image url.
        $url_no_image = Url::to(Yii::getAlias('@uploads_inv').'/').'ctt_no_image.jpg';

        // 2018-08-03 : Test for the right file type
        echo '<div class="well well-lg">';

        if (file_exists($file_name.'.jpg'))
           echo '<p><img src="'.$url_image.'.jpg" width="auto" style="max-height:100%; max-width:100%"></p>';
        else if (file_exists($file_name.'.png'))
           echo '<p><img src="'.$url_image.'.png" width="auto" style="max-height:100%; max-width:100%"></p>';
        else
           echo '<p><img src="'.$url_no_image.'"  width="auto" style="max-height:100%; max-width:100%"></p>';

        echo Html::a(Yii::t('app','Asignar Imagen'), ['article/upload', 'id' => $model->id, 'page' => $ret_page], ['class' => 'btn btn-ctt-warning btn-ctt-fixed-width', 'data-toggle' => 'tooltip', 'title' => Yii::t('app', 'Cargar la imagen para este artículo').'.']);

        echo '</div>';
        }
    ?>

    <!-- Type Art Selector -->
    <?= $form->field($model, 'article_type_id')->dropDownList(ArrayHelper::map(ArticleType::find()->select(['id','type_desc'])->orderBy(['id' => SORT_ASC])->all(),'id','displayTypeDesc'), ['prompt' => Yii::t('app','Seleccione...'), 'data-toggle' => 'tooltip', 'title' => Yii::t('app', 'Tipos Disponibles')]); ?>

    <!-- Price input text -->
    <!-- 2019-11-06 : Adds the kartik-v/yii2-number (v1.0.5) extension to control the display and save formats for numbers. -->
    <?= $form->field($model, 'price_art')->textInput()->widget(NumberControl::class, [
            'maskedInputOptions' => [
                'prefix' => '$ ',           // 2019-11-06 : Default price prefix
                'min' => 10,                // 2019-11-06 : Min value accepted
                'max' => 9999999.99,        // 2019-11-06 : Max value accepted
                'allowMinus' => false,      // 2019-11-06 : No negative prices accepted
            ],
            'displayOptions' => ['style' =>'width:250px;'],  // 2019-11-06 : Set the field's width.
        ]);
    ?>

    <!-- Currency input text -->
    <?= $form->field($model, 'currency_art')->radioList(['1' => 'Pesos', '2' => 'Dólares'],
        [
            'item' => function($index, $label, $name, $checked, $value) {

                $return  = '<label class="modal-radio">';
                $return .= '<input type="radio" name="' . $name . '" value="' . $value . '" title="'.Yii::t('app','Determina la moneda base de cotización').'" data-toggle="tooltip" ' . ($checked?"checked":""). '>';
                $return .= '<i></i>';
                $return .= '<span>' . ucwords($label) .str_repeat('&nbsp;',5) . '</span>';
                $return .= '</label>';

                return $return;
            }
        ]); ?>

    <!-- Brand Selector  -->
    <?= $form->field($model, 'brand_id')->dropDownList(ArrayHelper::map(Brand::find()->select(['id','brand_desc'])->orderBy(['id' => SORT_ASC])->all(),'id','displayBrandDesc'), ['prompt' => Yii::t('app','Seleccione...')]); ?>

    <!-- Part Number input text  -->
    <?= $form->field($model, 'part_num')->textInput(['style' => 'text-transform: uppercase', 'maxlength' => true]) ?>

    <!-- Catalog Selector  -->
    <?= $form->field($model, 'catalog_id')->dropDownList(ArrayHelper::map(Catalog::find()->select(['id','name_cat'])->orderBy(['id' => SORT_ASC])->all(),'id','displayNameCat'), ['prompt' => Yii::t('app','Seleccione...')]); ?>

    <!-- Warehouse Selector  -->
    <?= $form->field($model, 'warehouse_id')->dropDownList(ArrayHelper::map(Warehouse::find()->select(['id','desc_warehouse'])->orderBy(['id' => SORT_ASC])->all(),'id','displayDescWarehouse'), ['prompt' => Yii::t('app','Seleccione...')]); ?>

    <!-- Shown in Price List Selector  -->
    <?= $form->field($model, 'shown_price_list')->radioList(
            ['0' => 'No', '1' => 'Si'],
            // 2019-03-31 : This code is for customize the tooltip in each radio button, avoiding have only one for the entire RadioList control.
            // Because this condition, the tooltip was displayed at the center of the screen area.
            [
                'item' => function($index, $label, $name, $checked, $value) {

                    $return  = '<label class="modal-radio">';
                    $return .= '<input type="radio" name="' . $name . '" value="' . $value . '" title="'.Yii::t('app','Permite mostrar u ocultar este registro en el Listado de Precios').'" data-toggle="tooltip" ' . ($checked?"checked":""). '>';
                    $return .= '<i></i>';
                    $return .= '<span>' . ucwords($label) .str_repeat('&nbsp;',5) . '</span>';
                    $return .= '</label>';

                    return $return;
                }
            ]); ?>

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

</div>