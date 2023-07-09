<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_jorong extends MY_Model {

    protected $_table = 'jorong';
    protected $_timestamps = TRUE;
    protected $_log_user = TRUE;
    protected $_softdelete = TRUE;
    protected $_order_by = 'id';
    protected $_order = 'ASC';
    protected $_fields_toshow = ['id', 'nagari_id', 'nama_jorong','status'];
    protected $_fields = [
        'id' => 'id',
        'nagari_id'    => 'nagari_id',
        'nama_jorong'  => 'nama_jorong'
    ];

    public function __construct()
    {
        parent::__construct();
    }

    public function get_jorong_by_id($id)
    {
        parent::clear_join();
        $this->_timestamps = TRUE;
        $this->_log_user = TRUE;
        $this->_softdelete = TRUE;
        $this->_log_user = FALSE;
        $this->_primary_key = 'id';
        $this->_primary_filter = 'strval';
        $this->_fields_toshow = ['id', 'nagari_id', 'nama_jorong','status'];
        $this->_fields = [
            'id' => 'id',
            'nagari_id'    => 'nagari_id',
            'nama_jorong'  => 'nama_jorong'
        ];

        $this->db->where('id', $id);

        return parent::find($id);
    }

    public function get_all_jorong_by_id_nagari($nagari_id)
    {
        parent::clear_join();
        $this->_order_by = 'id';
        $this->_order = 'DESC';
        $this->_fields_toshow = ['id', 'nagari_id', 'nama_jorong'];

        $this->db->where('nagari_id', $nagari_id);

        return parent::findAll($nagari_id);
    }

    public function get_nilai_by_jorong($nagari_id)
    {
        $this->_fields_toshow = ['id', 'nama_jorong','nagari_id'];
        $this->db->where(array('nagari_id' => $nagari_id ,'status' =>'1'));
        
        return parent::findAll();
    }



}

/* End of file M_jorong.php */
