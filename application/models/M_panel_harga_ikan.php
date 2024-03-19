<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_panel_harga_ikan extends MY_Model {

    protected $_table = 'panel_harga_ikan';
    protected $_timestamps = TRUE;
    protected $_log_user = TRUE;
    protected $_softdelete = TRUE;
    protected $_order_by = 'id';
    protected $_order = 'ASC';
    protected $_fields_toshow = ['id', 'komoditas_id','harga'];
    protected $_fields = [
        'id' => 'id'
    ];

    public function __construct()
    {
        parent::__construct();
    }

    public function get_all_panel_ikan(){
        
        parent::clear_join();

        $this->_fields_toshow = ['panel_harga_ikan.id', 'komoditas', 'satuan','komoditas_id', 
            'harga', 'panel_harga_ikan.created_at as tanggal','jenis','volume', 'kamus_data as nama_satuan'];

        parent::join('komoditas ','panel_harga_ikan.komoditas_id=komoditas.id');
        parent::join('kamus_data ','panel_harga_ikan.satuan=kamus_data.id');
        

        return $this;
    }

    public function get_tahun($type){

        parent::clear_join();
        $this->_order_by = false;

        $this->_fields_toshow = ["date_part('Y', created_at) as tahun"];
        $this->db->where(['type' => $type]);
        $this->db->distinct();

        return $this;
    }

    public function get_report_harga_ikan_by_jenis($tanggal, $opsi, $type)
    {
        parent::clear_join();

        $this->_fields_toshow = ['panel_harga_ikan.id', 'komoditas', 'satuan',
        'harga', 'jenis','volume', 'kamus_data as nama_satuan',
        'panel_harga_ikan.type', 'panel_harga_ikan.created_at'];

        parent::join('komoditas ','panel_harga_ikan.komoditas_id=komoditas.id');
        parent::join('kamus_data ','panel_harga_ikan.satuan=kamus_data.id');

        if ($opsi == '0'){
            $this->db->where(['date(panel_harga_ikan.created_at)' => $tanggal, 'jenis' => '1', 'panel_harga_ikan.type' => $type]);
        } else {
            $this->db->where(['date(panel_harga_ikan.created_at)' => $tanggal, 'jenis' => '2', 'panel_harga_ikan.type' => $type]);
        }
        
        
        return $this;
    }
}