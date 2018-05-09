<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Article;

/**
 * ArticleSearch represents the model behind the search form of `app\models\Article`.
 */
class ArticleSearch extends Article
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'name_art', 'sp_desc', 'en_desc', 'type_art', 'currency_art', 'brand_id', 'part_num', 'created_at', 'updated_at', 'catalog_id'], 'safe'],
            [['price_art'], 'number'],
            [['created_by', 'updated_by'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = Article::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'price_art' => $this->price_art,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'created_by' => $this->created_by,
            'updated_by' => $this->updated_by,
        ]);

        $query->andFilterWhere(['ilike', 'id', $this->id])
            ->andFilterWhere(['ilike', 'name_art', $this->name_art])
            ->andFilterWhere(['ilike', 'sp_desc', $this->sp_desc])
            ->andFilterWhere(['ilike', 'en_desc', $this->en_desc])
            ->andFilterWhere(['ilike', 'type_art', $this->type_art])
            ->andFilterWhere(['ilike', 'currency_art', $this->currency_art])
            ->andFilterWhere(['ilike', 'brand_id', $this->brand_id])
            ->andFilterWhere(['ilike', 'part_num', $this->part_num])
            ->andFilterWhere(['ilike', 'catalog_id', $this->catalog_id]);

        return $dataProvider;
    }
}
