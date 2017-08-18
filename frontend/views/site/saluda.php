<?php
/**
 * Created by PhpStorm.
 * User: ricardo
 * Date: 17/08/17
 * Time: 07:27 PM
 *
 * Acción para el tutorial 3 - Yii Framework 2 Conectar acción-vista (Hola Mundo)
 *
 */

echo $mensaje;

foreach ($numeros as $valor):
?>
    <p><strong><?= $valor; ?></strong></p>

<?php
endforeach;
?>

<h1><?= $parametro; ?></h1>