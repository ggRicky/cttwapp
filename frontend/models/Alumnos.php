<?php
/**
 * Created by PhpStorm.
 * User: ricardo
 * Date: 6/09/17
 * Time: 09:40 PM
 */


namespace app\models;
use Yii;
use yii\db\ActiveRecord;

class Alumnos extends ActiveRecord{


    // Clase que permite instanciar un obtejo ActiveRecord y lograr la conexión a la base de datos mediante el componente db.
    // También define a través del método tableName() la tabla por accesar.

    public static function getDb()
    {
        return Yii::$app->db;
    }

    public static function tableName()
    {
        return 'alumnos';
    }

}
