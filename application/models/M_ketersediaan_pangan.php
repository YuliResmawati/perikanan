<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_ketersediaan_pangan extends MY_Model {

    protected $_table = 'ketersediaan_pangan';
    protected $_timestamps = TRUE;
    protected $_log_user = TRUE;
    protected $_softdelete = FALSE;
    protected $_order_by = 'id';
    protected $_order = 'DESC';
    protected $_fields_toshow = [
        'id', 'kecamatan_id', 'luas_tanam_padi', 'luas_puso_padi'
    ];
    protected $_fields = [
       'id' => 'id',
    ];

    public function __construct()
    {
        parent::__construct();
    }

    public function get_all_ketersediaan_pangan()
    {
        parent::clear_join();

        $this->_fields_toshow = ['ketersediaan_pangan.id', 'nama_kecamatan','luas_tanam_padi',
        'luas_puso_padi','kecamatan_id','ketersediaan_pangan.created_at'];

        parent::join('v_kecamatan ','ketersediaan_pangan.kecamatan_id=v_kecamatan.id');
        
        return $this;
    }

}

/* End of file M_ketersediaan_pangan.php */
