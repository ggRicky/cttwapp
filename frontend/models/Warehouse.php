<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "warehouse".
 *
 * @property string $id
 * @property string $desc_warehouse
 * @property string $attendant_warehouse
 * @property string $created_at
 * @property string $updated_at
 * @property int $created_by
 * @property int $updated_by
 */
class Warehouse extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'warehouse';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id'], 'required'],
            [['id'], 'string', 'max' => 15],
            [['desc_warehouse', 'attendant_warehouse'], 'string', 'max' => 75],
            [['id'], 'unique'],
            [['created_at', 'updated_at'], 'safe'],
            [['created_by', 'updated_by'], 'default', 'value' => null],
            [['created_by', 'updated_by'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'Identificador'),
            'desc_warehouse' => Yii::t('app', 'Descripción del Almacén'),
            'attendant_warehouse' => Yii::t('app', 'Responsable del Almacén'),
            'created_at' => Yii::t('app', 'Creado en'),
            'updated_at' => Yii::t('app', 'Actualizado en'),
            'created_by' => Yii::t('app', 'Creado por'),
            'updated_by' => Yii::t('app', 'Actualizado por'),
        ];
    }

    /** 2019-08-14 : Get the string data ['id']-['desc_warehouse']
     *
     */
    public function getDisplayDescWarehouse()
    {
        return $this->id . ' - ' . $this->desc_warehouse;
    }

}
