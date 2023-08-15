<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_tunjangan extends MY_Model {

    protected $_table = 'tunjangan';
    protected $_timestamps = TRUE;
    protected $_log_user = TRUE;
    protected $_softdelete = FALSE;
    protected $_order_by = 'id';
    protected $_order = 'DESC';
    protected $_fields_toshow = ['id','tmt_pembayaran','guru_id','link','alasan'];
    protected $_fields = [
       'tmt_pembayaran' => 'tmt_pembayaran',
       'guru_id' => 'guru_id',
       'link' => 'link',
       'alasan' => 'alasan'
    ];

    public function __construct()
    {
        parent::__construct();
    }

    public function get_all_tunjangan()
    {
        $this->_fields_toshow = ['cuti.id','tmt_pembayaran','guru_id','link','nama_sekolah',
                                'nama_guru','gelar_depan','gelar_belakang','sekolah_id','alasan'
                            ];

        parent::join('guru', 'guru.id=cuti.guru_id', 'left');
        parent::join('sekolah', 'sekolah.id=guru.sekolah_id', 'left');

        return $this;
    }


}

/* End of file M_sample_upload.php */
