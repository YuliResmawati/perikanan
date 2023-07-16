<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_siswa extends MY_Model {

    protected $_table = 'siswa';
    protected $_timestamps = TRUE;
    protected $_log_user = TRUE;
    protected $_softdelete = TRUE;
    protected $_order_by = 'id';
    protected $_order = 'ASC';
    protected $_fields_toshow = ['id','nik','no_kk','nipd','nisn', 'nama_siswa','jenis_kelamin','status',
                                'agama','tempat_lahir','tgl_lahir','nagari_id','alamat_lengkap','jenis_tinggal',
                                'transportasi','email','no_hp','skhun','no_kps','no_peserta_un','no_seri_ijazah','no_kip','no_kks',
                                'no_akta_lahir','no_rekening','bank','atas_nama','kelayakan_pip','alasan','kebutuhan_khusus',
                                'sekolah_lama_id','anak_ke'];
    protected $_fields = [
       'nik' => 'nik',
       'no_kk' => 'no_kk',
       'nipd' => 'nipd',
       'nisn' => 'nisn',
       'nama_siswa' => 'nama_siswa',
       'jenis_kelamin' => 'jenis_kelamin',
       'agama' => 'agama',
       'tempat_lahir' => 'tempat_lahir',
       'tgl_lahir' => 'tgl_lahir',
       'nagari_id' => 'nagari_id',
       'alamat_lengkap' => 'alamat_lengkap',
       'jenis_tinggal' => 'jenis_tinggal',
       'transportasi' => 'transportasi',
       'email' => 'email',
       'no_hp' => 'no_hp',
       'skhun' => 'skhun',
       'no_kps' => 'no_kps',
       'no_peserta_un' => 'no_peserta_un',
       'no_seri_ijazah' => 'no_seri_ijazah',
       'no_kip' => 'no_kip',
       'no_kks' => 'no_kks',
       'no_akta_lahir' => 'no_akta_lahir',
       'no_rekening' => 'no_rekening',
       'bank' => 'bank',
       'atas_nama' => 'atas_nama',
       'kelayakan_pip' => 'kelayakan_pip',
       'alasan' => 'alasan',
       'kebutuhan_khusus' => 'kebutuhan_khusus',
       'sekolah_lama_id' => 'sekolah_lama_id',
       'anak_ke' => 'anak_ke'
    ];

    public function __construct()
    {
        parent::__construct();
    }

    public function get_all_detail_siswa($siswa_id)
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

    public function get_all_siswa()
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
            'sek.nama_sekolah as sekolah_lama_nama','r.id as rombel_id'
        ];

        parent::join('detail_siswa dd','dd.siswa_id=siswa.id', 'left');
        parent::join('detail_rombel d','d.id=dd.detail_rombel_id', 'left');
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
