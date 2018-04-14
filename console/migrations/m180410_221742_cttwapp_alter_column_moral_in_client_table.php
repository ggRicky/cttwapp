<?php

use yii\db\Migration;

class m180410_221742_cttwapp_alter_column_moral_in_client_table extends Migration
{
    public function safeUp()
    {
        // 2018-04-10 : Rename column in client table.
        $this->renameColumn('{{%client}}', 'moral', 'taxpayer');
        $this->alterColumn('{{%client}}', 'taxpayer', 'varchar(1) USING taxpayer::varchar(1)');
    }

    public function safeDown()
    {
        // 2018-04-10 : Rename column to original name.
        $this->renameColumn('{{%client}}', 'taxpayer', 'moral');
        $this->alterColumn('{{%client}}', 'moral', 'boolean USING CAST(moral AS boolean)');
    }
}
