<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Announcement extends Frontend_Controller {

    public function __construct()
	{
		parent::__construct();

		$this->_init();
		$this->data['uri_mod'] = 'pengumuman';
		$this->load->model('m_pengumuman');
	}

	public function _init()
    {
        $this->output->set_template('frontend');
	}

    public function index()
	{
        if (current_url() == base_url('pengumuman/page')) {
			redirect('pengumuman', 'refresh');
		}

        $per_page = 4;
		$offset = 0;
		$result_count = count($this->m_pengumuman->where(['status' => '1'])->findAll());
		$config = $this->paging;
		$config['base_url'] 	    = site_url('pengumuman/page');
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

        $this->data['page_title'] = "Pengumuman";
        $this->data['page_description'] = "Kumpulan pengumuman silat pendidikan kota bukittinggi.";
		$this->data['pengumuman'] = $this->m_pengumuman->get_content_pengumuman($per_page, '', $offset);
        $this->data['total'] = $result_count;

		if ($result_count > $per_page) {
			$this->data['status_paging'] = 'show';
		} else {
			$this->data['status_paging'] = 'hidden';
		}
        
		$this->load->view('announcement/v_index', $this->data);
    }

}

/* End of file Announcement.php */
