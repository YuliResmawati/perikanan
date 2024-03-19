<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_armada_tangkap_ikan extends MY_Model {

    protected $_table = 'armada_tangkap_ikan';
    protected $_timestamps = TRUE;
    protected $_log_user = TRUE;
    protected $_softdelete = TRUE;
    protected $_order_by = 'id';
    protected $_order = 'DESC';
    protected $_fields_toshow = [
        'id', 'armada', 'jumlah_a','alat_tangkap', 'jumlah_b', 'alat_bantu', 'jumlah_c'
    ];
    protected $_fields = [
        'id' => 'id',
    ];

    public function __construct()
    {
        parent::__construct();
    }

    public function get_all_armada_tangkap(){
        parent::clear_join();
        $this->_order_by = FALSE;
        $this->_order = FALSE;

        $this->_fields_toshow = ['armada_tangkap_ikan.id', 'a.nama_indikator as nama_armada','b.nama_indikator as nama_alat_tangkap',
        'c.nama_indikator as nama_alat_bantu', 'type', 'jumlah_a', 'jumlah_b', 'jumlah_c', 'armada', 'alat_tangkap', 'alat_bantu','armada_tangkap_ikan.created_at'
        ];

        parent::join('indikator_tangkap_ikan a ','armada_tangkap_ikan.armada=a.id', 'left');
        parent::join('indikator_tangkap_ikan b ','armada_tangkap_ikan.alat_tangkap=b.id', 'left');
        parent::join('indikator_tangkap_ikan c ','armada_tangkap_ikan.alat_bantu=c.id', 'left');
        
        return $this;
    }
}

/* End of file M_armada_tangkap_ikan.php */
