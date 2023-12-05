<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Skm extends Frontend_Controller {

    public function __construct()
	{
		parent::__construct();

		$this->_init();
		$this->data['uri_mod'] = 'isi-survei';
        $this->load->model(['m_api','m_ikm']);

	}

	public function _init()
    {
        $this->output->set_template('frontend');
	}

    public function index()
	{
        $this->data['page_title'] = "Isi Survei Kepuasan";
        $this->data['page_description'] = "Berikan penilaian untuk bentuk perubahan.";
        $this->data['ikm'] = $this->m_api->get_data_from_api();
        
		$this->load->view('skm/v_index', $this->data);
    }

    public function process()
    {
        $this->output->unset_template();

        $captcha_score = get_recapture_score($this->input->post('is-recaptcha-response'));  
        $score = (float)$this->input->post('score');

        if ($captcha_score < RECAPTCHA_ACCEPTABLE_SPAM_SCORE) {
            $this->result = array(
                'status' => FALSE,
                'message' => '<span class="text-danger"> Request yang anda jalankan dianggap SPAM oleh sistem.</span>'
            );
        } else {
            $this->form_validation->set_rules('score', 'Rating', 'required');
            $this->form_validation->set_rules('name', 'Nama Lengkap', 'required');
            $this->form_validation->set_rules('gender', 'Jenis Kelamin', 'required');
            $this->form_validation->set_rules('education', 'Pendidikan', 'required');
            $this->form_validation->set_rules('age', 'Usia', 'required');
            $this->form_validation->set_rules('phone_number', 'Nomor Handphone', 'required');
            $this->form_validation->set_rules('phone_number', 'Nomor Handphone', 'required');
            $this->form_validation->set_error_delimiters(error_delimeter(1), error_delimeter(2));

            if ($this->form_validation->run() == TRUE) {
                if ($score >= 0.5 && $score <= 5) {
                    $education = decrypt_url($this->input->post('education'), 'skm');
                    $gender = decrypt_url($this->input->post('gender'), 'skm');

                    $this->return = $this->m_skm->push_to_data('status', '1')
                        ->push_to_data('gender', $gender)
                        ->push_to_data('education', $education)
                        ->push_to_data('rate', $score)
                        ->save();

                    if ($this->return) {
                        $this->result = array(
                            'status' => TRUE,
                            'message' => '<span class="text-success"><i class="mdi mdi-check-decagram"></i> Survei berhasil dikirim.</span>'
                        );
                    } else {
                        $this->result = array(
                            'status' => FALSE,
                            'message' => '<span class="text-danger"><i class="mdi mdi-alert"></i> Survei gagal dikirim.</span>'
                        );
                    }
                } else {
                    $this->result = array(
                        'status' => FALSE,
                        'message' => '<span class="text-danger"> Silahkan berikan nilai score yang sesuai.</span>'
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
