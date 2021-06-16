<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "property_image_galleries".
 *
 * @property int $id
 * @property int $property_id
 * @property string $name
 * @property string|null $size
 * @property string|null $created_at
 * @property string|null $updated_at
 *
 * @property Properties $id0
 */
class PropertyImageGalleries extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'property_image_galleries';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'property_id', 'name'], 'required'],
            [['id', 'property_id'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['name', 'size'], 'string', 'max' => 191],
            [['id'], 'unique'],
            [['id'], 'exist', 'skipOnError' => true, 'targetClass' => Properties::className(), 'targetAttribute' => ['id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'property_id' => 'Property ID',
            'name' => 'Name',
            'size' => 'Size',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * Gets query for [[Id0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getId0()
    {
        return $this->hasOne(Properties::className(), ['id' => 'id']);
    }
}
