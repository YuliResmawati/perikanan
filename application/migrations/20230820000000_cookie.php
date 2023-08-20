<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Cookie extends CI_Migration {

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
                        'cookie' => array(
                                'type' => 'VARCHAR',
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
                        'time_cookie' => array(
                                'type' => 'timestamp',
                                'default' => null,
                        ),
                        'cookie_expires' => array(
                                'type' => 'timestamp',
                                'default' => null,
                        ),
                        'last_login' => array(
                                'type' => 'timestamp',
                                'default' => null,
                        ),
                        'deleted' => array(
                                'type' => 'INT4',
                                'default' => null,
                        ),
                ));
                $this->dbforge->add_key('id', TRUE);
                $this->dbforge->create_table('cookie');
        }

        public function down()
        {
                $this->dbforge->drop_table('cookie');
        }
}
?>