<?php
/**
 * Created by PhpStorm.
 * User: ricardo
 * Date: 22/09/19
 * Time: 06:52 PM
 */

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\file\FileInput;

// 2019-09-22 : This is the form to gets a CSV file type.

?>
<?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]) ?>

    <?= $form->field($model, 'file')->widget(FileInput::class, ['options' => ['accept' => 'csv'],]); ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app','Enviar'), ['class' => 'btn btn-success btn-ctt-fixed-width', 'data-toggle' => 'tooltip', 'title' => Yii::t('app', 'Cargar un archivo CSV').'.']) ?>
    </div>

<?php ActiveForm::end() ?>