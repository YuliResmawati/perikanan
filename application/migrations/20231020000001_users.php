<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Users extends CI_Migration {

        public function up()
        {
                $this->dbforge->add_field(array(
                        'id' => array(
                                'type' => 'INT4',
                                'unsigned' => TRUE,
                                'auto_increment' => TRUE
                        ), 
                        'sekolah_id' => array(
                                'type' => 'INT4',
                                'default' => null
                        ),
                        'username' => array(
                                'type' => 'VARCHAR',
                                'default' => null,
                        ),
                        'password' => array(
                                'type' => 'VARCHAR',
                                'default' => null,
                        ),
                        'level' => array(
                                'type' => 'INT4',
                                'constraint' => '1',
                                'default' => null,
                        ),
                        'recovery' => array(
                                'type' => 'VARCHAR',
                                'default' => null,
                        ),
                        'display_name' => array(
                                'type' => 'VARCHAR',
                                'default' => null,
                        ),
                        'email' => array(
                                'type' => 'VARCHAR',
                                'default' => null,
                        ),
                        'avatar' => array(
                                'type' => 'TEXT',
                                'default' => null,
                        ),
                        'token' => array(
                                'type' => 'VARCHAR',
                                'constraint' => '255',
                                'default' => null,
                        ),
                        'last_login' => array(
                                'type' => 'timestamp',
                                'default' => null,
                        ),
                        'last_ip_login' => array(
                                'type' => 'VARCHAR',
                                'constraint' => '255',
                                'default' => null,
                        ),
                        'last_password_reset' => array(
                                'type' => 'timestamp',
                                'default' => null,
                        ),
                        'reason_disabled' => array(
                                'type' => 'TEXT',
                                'default' => null,
                        ),
                        'is_email_active' => array(
                                'type' => 'INT4',
                                'default' => null,
                        ),
                        'disabled_at' => array(
                                'type' => 'timestamp',
                                'default' => null,
                        ),
                        'disabled_by' => array(
                                'type' => 'INT4',
                                'default' => null,
                        ),
                        'enabled_at' => array(
                                'type' => 'timestamp',
                                'default' => null,
                        ),
                        'enabled_by' => array(
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
                                'type' => 'INT4',
                                'default' => null,
                        ),
                ));
                $this->dbforge->add_key('id', TRUE);
                $this->dbforge->create_table('users');
        }

        public function down()
        {
                $this->dbforge->drop_table('users');
        }
}
?>