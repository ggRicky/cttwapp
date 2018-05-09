<?php

use yii\db\Migration;

/**
 * Class m180505_235237_cttwapp_refactoring_test_data_for_client_table
 */
class m180505_235237_cttwapp_refactoring_test_data_for_client_table extends Migration
{
    public function safeUp()
    {
        // tbl: client

        // 2018-05-05 : Add the new column considerations in client table.
        $this->addColumn('{{%client}}', 'considerations', 'string(100) NOT NULL DEFAULT(\'N/D\')');

        // 2018-05-05 : Remove old test data for client table
        $this->truncateTable('{{%client}}'); // fk: id

        // 2018-05-05 : Add the new test data for client table
        $this->batchInsert('{{%client}}',
            ['id','rfc','curp','taxpayer','business_name','corporate','provenance','contact_name','contact_email','street','outdoor_number','interior_number','suburb','municipality','delegation','state','zip_code','phone_number_1','phone_number_2','web_page','client_email','considerations','created_at','updated_at','created_by','updated_by','client_type_id'],
            [
                ['C17','ASI920928M64','N/D','M','CARAVANA UNO, S.A. DE C.V.','INDEPENDIENTE','N','FERNANDO URIARTE PALACIOS','ferupal@gmail.com','EMILIO CARDENAS','148','N/D','FRACCIONAMIENTO INDUSTRIAL TLALNEPANTLA','EDO. DE MEX','N/D','ESTADO DE MÉXICO','54030','5321-0900','5679-7097','N/D','caravana1@gmail.com','REV:MAR Y MIER DE 4:30 A 6 PAGOS VIERNES DE 16:00 PM A 18:00','2018-05-05 00:00:00-06','2018-05-05 00:00:00-06',1,1,1],
                ['D02','DFI021220FH5','N/D','M','DISTRITO FILMS, S.A. DE C.V.','INDEPENDIENTE','N','SANDRA ROBLES MARTÍNEZ','sandyro@yahoo.com','LAGO TANGAÑICA','23','N/D','GRANADA DEL LAGO','CDMX','MIGUEL HIDALGO','CDMX','11520','3003-2150','3003-2152','N/D','salvarado@distritofilms.com','PAGO VIERNES 15:00 AM 17:00 PM','2018-05-05 00:00:00-06','2018-05-05 00:00:00-06',1,1,2],
                ['D03','DIR0206256I3','N/D','M','DIRECTRA, S.A. DE C.V.','TELEVISA MTY','N','RAFAEL GONZÁLEZ TREVIÑO','rafagon@msn.com','AV. LAZARO CARDENAS','2321','N/D','CENTRO','SAN PEDRO GARZA GARCIA','MONTERREY','NUEVO LEÓN','66200','5148-7000','N/D','N/D','directra@yahoo.com','PAGO VIERNES DE 10:00 AM A 2:00 PM  REV: 10 A 2:00 PM','2018-05-05 00:00:00-06','2018-05-05 00:00:00-06',1,1,1],
                ['L01','TIM920730RJ5','N/D','M','LA TIENDA DE LA IMAGEN, S.A. DE C.V.','IMAGEN TV','N','ROCIO URIOSTEGUI RIVAS','rurir81@gmail.com','MAZATLAN','15A','INT. 5','CONDESA','CDMX','CUAUHTEMOC','CDMX','06140','5662-3590','5662-7534','N/D','timlatienda@terra.com.mx','REV:MARTES 4 A 5:30 PM PAGOS MIER DE 16:00 PM A 17:30 PM','2018-05-05 00:00:00-06','2018-05-05 00:00:00-06',1,1,3],
                ['R02','RCT991108F71','N/D','M','REVOLUTION 435 D & C S.A. DE C.V.','INDEPENDIENTE','N','FERNANDO HERNÁNDEZ JUÁREZ','revo1999@prodigy.net.mx','AV. POPOCATEPETL','176','N/D','GENERAL ANAYA','CDMX','BENITO JUÁREZ','CDMX','03340','5605-8060','5605-8260','N/D','revo1999@prodigy.net.mx','PAGO VIERNES 15:00 AM 17:00 PM','2018-05-05 00:00:00-06','2018-05-05 00:00:00-06',1,1,5],
                ['R01','RIM801015HI4','N/D','M','RENTA IMAGEN, S.A. DE C.V.','IMAGEN TV','N','JUAN CARLOS OLIVEROS CABRERA','juancoc@prodigy.net.mx','AV. 5 DE MAYO','492','N/D','MERCED GOMEZ','CDMX','ALVARO OBREGÓN','CDMX','01600','5593-9337','5593-9331','www.centro.com','rentaimagen@prodigy.net.mx','PAGO MIERCOLES DE 16:00 PM A 18:00 PM','2018-05-05 00:00:00-06','2018-05-05 00:00:00-06',1,1,3],
                ['S76','SYP860815L32','N/D','M','SERGIO YAZBEK PRODUCCIONES S.A. DE C.V.','INDEPENDIENTE','N','FERNANDO ELIZÓNDO VALADÉZ','ferelival@prodigy.net.mx','JOAQUIN A PEREZ','6','N/D','SAN MIGUEL CHAPULTEPEC','CDMX','MIGUEL HIDALGO','CDMX','11850','5273-3101','N/D','N/D','sergioyaz@yahoo.com','REVISION: VIERNES 9  A 16 HRS.  PAGOS MIER. 9 A 16 HRS.','2018-05-05 00:00:00-06','2018-05-05 00:00:00-06',1,1,2],
                ['U06','UNA2907227Y5','N/D','M','UNIVERSIDAD NACIONAL AUTONOMA DE MEXICO','INDEPENDIENTE','N','ROBERTO CARLOS VEGA IBARRA','robertcarl@gmail.com','AV. UNIVERSIDAD','3000','N/D','UNAM CU','CDMX','COYOACAN','CDMX','04510','5687-0696','5536-1799','N/D','upcine@unam.edu.mx','REVISION: JUEVES  4  A  6  PAGOS:VIERNES   DE 4  A 6','2018-05-05 00:00:00-06','2018-05-05 00:00:00-06',1,1,1],
                ['T10','TEL721214GK7','N/D','M','TELEVISA, S.A. DE C.V.','TELEVISA','N','EMILIO ZAMPER ROCHA','emizamp@televisa.com','VASCO DE QUIROGA','2000','N/D','SANTA FE','CDMX','ALVARO OBREGÓN','CDMX','01210','5728-3761','N/D','N/D','uproduccion@televisa.com','REV: LUNES DE 9  A  2 PM  PAGOS: LUNES 4  A  6 PM','2018-05-05 00:00:00-06','2018-05-05 00:00:00-06',1,1,4],
                ['T03','TAZ960904V78','N/D','M','TV AZTECA, S.A. DE C.V.','TV AZTECA','N','LEOPOLDO GÓMEZ DE LA CORTINA','leogc@tvazteca.com','PERIFERICO SUR','4121','N/D','FUENTES DEL PEDREGAL','CDMX','MIGUEL HIDALGO','CDMX','14141','17201313','N/D','N/D','azteca_digital@tvazteca.com','REV:MARTES 4 A 5:30 PM PAGOS MIER DE 16:00 PM A 17:30 PM','2018-05-05 00:00:00-06','2018-05-05 00:00:00-06',1,1,3],
                ['M10','MPR031020923','N/D','M','MINOTAURO PRODUCCIONES S.A. DE C.V.','INDEPENDIENTE','N','JULIAN ÁLVAREZ FÉLIX','julafx@prodigy.net.mx','AV. LOS ANDES','350','N/D','LOMAS DE CHAPULTEPEC','CDMX','MIGUEL HIDALGO','CDMX','11000','5531-2746','5531-2739','N/D','minotaurop@yahoo.com','PAGO VIERNES 15:00 AM 17:00 PM','2018-05-05 00:00:00-06','2018-05-05 00:00:00-06',1,1,4],
                ['E18','ECA501108P74','N/D','M','ESTUDIOS CHURUBUSCO AZTECA S.A. DE C.V.','TV AZTECA','N','ROLANDO MONTENEGRO GIL','rolmonte@tvazteca.com','ATLETAS','2','N/D','COUNTRY CLUB','CDMX','COYOACAN','CDMX','04220','5549-3060 EXT.1','N/D','N/D','echurubusco@azteca.com','PAGO VIERNES 15:00 AM 17:00 PM','2018-05-05 00:00:00-06','2018-05-05 00:00:00-06',1,1,2],
            ]
        );
    }

    public function safeDown()
    {
        // tbl: client

        // 2018-05-05 : Remove unneeded column tax_residence from client table.
        $this->dropColumn('{{%client}}', 'considerations');

        $this->truncateTable('{{%client}}'); // fk: id

        echo "The client table is empty now ...\n";
    }
}
