<?php
/**
 * Created by PhpStorm.
 * User: ricardo
 * Date: 17/08/17
 * Time: 07:59 PM
 *
 * Acción para el tutorial 4 - Yii Framework 2 Conectar vista-acción (formularios y redirecciones)
 *
 */

use yii\helpers\Url;
use yii\helpers\Html;

?>

<h1>Formulario</h1>
<h3><?= $mensaje ?></h3>

<?= Html::beginForm(

            Url::toRoute("site/request"),           // action
                        "get",              // method
                        ["class"=>"form-inline"]   // options

               );
?>

<div class ="form-group">

    <?= Html::label("Introduce tu nombre","nombre") ?>
    <?= Html::textInput("nombre",null, ["class"=>"form-control"]) ?>

    <?= Html::submitInput("Enviar nombre",["class"=>"btn btn-primary"]) ?>

</div>

<?= Html::endForm(); ?>
