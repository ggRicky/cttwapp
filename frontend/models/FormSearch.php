<?php
/**
 * Created by PhpStorm.
 * User: ricardo
 * Date: 11/09/17
 * Time: 09:22 AM
 */

namespace app\models;
use Yii;
use yii\base\Model;

class FormSearch extends Model{
    public $q;

    public function rules()
    {
        return [
            ["q", "match", "pattern" => "/^[0-9a-záéíóúñ\s]+$/i", "message" => "Sólo se aceptan letras y números"]
        ];
    }

    public function attributeLabels()
    {
        return [
            'q' => "Buscar:",
        ];
    }
}
