<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_pengaduan extends MY_Model {

    protected $_table = 'pengaduan';
    protected $_timestamps = TRUE;
    protected $_log_user = TRUE;
    protected $_softdelete = TRUE;
    protected $_order_by = 'id';
    protected $_order = 'DESC';
    protected $_fields_toshow = [
        'id', 'nama', 'isi_pengaduan','email','no_hp'
    ];
    protected $_fields = [
       'id' => 'id',
    ];

    public function __construct()
    {
        parent::__construct();
    }

}

/* End of file M_pengaduan.php */
