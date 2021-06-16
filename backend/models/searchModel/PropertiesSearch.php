<?php

namespace backend\models\searchModel;

use backend\models\Properties;
use yii\data\ActiveDataProvider;

/**
 * Class ApplicationSearch
 * @package models\searchModel
 */
class PropertiesSearch extends Properties
{
    /**
     * @return array
     */

    public function rules()
    {
        return [
            [['title', 'floor_area', 'price', 'bedroom', 'bathroom', 'city', 'address', 'area', 'agent_id', 'description'], 'safe'],
        ];
    }

    /**
     * @param $params
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = Properties::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
 // Default Order
        $defaultOrder = [
            'title' => SORT_ASC,
        ];
 $dataProvider->setSort([
            'attributes' => [
            ],
            'defaultOrder' => $defaultOrder
        ]);
        $this->load($params);
        if (!$this->validate()) {
            return $dataProvider;
        }
      
        $query->andFilterWhere(['like', 'title', $this->title]);
        $query->andFilterWhere(['like', 'address', $this->address]);
        $query->andFilterWhere(['like', 'city', $this->city]);
        $query->andFilterWhere(['like', 'price', $this->price]);
        
      
        return $dataProvider;
    }

}
    

