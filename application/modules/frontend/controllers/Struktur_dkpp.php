<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Struktur_dkpp extends Frontend_Controller {

    public function __construct()
	{
		parent::__construct();

		$this->_init();
		$this->data['uri_mod'] = 'struktur-dkpp';
		$this->load->model('m_struktur');
	}

	public function _init()
    {
        $this->output->set_template('frontend');
	}

    public function index()
	{

        $this->data['page_title'] = "Visi & Misi";
        $this->data['page_description'] = "Visi & Misi Dinas Ketahanan Pangan dan Perikanan.";
        $this->data['struktur_dkpp'] = $this->m_struktur->where(['status' => '1'])->findAll();
        
		$this->load->view('struktur_dkpp/v_index', $this->data);
    }
}

/* End of file Struktur_dkpp.php */
