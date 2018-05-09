<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "catalog".
 *
 * @property string $id
 * @property string $name_cat
 * @property string $sp_desc
 * @property string $en_desc
 * @property string $created_at
 * @property string $updated_at
 * @property int $created_by
 * @property int $updated_by
 *
 * @property Article[] $articles
 */
class Catalog extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'catalog';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'name_cat', 'created_at', 'updated_at', 'created_by', 'updated_by'], 'required'],
            [['id', 'name_cat','sp_desc','en_desc'], 'filter', 'filter'=>'strtoupper'],
            [['id'], 'unique'],
            [['id'], 'string', 'max' => 15],
            [['name_cat'], 'string', 'max' => 50],
            [['sp_desc', 'en_desc'], 'string', 'max' => 100],
            [['created_at', 'updated_at'], 'safe'],
            [['created_by', 'updated_by'], 'default', 'value' => null],
            [['created_by', 'updated_by'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'Identificador'),
            'name_cat' => Yii::t('app', 'Nombre del Catálogo'),
            'sp_desc' => Yii::t('app', 'Descripción en Español'),
            'en_desc' => Yii::t('app', 'Descripción en Inglés'),
            'created_at' => Yii::t('app', 'Creado En'),
            'updated_at' => Yii::t('app', 'Actualizado En'),
            'created_by' => Yii::t('app', 'Creado Por'),
            'updated_by' => Yii::t('app', 'Actualizado Por'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getArticles()
    {
        return $this->hasMany(Article::className(), ['id' => 'id']);
    }

    /** 2018-05-06 : Get the string data ['id']-['name_cat']
     *
     */
    public function getDisplayNameCat()
    {
        return $this->id . ' - ' . $this->name_cat;
    }

}