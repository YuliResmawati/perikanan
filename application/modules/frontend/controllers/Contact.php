<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Contact extends Frontend_Controller {

    public function __construct()
	{
		parent::__construct();

		$this->_init();
		$this->data['uri_mod'] = 'kontak';
	}

	public function _init()
    {
        $this->output->set_template('frontend');
	}

    public function index()
	{
        $this->data['page_title'] = "Kontak Kami";
        $this->data['page_description'] = "Hubungi kami jika ada pertanyaan seputar silat pendidikan.";
        $this->data['website_data'] = $this->m_website->findAll();
        
		$this->load->view('contact/v_index', $this->data);
    }

}

/* End of file Contact.php */
