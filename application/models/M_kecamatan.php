<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_kecamatan extends MY_Model {

    protected $_table = 'kecamatan';
    protected $_timestamps = TRUE;
    protected $_log_user = TRUE;
    protected $_softdelete = TRUE;
    protected $_order_by = 'id';
    protected $_order = 'ASC';
    protected $_fields_toshow = ['id', 'kabupaten_id', 'nama_kecamatan','status'];
    protected $_fields = [
        'id' => 'id',
        'kabupaten_id'    => 'kabupaten_id',
        'nama_kecamatan'  => 'nama_kecamatan'
    ];

    public function __construct()
    {
        parent::__construct();
    }

    public function get_kecamatan_by_id($id)
    {
        parent::clear_join();
        $this->_timestamps = TRUE;
        $this->_log_user = TRUE;
        $this->_softdelete = TRUE;
        $this->_log_user = FALSE;
        $this->_primary_key = 'id';
        $this->_primary_filter = 'strval';
        $this->_fields_toshow = ['id', 'kabupaten_id', 'nama_kecamatan','status'];
        $this->_fields = [
            'id' => 'id',
            'kabupaten_id'    => 'kabupaten_id',
            'nama_kecamatan'  => 'nama_kecamatan'
        ];

        $this->db->where('id', $id);

        return parent::find($id);
    }

    public function get_all_kecamatan_by_int($kabupaten_id)
    {
        parent::clear_join();
        $this->_order_by = 'id';
        $this->_order = 'DESC';
        $this->_fields_toshow = ['CAST(id AS INTEGER) as id', 'kabupaten_id', 'nama_kecamatan'];

        $this->db->where('kabupaten_id', $kabupaten_id);

        return parent::findAll($kabupaten_id);
    }



}

/* End of file M_kecamatan.php */
