<?php

use yii\db\Migration;
use yii\db\mysql\Schema;

/**
 * Class m210616_023316_messages
 */
class m210616_023316_messages extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('messages', [
            'id' => Schema::TYPE_PK,
            'property_id' => Schema::TYPE_INTEGER . ' NOT NULL',
            'agent_id' => Schema::TYPE_INTEGER . ' NOT NULL',
            'user_id' => Schema::TYPE_INTEGER . ' NOT NULL',
            'name' => Schema::TYPE_STRING . '  NULL',
            'email' => Schema::TYPE_STRING . '  NULL',
            'message' => Schema::TYPE_STRING . '  NULL',
            'status' => Schema::TYPE_STRING . '  NULL',
            'ysn_reply' => Schema::TYPE_STRING . ' NOT NULL DEFAULT 0',
            'created_at' => $this->timestamp()->null(),
            'updated_at' => $this->timestamp()->null(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m210616_023316_messages cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m210616_023316_messages cannot be reverted.\n";

        return false;
    }
    */
}
