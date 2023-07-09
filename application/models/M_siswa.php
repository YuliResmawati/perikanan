<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_siswa extends MY_Model {

    protected $_table = 'siswa';
    protected $_timestamps = TRUE;
    protected $_log_user = TRUE;
    protected $_softdelete = TRUE;
    protected $_order_by = 'id';
    protected $_order = 'ASC';
    protected $_fields_toshow = ['id','nik','no_kk','nipd','nisn', 'nama_siswa','jenis_kelamin','agama','tempat_lahir','provinsi_id','kabupaten_id','kecamatan_id','kelurahan'];
    protected $_fields = [
       'sekolah_id' => 'sekolah_id',
       'guru_id' => 'guru_id',
       'nama_kelas' => 'nama_kelas',
       'tingkat' => 'tingkat',
       'tipe' => 'tipe'
    ];

    public function __construct()
    {
        parent::__construct();
    }

    public function get_All_Detail_siswa($siswa_id)
    {   
        parent::clear_join();
        $this->_fields_toshow = [
            'siswa.id','nama_siswa', 'nama_rombel', 'nama_sekolah', 'jenis_kelamin', 'nisn', 'siswa.status','npsn', 'd.id as detail_rombel_awal_id'
        ];

        parent::join('detail_siswa dd','dd.siswa_id=siswa.id');
        parent::join('detail_rombel d','d.id=dd.detail_rombel_id');
        parent::join('rombel r','r.id=d.rombel_id');
        parent::join('sekolah s','s.id=d.sekolah_id');

        parent::where(['siswa.id' => $siswa_id, 'siswa.status' => '1']);

        return $this;
    }

}

/* End of file M_sample_upload.php */
