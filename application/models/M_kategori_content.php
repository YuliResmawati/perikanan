<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_kategori_content extends MY_Model {

    protected $_table = 'kategori_konten';
    protected $_timestamps = TRUE;
    protected $_log_user = TRUE;
    protected $_softdelete = TRUE;
    protected $_order_by = 'id';
    protected $_order = 'DESC';
    protected $_fields_toshow = [
        'id', 'nama_kategori', 'status'
    ];
    protected $_fields = [
       'id' => 'id',
    ];

    public function __construct()
    {
        parent::__construct();
    }

}

/* End of file M_kategori_content.php */
