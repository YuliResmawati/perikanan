<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_struktur extends MY_Model {

    protected $_table = 'struktur';
    protected $_timestamps = TRUE;
    protected $_log_user = TRUE;
    protected $_softdelete = FALSE;
    protected $_order_by = 'created_at';
    protected $_order = 'DESC';
    protected $_fields_toshow = ['id','image','created_at', 'status'];
    protected $_fields = [
       'id' => 'id'
    ];

    public function __construct()
    {
        parent::__construct();
    }

}

/* End of file M_struktur.php */
