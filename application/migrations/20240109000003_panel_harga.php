<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Panel_harga extends CI_Migration {

    public function up()
    {
        $this->dbforge->add_field(array(
            'id' => array(
                'type' => 'INT4',
                'unsigned' => TRUE,
                'auto_increment' => TRUE
            ),
            'komoditas_id' => array(
                'type' => 'INT4',
                'default' => null,
            ),
            'kecamatan_id' => array(
                'type' => 'VARCHAR',
                'constraint' => '100',
                'default' => null,
            ),
            'harga' => array(
                'type' => 'INT4',
                'default' => null,
            ),
            'satuan' => array(
                'type' => 'INT4',
                'default' => null,
            ),
            'tanggal' => array(
                'type' => 'date',
                'default' => null,
            ),
            'type' => array(
                'type' => 'VARCHAR',
                'constraint' => '1',
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
        $this->dbforge->create_table('panel_harga');
    }

    public function down()
    {
        $this->dbforge->drop_table('panel_harga');
    }
}

?>