<?php

use yii\db\Migration;

/**
 * Class m180303_174828_cttwapp_add_test_data_to_client_and_client_type_tables
 */
class m180303_174828_cttwapp_add_test_data_to_client_and_client_type_tables extends Migration
{
    /**
     * @inheritdoc
     */
    public function safeUp()
    {
       // This is records for user table in cttwapp_db

       // user data
       $this->batchInsert('{{%user}}',
           ['id','username','auth_key','password_hash','password_reset_token','email','status','created_at','updated_at'],
           [
               [1,'ggRicardo67','VME-eX2fUMhBKUmouNLnxf2DYTB9rI7_','$2y$13$3J0Dy8dSiRVwVuOEKtBis.b.xG/Ll.2Zl8mSk7KLcY7mzLg6w2I7W','NULL', 'ricardo.gonzalez@itcelaya.edu.mx', 10, 1498607808, 1498607808],
               [2,'CTT1GG','TUVyGz98PPtuE1mtaS50HPOctesT2j2H','$$2y$13$6UkRvFjjrEt56YRTRNK4f.TlLCFW2chGzldl2gqHwoMvtmlkLSFo2','NULL', 'direccion@cttrentals.com', 10, 1518472527, 1518472527],
           ]
       );

       // This is records for client_type table in cttwapp_db

       // client_type test data
       $this->batchInsert('{{%client_type}}',
                                ['id','type_desc'],
                                [
                                  [1,'Activo-Frecuente'],
                                  [2,'Activo-Poco Frecuente'],
                                  [3,'Nuevo'],
                                  [4,'En recuperación'],
                                  [5,'Internacional']
                                ]
       );
       // client test data
       $this->batchInsert('{{%client}}',
                                ['id','rfc','curp','moral','first_name','paternal_name','maternal_name','created_at','updated_at','created_by','updated_by','client_type_id'],
                                [
                                  [1,'GOGR811003GT5','GOGR811003HDFNNFTR','t','FERNANDO', 'MARTÍNEZ', 'GONZÁLEZ','2018-02-04 00:00:00-06','2018-02-04 00:00:00-06', 1, 1, 1],
                                  [2,'JIGR811017PT3','JIGR811017PT3HDF7K','f','ROBERTO', 'JIMENEZ', 'GARCÍA','2018-02-11 00:00:00-06','2018-02-11 00:00:00-06', 1, 1, 5],
                                  [3,'HEGA511224PL3','HEGA511224PL3HDF54','f','ALBERTO', 'HERÁNDEZ', 'GARCÍA','2018-02-05 00:00:00-06','2018-02-11 00:00:00-06', 1, 1, 3],
                                  [4,'MARR760817TM5','MARR760817TM5MDF65','f','ROSA MARÍA', 'MARTÍNEZ', 'ROBLES','2018-02-05 00:00:00-06','2018-02-05 00:00:00-06', 1, 1, 5],
                                  [5,'ALFJ910503HY7','ALFJ910503HY7KUTR', 'f','JAIME', 'ÁLVAREZ', 'FELIX','2018-02-07 00:00:00-06','2018-02-07 00:00:00-06', 1, 1, 2]
                                ]
       );
    }

    /**
     * @inheritdoc
     */
    public function safeDown()
    {
        // 2018-03-05 : Using $this->truncateTable() method in this migration, caused an error message was send,
        // because foreigner keys was defined in a relationship between tables client and client_type.

        // This issue was resolved using the next method and an SQL statement :

        //                       $this->db->createCommand('TRUNCATE TABLE client CASCADE')->execute()

        // Originals methods  :  $this->truncateTable('{{%client}}'); // fk: id
        //                       $this->truncateTable('{{%client_type}}');
        //                       $this->truncateTable('{{%user}}');

        $this->db->createCommand('TRUNCATE TABLE client CASCADE')->execute();
        $this->db->createCommand('TRUNCATE TABLE client_type CASCADE')->execute();
        $this->db->createCommand('TRUNCATE TABLE user')->execute();
    }
}
