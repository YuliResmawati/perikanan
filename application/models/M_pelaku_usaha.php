<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_Pelaku_usaha extends MY_Model {

    protected $_table = 'pelaku_usaha';
    protected $_timestamps = TRUE;
    protected $_log_user = TRUE;
    protected $_softdelete = TRUE;
    protected $_order_by = 'id';
    protected $_order = 'DESC';
    protected $_fields_toshow = [
        'id', 'kecamatan_id', 'nama_pelaku', 'telp', 'email', 
        'jumlah_karyawan', 'alamat', 'skala', 'bidang'
    ];
    protected $_fields = [
       'id' => 'id',
    ];

    public function __construct()
    {
        parent::__construct();
    }

    public function get_all_pelaku_usaha()
    {
        parent::clear_join();

        $this->_fields_toshow = ['pelaku_usaha.id', 'nama_kecamatan','nama_pelaku', 'kecamatan_id','pelaku_usaha.bidang',
        'telp', 'email', 'jumlah_karyawan', 'alamat','kecamatan_id', 'skala', 'pelaku_usaha.status',
        "(select count(kusioner_id) from pendataan where pelaku_usaha_id=pelaku_usaha.id) as total",
        ];

        parent::join('v_kecamatan ','pelaku_usaha.kecamatan_id=v_kecamatan.id');
        
        return $this;
    }

}

/* End of file M_Pelaku_usaha.php */
