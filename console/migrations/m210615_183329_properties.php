<?php

use yii\db\Migration;
use yii\db\mysql\Schema;

/**
 * Class m210615_183329_properties
 */
class m210615_183329_properties extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('properties', [
            'id' => Schema::TYPE_PK,
            'title' => Schema::TYPE_STRING . ' NOT NULL',
            'floor_area' => Schema::TYPE_STRING . ' NOT NULL',
            'price' => $this->double(2)->notnull(),
            'image' => $this->string()->null(),
            'bedroom' => Schema::TYPE_INTEGER . '  NULL DEFAULT NULL',
            'bathroom' => Schema::TYPE_INTEGER . ' NULL DEFAULT NULL',
            'city' => Schema::TYPE_STRING . ' NOT NULL',
            'address' => Schema::TYPE_STRING . ' NOT NULL',
            'area' => Schema::TYPE_INTEGER . ' NOT NULL',
            'agent_id' => Schema::TYPE_INTEGER . ' NOT NULL',
            'description' => Schema::TYPE_STRING . ' NOT NULL',
            
            'nearby' => Schema::TYPE_STRING . '  NULL',
            'dat_created' => $this->timestamp()->null(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m210615_183329_properties cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m210615_183329_properties cannot be reverted.\n";

        return false;
    }
    */
}
