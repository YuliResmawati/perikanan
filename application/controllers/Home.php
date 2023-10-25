<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends Frontend_Controller {

    public function __construct()
    {
        parent::__construct();
        
        $this->_init();
        $this->data['uri_mod'] = 'home';
        // $this->load->js($this->data['theme_path'] . '/js/all-js-libraries.js');
        $this->load->model(['m_app']);
    }
    
    public function _init()
    {
        $this->output->set_template('frontend');
    }

    public function index()
    {
        $this->data['page_title'] = "Home";
        $this->data['page_description'] = "Simpeg adalah portal terintegrasi untuk pengelolaan dengan kemudahan akses data bagi pegawai pemerintah Kabupaten Agam.";
        // $this->data['count_sekolah'] = $this->m_app->get_count_sekolah();
        // $this->data['count_siswa'] = $this->m_app->get_count_student();
        // $this->data['count_guru'] = $this->m_app->get_count_teacher();

        $this->load->view('home/v_index', $this->data);  
    }
}

/* End of file Auth.php */