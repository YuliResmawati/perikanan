<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_jadwal extends MY_Model {

    protected $_table = 'jadwal';
    protected $_timestamps = TRUE;
    protected $_log_user = TRUE;
    protected $_softdelete = TRUE;
    protected $_order_by = 'id';
    protected $_order = 'ASC';
    protected $_fields_toshow = ['id','guru_id','mapel_id','kelas_id','jadwal_awal','jadwal_akhir','lama_pembelajaran'];
    protected $_fields = [
       'guru_id'            => 'guru_id',
       'mapel_id'           => 'mapel_id',
       'kelas_id'           => 'kelas_id',
       'jadwal_awal'        => 'jadwal_awal',
       'jadwal_akhir'       => 'jadwal_akhir',
       'lama_pembelajaran'  => 'lama_pembelajaran'
    ];

    public function __construct()
    {
        parent::__construct();
    }
}

/* End of file M_sample_upload.php */
