<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;

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
            [['id', 'name_art', 'sp_desc', 'en_desc', 'type_art', 'currency_art', 'brand_id', 'part_num', 'created_at', 'updated_at', 'catalog_id', 'shown_price_list', 'warehouse_id'], 'safe'],
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
     * @param string $qry_type
     *
     * @return ActiveDataProvider
     */
    public function search($params, $qry_type=null)
    {
        // 2019-03-31 : Adds a new functionality to show filtered data in the  Price List option. At the same time, it show all records in the article table in Products & Services option.
        if($qry_type=='pl') $query = Article::find()->where('shown_price_list LIKE \'S\'');  // 2019-03-31 : $qry_type == 'pl' [ Price List ] To filter only records for the Price List option
        else $query = Article::find();  // No filter shows all available records in the article table.

        // add conditions that should always apply here
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            // 2018-05-28 : Set the records displayed in the GridView widget, setting up the pageSize attribute.
            'pagination' => [
                'pageSize' => 50,
            ],
            'sort' => [
                'defaultOrder' => [
                    'id' => SORT_ASC,
                ],
            ],
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'price_art'  => $this->price_art,
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
              ->andFilterWhere(['ilike', 'catalog_id', $this->catalog_id])
              ->andFilterWhere(['ilike', 'shown_price_list', $this->shown_price_list])
              ->andFilterWhere(['ilike', 'warehouse_id', $this->warehouse_id]);

        return $dataProvider;
    }
}
