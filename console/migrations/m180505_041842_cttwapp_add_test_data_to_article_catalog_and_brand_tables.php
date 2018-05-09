<?php

use yii\db\Migration;

/**
 * Class m180505_041842_cttwapp_add_test_data_to_article_catalog_and_brand_tables
 */
class m180505_041842_cttwapp_add_test_data_to_article_catalog_and_brand_tables extends Migration
{
    /**
     * @inheritdoc
     */
    public function safeUp()
    {
        // These are test records for catalog table in cttwapp_db

        // tbl: catalog

        // catalog test data
        $this->batchInsert('{{%catalog}}',
            ['id','name_cat','sp_desc','en_desc','created_at','updated_at','created_by','updated_by'],
            [
                ['11','PAQUETES DE FILMACIÓN','PAQUETES DE FILMACIÓN','FILMING PACKAGES','2018-05-05 00:00:00-00','2018-05-05 00:00:00-00',1,1],
                ['D','GENERADORES,GRUAS,CABLES,DOLLI','GENERADORES,GRUAS, DOLLIES, RIELES.','GENERATORS, CRANES, DOLLIES, RAILS.','2018-05-05 00:00:00-00','2018-05-05 00:00:00-00',1,1],
                ['L','LAMPARAS PARA REFLECTORES','LAMPARAS ROTAS, FUNDIDAS O VENTA DESDE 20 HASTA 18000 WATTS.','LAMPS BROKEN, MELTED OR SALE FROM 20 TO 18000 WATTS.','2018-05-05 00:00:00-00','2018-05-05 00:00:00-00',1,1],
                ['RA','ROLLOS ARRIFLEX','ROLLOS DE FILTRO ARRIFLEX EN GENERAL','ARRIFLEX FILTER ROLLS IN GENERAL','2018-05-05 00:00:00-00','2018-05-05 00:00:00-00',1,1],
            ]
        );

        // These are test records for brand table in cttwapp_db

        // tbl: brand

        // brand test data
        $this->batchInsert('{{%brand}}',
            ['id', 'brand_desc'],
            [
                ['1','ARRI'],
                ['2','ROSCO'],
                ['3','HONDA'],
                ['4','CTT'],
            ]
        );

        // These are test records for article table in cttwapp_db

        // tbl: article

        // article data
        $this->batchInsert('{{%article}}',
            ['id','name_art','sp_desc','en_desc','type_art','price_art','currency_art','brand_id','part_num','created_at','updated_at','created_by','updated_by','catalog_id'],
            [
                ['L10','LAMPARA SEGUIDOR 350 W.','350 W. 120 V. EZT MARC LAMPARA SEGUIDOR DE TEATRO','350 W. 120 V. EZT MARC LAMP FOLLOW SPOT LIGHT','V',30,'D','1','PN-6738722','2018-05-05 00:00:00-00','2018-05-05 00:00:00-00',1,1,'L'],
                ['L41','P 64 1000 MFLOOD','1,000 W. 120 V. FFR LAMPARA PAR 64 MEDIUM FLOOD','1,000 W. 120 V. FFR LAMP PAR 64 MEDIUM FLOOD','V',123,'D','1','PN-6738542','2018-05-05 00:00:00-00','2018-05-05 00:00:00-00',1,1,'L'],
                ['L46','LAMPARA 2,000 W CUARZO ABIERTO','2,000 W. 120 V. FEY LAMPARA ARRI CUARZO','2,000 W. 120 V. FEY ARRI QUARTZ LAMP','V',39,'D','1','PN-6785721','2018-05-05 00:00:00-00','2018-05-05 00:00:00-00',1,1,'L'],
                ['L74','FOTO 2 AZUL','500 W. 120 V. EBW FOTOLAMPARA NO. 2 AZUL','500 W. 120 V. EBW PHOTOLAMP NO. 2 BLUE','V',46,'D','1','PN-6738533','2018-05-05 00:00:00-00','2018-05-05 00:00:00-00', 1, 1, 'L'],

                ['RA124','DARK GREEN','ROLLO FILTRO ARRI 124 DARK GREEN','FILTER ROLL ARRI 124/ DARK GREEN','V',1800,'P','1','PN-78938722','2018-05-05 00:00:00-00','2018-05-05 00:00:00-00',1,1,'RA'],
                ['RA185','COSMETIC BURGUNDY','ROLLO FILTRO ROSCO 185 COSMETIC BURGUNDY','FILTER ROLL ARRI 185/ COSMETIC BURGUNDY','V',1800,'P','2','PN-78938122','2018-05-05 00:00:00-00','2018-05-05 00:00:00-00',1,1,'RA'],
                ['RA189','COSMETIC SILVER MOSS','ROLLO FILTRO ROSCO 189 COSMETIC SILVER MOSS','FILTER ROLL ARRI 189/ COSMETIC SILVER MOSS','V',1800,'P','2','PN-78900722','2018-05-05 00:00:00-00','2018-05-05 00:00:00-00', 1, 1,'RA'],
                ['RA213','WTE FLAME-WF/GREEN','ROLLO FILTRO ROSCO 213 / 3110 WHITE FLAME GREEN','FILTER ROLL ARRI 213/ ROSCO 3110- WTE FLAME-WF/GREEN','V',0,'P','2','PN-78938965','2018-05-05 00:00:00-00','2018-05-05 00:00:00-00',1, 1,'RA'],

                ['D30','PLANTA GEN.CABLES/DIESEL.','PLANTA GENERADORA 900-1200 AMPS.HILOS,SPIDERS,DIESEL.','GENERATOR PLANT 900-1200 AMPS. THREADS, SPIDERS, DIESEL.','R',5500,'P','3','PN-97838722','2018-05-05 00:00:00-00','2018-05-05 00:00:00-00',1,1,'D'],
                ['D31','PLANTA GEN.SOLA SIN DIESEL','PLANTA GENERADORA 900-1200 AMPS. (SOLA) 10 HRS.  SIN DIESEL','GENERATOR, A-C.900-1200 AMPS.10 HRS.LABOR WITHOUT DIESEL','R',3000,'P','3','PN-97838675','2018-05-05 00:00:00-00','2018-05-05 00:00:00-00',1,1,'D'],

                ['11B3','ARRICAM LITE  CON MÓVIL Y PLANTA','ARRICAM LITE  CON MÓVIL Y PLANTA','ARRICAM LITE  / MOBILE AND GENERATOR','R',25500,'P','1','PN-886756667','2018-05-05 00:00:00-00','2018-05-05 00:00:00-00',1,1,'11'],
                ['11B4','ARRICAM LITE 3 PERF CON MÓVIL Y PLANTA','ARRICAM LITE 3 PERF CON MÓVIL Y PLANTA','ARRICAM LITE 3 PERF / MOBILE AND GENERATOR','R',26500,'P','1','PN-886756542','2018-05-05 00:00:00-00','2018-05-05 00:00:00-00',1,1,'11'],
                ['11B5','ARRIFLEX 535 A/B CON MÓVIL Y PLANTA','ARRIFLEX 535 A/B CON MÓVIL Y PLANTA','ARRICAM 535 A/B / MOBILE AND GENERATOR','R',20000,'P','1','PN-886757422','2018-05-05 00:00:00-00','2018-05-05 00:00:00-00',1,1,'11'],
                ['11C4','ARRICAM LITE 3 PERF CON MINIMÓVIL Y PLAN','ARRICAM LITE 3 PERF CON MINIMÓVIL Y PLANTA','ARRICAMLITE 3 PERF / MINIMOBILE AND GENERATOR','R',25300,'P','1','PN-886799447','2018-05-05 00:00:00-00','2018-05-05 00:00:00-00',1,1,'11'],
                ['11C10','ARRIFLEX 416 PLUS CON  MINIMÓVIL Y PLANT','ARRIFLEX 416 PLUS CON  MINIMÓVIL Y PLANTA','ARRIFLEX 416 PLUS / MINIMOBILE AND GENERATOR','R',19000,'P','1','PN-886751234','2018-05-05 00:00:00-00','2018-05-05 00:00:00-00',1,1,'11'],
                ['11G1','FORO CTT FILMACIÓN','FORO CTT FILMACIÓN','CTT STAGE','R',14000,'P','4','N/D','2018-05-05 00:00:00-00','2018-05-05 00:00:00-00',1,1,'11'],
            ]
        );
    }

    /**
     * @inheritdoc
     */
    public function safeDown()
    {
        // 2018-05-05 : Using $this->truncateTable() method in this migration, cause that an error message was send,
        // because foreigner keys was defined in a relationship between tables article, catalog and brand.

        // This issue was resolved using the next method and an SQL statement :

        //                       $this->db->createCommand('TRUNCATE TABLE article CASCADE')->execute()

        // Originals methods  :  $this->truncateTable('{{%article}}'); // fk: id
        //                       $this->truncateTable('{{%catalog}}');
        //                       $this->truncateTable('{{%brand}}');

        $this->db->createCommand('TRUNCATE TABLE article CASCADE')->execute();
        $this->db->createCommand('TRUNCATE TABLE catalog CASCADE')->execute();
        $this->db->createCommand('TRUNCATE TABLE brand CASCADE')->execute();
    }
}
