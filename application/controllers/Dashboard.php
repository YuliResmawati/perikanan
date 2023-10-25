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
        $this->load->model(['m_app']);

	 }

	public function _init()
    {
        $this->output->set_template('backend');
    }

    public function index()
    {
        $this->data['page_title'] = "Dashboard";
        $this->data['header_title'] = 'none';
        // if($this->logged_level == "3"){
        //     $this->data['count_rombel'] = $this->m_app->get_count_rombel_dash();
        // }else{
        //     $this->data['count_sekolah'] = $this->m_app->get_count_sekolah();
        // }
        // $this->data['count_siswa'] = $this->m_app->get_count_student_dash();
        // $this->data['count_guru'] = $this->m_app->get_count_teacher_dash();
        $this->data['breadcrumbs'] = $this->breadcrumbs->show();

        $this->load->view('dashboard/v_index', $this->data);
    }

}

/* End of file Dashboard.php */