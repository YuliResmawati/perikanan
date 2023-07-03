<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_sekolah extends MY_Model {

    protected $_table = 'sekolah';
    protected $_timestamps = TRUE;
    protected $_log_user = TRUE;
    protected $_softdelete = TRUE;
    protected $_order_by = 'tipe_sekolah';
    protected $_order = 'ASC';
    protected $_fields_toshow = ['id','npsn','nama_sekolah','tipe_sekolah','alamat', 'no_telp', 'link_g_site', 'foto'];
    protected $_fields = [
       'npsn' => 'npsn',
       'nama_sekolah' => 'nama_sekolah',
       'tipe_sekolah' => 'tipe_sekolah',
       'alamat' => 'alamat',
       'no_telp' => 'no_telp',
       'link_g_site' => 'link_g_site'
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

}

/* End of file M_sample_upload.php */
