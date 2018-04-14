<?php

use yii\db\Migration;

class m180410_024336_cttwapp_refactoring_client_table extends Migration
{
    public function safeUp()
    {
        // 2018-04-09 : Remove unneeded columns from client table.
        $this->dropColumn('{{%client}}', 'first_name');
        $this->dropColumn('{{%client}}', 'paternal_name');
        $this->dropColumn('{{%client}}', 'maternal_name');

        // 2018-04-09 : Add new columns to client table.
        $this->addColumn('{{%client}}', 'provenance', 'string(1) NOT NULL DEFAULT(\'N\')');
        $this->addColumn('{{%client}}', 'business_name', 'string(150) NOT NULL DEFAULT(\'N/D\')');
        $this->addColumn('{{%client}}', 'corporate', 'string(80) NOT NULL DEFAULT(\'N/D\')');
        $this->addColumn('{{%client}}', 'contact_name', 'string(80) NULL');
        $this->addColumn('{{%client}}', 'contact_email', 'string(255) NULL');
        $this->addColumn('{{%client}}', 'tax_residence', 'string(100) NOT NULL DEFAULT(\'N/D\')');
        $this->addColumn('{{%client}}', 'street', 'string(60) NOT NULL DEFAULT(\'N/D\')');
        $this->addColumn('{{%client}}', 'outdoor_number', 'string(10) NOT NULL DEFAULT(\'N/D\')');
        $this->addColumn('{{%client}}', 'interior_number', 'string(10) NULL');
        $this->addColumn('{{%client}}', 'suburb', 'string(80) NOT NULL DEFAULT(\'N/D\')');
        $this->addColumn('{{%client}}', 'municipality', 'string(80) NOT NULL DEFAULT(\'N/D\')');
        $this->addColumn('{{%client}}', 'delegation', 'string(80) NOT NULL DEFAULT(\'N/D\')');
        $this->addColumn('{{%client}}', 'state', 'string(50) NOT NULL DEFAULT(\'N/D\')');
        $this->addColumn('{{%client}}', 'zip_code', 'string(5) NOT NULL DEFAULT(\'N/D\')');
        $this->addColumn('{{%client}}', 'phone_number_1', 'string(15) NOT NULL DEFAULT(\'N/D\')');
        $this->addColumn('{{%client}}', 'phone_number_2', 'string(15) NULL');
        $this->addColumn('{{%client}}', 'web_page', 'string(50) NULL');
        $this->addColumn('{{%client}}', 'client_email', 'string(255) NOT NULL DEFAULT(\'N/D\')');
    }

    public function safeDown()
    {
        // 2018-04-10 : Remove the new columns from client table.
        $this->dropColumn('{{%client}}', 'provenance');
        $this->dropColumn('{{%client}}', 'business_name');
        $this->dropColumn('{{%client}}', 'corporate');
        $this->dropColumn('{{%client}}', 'contact_name');
        $this->dropColumn('{{%client}}', 'contact_email');
        $this->dropColumn('{{%client}}', 'tax_residence');
        $this->dropColumn('{{%client}}', 'street');
        $this->dropColumn('{{%client}}', 'outdoor_number');
        $this->dropColumn('{{%client}}', 'interior_number');
        $this->dropColumn('{{%client}}', 'suburb');
        $this->dropColumn('{{%client}}', 'municipality');
        $this->dropColumn('{{%client}}', 'delegation');
        $this->dropColumn('{{%client}}', 'state');
        $this->dropColumn('{{%client}}', 'zip_code');
        $this->dropColumn('{{%client}}', 'phone_number_1');
        $this->dropColumn('{{%client}}', 'phone_number_2');
        $this->dropColumn('{{%client}}', 'web_page');
        $this->dropColumn('{{%client}}', 'client_email');

        // 2018-04-10 : Restore the columns to client table.
        $this->addColumn('{{%client}}', 'first_name', 'string(150)');
        $this->addColumn('{{%client}}', 'paternal_name', 'string(50)');
        $this->addColumn('{{%client}}', 'maternal_name', 'string(50)');
    }
}
