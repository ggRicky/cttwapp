<?php

namespace frontend\controllers;

use Yii;
use yii\helpers\Html;
use yii\helpers\Url;
use app\models\Article;
?>

<p>

<?php
/**
 * Created by PhpStorm.
 *
 * This script is used to debug some functionalities before implementing them.
 *
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
    // 2019-04-07 : Disabled temporarily
    // rsort($data);
    // foreach($data as $line){
    //    echo $line."<br />";
    // }

    echo '</td></tr>';
    echo '</table></br></br>';

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

    //  2018-11-10 : Debug data
    //  echo var_dump($data);
    //  echo print_r($data);

    // 2019-04-07 : Test to refactoring the content of the window modal confirm.
    echo '<table class="table-bordered">';
    echo '<tr>';
    echo '<th scope="row"><span><i class="fa fa-spinner fa-pulse fa-2x fa-fw" style="color:#999"></i></th> <td>', ' Do you want to change the visibility status of this item in the price list ? L10 - LAMPARA SEGUIDOR 350 W.', '</td>';
    echo '</tr>';
    echo '</table>';

    // 2019-08-14 : Test the & operator in strings
    echo '<br/><br/>';
    echo '$a = ', $a = '10011111111111111111111',' : ',strlen($a),'<br/>';
    echo '$b = ', $b = '1111111111111111111111111',' : ',strlen($b),'<br/>';
    echo '$c = ', $c = ($a & $b).str_repeat('0',abs(strlen($a)-strlen($b))),' : ', strlen($c);

    // 2019-09-06 : Test the session array 'keylist'
    echo '<br/><br/>';

    $session = Yii::$app->session;

    if (isset($session['keylist']) && count($session['keylist'])>0) {

        echo '$session[\'keylist\'] = ';
        print_r($session['keylist']);

        echo '<br/><br/>';
        echo 'Conversión del arreglo de sesión $session[\'keylist\'] ', "a Cadenas : ", "\"".implode("\", \"",$session['keylist'])."\"";

        echo '<br/><br/>';
        $list = "'".implode("', '",$session['keylist'])."'";
        echo '$list : ', $list;

        // $model = Article::findOne('11B3');   // Ok - Gets one article record with id ='11B3'

        $sql = "SELECT * FROM article WHERE \"id\" IN (".$list.");";  // Ok - Gets an article list based on the variable $list content.
        $model = Article::findBySql($sql)->all();

        echo '<br/><br/>';
        echo 'Consulta de Registros en $list : ';

        echo '<br/><br/>';
        print_r($model);

        // Export data using COPY SQL statement. Status : Ok

        if (false) {

            $sql1 = "COPY (SELECT * FROM article WHERE \"id\" IN (" . $list . ")) TO '/var/www/web/cttwapp/frontend/web/downloads/ctt_arts.csv' CSV HEADER;";
            Yii::$app->db->createCommand($sql1)->execute();
            echo '<br/><br/>';
            $file_name = Yii::getAlias('@webroot') . Yii::getAlias('@downloads') . '/ctt_arts.csv';
            $url_csv = Url::to(Yii::getAlias('@downloads') . '/ctt_arts.csv');
            if (file_exists($file_name)) {
                echo '<a href="' . $url_csv . '">Artículos Exportados</a>';
            }

        }

    }
    else echo 'The $session[\'keylist\'] is not available !';

    // Import data using COPY SQL statement. Status : Ok

    if (false) {

        echo '<br/><br/>';
        echo 'Importing ... ';
        $sql1 = "COPY article(id,name_art,sp_desc,en_desc,type_art,price_art,currency_art,brand_id,part_num,created_at,updated_at,created_by,updated_by,catalog_id,shown_price_list,warehouse_id) FROM '/var/www/web/cttwapp/frontend/web/uploads/imported_article_list.csv' DELIMITER ',' CSV HEADER;";
        Yii::$app->db->createCommand($sql1)->execute();
        echo '<br/><br/>';
        echo '$sql1 : '. $sql1;

    }

echo '</div>';

?>
</p>