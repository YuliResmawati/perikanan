<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_guru extends MY_Model {

    protected $_table = 'guru';
    protected $_timestamps = TRUE;
    protected $_log_user = TRUE;
    protected $_softdelete = TRUE;
    protected $_order_by = 'id';
    protected $_order = 'ASC';
    protected $_fields_toshow = ['id','nama_guru','nip'];
    protected $_fields = [
       'id'               => 'id'
    ];

    public function __construct()
    {
        parent::__construct();
    }

}

/* End of file M_sample_upload.php */
