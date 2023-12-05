<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_gallery extends MY_Model {

    protected $_table = 'gallery';
    protected $_timestamps = TRUE;
    protected $_log_user = TRUE;
    protected $_softdelete = FALSE;
    protected $_order_by = 'id';
    protected $_order = 'DESC';
    protected $_fields_toshow = [
        'id', 'judul', 'image', 'link', 'type', 'keterangan'
    ];
    protected $_fields = [
        'id' => 'id',
    ];

    public function __construct()
    {
        parent::__construct();
    }

}

/* End of file M_gallery.php */
