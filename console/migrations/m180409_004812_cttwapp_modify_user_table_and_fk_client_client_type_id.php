<?php

use yii\db\Migration;

class m180409_004812_cttwapp_modify_user_table_and_fk_client_client_type_id extends Migration
{
    public function safeUp()
    {
        // tbl: user

        // 2018-04-06 : Add four columns to the user table. This will contain more specific info about the user.
        $this->addColumn('{{%user}}', 'first_name', 'string(50)');
        $this->addColumn('{{%user}}', 'paternal_name', 'string(35)');
        $this->addColumn('{{%user}}', 'maternal_name', 'string(35)');
        $this->addColumn('{{%user}}', 'curp', 'string(18)');

        // 2018-04-06 : fk: Drop the client's foreign key, because of a bad modeling.
        $this->dropForeignKey('fk_client_id', '{{%client}}');

        // 2018-04-06 : fk: Add the new client foreign key.
        $this->addForeignKey('fk_client_client_type_id', '{{%client}}', 'client_type_id', '{{%client_type}}', 'id');
    }

    public function safeDown()
    {
        // tbl: user

        // 2018-04-09 : Remove the four columns added before.
        $this->dropColumn('{{%user}}', 'first_name');
        $this->dropColumn('{{%user}}', 'paternal_name');
        $this->dropColumn('{{%user}}', 'maternal_name');
        $this->dropColumn('{{%user}}', 'curp');

        // 2018-04-09 : Restore the fk: client
        $this->dropForeignKey('fk_client_client_type_id', '{{%client}}');
        $this->addForeignKey('fk_client_id', '{{%client}}', 'id', '{{%client_type}}', 'id');
    }
}