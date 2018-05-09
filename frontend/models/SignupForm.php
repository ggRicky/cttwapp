<?php
namespace frontend\models;

use yii;
use yii\base\Model;
use common\models\User;

/**
 * Signup form
 */
class SignupForm extends Model
{
    public $username;
    public $email;
    public $password;

    // 2018-04-05 : The new properties for the user's extended model

    public $first;
    public $paternal;
    public $maternal;
    public $curp;


    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['username', 'trim'],
            ['username', 'required'],
            ['username', 'unique', 'targetClass' => '\common\models\User', 'message' => Yii::t('app','Este nombre de usuario ya fue asignado.')],
            ['username', 'string', 'min' => 2, 'max' => 255],

            ['email', 'trim'],
            ['email', 'required'],
            ['email', 'email'],
            ['email', 'string', 'max' => 255],
            ['email', 'unique', 'targetClass' => '\common\models\User', 'message' => Yii::t('app','Esta dirección de correo ya fue asignada.')],

            ['password', 'required'],
            ['password', 'string', 'min' => 6],

            // 2018-04-05 : The rules for the user new fields

            ['first', 'trim'],
            ['first', 'required'],
            ['first', 'string', 'max' => 50],

            ['paternal', 'trim'],
            ['paternal', 'required'],
            ['paternal', 'string', 'max' => 35],

            ['maternal', 'trim'],
            ['maternal', 'required'],
            ['maternal', 'string', 'max' => 35],

            ['curp', 'trim'],
            ['curp', 'required'],
            ['curp', 'string', 'min' => 18, 'max' => 18],
        ];
    }

    public function attributeLabels()
    {
        return [
            'username' => Yii::t('app','Usuario'),
            'password' => Yii::t('app','Contraseña'),
            'email'    => Yii::t('app','Correo Electrónico'),

            // 2018-04-05 : The labels for the user new fields

            'first'    => Yii::t('app','Nombre'),
            'paternal' => Yii::t('app','Apellido Paterno'),
            'maternal' => Yii::t('app','Apellido Materno'),
            'curp'     => 'CURP',
        ];
    }

    /**
     * Signs user up.
     *
     * @return User|null the saved model or null if saving fails
     */
    public function signup()
    {
        if (!$this->validate()) {
            return null;
        }
        
        $user = new User();
        $user->username = $this->username;
        $user->email = $this->email;
        $user->setPassword($this->password);
        $user->generateAuthKey();

        // 2018-04-05 : The values for the user new fields
        // 2018-05-06 : Convert to uppercase this values

        $user->first_name = mb_strtoupper($this->first, 'UTF-8');
        $user->paternal_name = mb_strtoupper($this->paternal, 'UTF-8');
        $user->maternal_name = mb_strtoupper($this->maternal, 'UTF-8');
        $user->curp = strtoupper($this->curp);

        return $user->save() ? $user : null;
    }
}
