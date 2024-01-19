<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_produksi_perikanan extends MY_Model {

    protected $_table = 'produksi_perikanan';
    protected $_timestamps = TRUE;
    protected $_log_user = TRUE;
    protected $_softdelete = TRUE;
    protected $_order_by = 'id';
    protected $_order = 'DESC';
    protected $_fields_toshow = [
        'id', 'komoditas_id', 'satuan', 'produksi'
    ];
    protected $_fields = [
       'id' => 'id',
    ];

    public function __construct()
    {
        parent::__construct();
    }

    public function get_all_produksi()
    {
        parent::clear_join();

        $this->_fields_toshow = ['produksi_perikanan.id', 'komoditas', 'kamus_data as nama_satuan', 'satuan' ,'produksi','jenis', 'komoditas_id'];

        parent::join('komoditas ','produksi_perikanan.komoditas_id=komoditas.id');
        parent::join('kamus_data ','produksi_perikanan.satuan=kamus_data.id');
        
        return $this;
    }

}

/* End of file M_produksi_perikanan.php */
