<p>
<?php
/**
 * Created by PhpStorm.
 * User: ricardo
 * Date: 15/06/18
 * Time: 12:09 PM
 */

    echo '<div style="padding: 20px 20px 20px 20px;">';
    echo '<h3>CTTwapp Project</h3>';
    echo '<h4>Yii2 Predefined Aliases</h4>';
    echo '<h5>2018-06-15</h5><br/>';
    echo '<table>';
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
