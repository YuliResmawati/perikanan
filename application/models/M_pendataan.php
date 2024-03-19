<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_pendataan extends MY_Model {

    protected $_table = 'pendataan';
    protected $_timestamps = TRUE;
    protected $_log_user = TRUE;
    protected $_softdelete = FALSE;
    protected $_order_by = 'id';
    protected $_order = 'DESC';
    protected $_fields_toshow = [
        'id','pelaku_usaha_id', 'kusioner_id','opsi','nama_petugas','bidang'
    ];
    protected $_fields = [
       'id' => 'id',
    ];

    public function __construct()
    {
        parent::__construct();
    }


    public function get_all_pendataan()
    {
        parent::clear_join();

        $this->_fields_toshow = ['pendataan.id', 'kusioner','opsi','pelaku_usaha_id','komoditas'];

        parent::join('kusioner ','pendataan.kusioner_id=kusioner.id');
        parent::join('komoditas ','pendataan.komoditas_id=komoditas.id');
        // $this->db->where(['pelaku_usaha_id' => $pelaku]);
        
        return $this;
    }

}

/* End of file M_pendataan.php */
