<?php

use yii\db\Migration;

/**
 * Class m180211_140545_cttwapp_create_client_and_client_type_tables
 */
class m180211_140545_cttwapp_create_client_and_client_type_tables extends Migration
{
    /**
     * @inheritdoc
     */
    public function safeUp()
    {

    }

    /**
     * @inheritdoc
     */
    public function safeDown()
    {
        echo "m180211_140545_cttwapp_create_client_and_client_type_tables cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m180211_140545_cttwapp_create_client_and_client_type_tables cannot be reverted.\n";

        return false;
    }
    */
}
