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


    public function get_kabupaten_by_paging($per_page, $page, $search, $type)
    {
        if($page == 0) $page = 1;
        $page = ($per_page * $page) - $per_page;
        $this->db->select('id, nama_kabupaten, provinsi_id, status');
        $this->db->from('kabupaten');
        $this->db->like('LOWER(nama_kabupaten)', strtolower($search));
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

    public function get_all_siswa_by_paging($per_page, $page, $search, $type)
    {
        if($page == 0) $page = 1;
        $page = ($per_page * $page) - $per_page;
        $this->db->select('siswa.id, nama_siswa, nisn', 'nama_Sekolah');
        $this->db->from('siswa');
        $this->db->join('detail_siswa','siswa.id = detail_siswa.siswa_id');
        $this->db->join('detail_rombel','detail_siswa.detail_rombel_id = detail_rombel.id');
        $this->db->join('sekolah','detail_rombel.sekolah_id = sekolah.id');
        $this->db->like('LOWER(nama_siswa)', strtolower($search));
        $this->db->where(array('siswa.status' =>'1'));
        $this->db->or_like('nisn',$search);
        $this->db->limit($per_page, $page);
        $this->db->where(array('siswa.status' =>'1'));

        if ($type == 'data') {
            return $this->db->get()->result_array();
        } else {
            return $this->db->count_all_results();
        }
    }

    public function get_all_guru_by_paging($per_page, $page, $search, $type)
    {
        if($page == 0) $page = 1;
        $page = ($per_page * $page) - $per_page;
        $this->db->select('guru.id, nama_guru,nip');
        $this->db->from('guru');
        $this->db->join('sekolah','guru.sekolah_id = sekolah.id');
        $this->db->like('LOWER(nama_guru)', strtolower($search));
        $this->db->where(array('guru.status' =>'1'));
        $this->db->or_like('nip',$search);
        $this->db->limit($per_page, $page);
        $this->db->where(array('guru.status' =>'1'));

        if ($type == 'data') {
            return $this->db->get()->result_array();
        } else {
            return $this->db->count_all_results();
        }
    }

    public function get_all_sekolah_by_paging($per_page, $page, $search, $type)
    {
        if($page == 0) $page = 1;
        $page = ($per_page * $page) - $per_page;
        $this->db->select('id, nama_sekolah,npsn');
        $this->db->from('sekolah');
        $this->db->like('LOWER(nama_sekolah)', strtolower($search));
        $this->db->where(array('status' =>'1'));
        $this->db->or_like('npsn',$search);
        $this->db->limit($per_page, $page);
        $this->db->where(array('status' =>'1'));

        if ($type == 'data') {
            return $this->db->get()->result_array();
        } else {
            return $this->db->count_all_results();
        }
    }


}

/* End of file M_app.php */
