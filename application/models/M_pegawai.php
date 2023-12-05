<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_pegawai extends MY_Model {

    protected $_table = 'pegawai';
    protected $_order_by = 'id';
    protected $_order = 'DESC';
    protected $_softdelete = TRUE;
    protected $_timestamps = TRUE;
    protected $_log_user = TRUE;
    protected $_fields_toshow = ['id','image', 'simpeg_pegawai_id'];
    protected $_fields = [
        'id' => 'id',
    ];

    public function __construct()
    {
        parent::__construct();
    }

    public function get_pegawai()
    {
        parent::clear_join();

        $this->_fields_toshow = ['e.id as id','nip', 'nama_pegawai', 'gelar_depan', 'gelar_blkng','nama_jabatan','nama_unor',
        'kedudukan_hukum','jenis_kelamin','eselon_id','pegawai.image'];

        parent::join('v_pegawai_dkpp e','pegawai.simpeg_pegawai_id=e.id', 'right');

        return $this;
    }
    
}

/* End of file M_pegawai.php */