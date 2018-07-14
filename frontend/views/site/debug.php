<p>
<?php
/**
 * Created by PhpStorm.
 * User: ricardo
 * Date: 15/06/18
 * Time: 12:09 PM
 */

    echo '<div style="padding: 20px 20px 20px 20px;">';
    echo '<div style="position: relative;"><img src="https://ctt-app.com/ctt-logo.png"></div>';
    echo '<h3><b>CTTwapp V1.0</b></h3>';
    echo '<h4>Servicio de Soporte al Cliente</h4>';
    echo '<h5><em>TSR Development Software</em></h5><br/><br/>';
    echo '<h3>CTTwapp Project</h3>';
    echo '<h4>Yii2 Predefined Aliases</h4>';
    echo '<h5>'.date('Y-m-d G:i:s').'</h5><br/>';
    echo '<table>';
    echo '<th>Yii version :</th> <tr><td>', Yii::getVersion(), '</td></tr>';
    echo '<th>@yii :</th> <tr><td>', Yii::getAlias('@yii'), '</td></tr>';
    echo '<th>@app :</th> <tr><td>', Yii::getAlias('@app'), '</td></tr>';
    echo '<th>@runtime :</th> <tr><td>', Yii::getAlias('@runtime'), '</td></tr>';
    echo '<th>@web :</th> <tr><td>', Yii::getAlias('@web'), '</td></tr>';
    echo '<th>@webroot :</th> <tr><td>', Yii::getAlias('@webroot'), '</td></tr>';
    echo '<th>@vendor :</th> <tr><td>', Yii::getAlias('@vendor'), '</td></tr>';
    echo '<th>@bower :</th> <tr><td>', Yii::getAlias('@bower'), '</td></tr>';
    echo '</table>';
    echo '</div>';

?>
</p>