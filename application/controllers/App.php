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

        $this->load->model(array('m_app','m_komoditas'));  
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
        $results = $this->m_app->get_kecamatan_by_paging($perPage, $page, $search, 'data');
		$countResults = $this->m_app->get_kecamatan_by_paging($perPage, $page, $search, 'count');

        $this->return = [];

        foreach ($results as $row) {
            $this->return[] = array(
                'id' => encrypt_url($row['id'], 'app'),
                'text' => $row['nama_kecamatan']
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

    public function AjaxGetKomoditas($params)
    {
        $this->output->unset_template();

        $search = $this->input->post('search');
        $page = $this->input->post('page');
        $params = decrypt_url($params, 'app');
		$perPage = 10;
        $results = $this->m_app->get_komoditas_by_paging($perPage, $page, $search, 'data', $params);
		$countResults = $this->m_app->get_komoditas_by_paging($perPage, $page, $search, 'count', $params);

        $this->return = [];

        foreach ($results as $row) {
            $text = $row['komoditas'];

            $this->return[] = array(
                'id' => encrypt_url($row['id'], 'app'),
                'text' => $text
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

    public function AjaxGetPelaku()
    {
        $this->output->unset_template();

        $search = $this->input->post('search');
        $page = $this->input->post('page');
		$perPage = 10;
        $results = $this->m_app->get_pelaku_by_paging($perPage, $page, $search, 'data');
		$countResults = $this->m_app->get_pelaku_by_paging($perPage, $page, $search, 'count');

        $this->return = [];

        foreach ($results as $row) {
            $text = $row['nama_pelaku'];

            $this->return[] = array(
                'id' => encrypt_url($row['id'], 'app'),
                'text' => $text
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

    public function AjaxGetValueByJenis()
    {
        $this->output->unset_template();
        $jenis_id = decrypt_url($this->input->post('id'), 'app');

        if ($jenis_id != FALSE) { 
            $this->return = $this->m_komoditas->get_all_komoditas_ikan()->where([
                    'jenis' => $jenis_id,
                    'status' => '1'])->findAll();

            foreach ($this->return as $key => $value) {
                $this->return[$key]->id = encrypt_url($value->id, 'app');
                unset($this->return[$key]->status);
                
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
                    'message' => 'Gagal mengambil data',
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

    public function AjaxGetKomoditiPSAT()
    {
        $this->output->unset_template();

        $search = $this->input->post('search');
        $page = $this->input->post('page');
		$perPage = 10;
        $results = $this->m_app->get_komoditas_psat_by_paging($perPage, $page, $search, 'data');
		$countResults = $this->m_app->get_komoditas_psat_by_paging($perPage, $page, $search, 'count');

        $this->return = [];

        foreach ($results as $row) {
            $text = $row['komoditas'];

            $this->return[] = array(
                'id' => encrypt_url($row['id'], 'app'),
                'text' => $text
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

    public function AjaxGetIndikator($choise, $params)
    {
        $this->output->unset_template();

        $search = $this->input->post('search');
        $page = $this->input->post('page');
        $params = decrypt_url($params, 'app');
		$perPage = 10;
        $results = $this->m_app->get_indikator_by_paging($perPage, $page, $search, 'data', $choise, $params);
		$countResults = $this->m_app->get_indikator_by_paging($perPage, $page, $search, 'count', $choise, $params);

        $this->return = [];

        foreach ($results as $row) {
            $text = $row['nama_indikator'];

            $this->return[] = array(
                'id' => encrypt_url($row['id'], 'app'),
                'text' => $text
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