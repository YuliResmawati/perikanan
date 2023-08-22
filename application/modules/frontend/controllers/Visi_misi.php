<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Visi_misi extends Frontend_Controller {

    public function __construct()
	{
		parent::__construct();

		$this->_init();
		$this->data['uri_mod'] = 'visi-misi';
	}

	public function _init()
    {
        $this->output->set_template('frontend');
	}

    public function index()
	{
        $this->data['page_title'] = "Visi & Misi";
        $this->data['page_description'] = "Visi & Misi Sistem Informasi Layanan Terintegrasi Pendidikan Kota Bukittinggi.";
        $this->data['website_data'] = $this->m_website->findAll();
        
		$this->load->view('visi_misi/v_index', $this->data);
    }
}

/* End of file Visi_misi.php */
