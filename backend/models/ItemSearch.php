<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\Item;

/**
 * ItemSearch represents the model behind the search form about `backend\models\Item`.
 */
class ItemSearch extends Item
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'currency', 'category', 'manufacturer', 'country', 'stock', 'warranty', 'delivery', 'delivery_time', 'home'], 'integer'],
            [['name', 'url', 'title', 'description', 'content', 'code', 'unit', 'packing', 'created'], 'safe'],
            [['price'], 'number'],
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
        $query = Item::find();

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
            'currency' => $this->currency,
            'category' => $this->category,
            'manufacturer' => $this->manufacturer,
            'country' => $this->country,
            'stock' => $this->stock,
            'warranty' => $this->warranty,
            'delivery' => $this->delivery,
            'delivery_time' => $this->delivery_time,
            'home' => $this->home,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'created', $this->created])
            ->andFilterWhere(['like', 'url', $this->url])
            ->andFilterWhere(['like', 'title', $this->title])
            ->andFilterWhere(['like', 'description', $this->description])
            ->andFilterWhere(['like', 'content', $this->content])
            ->andFilterWhere(['like', 'code', $this->code])
            ->andFilterWhere(['like', 'price', $this->price])
            ->andFilterWhere(['like', 'unit', $this->unit])
            ->andFilterWhere(['like', 'packing', $this->packing]);

        return $dataProvider;
    }
}
