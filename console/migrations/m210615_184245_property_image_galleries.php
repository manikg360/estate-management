<?php

use yii\db\Migration;
use yii\db\mysql\Schema;

/**
 * Class m210615_184245_property_image_galleries
 */
class m210615_184245_property_image_galleries extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
       $this->createTable('property_image_galleries', [
            'id' => Schema::TYPE_PK,
            'property_id' => Schema::TYPE_INTEGER . ' NOT NULL',
            'name' => Schema::TYPE_STRING . ' NOT NULL',
            'size' => Schema::TYPE_STRING . ' NOT NULL',
            'created_at' => $this->timestamp()->null(),
            'updated_at' => $this->timestamp()->null(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m210615_184245_property_image_galleries cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m210615_184245_property_image_galleries cannot be reverted.\n";

        return false;
    }
    */
}
