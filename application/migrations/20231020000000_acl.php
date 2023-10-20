<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Acl extends CI_Migration {

        public function up()
        {
                $this->dbforge->add_field(array(
                        'id' => array(
                                'type' => 'INT',
                                'unsigned' => TRUE,
                                'auto_increment' => TRUE
                        ),
                        'controller' => array(
                                'type' => 'VARCHAR',
                                'constraint' => '100',
                                'default' => null,
                        ),
                        'method' => array(
                                'type' => 'VARCHAR[]',
                                'default' => null,
                        ),
                        'url' => array(
                                'type' => 'VARCHAR',
                                'constraint' => '100',
                                'default' => null,
                        ),
                        'type' => array(
                                'type' => 'VARCHAR',
                                'constraint' => '100',
                                'default' => null,
                        ),
                        'level' => array(
                                'type' => 'INT4[]',
                                'default' => null,
                        ),
                        'title' => array(
                                'type' => 'VARCHAR',
                                'constraint' => '100',
                                'default' => null,
                        ),
                        'icon' => array(
                                'type' => 'VARCHAR',
                                'constraint' => '100',
                                'default' => null,
                        ),
                        'parent' => array(
                                'type' => 'INT4',
                                'default' => null,
                        ),
                        'position' => array(
                                'type' => 'INT4',
                                'default' => null,
                        ),
                        'isjson' => array(
                                'type' => 'INT4',
                                'default' => '0',
                        ),
                        'status' => array(
                                'type' => 'INT4',
                                'default' => '1',
                        ),
                ));
                $this->dbforge->add_key('id', TRUE);
                $this->dbforge->create_table('_acl');
        }

        public function down()
        {
                $this->dbforge->drop_table('_acl');
        }
}
?>