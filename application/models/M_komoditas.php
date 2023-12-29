<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_komoditas extends MY_Model {

    protected $_table = 'komoditas';
    protected $_timestamps = TRUE;
    protected $_log_user = TRUE;
    protected $_softdelete = TRUE;
    protected $_order_by = 'id';
    protected $_order = 'DESC';
    protected $_fields_toshow = [
        'id', 'komoditas', 'jenis'
    ];
    protected $_fields = [
       'id' => 'id',
    ];

    public function __construct()
    {
        parent::__construct();
    }

    public function get_all_komoditas_bahan_pokok(){
        
        parent::clear_join();

        $this->_fields_toshow = ['id', 'komoditas','status'];
        $this->db->where(['jenis' => '3']);

        return $this;
    }

    public function get_all_komoditas_ikan(){
        
        parent::clear_join();

        $this->_fields_toshow = ['id', 'komoditas','status'];
        $this->db->where(['jenis !=' => '3']);

        return $this;
    }

}

/* End of file M_komoditas.php */
