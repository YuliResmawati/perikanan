<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class App extends Backend_Controller {

    public function __construct()
	 {
        parent::__construct();
        $this->_init();
        $this->data['uri_mod'] = 'app';
        $this->id_key = $this->private_key;
        $this->breadcrumbs->push('App', 'app');

        $this->load->model(array('m_app','m_sekolah','m_guru','m_siswa','m_rombel'));  
	 }

	public function _init()
    {
        $this->output->set_template('backend');
    }

    public function index()
    {
       show_404();
    }

    public function AjaxGetDistrict()
    {
        $this->output->unset_template();

        $search = $this->input->post('search');
        $page = $this->input->post('page');
		$perPage = 10;
        $results = $this->m_app->get_kabupaten_by_paging($perPage, $page, $search, 'data');
		$countResults = $this->m_app->get_kabupaten_by_paging($perPage, $page, $search, 'count');

        $this->return = [];

        foreach ($results as $row) {
            $this->return[] = array(
                'id' => encrypt_url($row['id'], 'app'),
                'text' => $row['nama_kabupaten']
            );
        }

        if ($this->return) {
            $this->result = array ( 
                'status' => TRUE, 
                'message' => 'Berhasil mengambil data', 
                'items' => $this->return,
                'total_count' => $countResults
            ); 
        } else {
            $this->result = array ( 
                'status' => FALSE, 
                'message' => 'Gagal mengambil data', 
                'items' => [],
                'total_count' => 0
            ); 
        }

        if ($this->result) { 
            $this->output->set_content_type('application/json')->set_output(json_encode($this->result));
        } else { 
            $this->output->set_output(json_encode(['status'=> FALSE, 'message'=> 'Terjadi kesalahan pada response server.'])); 
        } 
    }

    public function AjaxGetRegion()
    {
        $this->output->unset_template();

        $search = $this->input->post('search');
        $page = $this->input->post('page');
		$perPage = 10;
        $results = $this->m_app->get_region_by_paging($perPage, $page, $search, 'data');
		$countResults = $this->m_app->get_region_by_paging($perPage, $page, $search, 'count');

        $this->return = [];

        foreach ($results as $row) {
            $this->return[] = array(
                'id' => encrypt_url($row['nagari_id'], 'app'),
                'text' => "Kelurahan " . uc_words($row['nama_nagari']) . ", Kecamatan " . uc_words($row['nama_kecamatan']) . ", " . uc_words($row['nama_kabupaten']) . ", Provinsi " . uc_words($row['nama_provinsi']),
            );
        }

        if ($this->return) {
            $this->result = array ( 
                'status' => TRUE, 
                'message' => 'Berhasil mengambil data', 
                'items' => $this->return,
                'total_count' => $countResults
            ); 
        } else {
            $this->result = array ( 
                'status' => FALSE, 
                'message' => 'Gagal mengambil data', 
                'items' => [],
                'total_count' => 0
            ); 
        }

        if ($this->result) { 
            $this->output->set_content_type('application/json')->set_output(json_encode($this->result));
        } else { 
            $this->output->set_output(json_encode(['status'=> FALSE, 'message'=> 'Terjadi kesalahan pada response server.'])); 
        } 
    }

    public function AjaxGetSekolah()
    {
        $this->output->unset_template();

        $search = $this->input->post('search');
        $page = $this->input->post('page');
		$perPage = 10;
        $results = $this->m_app->get_all_sekolah_by_paging($perPage, $page, $search, 'data');
		$countResults = $this->m_app->get_all_sekolah_by_paging($perPage, $page, $search, 'count');

        $this->return = [];

        foreach ($results as $row) {
            $this->return[] = array(
                'id' => encrypt_url($row['id'], 'dkpp'),
                'text' => $row['npsn'] . " - " . $row['nama_sekolah']
            );
        }

        if ($this->return) {
            $this->result = array ( 
                'status' => TRUE, 
                'message' => 'Berhasil mengambil data', 
                'items' => $this->return,
                'total_count' => $countResults
            ); 
        } else {
            $this->result = array ( 
                'status' => FALSE, 
                'message' => 'Gagal mengambil data', 
                'items' => [],
                'total_count' => 0
            ); 
        }

        if ($this->result) { 
            $this->output->set_content_type('application/json')->set_output(json_encode($this->result));
        } else { 
            $this->output->set_output(json_encode(['status'=> FALSE, 'message'=> 'Terjadi kesalahan pada response server.'])); 
        } 
    }

    public function AjaxGetSiswa($option = null)
    {
        $this->output->unset_template();

        $search = $this->input->post('search');
        $page = $this->input->post('page');
		$perPage = 10;

        if ($option == TRUE) {
            $results = $this->m_app->get_all_siswa_by_paging($perPage, $page, $search, 'data', true);
		    $countResults = $this->m_app->get_all_siswa_by_paging($perPage, $page, $search, 'count', true);
        }else {
            $results = $this->m_app->get_all_siswa_by_paging($perPage, $page, $search, 'data');
		    $countResults = $this->m_app->get_all_siswa_by_paging($perPage, $page, $search, 'count');
        }
        

        $this->return = [];

        foreach ($results as $row) {
            $this->return[] = array(
                'id' => encrypt_url($row['id'], 'dkpp'),
                'text' => $row['nisn'] . " - " . $row['nama_siswa']
            );
        }

        if ($this->return) {
            $this->result = array ( 
                'status' => TRUE, 
                'message' => 'Berhasil mengambil data', 
                'items' => $this->return,
                'total_count' => $countResults
            ); 
        } else {
            $this->result = array ( 
                'status' => FALSE, 
                'message' => 'Gagal mengambil data', 
                'items' => [],
                'total_count' => 0
            ); 
        }

        if ($this->result) { 
            $this->output->set_content_type('application/json')->set_output(json_encode($this->result));
        } else { 
            $this->output->set_output(json_encode(['status'=> FALSE, 'message'=> 'Terjadi kesalahan pada response server.'])); 
        } 
    }

    public function AjaxGetGuru($option = null)
    {
        $this->output->unset_template();

        $search = $this->input->post('search');
        $page = $this->input->post('page');
		$perPage = 10;

        if ($option == TRUE) {
            $results = $this->m_app->get_all_guru_by_paging($perPage, $page, $search, 'data', true);
            $countResults = $this->m_app->get_all_guru_by_paging($perPage, $page, $search, 'count', true);
        }else {
            $results = $this->m_app->get_all_guru_by_paging($perPage, $page, $search, 'data');
            $countResults = $this->m_app->get_all_guru_by_paging($perPage, $page, $search, 'count');
        }
       

        $this->return = [];

        foreach ($results as $row) {
            $this->return[] = array(
                'id' => encrypt_url($row['id'], 'dkpp'),
                'text' => $row['nip'] . " - " . $row['nama_guru']
            );
        }

        if ($this->return) {
            $this->result = array ( 
                'status' => TRUE, 
                'message' => 'Berhasil mengambil data', 
                'items' => $this->return,
                'total_count' => $countResults
            ); 
        } else {
            $this->result = array ( 
                'status' => FALSE, 
                'message' => 'Gagal mengambil data', 
                'items' => [],
                'total_count' => 0
            ); 
        }

        if ($this->result) { 
            $this->output->set_content_type('application/json')->set_output(json_encode($this->result));
        } else { 
            $this->output->set_output(json_encode(['status'=> FALSE, 'message'=> 'Terjadi kesalahan pada response server.'])); 
        } 
    }

    public function AjaxGetSekolahByTipe($tipe_sekolah = null)
    {
        $this->output->unset_template();
        $tipe_sekolah = $this->input->post('tipe_sekolah');

            if ($tipe_sekolah != FALSE) {
                
                $this->return = $this->m_sekolah->get_sekolah_by_tipe($tipe_sekolah)->findAll();
                foreach ($this->return as $key => $value) {
                    $this->return[$key]->id = encrypt_url($value->id, 'app');
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
        $sekolah_id = decrypt_url($this->input->post('sekolah_id'), 'app');

            if ($sekolah_id != FALSE) {
                
                $this->return = $this->m_rombel->get_rombel_by_sekolah($sekolah_id)->findAll();
                foreach ($this->return as $key => $value) {
                    $this->return[$key]->id = encrypt_url($value->id, 'app');
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

    public function AjaxGetGuruBySekolah($sekolah_id = null)
    {
        $this->output->unset_template();
        $sekolah_id = decrypt_url($this->input->post('sekolah_id'), 'app');

            if ($sekolah_id != FALSE) {
                
                $this->return = $this->m_guru->get_guru_by_sekolah($sekolah_id)->findAll();
                foreach ($this->return as $key => $value) {
                    $this->return[$key]->id = encrypt_url($value->id, 'app');
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


   
}

/* End of file Dashboard.php */