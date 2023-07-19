<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_detail_siswa extends MY_Model {

    protected $_table = 'detail_siswa';
    protected $_timestamps = TRUE;
    protected $_log_user = TRUE;
    protected $_softdelete = TRUE;
    protected $_order_by = 'id';
    protected $_order = 'ASC';
    protected $_fields_toshow = ['id','detail_rombel_id','siswa_id'];
    protected $_fields = [
       'id' => 'id',
       'detail_rombel_id' => 'detail_rombel_id',
       'siswa_id' => 'siswa_id'
    ];

    public function __construct()
    {
        parent::__construct();
    }

    public function get_all_detail_siswa()
    {   
        parent::clear_join();
        $this->_fields_toshow = [
            'nik','no_kk','nipd','nisn', 'nama_siswa','jenis_kelamin','siswa.status',
            'agama','tempat_lahir','tgl_lahir','siswa.nagari_id','siswa.alamat_lengkap','jenis_tinggal',
            'transportasi','email','no_hp','skhun','no_kps','no_peserta_un','no_seri_ijazah','no_kip','no_kks',
            'no_akta_lahir','no_rekening','bank','atas_nama','kelayakan_pip','alasan','kebutuhan_khusus',
            'sekolah_lama_id','anak_ke','nama_nagari','nama_kecamatan','nama_kabupaten','nama_provinsi',
            's.nama_sekolah as nama_sekolah',
            'tingkatan','nama_rombel','s.tipe_sekolah as tipe_sekolah','s.id as sekolah_id',
            'sek.nama_sekolah as sekolah_lama_nama','r.id as rombel_id','d.id as detail_rombel_id','siswa.id as siswa_id'
        ];

        parent::join('siswa','detail_siswa.siswa_id=siswa.id', 'left');
        parent::join('detail_rombel d','d.id=detail_siswa.detail_rombel_id', 'left');
        parent::join('rombel r','r.id=d.rombel_id', 'left');
        parent::join('sekolah s','s.id=d.sekolah_id', 'left');
        parent::join('nagari', 'nagari.id=siswa.nagari_id', 'left');
        parent::join('kecamatan', 'kecamatan.id=nagari.kecamatan_id', 'left');
        parent::join('kabupaten', 'kabupaten.id=kecamatan.kabupaten_id', 'left');
        parent::join('provinsi', 'provinsi.id=kabupaten.provinsi_id', 'left');
        parent::join('sekolah sek','sek.id=siswa.sekolah_lama_id', 'left');

        return $this;
    }

}

/* End of file M_sample_upload.php */
