<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_detail_rombel extends MY_Model {

    protected $_table = 'detail_rombel';
    protected $_timestamps = TRUE;
    protected $_log_user = TRUE;
    protected $_softdelete = TRUE;
    protected $_order_by = 'id';
    protected $_order = 'ASC';
    protected $_fields_toshow = ['id','rombel_id','sekolah_id','walas_id'];
    protected $_fields = [
       'id' => 'id',
       'rombel_id' => 'rombel_id',
       'sekolah_id' => 'sekolah_id',
       'walas_id' => 'walas_id'
    ];

    public function __construct()
    {
        parent::__construct();
    }

    public function get_rombel_by_sekolah($sekolah_id){
        $this->_fields_toshow = [ 'detail_rombel.id','nama_rombel','sekolah_id','sekolah.status','tingkatan','nama_sekolah'];
        parent::join('sekolah','detail_rombel.sekolah_id=sekolah.id');
        parent::join('rombel','detail_rombel.rombel_id=rombel.id');
        $this->db->where(array('detail_rombel.sekolah_id' => $sekolah_id ,'sekolah.status' =>'1'));
        
        return $this;
    }

    public function get_detail_rombel_by_rombel($rombel_id){
        $this->_fields_toshow = [ 'detail_rombel.id','nama_rombel','sekolah_id','sekolah.status','tingkatan','nama_sekolah'];
        parent::join('sekolah','detail_rombel.sekolah_id=sekolah.id');
        parent::join('rombel','detail_rombel.rombel_id=rombel.id');
        $this->db->where(array('detail_rombel.rombel_id' => $rombel_id ,'detail_rombel.status' =>'1'));
        
        return $this;
    }

    public function get_all_rombel(){
        $this->_fields_toshow = [ 'detail_rombel.id','nama_rombel','detail_rombel.sekolah_id','sekolah.status','detail_rombel.status as detail_rombel_status',
                                    'npsn','nama_sekolah','nama_guru','tingkatan','rombel_id','walas_id','gelar_depan','gelar_belakang',
                                    '(select count(id) from detail_siswa where detail_rombel_id = detail_rombel.id) as jumlah_siswa'
                                ];
        parent::join('sekolah','detail_rombel.sekolah_id=sekolah.id');
        parent::join('rombel','detail_rombel.rombel_id=rombel.id');
        parent::join('guru','detail_rombel.walas_id=guru.id');
        
        return $this;
    }

}

/* End of file M_sample_upload.php */
