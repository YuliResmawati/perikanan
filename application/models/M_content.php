<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_content extends MY_Model {

    protected $_table = 'konten';
    protected $_timestamps = TRUE;
    protected $_log_user = TRUE;
    protected $_softdelete = FALSE;
    protected $_order_by = 'id';
    protected $_order = 'DESC';
    protected $_fields_toshow = [
        'id', 'kategori_konten_id', 'judul_konten', 'isi_konten', 'tgl_konten', 'status','hits','slug','berkas', 'created_at as tanggal'
    ];
    protected $_fields = [
        'id' => 'id',
    ];

    public function __construct()
    {
        parent::__construct();
    }

    public function get_all_content()
    {
        parent::clear_join();

        $this->_fields_toshow = ['judul_konten', 'isi_konten', 'tgl_konten', 'konten.status','hits','slug','nama_kategori','berkas',
        'kategori_konten_id', 'konten.created_at as tanggal'];

        parent::join('kategori_konten ','konten.kategori_konten_id=kategori_konten.id');

        return $this;
    }

    public function get_content_by_type($limit = '', $order = '', $offset = '', $type = null)
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
            'id', 'judul_konten', 'isi_konten', 'slug', 'hits', 'berkas', 'created_at as tanggal', 'status'
        ];

        $this->db->where(['status' => '1', 'kategori_konten_id' => $type]);

        return parent::findAll();
    }

    public function get_content_by_slug($slug, $type = null)
    {
        parent::clear_join();
        $this->_timestamps = FALSE;
        $this->_log_user = FALSE;
        $this->_primary_key = 'slug';
        $this->_primary_filter = 'strval';
        $this->_fields_toshow = [
            'id', 'judul_konten', 'isi_konten', 'slug', 'hits', 'berkas', 'created_at as tanggal', 'status'
        ];

        $this->db->where(['status' => '1', 'kategori_konten_id' => $type]);

        $this->db->set('hits', 'hits +1',false);
        parent::save($slug);

        return parent::find($slug);
    }

    public function get_related_content($limit = '', $blacklist_id = '', $type = null) 
    {
        parent::clear_join();
        if ($limit) {
            $this->db->limit($limit, '');
        }

        if ($blacklist_id) {
            $this->db->where('id !=', $blacklist_id);
        }

        $this->_fields_toshow = [
            'id', 'judul_konten', 'isi_konten', 'slug', 'hits', 'berkas', 'created_at as tanggal', 'status'
        ];

        $this->db->where(['status' => '1', 'kategori_konten_id' => $type]);
        $this->db->order_by('hits desc');

        return parent::findAll();
    }


}

/* End of file M_content.php */
