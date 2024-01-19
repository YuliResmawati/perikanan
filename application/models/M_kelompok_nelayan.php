<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_kelompok_nelayan extends MY_Model {

    protected $_table = 'kelompok_nelayan';
    protected $_timestamps = TRUE;
    protected $_log_user = TRUE;
    protected $_softdelete = TRUE;
    protected $_order_by = 'id';
    protected $_order = 'DESC';
    protected $_fields_toshow = [
        'id', 'nama_koperasi', 'nama_ketua', 'alamat', 'jumlah_anggota', 'tahun_berdiri'
    ];
    protected $_fields = [
       'id' => 'id',
    ];

    public function __construct()
    {
        parent::__construct();
    }

}

/* End of file M_kelompok_nelayan.php */
