<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_indikator_tangkap_ikan extends MY_Model {

    protected $_table = 'indikator_tangkap_ikan';
    protected $_timestamps = TRUE;
    protected $_log_user = TRUE;
    protected $_softdelete = TRUE;
    protected $_order_by = 'id';
    protected $_order = 'DESC';
    protected $_fields_toshow = [
        'id', 'jenis', 'nama_indikator','type_perairan'
    ];
    protected $_fields = [
        'id' => 'id',
    ];

    public function __construct()
    {
        parent::__construct();
    }
}

/* End of file M_indikator_tankap_ikan.php */
