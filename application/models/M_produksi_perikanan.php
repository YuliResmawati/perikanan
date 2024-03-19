<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_produksi_perikanan extends MY_Model {

    protected $_table = 'produksi_perikanan';
    protected $_timestamps = TRUE;
    protected $_log_user = TRUE;
    protected $_softdelete = TRUE;
    protected $_order_by = 'id';
    protected $_order = 'DESC';
    protected $_fields_toshow = [
        'id', 'komoditas_id', 'satuan', 'produksi'
    ];
    protected $_fields = [
       'id' => 'id',
    ];

    public function __construct()
    {
        parent::__construct();
    }

    public function get_all_produksi()
    {
        parent::clear_join();

        $this->_fields_toshow = ['produksi_perikanan.id', 'komoditas', 'kamus_data as nama_satuan',
            'satuan' ,'produksi','jenis', 'komoditas_id', 'produksi_perikanan.created_at'
        ];

        parent::join('komoditas ','produksi_perikanan.komoditas_id=komoditas.id');
        parent::join('kamus_data ','produksi_perikanan.satuan=kamus_data.id');
        
        return $this;
    }

    public function get_all_produksi_by_jenis($filter, $optional, $tahun, $opsi)
    {
        parent::clear_join();
        $this->_order_by = FALSE;
        $this->_order = FALSE;

        $this->_fields_toshow = ['komoditas.id', 'komoditas', 'jenis', 'sum(produksi) as produksi'];

        parent::join('komoditas ','produksi_perikanan.komoditas_id=komoditas.id');
        parent::join('kamus_data ','produksi_perikanan.satuan=kamus_data.id');

        if($filter == '1'){
            if ($opsi == '0'){
                $this->db->where(["extract(month from produksi_perikanan.created_at) = '$optional'" => null, "extract(year from produksi_perikanan.created_at) = '$tahun'" => null, 'jenis' => '1']);
            } else {
                $this->db->where(["extract(month from produksi_perikanan.created_at) = '$optional'" => null, "extract(year from produksi_perikanan.created_at) = '$tahun'" => null, 'jenis' => '2']);
            }
        }else if ($filter == '2'){
            if ($optional == '1'){
                if ($opsi == '0'){
                    $this->db->where (["extract(month from produksi_perikanan.created_at) IN ('1','2','3')" => null, "extract(year from produksi_perikanan.created_at) = '$tahun'" => null, 'jenis' => '1']);
                } else {
                    $this->db->where (["extract(month from produksi_perikanan.created_at) IN ('1','2','3')" => null, "extract(year from produksi_perikanan.created_at) = '$tahun'" => null, 'jenis' => '2']);
                }
            } else if ($optional == '2'){
                if ($opsi == '0'){
                    $this->db->where(["extract(month from produksi_perikanan.created_at) IN ('4','5','6')" => null, "extract(year from produksi_perikanan.created_at) = '$tahun'" => null, 'jenis' => '1']);
                } else {
                    $this->db->where(["extract(month from produksi_perikanan.created_at) IN ('4','5','6')" => null, "extract(year from produksi_perikanan.created_at) = '$tahun'" => null, 'jenis' => '2']);
                }
            } else if ($optional == '3'){
                if ($opsi == '0'){
                    $this->db->where(["extract(month from produksi_perikanan.created_at) IN ('7','8','9')" => null, "extract(year from produksi_perikanan.created_at) = '$tahun'" => null, 'jenis' => '1']);
                } else {
                    $this->db->where(["extract(month from produksi_perikanan.created_at) IN ('7','8','9')" => null, "extract(year from produksi_perikanan.created_at) = '$tahun'" => null, 'jenis' => '2']);
                }
            } else {
                if ($opsi == '0'){
                    $this->db->where(["extract(month from produksi_perikanan.created_at) IN ('10','11','12')" => null, "extract(year from produksi_perikanan.created_at) = '$tahun'" => null, 'jenis' => '1']);
                } else {
                    $this->db->where(["extract(month from produksi_perikanan.created_at) IN ('10','11','12')" => null, "extract(year from produksi_perikanan.created_at) = '$tahun'" => null, 'jenis' => '2']);
                }
            }
        }else {
            if ($opsi == '0'){
                $this->db->where(["extract(year from produksi_perikanan.created_at) = '$tahun'" => null, 'jenis' => '1']);
            } else {
                $this->db->where(["extract(year from produksi_perikanan.created_at) = '$tahun'" => null, 'jenis' => '2']);
            }
        }

        $this->db->group_by('komoditas.id');
        return $this;
    }
}

/* End of file M_produksi_perikanan.php */
