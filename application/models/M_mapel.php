<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_mapel extends MY_Model {

    protected $_table = 'mapel';
    protected $_timestamps = TRUE;
    protected $_log_user = TRUE;
    protected $_softdelete = TRUE;
    protected $_order_by = 'nama_mapel';
    protected $_order = 'ASC';
    protected $_fields_toshow = ['id', 'nama_mapel','type'];
    protected $_fields = [
        'nama_mapel'    => 'nama_mapel',
        'type'          => 'type'
    ];

    public function __construct()
    {
        parent::__construct();
    }


}

/* End of file M_kecamatan.php */