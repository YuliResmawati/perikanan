<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Laporan_panel_harga extends Backend_Controller {

    public function __construct()
	{
		parent::__construct();

		$this->_init();
		$this->data['uri_mod'] = 'laporan/laporan_panel_harga';
        $this->id_key = $this->private_key;
        $this->breadcrumbs->push('Laporan', 'laporan_panel_harga');
        $this->load->model([
            'm_panel_harga', 'm_bulan', 'm_wilayah'
        ]);

        $this->load->css($this->data['theme_path'] . '/libs/bootstrap-select/css/bootstrap-select.min.css');
        $this->load->css($this->data['theme_path'] . '/libs/flatpickr/flatpickr.min.css');
        $this->load->css($this->data['theme_path'] . '/libs/selectize/css/selectize.bootstrap3.css');
        $this->load->css($this->data['theme_path'] . '/libs/select2/css/select2.min.css');
        $this->load->css($this->data['theme_path'] . '/css/float-table.css');
        $this->load->js($this->data['theme_path'] . '/libs/flatpickr/flatpickr.min.js');
        $this->load->js($this->data['theme_path'] . '/libs/bootstrap-select/js/bootstrap-select.min.js');
        $this->load->js($this->data['theme_path'] . '/libs/selectize/js/standalone/selectize.min.js');
        $this->load->js($this->data['theme_path'] . '/libs/select2/js/select2.min.js');
        $this->load->js($this->data['theme_path'] . '/libs/select2/js/i18n/id.js');
        $this->load->js($this->data['global_custom_path'] . '/js/select2-init.js');
        $this->load->js($this->data['global_custom_path'] . '/js/init_mask.js');
        $this->load->js($this->data['theme_path'] . '/js/rupiah.js');

	}

	public function _init()
    {
        $this->output->set_template('backend');
	}

    public function index()
	{   
        $this->data['page_title'] = "Rekapitulasi Ketersediaan dan Stabilitas Pangan";
        $this->data['page_description'] = "Halaman Rekapitulasi Ketersediaan dan Stabilitas Pangan.";
        $this->data['breadcrumbs'] = $this->breadcrumbs->show();
        $this->data['id_key'] = $this->id_key;
        $this->data['card'] = "true";
        $this->data['bulan'] = $this->m_bulan->findAll();
        $this->data['kecamatan'] = $this->m_wilayah->findAll();

		$this->load->view('laporan_panel_harga/v_index', $this->data);
    }

    public function report($kecamatan='', $bulan='', $minggu='', $tahun='')
    {
        $this->output->unset_template();
        ini_set('memory_limit', '-1');

        $this->benchmark->mark('start_report');

        $kecamatan = decrypt_url($kecamatan, $this->id_key);
        $bulan = decrypt_url($bulan, $this->id_key);
        $minggu = decrypt_url($minggu, $this->id_key);
        $tahun = decrypt_url($tahun, $this->id_key);

        if ($kecamatan != FALSE){
            $this->data['base64_logo_instansi'] = base64_encode(file_get_contents("./assets/global/images/agam.png"));
            $this->data['paper_size'] = "F4";
            $this->data['page_title'] = "Cetak Laporan Panel Harga Konsumen";
            $this->data['tahun'] = $tahun;
            $this->data['minggu'] = $minggu;
            $this->data['bulan'] = $bulan;
            $this->data['kecamatan'] = $this->m_wilayah->where(['id' => $kecamatan])->findAll()[0]->nama_kecamatan;
            $this->data['tanggal'] = date("Y-m-d");

            $this->data['data_list'][0]  = $this->m_panel_harga->get_all_komoditas_by_kecamatan()->findAll();
            $this->data['data_list'][1]  = $this->m_panel_harga->get_all_komoditas_by_kecamatan()->findAll();
            
            $this->data['reports'][] = lap_content('L', 'laporan_panel_harga/v_report_panel_harga', $this->data);

            $this->benchmark->mark('end_report');

            $this->data['benchmark'] = $this->benchmark->elapsed_time('start_report', 'end_report');

            $this->load->view('themes/report', $this->data);
        } else {
            show_404();
        }
    }
}



/* End of file laporan_panel_harga.php */
