<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_bidang_user extends MY_Model {

    protected $_table = 'v_bidang_dkpp';
    protected $_timestamps = TRUE;
    protected $_log_user = TRUE;
    protected $_softdelete = TRUE;
    protected $_order_by = 'id';
    protected $_order = 'ASC';
    protected $_fields_toshow = [
        'id', 'nama_jabatan', 'status'
    ];
    protected $_fields = [
       'id' => 'id',
    ];

    public function __construct()
    {
        parent::__construct();
    }

}

/* End of file M_bidang_user.php */
