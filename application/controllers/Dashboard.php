<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends Backend_Controller {

    public function __construct()
	 {
        parent::__construct();
        $this->_init();
        $this->data['uri_mod'] = 'dashboard';
        $this->id_key = $this->private_key;
        $this->breadcrumbs->push('Dashboard', 'dashboard');
	 }

	public function _init()
    {
        $this->output->set_template('backend');
    }

    public function index()
    {
        $this->data['page_title'] = "Dashboard";
        $this->data['header_title'] = 'none';
        $this->data['breadcrumbs'] = $this->breadcrumbs->show();

        $this->load->view('dashboard/v_index', $this->data);
    }
}

/* End of file Dashboard.php */