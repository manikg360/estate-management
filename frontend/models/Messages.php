<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "messages".
 *
 * @property int $id
 * @property int $agent_id
 * @property int|null $user_id
 * @property int|null $property_id
 * @property string $name
 * @property string $email
 * @property string $message
 * @property int $status
 * @property string|null $created_at
 * @property string|null $updated_at
 */
class Messages extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'messages';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'agent_id', 'message'], 'required'],
            [['id', 'agent_id', 'user_id', 'property_id', 'status'], 'integer'],
            [['message'], 'string'],
            [['created_at', 'updated_at'], 'safe'],
            [['name', 'email'], 'string', 'max' => 191],
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
            'agent_id' => 'Agent ID',
            'user_id' => 'User ID',
            'property_id' => 'Property ID',
            'name' => 'Name',
            'email' => 'Email',
            'message' => 'Message',
            'status' => 'Status',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }
}
