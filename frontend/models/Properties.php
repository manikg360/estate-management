<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "properties".
 *
 * @property int $id
 * @property string $title
 * @property string $floor_area
 * @property float $price
 * @property string|null $image
 * @property int $bedroom
 * @property int $bathroom
 * @property string $city
 * @property string $address
 * @property int $area
 * @property int $agent_id
 * @property string $description
 * @property string|null $nearby
 * @property string|null $dat_created
 *
 * @property PropertyImageGalleries $propertyImageGalleries
 */
class Properties extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'properties';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['title', 'floor_area', 'price', 'bedroom', 'bathroom', 'city', 'address', 'area', 'agent_id', 'description'], 'required','except' => 'search'],
            [['id', 'bedroom', 'bathroom', 'area', 'agent_id'], 'integer'],
            [['price'], 'number'],
            [['description', 'nearby'], 'string'],
            [['dat_created'], 'safe'],
            [['title', 'floor_area'], 'string', 'max' => 250],
            [['image', 'city', 'address'], 'string', 'max' => 191],
            [['id'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Title',
            'floor_area' => 'Floor Area',
            'price' => 'Price',
            'image' => 'Image',
            'bedroom' => 'Bedroom',
            'bathroom' => 'Bathroom',
            'city' => 'City',
            'address' => 'Address',
            'area' => 'Area',
            'agent_id' => 'Agent ID',
            'description' => 'Description',
            'nearby' => 'Nearby',
            'dat_created' => 'Dat Created',
        ];
    }

    /**
     * Gets query for [[PropertyImageGalleries]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPropertyImageGalleries()
    {
        return $this->hasOne(PropertyImageGalleries::className(), ['id' => 'id']);
    }
    
    public function getNextId($strTable, $strKey, $where = null, $dataBaseObj = null) {
        if ($dataBaseObj)
            $connDb = $dataBaseObj;
        else
            $connDb = Yii::$app->db;


        //$newKey = 0;
        $strSQL = 'SELECT MAX(' . $strKey . ') AS `intId` FROM ' . $strTable . ($where != null ? ' WHERE ' . $where : '');
        $model = $connDb->createCommand($strSQL)->queryOne();
        return (int) $model['intId'] + 1;
    }


}
