<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Detail_rombel extends CI_Migration {

    public function up()
    {
        $this->dbforge->add_field(array(
            'id' => array(
                'type' => 'INT4',
                'unsigned' => TRUE,
                'auto_increment' => TRUE
            ),
            'rombel_id' => array(
                'type' => 'INT4',
                'default' => null
            ),
            'sekolah_id' => array(
                'type' => 'INT4',
                'default' => null
            ),
            'walas_id' => array(
                'type' => 'INT4',
                'default' => null
            ),
            'tahun_ajaran_id' => array(
                'type' => 'INT4',
                'default' => null
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
        $this->dbforge->create_table('detail_rombel');
    }

    public function down()
    {
        $this->dbforge->drop_table('detail_rombel');
    }
}
?>