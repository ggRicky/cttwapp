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

    // Gets and displays the cttwapp_user log file contents.
    $str = file_get_contents( Yii::getAlias('@runtime')."/logs/cttwapp_user.log" );

    // The regular expression to search the timestamp pattern [ YYYY-MM-DD HH:MM:SS ].
    $re1='((?:2|1)\\d{3}(?:-|\\/)(?:(?:0[1-9])|(?:1[0-2]))(?:-|\\/)(?:(?:0[1-9])|(?:[1-2][0-9])|(?:3[0-1]))(?:T|\\s)(?:(?:[0-1][0-9])|(?:2[0-3])):(?:[0-5][0-9]):(?:[0-5][0-9]))';	# Time Stamp 1

    // First replaces all timestamp pattern with the same value in red color, plus a carriage return prefix. Then, convert the resulting string in an array.
    $data = explode('<br />', preg_replace("/".$re1."/is","<br /><span style='color: red;'><b>$1</b></span>", $str));

    echo '<th>cttwapp_user.log :</th> <tr><td>';

    // Reorder the array content in reverse order and shows the very last data at the beginning.
    rsort($data);
    foreach($data as $line){
        echo $line."<br />";
    }

    echo '</td></tr>';
    echo '</table>';
    echo '</div>';

    //  2018-10-27 : Test-OK
    //  Displays the current path to cttwapp_user.log
    //  echo  Yii::getAlias('@runtime')."/logs/cttwapp_user.log";

    //  2018-10-28 : Test-OK
    //  Gets and shows the cttwapp_user log file contents and replaces all nl with <br> label
    //  echo nl2br(file_get_contents( Yii::getAlias('@runtime')."/logs/cttwapp_user.log"));

    //  2018-10-29 : Test-OK
    //  Gets the cttwapp_user log file contents and replaces all nl with <br> label. Then replaces all single <br /> tags with a double <br /> tags
    //  $str = str_replace ('<br />', '<br /><br />', nl2br(file_get_contents( Yii::getAlias('@runtime')."/logs/cttwapp_user.log" )));

    //  2018-10-30 : Test-OK
    //  Replaces the regular expression with the same value in red color plus a <br /> tag.
    //  $data = preg_replace("/".$re1."/is","<br /><span style='color: red;'><b>$1</b></span>", $str);

?>
</p>