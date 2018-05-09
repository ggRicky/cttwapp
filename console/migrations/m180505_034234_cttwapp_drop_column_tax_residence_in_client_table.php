<?php

use yii\db\Migration;

/**
 * Class m180505_034234_cttwapp_drop_column_tax_residence_in_client_table
 */
class m180505_034234_cttwapp_drop_column_tax_residence_in_client_table extends Migration
{
    public function safeUp()
    {
        // tbl: client

        // 2018-04-09 : Remove unneeded column tax_residence from client table.
        $this->dropColumn('{{%client}}', 'tax_residence');
    }

    public function safeDown()
    {
        // tbl: client

        // 2018-04-23 : Restore the column tax_residence in client table.
        $this->addColumn('{{%client}}', 'tax_residence', 'string(100) NOT NULL DEFAULT(\'N/D\')');
    }
}
