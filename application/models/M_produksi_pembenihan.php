<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_produksi_pembenihan extends MY_Model {

    protected $_table = 'produksi_pembenihan';
    protected $_timestamps = TRUE;
    protected $_log_user = TRUE;
    protected $_softdelete = FALSE;
    protected $_order_by = 'id';
    protected $_order = 'DESC';
    protected $_fields_toshow = [
        'id', 'komoditas_id', 'rtp', 'induk_jantan','induk_betina','luas_lahan','produksi'
    ];
    protected $_fields = [
       'id' => 'id',
    ];

    public function __construct()
    {
        parent::__construct();
    }

    public function get_all_produksi_pembenihan()
    {
        parent::clear_join();

        $this->_fields_toshow = ['produksi_pembenihan.id', 'komoditas','jenis','rtp', 
        'induk_jantan','induk_betina', 'komoditas_id', 'luas_lahan','produksi', 'produksi_pembenihan.created_at'];

        parent::join('komoditas ','produksi_pembenihan.komoditas_id=komoditas.id');
        
        return $this;
    }

}

/* End of file M_produksi_pembenihan.php */
