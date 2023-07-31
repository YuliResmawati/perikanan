<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_mutasi_guru extends MY_Model {

    protected $_table = 'mutasi_guru';
    protected $_timestamps = TRUE;
    protected $_log_user = TRUE;
    protected $_softdelete = TRUE;
    protected $_order_by = 'id';
    protected $_order = 'DESC';
    protected $_fields_toshow = ['id','guru_id','sekolah_awal_id','sekolah_tujuan_id','tipe_mutasi','sekolah_luar'];
    protected $_fields = [
       'id' => 'id',
       'guru_id' => 'guru_id',
       'sekolah_awal_id' => 'sekolah_awal_id',
       'sekolah_tujuan_id' => 'sekolah_tujuan_id',
       'tipe_mutasi' => 'tipe_mutasi',
       'sekolah_luar' => 'sekolah_luar'
    ];

    public function __construct()
    {
        parent::__construct();
    }

    public function get_detail_mutasi_guru()
    {   
        parent::clear_join();
        $this->_fields_toshow = [
            'mutasi_guru.id','s_awal.nama_sekolah as sekolah_awal','s_tujuan.nama_sekolah as sekolah_tujuan',
            'nama_guru', 'nip','link', 'mutasi_guru.status','tipe_mutasi','sekolah_luar'
        ];

        parent::join('guru g','g.id=mutasi_guru.guru_id');
        parent::join('sekolah s_awal','s_awal.id=mutasi_guru.sekolah_awal_id');
        parent::join('sekolah s_tujuan','s_tujuan.id=mutasi_guru.sekolah_tujuan_id','left');

        return $this;
    }


}

/* End of file M_sample_upload.php */
