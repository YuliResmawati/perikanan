<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_produksi_budidaya extends MY_Model {

    protected $_table = 'produksi_budidaya';
    protected $_timestamps = TRUE;
    protected $_log_user = TRUE;
    protected $_softdelete = TRUE;
    protected $_order_by = 'id';
    protected $_order = 'DESC';
    protected $_fields_toshow = [
        'id', 'komoditas_id', 'satuan', 'jumlah_produksi','media_budidaya'
    ];
    protected $_fields = [
       'id' => 'id',
    ];

    public function __construct()
    {
        parent::__construct();
    }

    public function get_all_produksi_budidaya()
    {
        parent::clear_join();

        $this->_fields_toshow = ['produksi_budidaya.id', 'komoditas', 'b.kamus_data as nama_media', 
            'satuan', 'a.kamus_data as nama_satuan' ,'jumlah_produksi',
            'jenis', 'komoditas_id', 'media_budidaya', 'produksi_budidaya.created_at'
        ];

        parent::join('komoditas ','produksi_budidaya.komoditas_id=komoditas.id');
        parent::join('kamus_data a ','produksi_budidaya.satuan=a.id');
        parent::join('kamus_data b ','produksi_budidaya.media_budidaya=b.id');
        
        return $this;
    }

    public function get_report_produksi_budidaya_distinct($filter, $optional, $tahun)
    {
        parent::clear_join();
        $this->_order_by = FALSE;
        $this->_order = FALSE;

        $this->_fields_toshow = ['komoditas.id', 'komoditas', 'komoditas_id'];

        parent::join('komoditas ','produksi_budidaya.komoditas_id=komoditas.id');

        if($filter == '1'){
            $this->db->where(["extract(month from produksi_budidaya.created_at) = '$optional'" => null, "extract(year from produksi_budidaya.created_at) = '$tahun'" => null]);
        }else if ($filter == '2'){
            if ($optional == '1'){
                $this->db->where (["extract(month from produksi_budidaya.created_at) IN ('1','2','3')" => null, "extract(year from produksi_budidaya.created_at) = '$tahun'" => null]);
            } else if ($optional == '2'){
                $this->db->where (["extract(month from produksi_budidaya.created_at) IN ('4','5','6')" => null, "extract(year from produksi_budidaya.created_at) = '$tahun'" => null]);
            } else if ($optional == '3'){
                $this->db->where(["extract(month from produksi_budidaya.created_at) IN ('7','8','9')" => null, "extract(year from produksi_budidaya.created_at) = '$tahun'" => null]);
            } else {
                $this->db->where(["extract(month from produksi_budidaya.created_at) IN ('10','11','12')" => null, "extract(year from produksi_budidaya.created_at) = '$tahun'" => null]);
            }
        }else {
            $this->db->where(["extract(year from produksi_budidaya.created_at) = '$tahun'" => null]);
        }
        $this->db->distinct();
        
        return $this;
    }

    public function get_report_produksi_budidaya($filter, $optional, $tahun)
    {
        parent::clear_join();
        $this->_order_by = FALSE;
        $this->_order = FALSE;

        $this->_fields_toshow = ['komoditas.id', 'sum(jumlah_produksi) as jumlah_produksi', 'media_budidaya', 'komoditas_id'];

        parent::join('komoditas ','produksi_budidaya.komoditas_id=komoditas.id');

        if($filter == '1'){
            $this->db->where(["extract(month from produksi_budidaya.created_at) = '$optional'" => null, "extract(year from produksi_budidaya.created_at) = '$tahun'" => null]);
        }else if ($filter == '2'){
            if ($optional == '1'){
                $this->db->where (["extract(month from produksi_budidaya.created_at) IN ('1','2','3')" => null, "extract(year from produksi_budidaya.created_at) = '$tahun'" => null]);
            } else if ($optional == '2'){
                $this->db->where (["extract(month from produksi_budidaya.created_at) IN ('4','5','6')" => null, "extract(year from produksi_budidaya.created_at) = '$tahun'" => null]);
            } else if ($optional == '3'){
                $this->db->where(["extract(month from produksi_budidaya.created_at) IN ('7','8','9')" => null, "extract(year from produksi_budidaya.created_at) = '$tahun'" => null]);
            } else {
                $this->db->where(["extract(month from produksi_budidaya.created_at) IN ('10','11','12')" => null, "extract(year from produksi_budidaya.created_at) = '$tahun'" => null]);
            }
        }else {
            $this->db->where(["extract(year from produksi_budidaya.created_at) = '$tahun'" => null]);
        }
        $this->db->group_by('komoditas.id, media_budidaya, komoditas_id ');
        
        return $this;
    }

}

/* End of file M_produksi_budidaya.php */
