<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_mutasi_siswa extends MY_Model {

    protected $_table = 'mutasi_siswa';
    protected $_timestamps = TRUE;
    protected $_log_user = TRUE;
    protected $_softdelete = TRUE;
    protected $_order_by = 'id';
    protected $_order = 'ASC';
    protected $_fields_toshow = ['id','siswa_id','sekolah_awal_id','sekolah_tujuan_id'];
    protected $_fields = [
       'id' => 'id'
    ];

    public function __construct()
    {
        parent::__construct();
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

    public function get_detail_mutasi_siswa()
    {   
        parent::clear_join();
        $this->_fields_toshow = [
            'mutasi_siswa.id','s_awal.nama_sekolah as sekolah_awal','s_tujuan.nama_sekolah as sekolah_tujuan',
            'nama_siswa', 'nisn', 'mutasi_siswa.status', 'd.nama_rombel as rombel_awal', 'dd.nama_rombel as rombel_tujuan'
        ];

        parent::join('siswa a','a.id=mutasi_siswa.siswa_id');
        parent::join('detail_rombel b','b.id=mutasi_siswa.detail_rombel_awal_id');
        parent::join('detail_siswa c','c.detail_rombel_id=b.id');
        parent::join('sekolah s_awal','s_awal.id=b.sekolah_id');
        parent::join('rombel d','d.id=b.rombel_id');
        parent::join('detail_rombel bb','bb.id=mutasi_siswa.detail_rombel_tujuan_id');
        parent::join('detail_siswa cc','cc.detail_rombel_id=b.id');
        parent::join('sekolah s_tujuan','s_tujuan.id=bb.sekolah_id');
        parent::join('rombel dd','dd.id=bb.rombel_id');

        return $this;
    }


}

/* End of file M_sample_upload.php */
