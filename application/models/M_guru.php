<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_guru extends MY_Model {

    protected $_table = 'guru';
    protected $_timestamps = TRUE;
    protected $_log_user = TRUE;
    protected $_softdelete = TRUE;
    protected $_order_by = 'nama_guru';
    protected $_order = 'ASC';
    protected $_fields_toshow = ['id','sekolah_id','guru.status as status','nik','nip','nama_guru','nuptk',
                                'jenis_kelamin','agama','tempat_lahir','tgl_lahir','status_tugas','gelar_depan','gelar_belakang',
                                'jenjang','no_hp','sk_cpns','tgl_sk_cpns','sk_pengangkatan','tgl_sk_pengangkatan','jenis_ptk','pendidikan',
                                'bidang_studi_pendidikan', 'bidang_studi_sertifikasi','status_kepegawaian','pangkat',
                                'nagari_id','alamat_lengkap','is_kepsek','tahun_terakhir_kgb'];
    protected $_fields = [
       'sekolah_id'         => 'sekolah_id',
       'status'             => 'status',
       'nik'                => 'nik',
       'nip'                => 'nip',
       'nama_guru'          => 'nama_guru',
       'nuptk'              => 'nuptk',
       'gelar_depan'        => 'gelar_depan',
       'gelar_belakang'     => 'gelar_belakang',
       'jenis_kelamin'      => 'jenis_kelamin',
       'agama'              => 'agama',
       'tempat_lahir'       => 'tempat_lahir',
       'tgl_lahir'          => 'tgl_lahir',
       'status_tugas'       => 'status_tugas',
       'jenjang'            => 'jenjang',
       'no_hp'              => 'no_hp',
       'sk_cpns'            => 'sk_cpns',
       'tgl_sk_cpns'        => 'tgl_sk_cpns',
       'sk_pengangkatan'    => 'sk_pengangkatan',
       'tgl_sk_pengangkatan'        => 'tgl_sk_pengangkatan',
       'jenis_ptk'          => 'jenis_ptk',
       'pendidikan'         => 'pendidikan',
       'bidang_studi_pendidikan'    => 'bidang_studi_pendidikan',
       'bidang_studi_sertifikasi'   => 'bidang_studi_sertifikasi',
       'status_kepegawaian'         => 'status_kepegawaian',
       'pangkat'            => 'pangkat',
       'nagari_id'          => 'nagari_id',
       'alamat_lengkap'     => 'alamat_lengkap',
       'is_kepsek'     => 'is_kepsek',
       'tahun_terakhir_kgb'     => 'tahun_terakhir_kgb'
    ];

    public function __construct()
    {
        parent::__construct();
    }


    public function get_guru_by_sekolah($sekolah_id){
        $this->_order_by= false;
        $this->_order = false;
        $this->_fields_toshow = [ 'guru.id','nama_guru','nip'];
        $this->db->join('sekolah', 'guru.sekolah_id = sekolah.id');
        
        $this->db->where(['sekolah.id' =>$sekolah_id]);

        return $this;
    }

    public function get_all_guru()
    {
        $this->_fields_toshow = ['sekolah_id','nik','nip','nama_guru','nuptk','guru.status as status',
        'jenis_kelamin','agama','tempat_lahir','status_tugas','gelar_depan','gelar_belakang',
        'jenjang','no_hp','sk_cpns','tgl_sk_cpns','sk_pengangkatan','jenis_ptk','pendidikan',
        'bidang_studi_pendidikan', 'bidang_studi_sertifikasi','status_kepegawaian','pangkat',
        'guru.nagari_id','guru.alamat_lengkap','is_kepsek',
        'nama_sekolah','nama_nagari','nama_kecamatan','nama_kabupaten','nama_provinsi','tahun_terakhir_kgb'];


        parent::join('sekolah', 'sekolah.id=guru.sekolah_id', 'left');
        parent::join('nagari', 'nagari.id=guru.nagari_id', 'left');
        parent::join('kecamatan', 'kecamatan.id=nagari.kecamatan_id', 'left');
        parent::join('kabupaten', 'kabupaten.id=kecamatan.kabupaten_id', 'left');
        parent::join('provinsi', 'provinsi.id=kabupaten.provinsi_id', 'left');

        return $this;
    }


}

/* End of file M_sample_upload.php */
