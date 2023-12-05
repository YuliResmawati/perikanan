<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Gallery_dkpp extends Frontend_Controller {

    public function __construct()
	{
		parent::__construct();

		$this->_init();
		$this->data['uri_mod'] = 'gallery-dkpp';
		$this->load->model('m_gallery');
	}

	public function _init()
    {
        $this->output->set_template('frontend');
	}

    public function index()
	{

        $this->data['page_title'] = "Gallery";
        $this->data['page_description'] = "Gallery Dinas Ketahanan Pangan dan Perikanan.";
        $this->data['gallery'] = $this->m_gallery->where(['type' => '1'])->findAll();
        
		$this->load->view('gallery/v_index', $this->data);
    }

	public function index_video()
	{
		$this->data['page_title'] = "Gallery";
        $this->data['page_description'] = "Gallery Dinas Ketahanan Pangan dan Perikanan.";
        $this->data['video'] = $this->m_gallery->where(['type' => '2'])->findAll();
        
		$this->load->view('gallery/v_index_video', $this->data);
	}
}

/* End of file Gallery_dkpp.php */
