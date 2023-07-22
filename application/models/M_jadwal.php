<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_jadwal extends MY_Model {

    protected $_table = 'jadwal';
    protected $_timestamps = TRUE;
    protected $_log_user = TRUE;
    protected $_softdelete = TRUE;
    protected $_order_by = 'id';
    protected $_order = 'ASC';
    protected $_fields_toshow = ['id','guru_id','mapel_id','detail_rombel_id','hari','jadwal_awal','jadwal_akhir','lama_pembelajaran'];
    protected $_fields = [
       'guru_id'            => 'guru_id',
       'mapel_id'           => 'mapel_id',
       'detail_rombel_id'   => 'detail_rombel_id',
       'hari'               => 'hari',
       'jadwal_awal'        => 'jadwal_awal',
       'jadwal_akhir'       => 'jadwal_akhir',
       'lama_pembelajaran'  => 'lama_pembelajaran'
    ];

    public function __construct()
    {
        parent::__construct();
    }

    public function get_all_jadwal(){
        $this->_fields_toshow = [ 'jadwal.id','nama_guru','gelar_depan','gelar_belakang','nama_mapel','hari','jadwal_awal','jadwal_akhir','lama_pembelajaran',
                                    'jadwal.guru_id','jadwal.mapel_id','jadwal.detail_rombel_id','jadwal.status'
                                ];
        parent::join('guru','jadwal.guru_id=guru.id');
        parent::join('mapel','jadwal.mapel_id=mapel.id');
        
        return $this;
    }

}

/* End of file M_sample_upload.php */
