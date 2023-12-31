<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Konten extends CI_Migration {

    public function up()
    {
        $this->dbforge->add_field(array(
            'id' => array(
                'type' => 'INT4',
                'unsigned' => TRUE,
                'auto_increment' => TRUE
            ),
            'kategori_konten_id' => array(
                'type' => 'INT4',
                'default' => null,
            ),
            'judul_konten' => array(
                'type' => 'TEXT',
                'default' => null,
            ),
            'isi_konten' => array(
                'type' => 'TEXT',
                'default' => null,
            ),
            'tgl_konten' => array(
                'type' => 'timestamp',
                'default' => null,
            ),
            'slug' => array(
                'type' => 'VARCHAR',
                'constraint' => '100',
                'default' => null,
            ),
            'hits' => array(
                'type' => 'INT4',
                'default' => null,
            ),
            'berkas' => array(
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
        $this->dbforge->create_table('konten');
    }

    public function down()
    {
        $this->dbforge->drop_table('konten');
    }
}

?>