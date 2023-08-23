<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_app extends MY_Model {

    protected $_table = 'app';
    protected $_timestamps = FALSE;
    protected $_log_user = FALSE;
    protected $_softdelete = FALSE;
    protected $_order_by = '';
    protected $_order = '';
    protected $_fields_toshow = ['app'];
    protected $_fields = [
        'app' => 'app'
    ];

    public function __construct()
    {
        parent::__construct();
    }


    public function get_kabupaten_by_paging($per_page, $page, $search, $type)
    {
        if($page == 0) $page = 1;
        $page = ($per_page * $page) - $per_page;
        $this->db->select('id, nama_kabupaten, provinsi_id, status');
        $this->db->from('kabupaten');
        $this->db->like('LOWER(nama_kabupaten)', strtolower($search));
        $this->db->limit($per_page, $page);
        $this->db->where('status', '1');

        if ($type == 'data') {
            return $this->db->get()->result_array();
        } else {
            return $this->db->count_all_results();
        }
    }

    public function get_region_by_paging($per_page, $page, $search, $type)
    {
        if($page == 0) $page = 1;
        $page = ($per_page * $page) - $per_page;
        $this->db->select('a.id as provinsi_id, a.nama_provinsi, b.id as kabupaten_id, b.nama_kabupaten, c.id as kecamatan_id, c.nama_kecamatan, d.id as nagari_id, d.nama_nagari');
        $this->db->from('provinsi as a');
        $this->db->join('kabupaten as b', 'a.id=b.provinsi_id');
        $this->db->join('kecamatan as c', 'b.id=c.kabupaten_id');
        $this->db->join('nagari as d', 'c.id=d.kecamatan_id');
        $this->db->like('LOWER(d.nama_nagari)', strtolower($search));
        $this->db->or_like('LOWER(c.nama_kecamatan)', strtolower($search));
        $this->db->limit($per_page, $page);

        if ($type == 'data') {
            return $this->db->get()->result_array();
        } else {
            return $this->db->count_all_results();
        }
    }

    public function get_all_siswa_by_paging($per_page, $page, $search, $type, $option = null)
    {
        if($page == 0) $page = 1;
        $page = ($per_page * $page) - $per_page;
        $this->db->select('siswa.id, nama_siswa, nisn', 'nama_Sekolah');
        $this->db->from('siswa');

        if ($option == TRUE) {
            $this->db->join('detail_siswa','siswa.id = detail_siswa.siswa_id');
            $this->db->join('detail_rombel','detail_siswa.detail_rombel_id = detail_rombel.id');
            $this->db->join('sekolah','detail_rombel.sekolah_id = sekolah.id');
            $this->db->like('LOWER(nama_siswa)', strtolower($search));
            $this->db->where(array('siswa.status' =>'1', 'detail_rombel.sekolah_id' => $this->logged_sekolah_id));
            $this->db->or_like('nisn',$search);
            $this->db->limit($per_page, $page);
            $this->db->where(array('siswa.status' =>'1', 'detail_rombel.sekolah_id' => $this->logged_sekolah_id));
        } else {
            $this->db->join('detail_siswa','siswa.id = detail_siswa.siswa_id');
            $this->db->join('detail_rombel','detail_siswa.detail_rombel_id = detail_rombel.id');
            $this->db->join('sekolah','detail_rombel.sekolah_id = sekolah.id');
            $this->db->like('LOWER(nama_siswa)', strtolower($search));
            $this->db->where(array('siswa.status' =>'1'));
            $this->db->or_like('nisn',$search);
            $this->db->limit($per_page, $page);
            $this->db->where(array('siswa.status' =>'1'));
        }
       

        if ($type == 'data') {
            return $this->db->get()->result_array();
        } else {
            return $this->db->count_all_results();
        }
    }

    public function get_all_guru_by_paging($per_page, $page, $search, $type, $option = null)
    {
        if($page == 0) $page = 1;
        $page = ($per_page * $page) - $per_page;
        $this->db->select('guru.id, nama_guru,nip');
        $this->db->from('guru');

        if ($option == TRUE){
            $this->db->join('sekolah','guru.sekolah_id = sekolah.id');
            $this->db->like('LOWER(nama_guru)', strtolower($search));
            $this->db->where(array('guru.status' =>'1', 'sekolah_id' => $this->logged_sekolah_id));
            $this->db->or_like('nip',$search);
            $this->db->limit($per_page, $page);
            $this->db->where(array('guru.status' =>'1', 'sekolah_id' => $this->logged_sekolah_id));
        } else {
            $this->db->join('sekolah','guru.sekolah_id = sekolah.id');
            $this->db->like('LOWER(nama_guru)', strtolower($search));
            $this->db->where(array('guru.status' =>'1'));
            $this->db->or_like('nip',$search);
            $this->db->limit($per_page, $page);
            $this->db->where(array('guru.status' =>'1'));
        }
        

        if ($type == 'data') {
            return $this->db->get()->result_array();
        } else {
            return $this->db->count_all_results();
        }
    }

    public function get_all_sekolah_by_paging($per_page, $page, $search, $type)
    {
        if($page == 0) $page = 1;
        $page = ($per_page * $page) - $per_page;
        $this->db->select('id, nama_sekolah,npsn');
        $this->db->from('sekolah');
        $this->db->like('LOWER(nama_sekolah)', strtolower($search));
        $this->db->where(array('status' =>'1'));
        $this->db->or_like('npsn',$search);
        $this->db->limit($per_page, $page);
        $this->db->where(array('status' =>'1'));

        if ($type == 'data') {
            return $this->db->get()->result_array();
        } else {
            return $this->db->count_all_results();
        }
    }

    public function AjaxGetSekolahByTipe($tipe_sekolah = null)
    {
        $this->output->unset_template();
        $tipe_sekolah = $this->input->post('tipe_sekolah');

            if ($tipe_sekolah != FALSE) {
                
                $this->return = $this->m_sekolah->get_sekolah_by_tipe($tipe_sekolah)->findAll();
                foreach ($this->return as $key => $value) {
                    $this->return[$key]->id = encrypt_url($value->id, $this->id_key);
                }

                if ($this->return) {
                    $this->result = array (
                        'status' => TRUE,
                        'message' => 'Berhasil mengambil data',
                        'token' => $this->security->get_csrf_hash(),
                        'data' => $this->return
                    );
                } else {
                    $this->result = array (
                        'status' => FALSE,
                        'message' => 'Sekolah tidak dapat ditampilkan',
                        'data' => []
                    );
                }
            } else {
                $this->result = array('status' => FALSE, 'message' => 'ID tidak valid');
            }
        

        if ($this->result) {
            $this->output->set_output(json_encode($this->result));
        } else {
            $this->output->set_output(json_encode(['status'=> FALSE, 'message'=> 'Terjadi kesalahan.']));
        }

    }

    public function AjaxGetRombelBySekolah($sekolah_id = null)
    {
        $this->output->unset_template();
        $sekolah_id = decrypt_url($this->input->post('sekolah_id'), $this->id_key);

            if ($sekolah_id != FALSE) {
                
                $this->return = $this->m_rombel->get_rombel_by_sekolah($sekolah_id)->findAll();
                foreach ($this->return as $key => $value) {
                    $this->return[$key]->id = encrypt_url($value->id, $this->id_key);
                }

                if ($this->return) {
                    $this->result = array (
                        'status' => TRUE,
                        'message' => 'Berhasil mengambil data',
                        'token' => $this->security->get_csrf_hash(),
                        'data' => $this->return
                    );
                } else {
                    $this->result = array (
                        'status' => FALSE,
                        'message' => 'Sekolah tidak dapat ditampilkan',
                        'data' => []
                    );
                }
            } else {
                $this->result = array('status' => FALSE, 'message' => 'ID tidak valid');
            }
        

        if ($this->result) {
            $this->output->set_output(json_encode($this->result));
        } else {
            $this->output->set_output(json_encode(['status'=> FALSE, 'message'=> 'Terjadi kesalahan.']));
        }

    }

    public function get_count_sekolah() 
    {
        parent::clear_join();

        $this->_table = 'sekolah';
        $this->_timestamps = FALSE;
        $this->_log_user = FALSE;
        $this->_primary_key = 'id';
        $this->_fields_toshow = ['nama_sekolah'];

        $this->db->where('status', '1');

        return count(parent::findAll());
    }

    public function get_count_student() 
    {
        parent::clear_join();

        $this->_table = 'siswa';
        $this->_timestamps = FALSE;
        $this->_log_user = FALSE;
        $this->_primary_key = 'id';
        $this->_fields_toshow = ['nama_siswa'];

        $this->db->where('status', '1');

        return count(parent::findAll());
    }

    public function get_count_teacher() 
    {
        parent::clear_join();

        $this->_table = 'guru';
        $this->_timestamps = FALSE;
        $this->_log_user = FALSE;
        $this->_primary_key = 'id';
        $this->_fields_toshow = ['nama_guru'];

        $this->db->where('status', '1');

        return count(parent::findAll());
    }

    public function get_tipe_sekolah() 
    {
        parent::clear_join();

        $this->_table = 'sekolah';
        $this->_primary_key = 'id';
        $this->_fields_toshow = ['DISTINCT(tipe_sekolah)'];

        $this->db->where('status', '1');
        $this->db->order_by('tipe_sekolah', 'asc');
        return parent::findAll();
    }
}

/* End of file M_app.php */
