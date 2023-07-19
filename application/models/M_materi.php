<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_materi extends MY_Model {

    protected $_table = 'materi';
    protected $_timestamps = TRUE;
    protected $_log_user = TRUE;
    protected $_softdelete = TRUE;
    protected $_order_by = 'id';
    protected $_order = 'ASC';
    protected $_fields_toshow = ['id','mapel_id','nama_materi','jumlah_jam','sks'];
    protected $_fields = [
       'mapel_id'         => 'mapel_id',
       'nama_materi'      => 'nama_materi',
       'jumlah_jam'       => 'jumlah_jam',
       'sks'              => 'sks'
    ];

    public function __construct()
    {
        parent::__construct();
    }

    public function get_materi_by_mapel($mapel_id){
        $this->_order_by= false;
        $this->_order = false;
        $this->_fields_toshow = [ 'mapel_id','nama_materi','jumlah_jam','sks','nama_mapel'];
        $this->db->join('mapel', 'mapel.id = materi.mapel_id');
        $this->db->where(['mapel.id' =>$mapel_id]);

        return $this; 
    }

    public function get_materi(){
        $this->_order_by= false;
        $this->_order = false;
        $this->_fields_toshow = [ 'materi.id as id','mapel_id','nama_materi','jumlah_jam','sks','nama_mapel'];
        $this->db->join('mapel', 'mapel.id = materi.mapel_id');

        return $this; 
    }

}

/* End of file M_sample_upload.php */
