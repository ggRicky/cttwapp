<?php

namespace frontend\models;

use Yii;
use yii\base\Model;

/**
 * ContactForm is the model behind the contact form.
 */
class ContactForm extends Model
{
    public $name;
    public $email;
    public $subject;
    public $body;
    public $verifyCode;


    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            // name, email, subject and body are required
            [['name', 'email', 'subject', 'body'], 'required'],
            // email has to be a valid email address
            ['email', 'email'],
            // verifyCode needs to be entered correctly
            ['verifyCode', 'captcha'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'name' => Yii::t('app','Nombre'),
            'email' => Yii::t('app','Correo Electrónico'),
            'subject' => Yii::t('app','Asunto'),
            'body' => Yii::t('app','Descripción'),
            'verifyCode' => Yii::t('app','Código de Verificación'),
        ];
    }

    /**
     * Sends an email to the specified email address using the information collected by this model.
     *
     * @param string $email the target email address
     * @return bool whether the email was sent
     */
    public function sendEmail($email)
    {
        $content  = "<p>Email: " . $this->email . "</p>";
        $content .= "<p>Name: " . $this->name . "</p>";
        $content .= "<p>Subject: " . $this->subject . "</p>";
        $content .= "<p>Body: " . $this->body . "</p>";

        return Yii::$app->mailer->compose("@common/mail/layouts/html", ["content" => $content])
            ->setFrom([$this->email => $this->name])
            ->setTo($email)
            ->setSubject($this->subject)
            ->setTextBody($this->body)
            ->send();
    }
}