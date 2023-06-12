<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Token_history extends CI_Migration {

    public function up()
    {
        $this->dbforge->add_field(array(
            'id' => array(
                'type' => 'INT4',
                'unsigned' => TRUE,
                'auto_increment' => TRUE
            ),
            'users_id' => array(
                'type' => 'INT4',
                'default' => null,
            ),
            'token' => array(
                'type' => 'VARCHAR',
                'constraint' => '30',
                'default' => null,
            ),
            'description' => array(
                'type' => 'VARCHAR',
                'constraint' => '255',
                'default' => null,
            ),
            'type' => array(
                'type' => 'VARCHAR',
                'constraint' => '255',
                'default' => null,
            ),
            'expired_date' => array(
                'type' => 'timestamp',
                'default' => null,
            ),
            'user_agent' => array(
                'type' => 'VARCHAR',
                'default' => null,
            ),
            'browser_agent' => array(
                    'type' => 'VARCHAR',
                    'default' => null,
            ),
            'version_agent' => array(
                    'type' => 'VARCHAR',
                    'default' => null,
            ),
            'platform_agent' => array(
                    'type' => 'VARCHAR',
                    'default' => null,
            ),
            'ip_address' => array(
                    'type' => 'VARCHAR',
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
        $this->dbforge->create_table('token_history');
    }

    public function down()
    {
        $this->dbforge->drop_table('token_history');
    }
}
?>