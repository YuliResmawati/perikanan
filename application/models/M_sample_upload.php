<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_sample_upload extends MY_Model {

    protected $_table = 'sample_upload';
    protected $_timestamps = TRUE;
    protected $_log_user = TRUE;
    protected $_softdelete = FALSE;
    protected $_order_by = 'created_at';
    protected $_order = 'DESC';
    protected $_fields_toshow = ['id','judul','deskripsi','files', 'created_at'];
    protected $_fields = [
       'judul' => 'judul',
       'deskripsi' => 'deskripsi',
    ];

    public function __construct()
    {
        parent::__construct();
    }

}

/* End of file M_sample_upload.php */
