<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "client_type".
 *
 * @property integer $id
 * @property string $type_desc
 *
 * @property Client $client
 */
class ClientType extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'client_type';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['type_desc'], 'required'],
            [['type_desc'], 'string', 'max' => 50],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app','Identificador'),
            'type_desc' => Yii::t('app','Descripción del Tipo de Cliente'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getClient()
    {
        return $this->hasOne(Client::className(), ['id' => 'id']);
    }

    /** 2018-03-16 : Get the string data ['id']-['type_desc']
     *
     */
    public function getDisplayTypeDesc()
    {
        return $this->id . ' - ' . $this->type_desc;
    }
}