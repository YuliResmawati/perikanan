<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class School extends Frontend_Controller {

    public function __construct()
	{
		parent::__construct();

		$this->_init();
		$this->data['uri_mod'] = 'daftar-sekolah';
        $this->load->model(['m_app', 'm_sekolah']);
	}

	public function _init()
    {
        $this->output->set_template('frontend');
	}

    public function index()
	{
        $this->data['page_title'] = "Daftar Sekolah";
        $this->data['page_description'] = "Daftar sekolah yang ada di kota bukittingi.";
        $this->data['school_type'] = $this->m_app->get_tipe_sekolah();
        
		$this->load->view('school/v_index', $this->data);
    }

    public function detail($type)
	{
        if (current_url() == base_url('daftar-sekolah/') .$type .'/page') {
			redirect('daftar-sekolah/' .$type, 'refresh');
		}

        $per_page = 12;
		$offset = 0;
		$result_count = count($this->m_sekolah->where(['tipe_sekolah' => strtoupper($type), 'status' => '1'])->findAll());
		$config = $this->paging;
		$config['base_url'] 	    = site_url('daftar-sekolah/' .$type .'/page');
		$config['total_rows'] 	    = $result_count;
		$config['per_page'] 	    = $per_page;
		$config['use_page_numbers'] = TRUE;

		if ($config['use_page_numbers'] == TRUE) {
			$page = $this->uri->segment(4) - 1;

			if ($page > 0) {
				$offset = $page * $per_page;
			}
		} else {
			$offset = $this->uri->segment(3);
		}

		$this->pagination->initialize($config);

        $this->data['page_title'] = "Daftar Sekolah " .strtoupper($type);
        $this->data['page_description'] = "Daftar sekolah yang ada di kota bukittingi.";
		$this->data['school'] = $this->m_sekolah->get_school_by_type($type, $per_page, '', $offset);
		$this->data['type'] = strtoupper($type);
		$this->data['count'] = $result_count;

		if ($result_count > $per_page) {
			$this->data['status_paging'] = 'show';
		} else {
			$this->data['status_paging'] = 'hidden';
		}
          
		$this->load->view('school/v_detail', $this->data);
    }
}

/* End of file School.php */
