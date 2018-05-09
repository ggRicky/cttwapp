<?php

use yii\db\Migration;

/**
 * Class m180411_141921_cttwapp_alter_column_moral_in_client_table
 */
class m180411_141921_cttwapp_alter_column_moral_in_client_table extends Migration
{
    public function safeUp()
    {
        // tbl: client

        // 2018-04-10 : Rename column in client table.
        $this->renameColumn('{{%client}}', 'moral', 'taxpayer');
        $this->alterColumn('{{%client}}', 'taxpayer', 'varchar(1) USING taxpayer::varchar(1)');
    }

    public function safeDown()
    {
        // tbl: client

        // 2018-04-10 : Rename column to original name.
        $this->renameColumn('{{%client}}', 'taxpayer', 'moral');
        $this->alterColumn('{{%client}}', 'moral', 'boolean USING CAST(moral AS boolean)');
    }
}
