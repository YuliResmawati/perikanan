<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_app extends MY_Model {

    protected $_table = 'app';
    protected $_timestamps = FALSE;
    protected $_log_user = FALSE;
    protected $_softdelete = FALSE;
    protected $_order_by = '';
    protected $_order = '';
    protected $_fields_toshow = ['app'];
    protected $_fields = [
        'app' => 'app'
    ];

    public function __construct()
    {
        parent::__construct();
    }


    public function get_kecamatan_by_paging($per_page, $page, $search, $type)
    {
        if($page == 0) $page = 1;
        $page = ($per_page * $page) - $per_page;
        $this->db->select('id, nama_kecamatan');
        $this->db->from('v_kecamatan');
        $this->db->like('LOWER(nama_kecamatan)', strtolower($search));
        $this->db->limit($per_page, $page);
        $this->db->where('status', '1');

        if ($type == 'data') {
            return $this->db->get()->result_array();
        } else {
            return $this->db->count_all_results();
        }
    }

    public function get_region_by_paging($per_page, $page, $search, $type)
    {
        if($page == 0) $page = 1;
        $page = ($per_page * $page) - $per_page;
        $this->db->select('a.id as provinsi_id, a.nama_provinsi, b.id as kabupaten_id, b.nama_kabupaten, c.id as kecamatan_id, c.nama_kecamatan, d.id as nagari_id, d.nama_nagari');
        $this->db->from('provinsi as a');
        $this->db->join('kabupaten as b', 'a.id=b.provinsi_id');
        $this->db->join('kecamatan as c', 'b.id=c.kabupaten_id');
        $this->db->join('nagari as d', 'c.id=d.kecamatan_id');
        $this->db->like('LOWER(d.nama_nagari)', strtolower($search));
        $this->db->or_like('LOWER(c.nama_kecamatan)', strtolower($search));
        $this->db->limit($per_page, $page);

        if ($type == 'data') {
            return $this->db->get()->result_array();
        } else {
            return $this->db->count_all_results();
        }
    }

    public function get_komoditas_by_paging($per_page, $page, $search, $type, $params)
    {
        if($page == 0) $page = 1;
        $page = ($per_page * $page) - $per_page;
        $this->db->select('id, komoditas, status','jenis');
        $this->db->from('komoditas');
        $this->db->like('LOWER(komoditas)', strtolower($search));
        $this->db->limit($per_page, $page);
        $this->db->where(array('status' =>'1', 'jenis' => $params));

        if ($type == 'data') {
            return $this->db->get()->result_array();
        } else {
            return $this->db->count_all_results();
        }
    }

    public function get_komoditas_psat_by_paging($per_page, $page, $search, $type)
    {
        if($page == 0) $page = 1;
        $page = ($per_page * $page) - $per_page;
        $this->db->select('id, komoditas, status','jenis');
        $this->db->from('komoditas');
        $this->db->like('LOWER(komoditas)', strtolower($search));
        $this->db->limit($per_page, $page);
        $this->db->where(array('status' =>'1', 'jenis' => '4'));

        if ($type == 'data') {
            return $this->db->get()->result_array();
        } else {
            return $this->db->count_all_results();
        }
    }

    public function get_pelaku_by_paging($per_page, $page, $search, $type)
    {
        if($page == 0) $page = 1;
        $page = ($per_page * $page) - $per_page;
        $this->db->select('id, nama_pelaku, status');
        $this->db->from('pelaku_usaha');
        $this->db->like('LOWER(nama_pelaku)', strtolower($search));
        $this->db->limit($per_page, $page);
        $this->db->where(array('status' =>'1'));

        if ($type == 'data') {
            return $this->db->get()->result_array();
        } else {
            return $this->db->count_all_results();
        }
    }

    public function get_indikator_by_paging($per_page, $page, $search, $type, $choise, $params)
    {
        if($page == 0) $page = 1;
        $page = ($per_page * $page) - $per_page;
        $this->db->select('id, nama_indikator');
        $this->db->from('indikator_tangkap_ikan');
        $this->db->like('LOWER(nama_indikator)', strtolower($search));
        $this->db->limit($per_page, $page);
        if ($choise == 'armada'){
            $this->db->where(array('status' =>'1', 'jenis' => '1', 'type_perairan' => $params));
        } else if ($choise == 'alat_tangkap'){
            $this->db->where(array('status' =>'1', 'jenis' => '2', 'type_perairan' => $params));
        } else {
            $this->db->where(array('status' =>'1', 'jenis' => '3', 'type_perairan' => $params));
        }
        

        if ($type == 'data') {
            return $this->db->get()->result_array();
        } else {
            return $this->db->count_all_results();
        }
    }

}

/* End of file M_app.php */
