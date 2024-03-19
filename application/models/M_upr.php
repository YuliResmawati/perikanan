<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_upr extends MY_Model {

    protected $_table = 'upr';
    protected $_timestamps = TRUE;
    protected $_log_user = TRUE;
    protected $_softdelete = FALSE;
    protected $_order_by = 'id';
    protected $_order = 'DESC';
    protected $_fields_toshow = [
        'id', 'kecamatan_id','komoditas_id', 'jumlah_upr','luas_lahan'
    ];
    protected $_fields = [
       'id' => 'id',
    ];

    public function __construct()
    {
        parent::__construct();
    }

    public function get_all_upr()
    {
        parent::clear_join();

        $this->_fields_toshow = ['upr.id', 'komoditas', 
            'jumlah_upr','luas_lahan','kecamatan_id','komoditas_id'];

        parent::join('komoditas ','upr.komoditas_id=komoditas.id');
        
        return $this;
    }

    public function get_report_upr_distinct($tahun)
    {
        parent::clear_join();
        $this->_order_by = FALSE;
        $this->_order = FALSE;

        $this->_fields_toshow = ['komoditas.id', 'komoditas','komoditas_id'];
        parent::join('komoditas ','upr.komoditas_id=komoditas.id');
        $this->db->where(["extract(year from upr.created_at) = '$tahun'" => null]);
        $this->db->distinct();
        
        return $this;
    }

    public function get_report_upr($tahun)
    {
        parent::clear_join();
        $this->_order_by = FALSE;
        $this->_order = FALSE;

        $this->_fields_toshow = ['upr.id', 'komoditas_id', 'jumlah_upr', 'luas_lahan', 'kecamatan_id'];
        $this->db->where(["extract(year from upr.created_at) = '$tahun'" => null]);
        
        return $this;
    }

}

/* End of file M_upr.php */
