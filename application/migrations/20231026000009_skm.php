<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Skm extends CI_Migration {

    public function up()
    {
        $this->dbforge->add_field(array(
            'id' => array(
                'type' => 'INT4',
                'unsigned' => TRUE,
                'auto_increment' => TRUE
            ),
            'nama' => array(
                'type' => 'VARCHAR',
                'constraint' => '255',
                'default' => null,
            ),
            'email' => array(
                'type' => 'VARCHAR',
                'constraint' => '255',
                'default' => null,
            ),
            'jenis_kelamin' => array(
                'type' => 'VARCHAR',
                'constraint' => '2',
                'default' => null,
            ),
            'pendidikan' => array(
                'type' => 'INT4',
                'default' => null,
            ),
            'pekerjaan' => array(
                'type' => 'INT4',
                'default' => null,
            ),
            'usia' => array(
                'type' => 'INT4',
                'default' => null,
            ),
            'keterangan' => array(
                'type' => 'VARCHAR',
                'constraint' => '2',
                'default' => null,
            ),
            'created_at' => array(
                'type' => 'timestamp',
                'default' => null,
            ),
            'created_by' => array(
                'type' => 'INT4',
                'default' => null,
            ),
            'updated_at' => array(
                'type' => 'timestamp',
                'default' => null,
            ),
            'updated_by' => array(
                'type' => 'INT4',
                'default' => null,
            ),
            'deleted_at' => array(
                'type' => 'timestamp',
                'default' => null,
            ),
            'deleted_by' => array(
                'type' => 'INT4',
                'default' => null,
            ),
            'deleted' => array(
                'type' => 'VARCHAR',
                'constraint' => '1',
                'default' => null,
            ),
            'status' => array(
                'type' => 'VARCHAR',
                'constraint' => '1',
                'default' => null,
            ),      
        ));

        $this->dbforge->add_key('id', TRUE);
        $this->dbforge->create_table('skm');
    }

    public function down()
    {
        $this->dbforge->drop_table('skm');
    }
}

?>