<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_kamus_data extends MY_Model {

    protected $_table = 'kamus_data';
    protected $_timestamps = TRUE;
    protected $_log_user = TRUE;
    protected $_softdelete = TRUE;
    protected $_order_by = 'id';
    protected $_order = 'ASC';
    protected $_fields_toshow = ['id', 'kamus_data', 'type'];
    protected $_fields = [
        'id' => 'id'
    ];

    public function __construct()
    {
        parent::__construct();
    }

    public function get_all_satuan(){
        
        parent::clear_join();

        $this->_fields_toshow = ['id', 'kamus_data'];
        $this->db->where(['type' => 'Satuan']);

        return $this;
    }

    public function get_all_media(){
        
        parent::clear_join();

        $this->_fields_toshow = ['id', 'kamus_data'];
        $this->db->where(['type' => 'Media']);

        return $this;
    }
}