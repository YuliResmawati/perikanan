<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_wilayah extends MY_Model {

    protected $_table = 'simpeg.kecamatan';
    protected $_order_by = 'id';
    protected $_order = 'DESC';
    protected $_softdelete = TRUE;
    protected $_timestamps = TRUE;
    protected $_log_user = TRUE;
    protected $_fields_toshow = ['id','nama_kecamatan'];
    protected $_fields = [
        'id' => 'id',
    ];

    public function __construct()
    {
        parent::__construct();
    }

    public function get_kecamatan()
    {
        parent::clear_join();

        $this->_fields_toshow = ['id', 'nama_kecamatan','status'];

        return $this;
    }
    
}

/* End of file M_kecamatan.php */