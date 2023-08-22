<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_skm extends MY_Model {

    protected $_table = 'skm';
    protected $_timestamps = TRUE;
    protected $_log_user = TRUE;
    protected $_softdelete = TRUE;
    protected $_order_by = 'id';
    protected $_order = 'DESC';
    protected $_fields_toshow = [
        'name', 'age','phone_number','suggestion','rate','gender','education'
    ];
    protected $_fields = [
       'name' => 'name',
       'age' => 'age',
       'phone_number' => 'phone_number',
       'suggestion' => 'suggestion',
       'rate' => 'rate',
       'gender' => 'gender',
       'education' => 'education'
    ];

    public function __construct()
    {
        parent::__construct();
    }

}

/* End of file M_website.php */
