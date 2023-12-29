<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_panel_harga_ikan extends MY_Model {

    protected $_table = 'panel_harga_ikan';
    protected $_timestamps = TRUE;
    protected $_log_user = TRUE;
    protected $_softdelete = TRUE;
    protected $_order_by = 'id';
    protected $_order = 'ASC';
    protected $_fields_toshow = ['id', 'komoditas_id','harga'];
    protected $_fields = [
        'id' => 'id'
    ];

    public function __construct()
    {
        parent::__construct();
    }

    public function get_all_panel_ikan(){
        
        parent::clear_join();

        $this->_fields_toshow = ['panel_harga_ikan.id', 'komoditas', 'satuan','komoditas_id', 'harga', 'tanggal','jenis'];

        parent::join('komoditas ','panel_harga_ikan.komoditas_id=komoditas.id');
        

        return $this;
    }
}