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
 * @property integer $article_type_id
 * @property string $price_art
 * @property string $currency_art
 * @property string $brand_id
 * @property string $part_num
 * @property string $created_at
 * @property string $updated_at
 * @property int $created_by
 * @property int $updated_by
 * @property string $catalog_id
 * @property boolean $shown_price_list
 * @property string $warehouse_id
 * @property string $remarks_art
 *
 * @property Brand $brand
 * @property Catalog $catalog
 * @property Warehouse $warehouse
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
            [['id', 'name_art', 'article_type_id', 'price_art', 'currency_art', 'brand_id', 'created_at', 'updated_at', 'created_by', 'updated_by', 'catalog_id', 'shown_price_list', 'warehouse_id'], 'required'],
            [['id', 'name_art','sp_desc','en_desc', 'remarks_art'], 'filter', 'filter'=>'strtoupper'],
            [['id'], 'unique'],
            [['created_at', 'updated_at'], 'safe'],
            [['created_by', 'updated_by'], 'default', 'value' => null],
            [['created_by', 'updated_by', 'article_type_id'], 'integer'],

            [['id', 'brand_id', 'catalog_id', 'warehouse_id'], 'string', 'max' => 15],
            [['name_art', 'part_num'], 'string', 'max' => 50],
            [['sp_desc', 'en_desc'], 'string', 'max' => 100],
            [['currency_art', 'shown_price_list'], 'string', 'max' => 1],
            [['price_art'], 'number'],
            [['remarks_art'], 'string'],

            [['brand_id'], 'exist', 'skipOnError' => true, 'targetClass' => Brand::class, 'targetAttribute' => ['brand_id' => 'id']],
            [['catalog_id'], 'exist', 'skipOnError' => true, 'targetClass' => Catalog::class, 'targetAttribute' => ['catalog_id' => 'id']],
            [['warehouse_id'], 'exist', 'skipOnError' => true, 'targetClass' => Warehouse::class, 'targetAttribute' => ['warehouse_id' => 'id']],
            [['article_type_id'], 'exist', 'skipOnError' => true, 'targetClass' => ArticleType::class, 'targetAttribute' => ['article_type_id' => 'id']],
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
            'article_type_id' => Yii::t('app', 'Tipo de Artículo'),
            'price_art' => Yii::t('app', 'Precio'),
            'currency_art' => Yii::t('app', 'Moneda'),
            'brand_id' => Yii::t('app', 'Marca'),
            'part_num' => Yii::t('app', 'Número de Parte'),
            'created_at' => Yii::t('app', 'Creado en'),
            'updated_at' => Yii::t('app', 'Actualizado en'),
            'created_by' => Yii::t('app', 'Creado por'),
            'updated_by' => Yii::t('app', 'Actualizado por'),
            'catalog_id' => Yii::t('app', 'Catálogo'),
            'warehouse_id' => Yii::t('app', 'Almacén'),
            'photo' => Yii::t('app','Fotografía del Artículo'),
            'shown_price_list' => Yii::t('app','Lista de Precios'),
            'remarks_art' => Yii::t('app','Observaciones'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBrand()
    {
        return $this->hasOne(Brand::class, ['id' => 'brand_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCatalog()
    {
        return $this->hasOne(Catalog::class, ['id' => 'catalog_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getWarehouse()
    {
        return $this->hasOne(Warehouse::class, ['id' => 'warehouse_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getArticleType()
    {
        return $this->hasOne(ArticleType::class, ['id' => 'article_type_id']);
    }


}