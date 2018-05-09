<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "client".
 *
 * @property string $id
 * @property string $rfc
 * @property string $curp
 * @property string $taxpayer
 * @property string $created_at
 * @property string $updated_at
 * @property integer $created_by
 * @property integer $updated_by
 * @property integer $client_type_id
 * @property string $provenance
 * @property string $business_name
 * @property string $corporate
 * @property string $contact_name
 * @property string $contact_email
 * @property string $street
 * @property string $outdoor_number
 * @property string $interior_number
 * @property string $suburb
 * @property string $municipality
 * @property string $delegation
 * @property string $state
 * @property string $zip_code
 * @property string $phone_number_1
 * @property string $phone_number_2
 * @property string $web_page
 * @property string $client_email
 * @property string $considerations
 *
 * @property ClientType $id0
 */

class Client extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'client';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'rfc', 'taxpayer', 'provenance', 'business_name', 'state', 'corporate', 'street', 'outdoor_number', 'suburb',
                'municipality', 'delegation', 'zip_code', 'phone_number_1', 'client_email',], 'required'],
            [['id','rfc','curp','business_name','corporate','contact_name','street','suburb','municipality','delegation','state','considerations'], 'filter', 'filter'=>'strtoupper'],
            [['id'], 'unique'],
            [['created_by', 'updated_by', 'client_type_id'], 'integer'],

            [['created_at', 'updated_at'], 'date', 'format' => 'php:Y-m-d G:i:s'],
            [['rfc'], 'string', 'max' => 13],
            [['curp'], 'string', 'max' => 18],

            [['taxpayer', 'provenance'], 'string', 'max' => 1],
            [['business_name'], 'string', 'max' => 150],
            [['street'], 'string', 'max' => 60],
            [['corporate', 'contact_name', 'suburb', 'municipality', 'delegation'], 'string', 'max' => 80],
            [['outdoor_number', 'interior_number'], 'string', 'max' => 10],
            [['state', 'web_page'], 'string', 'max' => 50],
            [['zip_code'], 'string', 'max' => 5],
            [['phone_number_1', 'phone_number_2'], 'string', 'max' => 15],
            [['client_email', 'contact_email', 'considerations'], 'string', 'max' => 255],

            [['client_type_id'], 'exist', 'skipOnError' => true, 'targetClass' => ClientType::className(), 'targetAttribute' => ['client_type_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'Identificador'),
            'rfc' => 'RFC',
            'curp' => 'CURP',
            'taxpayer' => Yii::t('app', 'Contribuyente'),
            'business_name' => Yii::t('app', 'Razón Social / Nombre'),
            'provenance' => Yii::t('app','Procedencia'),
            'corporate' => Yii::t('app','Corporativo'),
            'contact_name' => Yii::t('app','Nombre del Contacto'),
            'contact_email' => Yii::t('app','Email del Contacto'),
            'street' => Yii::t('app','Calle'),
            'outdoor_number' => Yii::t('app','Número Exterior'),
            'interior_number' => Yii::t('app','Número Interior'),
            'suburb' => Yii::t('app','Colonia'),
            'municipality' => Yii::t('app','Municipio'),
            'delegation' => Yii::t('app','Delegación'),
            'state' => Yii::t('app','Estado'),
            'zip_code' => Yii::t('app','Código Postal'),
            'phone_number_1' => Yii::t('app','Teléfono 1'),
            'phone_number_2' => Yii::t('app','Teléfono 2'),
            'web_page' => Yii::t('app','Página Web'),
            'client_email' => Yii::t('app','Email del Cliente'),
            'considerations' => Yii::t('app','Consideraciones'),
            'created_at' => Yii::t('app','Creado en'),
            'updated_at' => Yii::t('app','Actualizado en'),
            'created_by' => Yii::t('app','Creado por'),
            'updated_by' => Yii::t('app','Actualizado por'),
            'client_type_id' => Yii::t('app','Tipo de Cliente'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getId0()
    {
        return $this->hasOne(ClientType::className(), ['id' => 'id']);
    }

}