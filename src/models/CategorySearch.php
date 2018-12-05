<?php

namespace nooclik\blog\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use nooclik\blog\models\Category;

/**
 * CategorySearch represents the model behind the search form of `nooclik\blog\models\Category`.
 */
class CategorySearch extends Category
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'category_parent'], 'integer'],
            [['category_title', 'category_slug', 'category_description', 'category_thumbnail'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
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
        $query = Category::find();

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
            'id' => $this->id,
            'category_parent' => $this->category_parent,
        ]);

        $query->andFilterWhere(['like', 'category_title', $this->category_title])
            ->andFilterWhere(['like', 'category_slug', $this->category_slug])
            ->andFilterWhere(['like', 'category_description', $this->category_description])
            ->andFilterWhere(['like', 'category_thumbnail', $this->category_thumbnail]);

        return $dataProvider;
    }
}
