<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Skm extends Frontend_Controller {

    public function __construct()
	{
		parent::__construct();

		$this->_init();
		$this->data['uri_mod'] = 'isi-survei';
        $this->load->model(['m_api','m_ikm']);

        $this->load->js("https://cdn.jsdelivr.net/npm/sweetalert2@11");

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

    public function sendRankiangApis()
    {
        $this->output->unset_template();

        $this->form_validation->set_rules('name', 'Nama Lengkap', 'required');
        $this->form_validation->set_rules('nilai[]', 'Nilai', 'required');
        // $this->form_validation->set_rules('id_nagari', 'Id Nagari', 'required');
        $this->form_validation->set_rules('usia', 'usia', 'required');
        $this->form_validation->set_rules('jenis_kelamin', 'Jenis Kelamin', 'required');
        $this->form_validation->set_rules('pendidikan', 'Pendidikan', 'required');
        $this->form_validation->set_rules('pekerjaan', 'Pekerjaan', 'required');
        $this->form_validation->set_error_delimiters(error_delimeter(1), error_delimeter(2));

        if ($this->form_validation->run() == TRUE) {
            $apiUrl = 'https://rangkiang.agamkab.go.id/api/ikm/ajaxInsertPenilaian';
            $nilai = $this->input->post('nilai');

            $data = new stdClass();
            $data->username = $this->input->post('username');
            $data->nilai = $nilai;
            $data->id_nagari = $this->input->post('id_nagari');
            $data->usia = $this->input->post('usia');
            $data->jenis_kelamin = $this->input->post('jenis_kelamin');
            $data->pendidikan = $this->input->post('pendidikan');
            $data->pekerjaan = $this->input->post('pekerjaan');

            $json_data = json_encode($data);

            $ch = curl_init($apiUrl);

            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $json_data);

            curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                'Content-Type: application/json',
                'Content-Length: ' . strlen($json_data)
            ));

            $apiResponse = curl_exec($ch);

            curl_close($ch);

            if (!$apiResponse) {
                $this->result = array(
                    'status' => FALSE,
                    'message' => '<span class="text-danger"><i class="mdi mdi-check-alert"></i> Failed to send data to API.</span>'
                );
            } else {
                $this->result = array(
                    'status' => TRUE,
                    'message' => '<span class="text-success"><i class="mdi mdi-check-decagram"></i> Success to send data to API.</span>'
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
            $this->output->set_output(json_encode(['status'=> FALSE, 'message'=> 'Gagal mengambil data.']));
        }
    }
}

/* End of file Skm.php */
