<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Layanan_pengaduan extends Frontend_Controller {

    public function __construct()
	{
		parent::__construct();

		$this->_init();
		$this->data['uri_mod'] = 'layanan-pengaduan';
        $this->load->model('m_pengaduan');

        $this->load->js("https://cdn.jsdelivr.net/npm/sweetalert2@11");

	}

	public function _init()
    {
        $this->output->set_template('frontend');
	}

    public function index()
	{
        $this->data['page_title'] = "Isi Layanan Pengaduan";
        $this->data['page_description'] = "Berikan kritik dan saran untuk bentuk perubahan.";
        
		$this->load->view('pengaduan/v_index', $this->data);
    }

    public function process()
    {
        $this->output->unset_template();

        $captcha_score = get_recapture_score($this->input->post('p-recaptcha-response'));  
        $score = (float)$this->input->post('score');

        if ($captcha_score < RECAPTCHA_ACCEPTABLE_SPAM_SCORE) {
            $this->result = array(
                'status' => FALSE,
                'message' => '<span class="text-danger"> Request yang anda jalankan dianggap SPAM oleh sistem.</span>'
            );
        } else {
            $this->form_validation->set_rules('name', 'Nama Lengkap', 'required');
            $this->form_validation->set_rules('email', 'email', 'required');
            // $this->form_validation->set_rules('alamat', 'Alamat', 'required');
            // $this->form_validation->set_rules('judul', 'Judul Pengaduan', 'required');
            $this->form_validation->set_rules('isi', 'Isi Pengaduan', 'required');
            $this->form_validation->set_error_delimiters(error_delimeter(1), error_delimeter(2));

            if ($this->form_validation->run() == TRUE) {

                $this->return = $this->m_pengaduan->push_to_data('status', '1')
                    ->push_to_data('nama', $this->input->post('name'))
                    ->push_to_data('email', $this->input->post('email'))
                    ->push_to_data('no_hp', $this->input->post('no_hp'))
                    ->push_to_data('isi_pengaduan', $this->input->post('isi'))
                    ->save();

                if ($this->return) {
                    $this->result = array(
                        'status' => TRUE,
                        'message' => '<span class="text-success"><i class="mdi mdi-check-decagram"></i> Pengaduan berhasil dikirim.</span>'
                    );
                } else {
                    $this->result = array(
                        'status' => FALSE,
                        'message' => '<span class="text-danger"><i class="mdi mdi-alert"></i> Pengaduan gagal dikirim.</span>'
                    );
                }
            } else {
                $this->result = array(
                    'status' => FALSE,
                    'message' => validation_errors()
                );
            }
        }

        if ($this->result) {
            $this->output->set_output(json_encode($this->result));
        } else {
            $this->output->set_output(json_encode(['message' => FALSE, 'msg' => 'Gagal mengambil data.']));
        }   
    }

}

/* End of file Skm.php */
