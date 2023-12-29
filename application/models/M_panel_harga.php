<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_panel_harga extends MY_Model {

    protected $_table = 'panel_harga';
    protected $_timestamps = TRUE;
    protected $_log_user = TRUE;
    protected $_softdelete = FALSE;
    protected $_order_by = 'id';
    protected $_order = 'DESC';
    protected $_fields_toshow = [
        'id', 'kecamatan_id', 'harga'
    ];
    protected $_fields = [
       'id' => 'id',
    ];

    public function __construct()
    {
        parent::__construct();
    }

    public function get_all_komoditas_by_kecamatan(){
        
        parent::clear_join();

        $this->_fields_toshow = ['panel_harga.id', 'komoditas', 'kecamatan_id','satuan','komoditas_id', 'harga', 'tanggal'];

        parent::join('komoditas ','panel_harga.komoditas_id=komoditas.id');
        

        return $this;
    }

}

/* End of file M_komoditas.php */
