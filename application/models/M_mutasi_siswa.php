<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_mutasi_siswa extends MY_Model {

    protected $_table = 'mutasi_siswa';
    protected $_timestamps = TRUE;
    protected $_log_user = TRUE;
    protected $_softdelete = TRUE;
    protected $_order_by = 'id';
    protected $_order = 'ASC';
    protected $_fields_toshow = ['id','siswa_id','detail_rombel_awal_id','detail_rombel_tujuan_id','link','alasan','output_balikan'];
    protected $_fields = [
       'id' => 'id'
    ];

    public function __construct()
    {
        parent::__construct();
    }


    public function get_detail_mutasi_siswa()
    {   
        parent::clear_join();
        $this->_fields_toshow = [
            "mutasi_siswa.id","s_awal.nama_sekolah as sekolah_awal","s_tujuan.nama_sekolah as sekolah_tujuan",
            "nama_siswa", "nisn", "mutasi_siswa.status","link","mutasi_siswa.alasan","output_balikan",
            "concat(d.tingkatan, ' ',d.nama_rombel)  as rombel_awal", "concat(dd.tingkatan, ' ',dd.nama_rombel) as rombel_tujuan"
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

        if($this->logged_level == "3"){
            $this->db->where(['s_awal.id' =>$this->logged_sekolah_id]);
        }

        $this->db->group_by([
            'mutasi_siswa.id',
            'mutasi_siswa.status',
            's_awal.nama_sekolah',
            's_tujuan.nama_sekolah',
            'nama_siswa',
            'nisn',
            'd.nama_rombel',
            'dd.nama_rombel',
            'd.tingkatan',
            'dd.tingkatan'
        ]);

        return $this;
    }


}

/* End of file M_sample_upload.php */
