<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_kusioner extends MY_Model {

    protected $_table = 'kusioner';
    protected $_timestamps = TRUE;
    protected $_log_user = TRUE;
    protected $_softdelete = TRUE;
    protected $_order_by = 'id';
    protected $_order = 'DESC';
    protected $_fields_toshow = [
        'id','kusioner', 'type','jenis_opsi'
    ];
    protected $_fields = [
       'id' => 'id',
    ];

    public function __construct()
    {
        parent::__construct();
    }

}

/* End of file M_kusioner.php */
