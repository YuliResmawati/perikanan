<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_wilayah extends MY_Model {

    protected $_table = 'v_kecamatan';
    protected $_order_by = 'id';
    protected $_order = 'DESC';
    protected $_softdelete = TRUE;
    protected $_timestamps = TRUE;
    protected $_log_user = TRUE;
    protected $_fields_toshow = ['id','nama_kecamatan'];
    protected $_fields = [
        'id' => 'id',
    ];

    public function __construct()
    {
        parent::__construct();
    }

    public function get_kecamatan()
    {
        parent::clear_join();

        $this->_fields_toshow = ['id', 'nama_kecamatan','status'];

        return $this;
    }

    public function get_all_kecamatan()
    {
        
        parent::clear_join();

        $this->_fields_toshow = ['id', 'nama_kecamatan','status'];
        $this->db->where(['kabupaten_id' => '1306']);

        return $this;
    }


    public function get_all_panel_kecamatan()
    {
        parent::clear_join();

        $this->_fields_toshow = [
            "id", "nama_kecamatan",
            "(select count(komoditas_id) from panel_harga where kecamatan_id=v_kecamatan.id) as total_panel",
        ];
        
        return $this;
    }
    
}

/* End of file M_kecamatan.php */