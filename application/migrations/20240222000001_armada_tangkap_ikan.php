<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Armada_tangkap_ikan extends CI_Migration {

    public function up()
    {
        $this->dbforge->add_field(array(
            'id' => array(
                'type' => 'INT4',
                'unsigned' => TRUE,
                'auto_increment' => TRUE
            ),
            'armada' => array(
                'type' => 'INT4',
                'default' => null,
            ),
            'jumlah_a' => array(
                'type' => 'INT4',
                'default' => null,
            ),
            'alat_tangkap' => array(
                'type' => 'INT4',
                'default' => null,
            ),
            'jumlah_b' => array(
                'type' => 'INT4',
                'default' => null,
            ),
            'alat_bantu' => array(
                'type' => 'INT4',
                'default' => null,
            ),
            'jumlah_c' => array(
                'type' => 'INT4',
                'default' => null,
            ),
            'type' => array(
                'type' => 'INT4',
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
        $this->dbforge->create_table('armada_tangkap_ikan');
    }

    public function down()
    {
        $this->dbforge->drop_table('armada_tangkap_ikan');
    }
}

?>