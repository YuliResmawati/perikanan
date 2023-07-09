<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_sekolah extends MY_Model {

    protected $_table = 'sekolah';
    protected $_timestamps = TRUE;
    protected $_log_user = TRUE;
    protected $_softdelete = TRUE;
    protected $_order_by = 'tipe_sekolah';
    protected $_order = 'ASC';
    protected $_fields_toshow = ['id','npsn','nama_sekolah','tipe_sekolah','status_sekolah',
                                'status_kepemilikan','sk_pendirian','tgl_sk_pendirian','sk_izin',
                                'tgl_sk_izin','akreditasi','kurikulum','provinsi_id','kabupaten_id',
                                'kecamatan_id','nagari_id','alamat_lengkap','kode_pos','no_telp', 'link_g_site', 'foto'];
    protected $_fields = [
       'npsn'               => 'npsn',
       'nama_sekolah'       => 'nama_sekolah',
       'tipe_sekolah'       => 'tipe_sekolah',
       'status_sekolah'     => 'status_sekolah',
       'status_kepemilikan' => 'status_kepemilikan',
       'sk_pendirian'       => 'sk_pendirian',
       'tgl_sk_pendirian'   => 'tgl_sk_pendirian',
       'sk_izin'            => 'sk_izin',
       'tgl_sk_izin'        => 'tgl_sk_izin',
       'akreditasi'         => 'akreditasi',
       'kurikulum'          => 'kurikulum',
       'provinsi_id'        => 'provinsi_id',
       'kabupaten_id'       => 'kabupaten_id',
       'kecamatan_id'       => 'kecamatan_id',
       'nagari_id'          => 'nagari_id',
       'alamat_lengkap'     => 'alamat_lengkap',
       'kode_pos'           => 'kode_pos',
       'no_telp'            => 'no_telp',
       'link_g_site'        => 'link_g_site',
       'foto'               => 'foto'
    ];

    public function __construct()
    {
        parent::__construct();
    }

    public function get_distinct_tipe(){
        $this->_fields_toshow = [ 'DISTINCT(tipe_sekolah) as tipe_sekolah'];
        return $this;
    }

    public function get_sekolah_by_tipe($tipe_sekolah){
        $this->_fields_toshow = [ 'id','npsn','nama_sekolah','tipe_sekolah'];
        $this->db->where(['tipe_sekolah' =>$tipe_sekolah, 'status' => '1']);

        return $this;
    }

    public function get_sekolah_by_guru($guru_id){
        $this->_fields_toshow = [ 'sekolah.id','npsn','nama_sekolah'];
        $this->db->join('guru', 'guru.sekolah_id = sekolah.id');
        
        $this->db->where(['guru.id' =>$guru_id]);

        return $this;
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

/* End of file M_sample_upload.php */
