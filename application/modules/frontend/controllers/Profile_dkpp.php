<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Profile_dkpp extends Frontend_Controller {

    public function __construct()
	{
		parent::__construct();

		$this->_init();
		$this->data['uri_mod'] = 'profil-dkpp';
	}

	public function _init()
    {
        $this->output->set_template('frontend');
	}

    public function index()
	{
        $this->data['page_title'] = "Profil Dinas Ketahanan Pangan dan Perikanan";
        $this->data['page_description'] = "Profil Dinas Ketahanan Pangan dan Perikanan Kabupaten Agam.";
        $this->data['website_data'] = $this->m_website->findAll();
        
		$this->load->view('profile_dkpp/v_index', $this->data);
    }
}

/* End of file Profile_silatpen.php */