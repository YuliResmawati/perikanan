<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_ikm extends MY_Model {

    protected $_table = 'ikm';
    protected $_timestamps = TRUE;
    protected $_log_user = TRUE;
    protected $_softdelete = TRUE;
    protected $_order_by = 'id';
    protected $_order = 'DESC';
    protected $_fields_toshow = [
        'id','ikm', 'status'
    ];
    protected $_fields = [
       'id' => 'id',
    ];

    public function __construct()
    {
        parent::__construct();
    }

    public function get_all_poin_ikm()
    {
        parent::clear_join();

        $this->_fields_toshow = ['detail_ikm.id','ikm', 'nilai', 'ikm.status','nama_kategori'];

        parent::join('detail_ikm ','ikm.id=detail_ikm.ikm_id');
        parent::join('kategori_ikm ','detail_ikm.kategori_ikm_id=kategori_ikm.id');
        $this->db->where('ikm.status', '1');

        return $this;
    }

}

/* End of file M_ikm.php */
