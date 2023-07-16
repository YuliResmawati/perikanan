<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_tahun_ajaran extends MY_Model {

    protected $_table = 'tahun_ajaran';
    protected $_timestamps = TRUE;
    protected $_log_user = TRUE;
    protected $_softdelete = TRUE;
    protected $_order_by = 'id';
    protected $_order = 'ASC';
    protected $_fields_toshow = ['id', 'tahun_ajaran'];
    protected $_fields = [
        'tahun_ajaran'    => 'tahun_ajaran'
    ];

    public function __construct()
    {
        parent::__construct();
    }


}

/* End of file M_kecamatan.php */