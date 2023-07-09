<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_kabupaten extends MY_Model {

    protected $_table = 'kabupaten';
    protected $_timestamps = TRUE;
    protected $_log_user = TRUE;
    protected $_softdelete = TRUE;
    protected $_order_by = 'id';
    protected $_order = 'ASC';
    protected $_fields_toshow = ['id','nama_kabupaten','status','provinsi_id'];
    protected $_fields = [
        'id' => 'id',
       'nama_kabupaten' => 'nama_kabupaten',
       'provinsi_id' => 'provinsi_id'
    ];

    public function __construct()
    {
        parent::__construct();
    }

    public function get_kabupaten_by_id($id)
    {
        parent::clear_join();
        $this->_timestamps = TRUE;
        $this->_log_user = TRUE;
        $this->_softdelete = TRUE;
        $this->_log_user = FALSE;
        $this->_primary_key = 'id';
        $this->_primary_filter = 'strval';
        $this->_fields_toshow = ['id','nama_kabupaten','status','provinsi_id'];
        $this->_fields = [
            'id' => 'id',
            'nama_kabupaten' => 'nama_kabupaten',
            'provinsi_id' => 'provinsi_id'
        ];

        $this->db->where('id', $id);

        return parent::find($id);
    }
}

/* End of file M_kabupaten.php */
