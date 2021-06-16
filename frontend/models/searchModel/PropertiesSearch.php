<?php

namespace frontend\models\searchModel;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use frontend\models\Properties;

/**
 * PropertiesSearch represents the model behind the search form of `frontend\models\Properties`.
 */
class PropertiesSearch extends Properties
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'bedroom', 'bathroom', 'area', 'agent_id'], 'integer'],
            [['title', 'floor_area', 'image', 'city', 'address', 'description', 'nearby', 'dat_created'], 'safe'],
            [['price'], 'safe'],
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
        $strWhere = '1 ';
      
        
        if(!empty($params['Properties']['title'])):
            $strWhere .= ' and properties.title = "'.$params['Properties']['title'].'"';
        endif;
        if(!empty($params['Properties']['city'])):
            $strWhere .= ' and properties.city = "'.$params['Properties']['city'].'"';
        endif;
        if(!empty($params['Properties']['bedroom'])):
            $strWhere .= ' and properties.bedroom = '.$params['Properties']['bedroom'];
        endif;
        if(!empty($params['Properties']['price'])):
            $strWhere .= ' and properties.price <='.$params['Properties']['price'];
        endif;
        $query = Properties::find()
                        ->andWhere($strWhere);
        $arrData = $query->all();

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
            'price' => $this->price,
            'bedroom' => $this->bedroom,
            'bathroom' => $this->bathroom,
            'area' => $this->area,
            'agent_id' => $this->agent_id,
            'dat_created' => $this->dat_created,
        ]);

        $query->andFilterWhere(['like', 'title', $this->title])
            ->andFilterWhere(['like', 'floor_area', $this->floor_area])
            ->andFilterWhere(['like', 'image', $this->image])
            ->andFilterWhere(['like', 'city', $this->city])
            ->andFilterWhere(['like', 'address', $this->address])
            ->andFilterWhere(['like', 'description', $this->description])
            ->andFilterWhere(['like', 'nearby', $this->nearby]);

        return [$dataProvider,$arrData];
    }
}
