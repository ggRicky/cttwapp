<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "article".
 *
 * @property string $id
 * @property string $name_art
 * @property string $sp_desc
 * @property string $en_desc
 * @property string $type_art
 * @property string $price_art
 * @property string $currency_art
 * @property string $brand_id
 * @property string $part_num
 * @property string $created_at
 * @property string $updated_at
 * @property int $created_by
 * @property int $updated_by
 * @property string $catalog_id
 *
 * @property Brand $brand
 * @property Catalog $catalog
 */
class Article extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'article';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'name_art', 'type_art', 'price_art', 'currency_art', 'brand_id', 'created_at', 'updated_at', 'created_by', 'updated_by', 'catalog_id'], 'required'],
            [['id', 'name_art','sp_desc','en_desc'], 'filter', 'filter'=>'strtoupper'],
            [['id'], 'unique'],
            [['created_at', 'updated_at'], 'safe'],
            [['created_by', 'updated_by'], 'default', 'value' => null],
            [['created_by', 'updated_by'], 'integer'],

            [['id', 'brand_id', 'catalog_id'], 'string', 'max' => 15],
            [['name_art', 'part_num'], 'string', 'max' => 50],
            [['sp_desc', 'en_desc'], 'string', 'max' => 100],
            [['type_art', 'currency_art'], 'string', 'max' => 1],
            [['price_art'], 'number'],

            [['brand_id'], 'exist', 'skipOnError' => true, 'targetClass' => Brand::className(), 'targetAttribute' => ['brand_id' => 'id']],
            [['catalog_id'], 'exist', 'skipOnError' => true, 'targetClass' => Catalog::className(), 'targetAttribute' => ['catalog_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'Identificador'),
            'name_art' => Yii::t('app', 'Nombre del Artículo'),
            'sp_desc' => Yii::t('app', 'Descripción en Español'),
            'en_desc' => Yii::t('app', 'Descripción en Inglés'),
            'type_art' => Yii::t('app', 'Tipo de Artículo'),
            'price_art' => Yii::t('app', 'Precio'),
            'currency_art' => Yii::t('app', 'Moneda'),
            'brand_id' => Yii::t('app', 'Marca'),
            'part_num' => Yii::t('app', 'Número de Parte'),
            'created_at' => Yii::t('app', 'Creado en'),
            'updated_at' => Yii::t('app', 'Actualizado en'),
            'created_by' => Yii::t('app', 'Creado por'),
            'updated_by' => Yii::t('app', 'Actualizado por'),
            'catalog_id' => Yii::t('app', 'Catálogo'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBrand()
    {
        return $this->hasOne(Brand::className(), ['id' => 'brand_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCatalog()
    {
        return $this->hasOne(Catalog::className(), ['id' => 'catalog_id']);
    }
}