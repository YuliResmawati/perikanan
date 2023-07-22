<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_cuti extends MY_Model {

    protected $_table = 'cuti';
    protected $_timestamps = TRUE;
    protected $_log_user = TRUE;
    protected $_softdelete = FALSE;
    protected $_order_by = 'id';
    protected $_order = 'ASC';
    protected $_fields_toshow = ['id','tahun_ajaran_id','guru_id','files','tgl_awal','tgl_akhir','lama_cuti','alasan'];
    protected $_fields = [
       'tahun_ajaran_id' => 'tahun_ajaran_id',
       'guru_id' => 'guru_id',
       'files' => 'files',
       'tgl_awal' => 'tgl_awal',
       'tgl_akhir' => 'tgl_akhir',
       'lama_cuti' => 'lama_cuti',
       'alasan' => 'alasan'
    ];

    public function __construct()
    {
        parent::__construct();
    }

    public function get_all_cuti()
    {
        $this->_fields_toshow = ['cuti.id','tahun_ajaran_id','guru_id','files','tgl_awal','tgl_akhir','lama_cuti',
                                'tahun_ajaran','nama_guru','gelar_depan','gelar_belakang','sekolah_id','cuti.status as status','alasan',
                                "(select sum(lama_cuti) from cuti a where a.guru_id = cuti.guru_id and a.status='1') as total_cuti"
                            ];

        parent::join('tahun_ajaran', 'tahun_ajaran.id=cuti.tahun_ajaran_id', 'left');
        parent::join('guru', 'guru.id=cuti.guru_id', 'left');

        return $this;
    }


}

/* End of file M_sample_upload.php */
