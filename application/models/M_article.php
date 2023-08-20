<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_article extends MY_Model {

    protected $_table = 'article';
    protected $_timestamps = TRUE;
    protected $_log_user = TRUE;
    protected $_softdelete = FALSE;
    protected $_order_by = 'created_at';
    protected $_order = 'DESC';
    protected $_fields_toshow = ['id', 'title', 'description', 'hits', 'image', 'slug', 'created_at as tanggal'];
    protected $_fields = [
       'title' => 'title'
    ];

    public function __construct()
    {
        parent::__construct();
    }

    public function get_content_article($limit = '', $order = '', $offset = '')
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
            'id', 'title', 'description', 'slug', 'hits', 'image', 'created_at as tanggal', 'status'
        ];

        $this->db->where('status', '1');

        return parent::findAll();
    }

    public function get_article_by_slug($slug)
    {
        parent::clear_join();
        $this->_timestamps = FALSE;
        $this->_log_user = FALSE;
        $this->_primary_key = 'slug';
        $this->_primary_filter = 'strval';
        $this->_fields_toshow = [
            'id', 'title', 'description', 'slug', 'hits', 'image', 'created_at as tanggal', 'status'
        ];

        $this->db->where('status', '1');

        $this->db->set('hits', 'hits +1',false);
        parent::save($slug);

        return parent::find($slug);
    }

    public function get_related_article($limit = '', $blacklist_id = '') 
    {
        parent::clear_join();
        if ($limit) {
            $this->db->limit($limit, '');
        }

        if ($blacklist_id) {
            $this->db->where('id !=', $blacklist_id);
        }

        $this->_fields_toshow = [
            'id', 'title', 'description', 'slug', 'hits', 'image', 'created_at as tanggal', 'status'
        ];

        $this->db->where('status', '1');
        $this->db->order_by('hits desc');

        return parent::findAll();
    }

}

/* End of file M_article.php */
