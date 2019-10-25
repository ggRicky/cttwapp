<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "article_type".
 *
 * @property integer $id
 * @property string $type_desc
 *
 */
class ArticleType extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'article_type';
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
            'type_desc' => Yii::t('app','Descripción del Tipo de Artículo'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getArticle()
    {
        return $this->hasOne(Article::class, ['id' => 'id']);
    }

    /** 2019-10-23 : Get the string data ['id']-['type_desc']
     *
     */
    public function getDisplayTypeDesc()
    {
        return $this->id . ' - ' . $this->type_desc;
    }
}