<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_pembudidaya extends MY_Model {

    protected $_table = 'pembudidaya';
    protected $_timestamps = TRUE;
    protected $_log_user = TRUE;
    protected $_softdelete = FALSE;
    protected $_order_by = 'id';
    protected $_order = 'DESC';
    protected $_fields_toshow = [
        'id', 'kecamatan_id', 'jumlah', 'type'
    ];
    protected $_fields = [
       'id' => 'id',
    ];

    public function __construct()
    {
        parent::__construct();
    }

    public function get_all_pembudidya()
    {
        parent::clear_join();

        $this->_fields_toshow = ['pembudidaya.id', 'nama_kecamatan','kecamatan_id','aktif','tidak_aktif','berkelompok','belum_berkelompok'];

        parent::join('v_kecamatan ','pembudidaya.kecamatan_id=v_kecamatan.id');
        
        return $this;
    }

    public function get_report_pembudidya($tahun)
    {
        parent::clear_join();

        $this->_fields_toshow = ['pembudidaya.id', 'nama_kecamatan','kecamatan_id','aktif','tidak_aktif','berkelompok','belum_berkelompok'];

        parent::join('v_kecamatan ','pembudidaya.kecamatan_id=v_kecamatan.id');
        $this->db->where(["extract(year from pembudidaya.created_at) = '$tahun'" => null]);
        
        
        return $this;
    }

}

/* End of file M_pembudidaya.php */
