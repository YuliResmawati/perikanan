<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_rombel extends MY_Model {

    protected $_table = 'rombel';
    protected $_timestamps = TRUE;
    protected $_log_user = TRUE;
    protected $_softdelete = TRUE;
    protected $_order_by = 'tingkatan';
    protected $_order = 'ASC';
    protected $_fields_toshow = ['id','nama_rombel','tingkatan'];
    protected $_fields = [
       'nama_rombel'     => 'nama_rombel',
       'tingkatan'       => 'tingkatan'
    ];

    public function __construct()
    {
        parent::__construct();
    }

    public function get_all_rombel()
    {   
        parent::clear_join();
        $this->_fields_toshow = [
            'rombel.id as id','tingkatan','nama_rombel'
        ];

        parent::join('detail_rombel d','rombel.id=d.rombel_id');

        return $this;
    }

    public function get_rombel_by_sekolah($sekolah_id){
        $this->_order_by= false;
        $this->_order = false;
        $this->_fields_toshow = [ 'rombel.id','tingkatan','nama_rombel'];
        parent::join('detail_rombel d','rombel.id=d.rombel_id');

        $this->db->where(['sekolah_id' =>$sekolah_id, 'rombel.status' => '1']);

        return $this;
    }




}

/* End of file M_sample_upload.php */
