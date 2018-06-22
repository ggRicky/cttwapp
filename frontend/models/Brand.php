<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "brand".
 *
 * @property string $id
 * @property string $brand_desc
 *
 * @property Article[] $articles
 */
class Brand extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'brand';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'brand_desc'], 'required'],
            [['id', 'brand_desc'], 'filter', 'filter'=>'strtoupper'],
            [['id'], 'unique'],
            [['id'], 'string', 'max' => 15],
            [['brand_desc'], 'string', 'max' => 50],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'Identificador'),
            'brand_desc' => Yii::t('app', 'Descripción de la Marca'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getArticles()
    {
        return $this->hasMany(Article::class, ['brand_id' => 'id']);
    }

    /** 2018-05-06 : Get the string data ['id']-['brand_desc']
     *
     */
    public function getDisplayBrandDesc()
    {
        return $this->id . ' - ' . $this->brand_desc;
    }
}