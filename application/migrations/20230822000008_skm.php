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
            'name' => array(
                'type' => 'VARCHAR',
                'constraint' => '255',
                'default' => null,
            ),
            'age' => array(
                'type' => 'INT4',
                'default' => null,
            ),
            'phone_number' => array(
                'type' => 'VARCHAR',
                'constraint' => '30',
                'default' => null,
            ),
            'suggestion' => array(
                'type' => 'TEXT',
                'default' => null,
            ),
            'gender' => array(
                'type' => 'VARCHAR',
                'constraint' => '2',
                'default' => null,
            ),
            'education' => array(
                'type' => 'VARCHAR',
                'constraint' => '100',
                'default' => null,
            ),
            'rate' => array(
                'type' => 'FLOAT4',
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