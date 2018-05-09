<?php

use yii\db\Migration;

/**
 * Class m180505_034732_cttwapp_create_article_catalog_and_brand_tables
 */
class m180505_034732_cttwapp_create_article_catalog_and_brand_tables extends Migration
{
    public function safeUp()
    {
        // tbl: article

        $this->createTable('{{%article}}', [
            'id' => $this->string(15)->notNull(),
            'name_art' => $this->string(50)->notNull(),
            'sp_desc' => $this->string(100)->null()->defaultValue('N/D'),
            'en_desc' => $this->string(100)->null()->defaultValue('N/D'),
            'type_art' => $this->char(1)->notNull(),
            'price_art' => $this->money(11,2)->notNull(),
            'currency_art' => $this->char(1)->notNull(),
            'brand_id' => $this->string(15)->notNull(),
            'part_num' => $this->string(50)->null()->defaultValue('N/D'),
            'created_at' => $this->timestamp()->notNull(),
            'updated_at' => $this->timestamp()->notNull(),
            'created_by' => $this->integer()->notNull(),
            'updated_by' => $this->integer()->notNull(),
            'catalog_id' => $this->string(15)->notNull(),
            'PRIMARY KEY (id)',
        ]);

        // tbl: brand

        $this->createTable('{{%brand}}', [
            'id' => $this->string(15)->notNull(),
            'brand_desc' => $this->string(50)->notNull(),
            'PRIMARY KEY (id)',
        ]);

        // tbl: catalog

        $this->createTable('{{%catalog}}', [
            'id' => $this->string(15)->notNull(),
            'name_cat' => $this->string(50)->notNull(),
            'sp_desc' => $this->string(100)->null()->defaultValue('N/D'),
            'en_desc' => $this->string(100)->null()->defaultValue('N/D'),
            'created_at' => $this->timestamp()->notNull(),
            'updated_at' => $this->timestamp()->notNull(),
            'created_by' => $this->integer()->notNull(),
            'updated_by' => $this->integer()->notNull(),
            'PRIMARY KEY (id)',
        ]);

        // fk: article

        $this->addForeignKey('fk_catalog_id', '{{%article}}', 'catalog_id', '{{%catalog}}', 'id');
        $this->addForeignKey('fk_brand_id', '{{%article}}', 'brand_id', '{{%brand}}', 'id');

    }

    public function safeDown()
    {
        // tbl: article

        $this->dropTable('{{%article}}'); // fk: id

        // tbl: brand

        $this->dropTable('{{%brand}}');

        // tbl: catalog

        $this->dropTable('{{%catalog}}');
    }
}
