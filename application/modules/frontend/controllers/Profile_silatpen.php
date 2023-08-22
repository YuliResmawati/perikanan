<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Profile_silatpen extends Frontend_Controller {

    public function __construct()
	{
		parent::__construct();

		$this->_init();
		$this->data['uri_mod'] = 'profil-silat-pendidikan';
	}

	public function _init()
    {
        $this->output->set_template('frontend');
	}

    public function index()
	{
        $this->data['page_title'] = "Profil Silat Pendidikan";
        $this->data['page_description'] = "Profil Sistem Informasi Layanan Terintegrasi Pendidikan Kota Bukittinggi.";
        $this->data['website_data'] = $this->m_website->findAll();
        
		$this->load->view('profile_silatpen/v_index', $this->data);
    }
}

/* End of file Profile_silatpen.php */