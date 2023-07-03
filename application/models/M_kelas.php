<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_kelas extends MY_Model {

    protected $_table = 'kelas';
    protected $_timestamps = TRUE;
    protected $_log_user = TRUE;
    protected $_softdelete = TRUE;
    protected $_order_by = 'sekolah_id';
    protected $_order = 'ASC';
    protected $_fields_toshow = ['id','sekolah_id','guru_id','nama_kelas','tingkat', 'tipe'];
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


}

/* End of file M_sample_upload.php */
