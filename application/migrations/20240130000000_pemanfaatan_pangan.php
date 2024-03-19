<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Pemanfaatan_pangan extends CI_Migration {

    public function up()
    {
        $this->dbforge->add_field(array(
            'id' => array(
                'type' => 'INT4',
                'unsigned' => TRUE,
                'auto_increment' => TRUE
            ),
            'kecamatan_id' => array(
                'type' => 'VARCHAR',
                'constraint' => '100',
                'default' => null,
            ),
            'bb_sangat_kurang' => array(
                'type' => 'INT4',
                'default' => null,
            ),
            'bb_kurang' => array(
                'type' => 'INT4',
                'default' => null,
            ),
            'bb_normal' => array(
                'type' => 'INT4',
                'default' => null,
            ),
            'risiko_bb_lebih' => array(
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
        $this->dbforge->create_table('pemanfaatan_pangan');
    }

    public function down()
    {
        $this->dbforge->drop_table('pemanfaatan_pangan');
    }
}

?>