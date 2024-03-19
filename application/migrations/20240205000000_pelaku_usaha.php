<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Pelaku_Usaha extends CI_Migration {

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
            'nama_pelaku' => array(
                'type' => 'VARCHAR',
                'constraint' => '225',
                'default' => null,
            ),
            'telp' => array(
                'type' => 'VARCHAR',
                'constraint' => '20',
                'default' => null,
            ),
            'email' => array(
                'type' => 'VARCHAR',
                'constraint' => '100',
                'default' => null,
            ),
            'bidang' => array(
                'type' => 'INT4',
                'default' => null,
            ),
            'skala' => array(
                'type' => 'INT4',
                'default' => null,
            ),
            'jumlah_karyawan' => array(
                'type' => 'INT4',
                'default' => null,
            ),
            'alamat' => array(
                'type' => 'TEXT',
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
        $this->dbforge->create_table('pelaku_usaha');
    }

    public function down()
    {
        $this->dbforge->drop_table('pelaku_usaha');
    }
}

?>