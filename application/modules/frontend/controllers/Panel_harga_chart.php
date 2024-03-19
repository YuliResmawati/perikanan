<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Panel_harga_chart extends Frontend_Controller {

    public function __construct()
	{
		parent::__construct();

		$this->_init();
		$this->data['uri_mod'] = 'panel_harga_chart';
		$this->load->model('m_panel_harga');
        // $this->load->library('img');
	}

	public function _init()
    {
        $this->output->set_template('frontend');
	}

    public function index()
	{

        $this->data['page_title'] = "Kepegawaian";
        $this->data['page_description'] = "Kepegawaian Dinas Ketahanan Pangan dan Perikanan."; 
        
		$this->load->view('panel_harga/v_template', $this->data);
    }

	public function AjaxGet()
	{
		$mod = $this->input->get('id');

		if ($mod == "grafik") {
			$this->data['chart_harga_panel_bahan'] = $this->m_panel_harga->get_all_komoditas_by_kecamatan()->where(['jenis' => '3'])->findAll();
			$this->data['chart_harga_panel_ikan'] = $this->m_panel_harga->get_all_komoditas_by_kecamatan()->clear_where()->where(['jenis !=' => '3'])->findAll();
			
			$this->load->view('panel_harga/v_grafik', $this->data);
		} else {
			
		}
	}

}

/* End of file Panel_harga_chart.php */
