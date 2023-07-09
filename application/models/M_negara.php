<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_negara extends MY_Model {

    protected $_table = 'negara';
    protected $_timestamps = TRUE;
    protected $_log_user = TRUE;
    protected $_softdelete = TRUE;
    protected $_order_by = 'id';
    protected $_order = 'ASC';
    protected $_fields_toshow = ['id','nama_negara'];
    protected $_fields = [
        'id' => 'id',
       'nama_negara' => 'nama_negara'
    ];

    public function __construct()
    {
        parent::__construct();
    }

    public function get_negara_by_id($id)
    {
        parent::clear_join();
        $this->_timestamps = TRUE;
        $this->_log_user = TRUE;
        $this->_softdelete = TRUE;
        $this->_log_user = FALSE;
        $this->_primary_key = 'id';
        $this->_primary_filter = 'strval';
        $this->_fields_toshow = ['id','nama_negara','status'];
        $this->_fields = [
            'id' => 'id',
           'nama_negara' => 'nama_negara'
        ];

        $this->db->where('id', $id);

        return parent::find($id);
    }

}

/* End of file M_negara.php */
