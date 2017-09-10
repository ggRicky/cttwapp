<?php
/**
 * Created by PhpStorm.
 * User: ricardo
 * Date: 6/09/17
 * Time: 09:38 PM
 */


namespace app\models;
use Yii;
use yii\base\Model;

class FormAlumnos extends Model
{

    // Propiedades de la clase FormAlumnos que serán usados por el formulario

    public $id_alumno;
    public $nombre;
    public $apellidos;
    public $clase;
    public $nota_final;

    // Reglas que se han de aplicar al ingreso de datos en el formulario

    public function rules()
    {
        return [
            ['id_alumno', 'integer', 'message' => 'Id incorrecto'],
            ['nombre', 'required', 'message' => 'Campo requerido'],
            ['nombre', 'match', 'pattern' => '/^[a-záéíóúñ\s]+$/i', 'message' => 'Sólo se aceptan letras'],
            ['nombre', 'match', 'pattern' => '/^.{3,50}$/', 'message' => 'Mínimo 3 máximo 50 caracteres'],
            ['apellidos', 'required', 'message' => 'Campo requerido'],
            ['apellidos', 'match', 'pattern' => '/^[a-záéíóúñ\s]+$/i', 'message' => 'Sólo se aceptan letras'],
            ['apellidos', 'match', 'pattern' => '/^.{3,80}$/', 'message' => 'Mínimo 3 máximo 80 caracteres'],
            ['clase', 'required', 'message' => 'Campo requerido'],
            ['clase', 'integer', 'message' => 'Sólo números enteros'],
            ['nota_final', 'required', 'message' => 'Campo requerido'],
            ['nota_final', 'number', 'message' => 'Sólo números'],
        ];
    }

}