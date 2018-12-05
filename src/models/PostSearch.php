<?php

namespace nooclik\blog\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use nooclik\blog\models\Post;

/**
 * PostSearch represents the model behind the search form of `nooclik\blog\models\Post`.
 */
class PostSearch extends Post
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'post_author_id', 'post_status', 'post_type', 'created_at', 'updated_at'], 'integer'],
            [['post_title', 'post_slug', 'post_content', 'post_thumbnail'], 'safe'],
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
        $query = Post::find();

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
            'post_status' => $this->post_status,
            'post_type' => $this->post_type,

        ]);

        $query->andFilterWhere(['like', 'post_title', $this->post_title])
            ->andFilterWhere(['like', 'post_content', $this->post_content]);

        return $dataProvider;
    }
}
