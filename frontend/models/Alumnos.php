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

    public static function getDb()
    {
        return Yii::$app->db;
    }

    public static function tableName()
    {
        return 'alumnos';
    }

}
