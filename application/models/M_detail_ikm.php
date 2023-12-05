<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_detail_ikm extends MY_Model {

    protected $_table = 'detail_ikm';
    protected $_timestamps = TRUE;
    protected $_log_user = TRUE;
    protected $_softdelete = TRUE;
    protected $_order_by = 'id';
    protected $_order = 'DESC';
    protected $_fields_toshow = [
        'id','ikm_id', 'kategori_ikm_id','status'
    ];
    protected $_fields = [
       'id' => 'id',
    ];

    public function __construct()
    {
        parent::__construct();
    }

}

/* End of file M_detail_ikm.php */
