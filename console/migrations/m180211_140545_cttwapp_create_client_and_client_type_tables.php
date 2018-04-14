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
        // client
        $this->createTable('{{%client}}', [
            'id' => $this->integer()->notNull(),
            'rfc' => $this->string(13)->notNull(),
            'curp' => $this->char(18)->null(),
            'moral' => $this->boolean()->notNull(),
            'first_name' => $this->string(150)->null(),
            'paternal_name' => $this->string(50)->null(),
            'maternal_name' => $this->string(50)->null(),
            'created_at' => $this->timestamp()->notNull(),
            'updated_at' => $this->timestamp()->notNull(),
            'created_by' => $this->integer()->notNull(),
            'updated_by' => $this->integer()->notNull(),
            'client_type_id' => $this->integer()->null(),
            'PRIMARY KEY (id)',
        ]);

        // client_type
        $this->createTable('{{%client_type}}', [
            'id' => $this->primaryKey(),
            'type_desc' => $this->string(50)->notNull(),
        ]);

        // fk: client
        $this->addForeignKey('fk_client_id', '{{%client}}', 'id', '{{%client_type}}', 'id');

    }

    /**
     * @inheritdoc
     */
    public function safeDown()
    {
        echo "m180211_140545_cttwapp_create_client_and_client_type_tables cannot be reverted.\n";

        $this->dropTable('{{%client}}'); // fk: id
        $this->dropTable('{{%client_type}}');
        $this->dropTable('{{%user}}');

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
