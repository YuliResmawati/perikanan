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

        $this->load->model(array('m_app'));  
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
                'id' => encrypt_url($row['id'], 'silat_pendidikan'),
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
                'id' => encrypt_url($row['id'], 'silat_pendidikan'),
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
                'id' => encrypt_url($row['id'], 'silat_pendidikan'),
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

   
}

/* End of file Dashboard.php */