<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_riwayat_kgb extends MY_Model {

    protected $_table = 'riwayat_kgb';
    protected $_timestamps = TRUE;
    protected $_log_user = TRUE;
    protected $_softdelete = TRUE;
    protected $_order_by = 'id';
    protected $_order = 'ASC';
    protected $_fields_toshow = ['id','guru_id','tmt_awal','tmt_akhir','berkas'];
    protected $_fields = [
       'id' => 'id'
    ];

    public function __construct()
    {
        parent::__construct();
    }

    public function get_riwayat_kgb(){
        $this->_fields_toshow = ['riwayat_kgb.id', 'guru_id', 'sekolah_id','nik','nip','nama_guru','nuptk','guru.status as status',
        'jenis_kelamin','agama','tempat_lahir','tgl_lahir','status_tugas','gelar_depan','gelar_belakang',
        'jenjang','no_hp','sk_cpns','tgl_sk_cpns','sk_pengangkatan','tgl_sk_pengangkatan','jenis_ptk','pendidikan',
        'bidang_studi_pendidikan', 'bidang_studi_sertifikasi','status_kepegawaian','pangkat', 'tmt_awal'];

        parent::join('guru','riwayat_kgb.guru_id=guru.id');
        
        return $this;
    }


}

/* End of file M_sample_upload.php */
