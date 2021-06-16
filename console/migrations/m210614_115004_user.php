<?php

use yii\db\Migration;
use yii\db\Schema;
use yii\db\sqlite\Schema as Schema2;

/**
 * Class m210614_115004_user
 */
class m210614_115004_user extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('user', [
            'id' => Schema::TYPE_PK,
            'role_id' => Schema2::TYPE_INTEGER . ' NOT NULL',
            'name' => Schema2::TYPE_STRING . ' NOT NULL',
            'username' => $this->string()->unique()->notnull(),
            'email' => $this->string()->unique()->notnull(),
            'image' => Schema2::TYPE_STRING . '  NULL DEFAULT NULL',
            'about' => Schema2::TYPE_STRING . ' NULL DEFAULT NULL',
            'password' => Schema2::TYPE_STRING . ' NOT NULL',
            'remember_token' => Schema2::TYPE_STRING . ' NULL',
            'status' => Schema2::TYPE_INTEGER . ' NULL DEFAULT 10',
            'auth_key' => Schema2::TYPE_TEXT . ' NULL',
            'created_at' => $this->timestamp()->null(),
            'updated_at' => $this->timestamp()->null(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m210614_115004_user cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m210614_115004_user cannot be reverted.\n";

        return false;
    }
    */
}
