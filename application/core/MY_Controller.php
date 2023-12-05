<?php
defined('BASEPATH') or exit('No direct script access allowed');
defined('MY_STORAGE_PATH') or define('MY_STORAGE_PATH', '../storage');

class MY_Controller extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        
        $this->data['errors'] 			    = array();
        $this->data['messages'] 		    = array();
        $this->data['site_name'] 		    = "Sistem Informasi Ketahanan Pangan dan Perikanan";
        $this->data['keywords'] 		    = "dkpp agam, dpkp agam, ketahanan pangan, perikanan";
        $this->data['description'] 		    = "Selamat Datang di Website Sistem Informasi";
        $this->data['regency']		 	    = "Kabupaten Agam";
        $this->data['author'] 			    = "Web Programmer Dinas Komunikasi dan Informatika Kabupaten Agam";
        $this->data['powered_by'] 		    = "Dinas Komunikasi dan Informatika Kabupaten Agam";
        $this->data['programmers'] 		    = "Yuli Resmawati";
        $this->data['company']              = "Dinas Komunikasi dan Informatika Kabupaten Agam";
        $this->data['web_domain']           = 'https://dkpp.agamakab.go.id/';
        $this->data['global_images_path']   = base_url('assets/global/images');
        $this->data['global_plugin_path']   = base_url('assets/global/plugin');
        $this->data['global_custom_path']   = base_url('assets/global/custom');
        $this->data['uri_mod']              = '';
        $this->data['version']              = '1.0';
        $this->timestamp                    = date('Y-m-d H:i:s');
        $this->loggedin                     = $this->session->userdata('dkpp_loggedin');
        $this->logged_level                 = $this->session->userdata('dkpp_level');  
        $this->private_key                  = "?~MgOWmkZ#9Gvasd@@&&^%$%JBvnUV9R6I9^DryEP+#" . $this->router->fetch_class() . '.DKPP';

        $this->output->set_common_meta(
            $this->data['site_name'],
            $this->data['description'],
            $this->data['keywords']
        );

        $this->output->set_meta("author", $this->data['author']);
        $this->output->set_meta("programmers", $this->data['programmers']);
        $this->output->set_meta("company", $this->data['company']);
        $this->output->set_meta("powered_by", $this->data['powered_by'] );
        $this->output->set_meta("regency", $this->data['regency']);

        if (base_url() == "https://dkpp.agamakab.go.id/" || base_url() == "http://dkpp.agamakab.go.id/") {
            $this->data['default_db'] = 'default';
            $this->data['file_path'] = MY_STORAGE_PATH.'/uploads/berkas/';
            $this->data['image_path'] = MY_STORAGE_PATH.'/uploads/images/';
        } else {
            $this->data['default_db'] = 'default_dev';
            $this->data['file_path'] = MY_STORAGE_PATH.'/uploads_dev/berkas/';
            $this->data['image_path'] = MY_STORAGE_PATH.'/uploads_dev/images/';
        }

        $this->db = $this->load->database($this->data['default_db'], TRUE);

        $this->data['file_image_path'] = 'files/images/';
        $this->data['public_file_path'] = 'files/berkas/';
        $this->data['image_authorization'] = 'files/images_authorization/';
        $this->data['my_images'] = 'files/my_images/';
        $this->data['my_files'] = 'files/my_files/';
        $this->data['public_image_path'] = 'assets/backend/images/';
        $this->data['files_path'] = './files/uploads/';
        $this->data['files_path_not_owner_must_login'] = './files/uploads_not_owner_must_login/';
        $this->data['upload_authorization'] = './files/upload_authorization/';
    }
}

class Frontend_Controller extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        // $this->data['theme_path_back']       = base_url('assets/backend');
        $this->data['theme_path']       = base_url('assets/frontend');
        $this->data['theme_path_backend']       = base_url('assets/backend');
        $this->data['page_title']       = '';
        $this->data['page_description'] = '';
        $this->paging                   = array(
            'full_tag_open' => '<div class="pagination justify-content-center">',
            'full_tag_close' => '</div>',

            'first_link' => '&laquo;',
            'first_tag_open' => '<li class="prev page">',
            'first_tag_close' => '</li>',

            'last_link' => '&raquo;',
            'last_tag_open' => '<li class="next page">',
            'last_tag_close' => '</li>',

            'next_link' => '&#10095;',
            'next_tag_open' => '<li class="">',
            'next_tag_close' => '</li>',

            'prev_link' => '&#10094;',
            'prev_tag_open' => '<li class="">',
            'prev_tag_close' => '</li>',

            'cur_tag_open' => '<li><a href="" class="active">',
            'cur_tag_close' => '</a></li>',

            'num_tag_open' => '<li class="page">',
            'num_tag_close' => '</li>'
        );
    }
}

class Auth_Controller extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->data['theme_path_backend']       = base_url('assets/backend');
        $this->data['theme_path']  = base_url('assets/frontend');
    }
}

class Backend_Controller extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('m_users');

        $cookie = get_cookie('dkpp_users_cookie');

        if ($this->loggedin == FALSE) {
			if ($cookie) {
				$row = $this->m_users->get_by_cookie($cookie)->row();

				if ($row) {
					$this->m_users->dkpp_session_register($row);
				}
			}
		}

        if ($cookie) {
			$this->m_users->user_check($cookie);
		} else {
			if ($this->session->userdata('dkpp_loggedin')) {
				$this->session->sess_destroy();

				redirect('auth','refresh');
			}
		}

        $this->data['page_title']               = '';
        $this->data['judul']	                = '';
        $this->data['breadcrumbs'] 		        = '';
        $this->data['theme_path']               = base_url('assets/backend');
        $this->data['page_description']         = '';
        $this->mod 				                = '';
        $this->return 			                = '';
        $this->result			                = array('status' => true, 'message' => '&nbsp');
        $this->msg 				                = '';
        $this->del 				                = '';
        $this->where			                = array();
        $this->data['navtoggle']                = false;
        $this->logged_pegawai_id               = $this->session->userdata('dkpp_pegawai_id');
        $this->logged_user_id                   = $this->session->userdata('dkpp_user_id');
        $this->logged_level                     = $this->session->userdata('dkpp_level');  
        $this->logged_display_name              = $this->session->userdata('dkpp_display_name');  
        $this->logged_username                  = $this->session->userdata('dkpp_username');  
        $this->logged_avatar                    = $this->session->userdata('dkpp_avatar');  
        $this->sidebar_report                   = array();

        $this->load->section('header', 'partials/header');

        $this->load->library('dynamic_menu');
        $this->breadcrumbs->set_config('breadcrumb_users');
        $this->data['sidebar_menu'] = $this->dynamic_menu->result;

        $last_login_info = array('last_login' => date('Y-m-d H:i:s'), 'last_ip_login' => '');

        if (!empty($_SERVER['HTTP_X_REAL_IP'])) {
            $last_login_info['last_ip_login'] = $_SERVER['HTTP_X_REAL_IP'];
        } else {
            $last_login_info['last_ip_login'] = $_SERVER['REMOTE_ADDR'];
        }

        $this->db->update('users', $last_login_info, ['id' => $this->session->userdata('dkpp_user_id')]);
    }
}
