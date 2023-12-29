<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Publication extends Frontend_Controller {

    public function __construct()
	{
		parent::__construct();

		$this->_init();
		$this->data['uri_mod'] = 'publication';
		$this->load->model('m_content');
        $this->load->library('img');
	}

	public function _init()
    {
        $this->output->set_template('frontend');
	}

    public function index()
	{
        if (current_url() == base_url('publication/page')) {
			redirect('publication', 'refresh');
		}

        $per_page = 4;
		$offset = 0;
		$result_count = count($this->m_content->where(['status' => '1', 'kategori_konten_id' => '4'])->findAll());
		$config = $this->paging;
		$config['base_url'] 	    = site_url('publication/page');
		$config['total_rows'] 	    = $result_count;
		$config['per_page'] 	    = $per_page;
		$config['use_page_numbers'] = TRUE;

		if ($config['use_page_numbers'] == TRUE) {
			$page = $this->uri->segment(3) - 1;
			if ($page > 0) {
				$offset = $page * $per_page;
			}
		} else {
			$offset = $this->uri->segment(3);
		}

		$this->pagination->initialize($config);

        $this->data['page_title'] = "Publikasi";
        $this->data['page_description'] = "Kumpulan publikasi dinas ketahanan pangan dan perikanan.";
		$this->data['publikasi'] = $this->m_content->get_content_by_type($per_page, '', $offset, '4');
        $this->data['total'] = $result_count;

		if ($result_count > $per_page) {
			$this->data['status_paging'] = 'show';
		} else {
			$this->data['status_paging'] = 'hidden';
		}
        
		$this->load->view('publication/v_index', $this->data);
    }

}

/* End of file Announcement.php */
