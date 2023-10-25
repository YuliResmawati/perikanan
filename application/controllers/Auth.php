<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends Auth_Controller {

    public function __construct()
    {
        parent::__construct();
        
        $this->_init();
        $this->data['uri_mod'] = 'auth';
        $this->load->model('m_users');

        $this->load->js("https://cdn.jsdelivr.net/npm/sweetalert2@11");
    }
    
    public function _init()
    {
        $this->output->set_template('frontend');
    }

    public function index()
    {
        $cookie = get_cookie('dkpp_users_cookie');

        if ($this->uri->segment(1) != 'masuk') {
            show_404();
        } else if ($this->loggedin != FALSE && $this->logged_level != FALSE) {
            redirect('dashboard', 'refresh');
        } else if ($cookie <> '') {
            $data = $this->m_users->get_by_cookie($cookie)->row();

            if ($data) {
                $this->m_users->dkpp_session_register($data);
                redirect('dashboard', 'refresh');
            }
        }
        
        $this->data['page_title'] = "Masuk";
        $this->data['page_description'] = "Halaman Masuk Aplikasi DPKK Kabupaten Agam.";

        $this->load->view('auth/v_login', $this->data);  
    }

    public function do_login() 
    {
        $this->output->unset_template();

        $captcha_score = get_recapture_score($this->input->post('g-recaptcha-response'));  
        $cookie = get_cookie('dkpp_users_cookie');

        if ($this->loggedin != FALSE && $this->logged_level != FALSE) {
            redirect('dashboard', 'refresh');
        } else if ($cookie <> '') {
            $data = $this->m_users->get_by_cookie($cookie)->row();

            if ($data) {
                $this->m_users->dkpp_session_register($data);
                redirect('dashboard', 'refresh');
            }
        }

        if ($captcha_score < RECAPTCHA_ACCEPTABLE_SPAM_SCORE) {
            $data = array(
                'status' => FALSE,
                'message' => '<span class="text-danger"> Request yang anda jalankan dianggap SPAM oleh sistem.</span>'
            );
        } else {
            $this->form_validation->set_rules('dkpp_username', 'nama pengguna', 'trim|required|min_length[3]|max_length[50]');
            $this->form_validation->set_rules('dkpp_password', 'kata sandi', 'required|min_length[8]|max_length[35]');
            $this->form_validation->set_error_delimiters(error_delimeter(1), error_delimeter(2));

            if ($this->form_validation->run() == TRUE) {
                $auth = $this->m_users->authentication_check();
    
                if ($auth == TRUE) {
                    $key = random_string('alnum', 64);
    
                    if ($this->input->post('rememberMe') == "checked") {
                        set_cookie('dkpp_users_cookie', $key, 3600*24*30); // expired 30 days 
                    
                        $this->m_users->save_cookie($key, $auth->id, 3600*24*30);
                        $this->m_users->dkpp_session_register($auth);
                    } else {
                        set_cookie('dkpp_users_cookie', $key, 3600*24*1); // expired 1 days 
                    
                        $this->m_users->save_cookie($key, $auth->id, 3600*24*1);
                        $this->m_users->dkpp_session_register($auth);
                    }
    
                    $data = array(
                        'status' => TRUE,
                        'message' => '<span class="text-success"> Berhasil Login.</span>'
                    );
                } else {
                    $data = array(
                        'status' => FALSE,
                        'message' => '<span class="text-danger"> <strong>nama pengguna</strong> atau <strong>kata sandi salah</strong>.</span>'
                    );
                }
            } else {
                $data = array(
                    'status' => FALSE,
                    'message' => validation_errors()
                );
            }
        }

        if ($data) {
            $this->output->set_output(json_encode($data));
        } else {
            $this->output->set_output(json_encode(['message' => FALSE, 'msg' => 'Gagal mengambil data.']));
        }   
    }

    public function do_logout()
    {
        if ($this->loggedin == TRUE) {
            $cookie = get_cookie('dkpp_users_cookie');

            $this->db->update('cookie', ['deleted' => 1] , ['cookie' => $cookie ]);
            delete_cookie('dkpp_users_cookie');
            $this->m_users->dkpp_session_destroy();
            $this->data['page_title'] = "Logout";
            $this->data['page_description'] = "Halaman Logout.";

            redirect('', 'refresh');
        } else {
            redirect('', 'refresh');
        } 
    }

}

/* End of file Auth.php */