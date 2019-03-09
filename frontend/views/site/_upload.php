<?php
/**
 * Created by PhpStorm.
 * User: ricardo
 * Date: 10/07/18
 * Time: 06:47 AM
 */

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\file\FileInput;

?>
<?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]) ?>

    <?= $form->field($model, 'file')->widget(FileInput::class, ['options' => ['accept' => 'image/*'],]); ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app','Enviar'), ['class' => 'btn btn-success btn-ctt-fixed-width', 'data-toggle' => 'tooltip', 'title' => Yii::t('app', 'Cargar la imagen de este inventario.')]) ?>
    </div>

<?php ActiveForm::end() ?>