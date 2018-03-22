<?php

namespace app\models;

use Yii;


/**
 * This is the model class for table "client".
 *
 * @property integer $id
 * @property string $rfc
 * @property string $curp
 * @property boolean $moral
 * @property string $first_name
 * @property string $paternal_name
 * @property string $maternal_name
 * @property string $created_at
 * @property string $updated_at
 * @property integer $created_by
 * @property integer $updated_by
 * @property integer $client_type_id
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
            [['id', 'rfc', 'moral', 'created_at', 'updated_at', 'created_by', 'updated_by'], 'required'],
            [['id', 'created_by', 'updated_by', 'client_type_id'], 'integer'],
            [['moral'], 'boolean'],
            [['created_at', 'updated_at'], 'safe'],
            [['rfc'], 'string', 'max' => 13],
            [['curp'], 'string', 'max' => 18],
            [['first_name'], 'string', 'max' => 150],
            [['paternal_name', 'maternal_name'], 'string', 'max' => 50],
            [['id'], 'unique'],
            [['id'], 'exist', 'skipOnError' => true, 'targetClass' => ClientType::className(), 'targetAttribute' => ['id' => 'id']],
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
            'moral' => 'Moral',
            'first_name' => 'Nombre',
            'paternal_name' => 'Apellido Paterno',
            'maternal_name' => 'Apellido Materno',
            'created_at' => 'Creado en',
            'updated_at' => 'Actualizado en',
            'created_by' => 'Creado por',
            'updated_by' => 'Actualizado por',
            'client_type_id' => 'ID Tipo de cliente',
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
