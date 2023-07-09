<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_nagari extends MY_Model {

    protected $_table = 'nagari';
    protected $_timestamps = TRUE;
    protected $_log_user = TRUE;
    protected $_softdelete = TRUE;
    protected $_order_by = 'id';
    protected $_order = 'ASC';
    protected $_fields_toshow = ['id', 'kecamatan_id', 'nama_nagari'];
    protected $_fields = [
        'kecamatan_id'    => 'kecamatan_id',
        'nama_nagari'  => 'nama_nagari'
    ];

    public function __construct()
    {
        parent::__construct();
    }

    public function get_nagari_by_id($id)
    {
        parent::clear_join();
        $this->_timestamps = TRUE;
        $this->_log_user = TRUE;
        $this->_softdelete = TRUE;
        $this->_log_user = FALSE;
        $this->_primary_key = 'id';
        $this->_primary_filter = 'strval';
        $this->_fields_toshow = ['id', 'kecamatan_id', 'nama_nagari','status'];
        $this->_fields = [
            'id' => 'id',
            'kecamatan_id'    => 'kecamatan_id',
            'nama_nagari'  => 'nama_nagari'
        ];

        $this->db->where('id', $id);

        return parent::find($id);
    }

    public function get_all_nagari_by_int($kecamatan_id)
    {
        parent::clear_join();
        $this->_order_by = 'id';
        $this->_order = 'DESC';
        $this->_fields_toshow = ['CAST(id AS INTEGER) as id', 'kecamatan_id', 'nama_nagari'];
        $this->db->where('kecamatan_id', $kecamatan_id);
        return parent::findAll($kecamatan_id);
    }



}

/* End of file M_kecamatan.php */