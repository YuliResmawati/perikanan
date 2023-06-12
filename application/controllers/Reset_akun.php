<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Reset_akun extends Backend_Controller {

    public function __construct()
	{
		parent::__construct();

		$this->_init();
		$this->data['uri_mod'] = 'reset_akun';
        $this->id_key = $this->private_key;
        $this->breadcrumbs->push('Reset Akun', 'reset_akun');
        $this->load->model(['m_pegawai', 'm_log_reset_password']);

        $this->load->css($this->data['theme_path'] . '/libs/select2/css/select2.min.css');
        $this->load->js($this->data['theme_path'] . '/libs/select2/js/select2.min.js');
        $this->load->js($this->data['theme_path'] . '/libs/select2/js/i18n/id.js');
        $this->load->js($this->data['global_custom_path'] . '/js/select2-init.js');
        $this->load->js($this->data['theme_path'] . '/libs/jquery-mask-plugin/jquery.mask.min.js');
        $this->load->js($this->data['global_custom_path'] . '/js/init_mask.js');
	}

	public function _init()
    {
        $this->output->set_template('backend');
	}

    public function index()
	{
        $this->data['page_title'] = "Reset Akun Pegawai";
        $this->data['page_description'] = "Halaman Reset Akun Pegawai.";
        $this->data['header_title'] = 'none';
        $this->data['breadcrumbs'] = $this->breadcrumbs->show();
        $this->data['id_key'] = $this->id_key;

        if (base_url() == "https://simpeg.agamkab.go.id/" || base_url() == "http://simpeg.agamkab.go.id/") {
            if ($this->logged_user_id == '8377') {
                $this->load->view('reset_akun/v_index', $this->data);
            } else {
                show_404();
            }
        } else {
            $this->load->view('reset_akun/v_index', $this->data);
        }
    }

    private function action_get_nip($nip = NULL, $score)
    {
        $this->output->unset_template();
        $score = get_recapture_score($score);

        if ($score < RECAPTCHA_ACCEPTABLE_SPAM_SCORE) {
            $response = array(
                'status' => FALSE,
                'message' => 'Request anda terdeteksi SPAM!',
                'data' => []
            );
        } else {
            $this->return = $this->m_pegawai->get_pegawai_using_nip($nip); 

            if ($this->return !== FALSE) {
                unset($this->return->pegawai_id);
    
                if ($this->return) {
                    $this->return->nama_pegawai = name_degree($this->return->gelar_depan, custom_tolower_text($this->return->nama_pegawai), $this->return->gelar_blkng);
                    $this->return->user_id = ($this->return->user_id) ? encrypt_url($this->return->user_id, $this->id_key) : '';  
                } 
    
                $response = array(
                    'status' => TRUE,
                    'message' => 'Berhasil mengambil data',
                    'data' => $this->return
                );
            } else {
                $response = array(
                    'status' => FALSE,
                    'message' => 'Gagal mengambil data',
                    'data' => []
                );
            }
        }
        
        $response = json_encode($response);

        return $this->output->set_output($response);
    }

    private function action_reset_password()
    {
        $this->output->unset_template();
        $score = get_recapture_score($this->input->post('reset-token-response'));
        $nip = $this->input->post('nip_search');

        if ($score < RECAPTCHA_ACCEPTABLE_SPAM_SCORE) {
            $this->result = array(
                'status' => FALSE,
                'message' => '<span class="text-danger"><i class="mdi mdi-alert"></i> Request yang anda jalankan dianggap SPAM oleh sistem SIMPEG Agam.</span>'
            );
        } else {
            $this->form_validation->set_rules('nip_search', 'NIP', "required|numeric|min_length[18]|max_length[18]");
            $this->form_validation->set_error_delimiters(error_delimeter(1), error_delimeter(2));

            if ($this->form_validation->run() == TRUE) {
                $data = $this->m_pegawai->get_pegawai_using_nip($nip); 

                if (!empty($data)) {
                    $reset_action = $this->m_users->push_to_data('password', $this->m_users->ghash('simpeg_pass'))
                        ->push_to_data('last_password_reset', date("Y-m-d H:i:s"))
                        ->save($data->user_id);

                    if ($reset_action) {
                        $log = $this->m_log_reset_password->push_to_data('user_id', $data->user_id)
                            ->push_to_data('status', '1')
                            ->save();

                        if ($log) {
                            $this->result = array(
                                'status' => TRUE,
                                'message' => '<span class="text-success"><i class="mdi mdi-check-decagram"></i> Berhasil reset akun.</span>'
                            );
                        } else {
                            $this->result = array(
                                'status' => FALSE,
                                'message' => '<span class="text-danger"><i class="mdi mdi-alert"></i> Gagal melakukan reset akun.</span>'
                            );
                        }
                    } else {
                        $this->result = array(
                            'status' => FALSE,
                            'message' => '<span class="text-danger"><i class="mdi mdi-alert"></i> Gagal melakukan reset akun.</span>'
                        );
                    }
                } else {
                    $this->result = array(
                        'status' => FALSE,
                        'message' => '<span class="text-danger"><i class="mdi mdi-alert"></i> Data tidak ditemukan.</span>'
                    );
                }
            } else {
                $this->result = array(
                    'status' => FALSE,
                    'message' => validation_errors()
                );
            }

            if ($this->result) {
                $this->output->set_output(json_encode($this->result));
            } else {
                $this->output->set_output(json_encode(['message'=>false, 'msg'=> 'Terjadi kesalahan.']));
            }  
        }
    }

    public function AjaxGet()
    {
        $this->output->unset_template();

        $response = $this->m_log_reset_password->get_log_reset()->datatables();
        
        $response->edit_column('id', '$1', "encrypt_url(id,' ', $this->id_key)");      
        $response->edit_column('user_id', '$1', "encrypt_url(user_id,' ', $this->id_key)");      
        $response->edit_column('tanggal_reset', '$1', "format_indo(tanggal_reset,no)");              

        $response = $this->m_log_reset_password->datatables(true);

        $this->output->set_output($response);

        return $this->output->set_output($response);
    }

    public function AjaxGetNip($nip = NULL, $score)
    {  
        $this->output->unset_template();

        if (base_url() == "https://simpeg.agamkab.go.id/" || base_url() == "http://simpeg.agamkab.go.id/") {
            if ($this->logged_user_id == '8377') {
                $this->action_get_nip($nip, $score);
            } else {
                show_404();
            }
        } else {
            $this->action_get_nip($nip, $score);
        }
    }

    public function AjaxReset()
    {
        $this->output->unset_template();

        if (base_url() == "https://simpeg.agamkab.go.id/" || base_url() == "http://simpeg.agamkab.go.id/") {
            if ($this->logged_user_id == '8377') {
                $this->action_reset_password();
            } else {
                show_404();
            }
        } else {
            $this->action_reset_password();
        }
    }

}

/* End of file Reset_akun.php */
