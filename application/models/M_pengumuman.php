<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_pengumuman extends MY_Model {

    protected $_table = 'pengumuman';
    protected $_timestamps = TRUE;
    protected $_log_user = TRUE;
    protected $_softdelete = FALSE;
    protected $_order_by = 'created_at';
    protected $_order = 'DESC';
    protected $_fields_toshow = ['id', 'title', 'description', 'hits', 'file', 'slug', 'created_at as tanggal'];
    protected $_fields = [
       'title' => 'title',
       'description' => 'description',
    ];

    public function __construct()
    {
        parent::__construct();
    }

    public function get_content_pengumuman($limit = '', $order = '', $offset = '')
    {
        parent::clear_join();
        if ($limit) {
            $this->db->limit($limit, $offset);
        }

        if ($order) {
            $this->_order_by = $order;
            $this->_order = 'DESC';
        } else {
            $this->_order_by = 'created_at';
            $this->_order = 'DESC';
        }

        $this->_fields_toshow = [
            'id', 'title', 'description', 'slug', 'hits', 'file', 'created_at as tanggal', 'status'
        ];

        $this->db->where('status', '1');

        return parent::findAll();
    }

}

/* End of file M_article.php */
