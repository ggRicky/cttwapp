<?php

namespace app\models;


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
            [['created_by', 'updated_by', 'client_type_id'], 'integer'],
            [['id'], 'unique'],

            [['created_at', 'updated_at'], 'date', 'format' => 'php:Y-m-d G:i:s'],
            [['rfc'], 'string', 'max' => 13],
            [['curp'], 'string', 'max' => 18],

            [['taxpayer', 'provenance'], 'string', 'max' => 1],
            [['business_name'], 'string', 'max' => 150],
            [['tax_residence'], 'string', 'max' => 100],
            [['street'], 'string', 'max' => 60],
            [['corporate', 'contact_name', 'suburb', 'municipality', 'delegation'], 'string', 'max' => 80],
            [['outdoor_number', 'interior_number'], 'string', 'max' => 10],
            [['state', 'web_page'], 'string', 'max' => 50],
            [['zip_code'], 'string', 'max' => 5],
            [['phone_number_1', 'phone_number_2'], 'string', 'max' => 15],
            [['client_email', 'contact_email'], 'string', 'max' => 255],

            [['client_type_id'], 'exist', 'skipOnError' => true, 'targetClass' => ClientType::className(), 'targetAttribute' => ['client_type_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'rfc' => 'RFC',
            'curp' => 'CURP',
            'taxpayer' => 'Contribuyente',
            'business_name' => 'Razón Social',
            'provenance' => 'Procedencia',
            'corporate' => 'Corporativo',
            'contact_name' => 'Nombre del Contacto',
            'contact_email' => 'Email del contacto',
            'street' => 'Calle',
            'outdoor_number' => 'Número Exterior',
            'interior_number' => 'Número Interior',
            'suburb' => 'Colonia',
            'municipality' => 'Municipio',
            'delegation' => 'Delegación',
            'state' => 'Estado',
            'zip_code' => 'Código Postal',
            'phone_number_1' => 'Teléfono 1',
            'phone_number_2' => 'Teléfono 2',
            'web_page' => 'Página Web',
            'client_email' => 'Email del Cliente',
            'created_at' => 'Creado en',
            'updated_at' => 'Actualizado en',
            'created_by' => 'Creado por',
            'updated_by' => 'Actualizado por',
            'client_type_id' => 'Tipo de Cliente',
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
