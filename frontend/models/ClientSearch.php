<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * ClientSearch represents the model behind the search form about `app\models\Client`.
 */
class ClientSearch extends Client
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id'], 'string'],
            [['rfc', 'curp', 'business_name', 'contact_name', 'street', 'suburb', 'municipality', 'delegation', 'state', 'phone_number_1', 'considerations'], 'safe'],
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
        $query = Client::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            // 2018-05-28 : Set the records displayed in the GridView widget, setting up the pageSize attribute.
            'pagination' => [
                'pageSize' => 10,
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
            'id' => $this->id,
        ]);

        // 2018-04-10 : New fields add to client table in refactoring action.

        $query->andFilterWhere(['like', 'rfc', $this->rfc])
              ->andFilterWhere(['like', 'curp', $this->curp])
              ->andFilterWhere(['like', 'business_name', $this->business_name])
              ->andFilterWhere(['like', 'contact_name', $this->contact_name])
              ->andFilterWhere(['like', 'street', $this->street])
              ->andFilterWhere(['like', 'suburb', $this->suburb])
              ->andFilterWhere(['like', 'municipality', $this->municipality])
              ->andFilterWhere(['like', 'delegation', $this->delegation])
              ->andFilterWhere(['like', 'state', $this->state])
              ->andFilterWhere(['like', 'phone_number_1', $this->phone_number_1])
              ->andFilterWhere(['like', 'considerations', $this->considerations]);

        return $dataProvider;
    }
}
