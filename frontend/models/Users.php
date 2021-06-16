<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "users".
 *
 * @property int $id
 * @property int $role_id
 * @property string $name
 * @property string $username
 * @property string $email
 * @property string $image
 * @property string|null $about
 * @property string $password
 * @property string|null $remember_token
 * @property string|null $created_at
 * @property string|null $updated_at
 */
class Users extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'user';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'role_id', 'name', 'username', 'email', 'password'], 'required'],
            [['id', 'role_id'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['name', 'username', 'email', 'image', 'about', 'password'], 'string', 'max' => 191],
            [['remember_token'], 'string', 'max' => 100],
            [['username'], 'unique'],
            [['email'], 'unique'],
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
            'role_id' => 'Role ID',
            'name' => 'Name',
            'username' => 'Username',
            'email' => 'Email',
            'image' => 'Image',
            'about' => 'About',
            'password' => 'Password',
            'remember_token' => 'Remember Token',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }
}
