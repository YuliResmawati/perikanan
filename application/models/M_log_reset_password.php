<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_log_reset_password extends MY_Model {

    protected $_table = '_log_reset_password';
    protected $_timestamps = TRUE;
    protected $_log_user = TRUE;
    protected $_softdelete = TRUE;
    protected $_order_by = 'id';
    protected $_order = 'DESC';
    protected $_fields_toshow = ['id'];
    protected $_fields = [
        'id'    => 'id'
    ];

    public function __construct()
    {
        parent::__construct();
    }

    public function get_log_reset()
    {
        parent::clear_join();

        $this->_fields_toshow = [
            'user_id', 'c.nama_pegawai', 'c.nip', 'cc.nama_pegawai as penanggung_jawab', '_log_reset_password.created_at as tanggal_reset', '_log_reset_password.status'
        ];

        parent::join('users b','_log_reset_password.user_id=b.id', 'left');
        parent::join('pegawai c','b.pegawai_id=c.id', 'left');
        parent::join('users d','_log_reset_password.created_by=d.id', 'left');
        parent::join('pegawai cc','d.pegawai_id=cc.id', 'left');

        return $this;
    }

}

/* End of file M_pejabat_level.php */