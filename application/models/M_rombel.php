<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_rombel extends MY_Model {

    protected $_table = 'rombel';
    protected $_timestamps = TRUE;
    protected $_log_user = TRUE;
    protected $_softdelete = TRUE;
    protected $_order_by = 'tingkatan';
    protected $_order = 'ASC';
    protected $_fields_toshow = ['id','nama_rombel','tingkatan'];
    protected $_fields = [
       'nama_rombel'     => 'nama_rombel',
       'tingkatan'       => 'tingkatan'
    ];

    public function __construct()
    {
        parent::__construct();
    }


}

/* End of file M_sample_upload.php */
