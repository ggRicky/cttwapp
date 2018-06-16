<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Catalog;

/**
 * CatalogSearch represents the model behind the search form of `app\models\Catalog`.
 */
class CatalogSearch extends Catalog
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'name_cat', 'sp_desc', 'en_desc', 'created_at', 'updated_at'], 'safe'],
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
        $query = Catalog::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            // 2018-06-13 : Set the records displayed in the GridView widget, setting up the pageSize attribute.
            'pagination' => [
                'pageSize' => 10,
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
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'created_by' => $this->created_by,
            'updated_by' => $this->updated_by,
        ]);

        $query->andFilterWhere(['ilike', 'id', $this->id])
            ->andFilterWhere(['ilike', 'name_cat', $this->name_cat])
            ->andFilterWhere(['ilike', 'sp_desc', $this->sp_desc])
            ->andFilterWhere(['ilike', 'en_desc', $this->en_desc]);

        return $dataProvider;
    }
}