<?php

namespace app\models;

use Yii;
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
            [['id', 'name_art', 'sp_desc', 'en_desc', 'currency_art', 'brand_id', 'part_num', 'created_at', 'updated_at', 'catalog_id', 'shown_price_list', 'warehouse_id'], 'safe'],
            [['price_art'], 'number'],
            [['created_by', 'updated_by', 'article_type_id'], 'integer'],
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
     * Creates different kinds of data provider instance with search query applied based on the '$qry_type' parameter
     *
     * @param array $params
     * @param string $qry_type
     *
     * @return ActiveDataProvider
     */
    public function search($params, $qry_type=null)
    {
        switch ($qry_type){
            case '0':   // Price List. Shows filtered data in the Price List option,

                // 2019-03-31 : Adds a new functionality to show filtered data in the Price List option. At the same time, it show all records in the article table in Products & Services option.
                $query = Article::find()->where('shown_price_list LIKE \'1\'');  // 2019-03-31 : $qry_type == '0' [ Price List ] To filter only records for the Price List option

                // Adds the conditions that should always apply to the dataProvider
                $dataProvider = new ActiveDataProvider([
                    'query' => $query,
                    'pagination' => [
                        'pageSize' => 50,  // 2018-05-28 : Set the records displayed in the GridView widget, setting up the pageSize attribute.
                    ],
                    'sort' => [
                        'defaultOrder' => ['id' => SORT_ASC,],
                    ],
                ]);

                break;

            case '1':   // Print Article List. Shows all selected records in the article table, based on the session array 'keylist'.

                // 2019-09-08 : Access to sessions through the session application component
                $session = Yii::$app->session;

                // 2019-09-08 : Gets the list of selected article records.
                $list = "'".implode("', '",$session['keylist'])."'";

                // 2019-09-08 : Gets an article list based on the variable $list content and ordered by the id field.
                $sql = "SELECT * FROM article WHERE \"id\" IN (".$list.") ORDER BY \"id\"";
                // 2019-09-08 : Find all the records listed in the $list variable.
                $query = Article::findBySql($sql);

                // Adds the conditions that should always apply to the dataProvider
                $dataProvider = new ActiveDataProvider([
                    'query' => $query,
                    'sort' => false,       // 2019-09-08 : Removes the sort object in the top header of the GridView control
                ]);

                break;

            default:

                // No filter applied. Shows all available records in the article table.
                $query = Article::find();

                // Adds the conditions that should always apply to the dataProvider
                $dataProvider = new ActiveDataProvider([
                    'query' => $query,
                    'pagination' => [
                        'pageSize' => 50,  // 2018-05-28 : Set the records displayed in the GridView widget, setting up the pageSize attribute.
                    ],
                    'sort' => [
                        'defaultOrder' => ['id' => SORT_ASC,],
                    ],
                ]);

        }

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
              // 2019-10-23 : Due to the field type article_type_id was changed from VARCHAR to INTEGER the operator 'ilike' must be changed to '=' operator.
              ->andFilterWhere(['=',     'article_type_id', $this->article_type_id])
              ->andFilterWhere(['ilike', 'currency_art', $this->currency_art])
              ->andFilterWhere(['ilike', 'brand_id', $this->brand_id])
              ->andFilterWhere(['ilike', 'part_num', $this->part_num])
              ->andFilterWhere(['ilike', 'catalog_id', $this->catalog_id])
              ->andFilterWhere(['ilike', 'shown_price_list', $this->shown_price_list])
              ->andFilterWhere(['ilike', 'warehouse_id', $this->warehouse_id]);

        return $dataProvider;
    }
}
