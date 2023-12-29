<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_bulan extends MY_Model {

    protected $_table = 'bulan';
    protected $_timestamps = TRUE;
    protected $_log_user = TRUE;
    protected $_softdelete = TRUE;
    protected $_order_by = 'id';
    protected $_order = 'ASC';
    protected $_fields_toshow = ['id', 'bulan'];
    protected $_fields = [
        'id' => 'id'
    ];

    public function __construct()
    {
        parent::__construct();
    }
}