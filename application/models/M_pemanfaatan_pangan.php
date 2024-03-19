<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_pemanfaatan_pangan extends MY_Model {

    protected $_table = 'pemanfaatan_pangan';
    protected $_timestamps = TRUE;
    protected $_log_user = TRUE;
    protected $_softdelete = FALSE;
    protected $_order_by = 'id';
    protected $_order = 'DESC';
    protected $_fields_toshow = [
        'id', 'kecamatan_id', 'bb_sangat_kurang', 'bb_kurang','bb_normal','risiko_bb_lebih'
    ];
    protected $_fields = [
       'id' => 'id',
    ];

    public function __construct()
    {
        parent::__construct();
    }

    public function get_all_pemanfaatan_pangan()
    {
        parent::clear_join();

        $this->_fields_toshow = ['pemanfaatan_pangan.id', 'nama_kecamatan','bb_sangat_kurang',
         'bb_kurang','bb_normal','risiko_bb_lebih','kecamatan_id'];

        parent::join('v_kecamatan ','pemanfaatan_pangan.kecamatan_id=v_kecamatan.id');
        
        return $this;
    }

}

/* End of file M_pembanfaatan_pangan.php */
