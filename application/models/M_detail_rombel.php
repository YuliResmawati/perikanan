<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_detail_rombel extends MY_Model {

    protected $_table = 'detail_rombel';
    protected $_timestamps = TRUE;
    protected $_log_user = TRUE;
    protected $_softdelete = TRUE;
    protected $_order_by = 'id';
    protected $_order = 'ASC';
    protected $_fields_toshow = ['id','rombel_id','sekolah_id'];
    protected $_fields = [
       'id' => 'id'
    ];

    public function __construct()
    {
        parent::__construct();
    }

    public function get_rombel_by_sekolah($sekolah_id){
        $this->_fields_toshow = [ 'detail_rombel.id','nama_rombel','sekolah_id','sekolah.status'];
        parent::join('sekolah','detail_rombel.sekolah_id=sekolah.id');
        parent::join('rombel','detail_rombel.rombel_id=rombel.id');
        $this->db->where(array('detail_rombel.sekolah_id' => $sekolah_id ,'sekolah.status' =>'1'));
        
        return $this;
    }


}

/* End of file M_sample_upload.php */
