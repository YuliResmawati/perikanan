<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_pegawai extends MY_Model {

    protected $_table = 'pegawai';
    protected $_order_by = 'id';
    protected $_order = 'DESC';
    protected $_softdelete = TRUE;
    protected $_timestamps = TRUE;
    protected $_log_user = TRUE;
    protected $_fields_toshow = ['id','image', 'simpeg_pegawai_id','jenis_pegawai','nama_pegawai','jenis_kelamin', 'jabatan'];
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

        $this->_fields_toshow = ['pegawai.id','e.id as pegawai_id','nip', 'e.nama_pegawai', 'gelar_depan', 'gelar_blkng','nama_jabatan','nama_unor',
        'kedudukan_hukum','eselon_id','pegawai.image','jenis_pegawai'];

        parent::join('v_pegawai_dkpp e','pegawai.simpeg_pegawai_id=e.id', 'right');

        return $this;
    }

    public function get_pegawai_non_pns()
    {
        parent::clear_join();
        $this->_order_by= false;
        $this->_order = false;
        $this->_fields_toshow = ['id','simpeg_pegawai_id as nip','nama_pegawai','jabatan', 'status as kedudukan_hukum','image', 'jabatan as nama_jabatan','jenis_pegawai'];
        $this->db->where(['jenis_pegawai' => 'Non PNS']);
        return $this;
    }
    
}

/* End of file M_pegawai.php */