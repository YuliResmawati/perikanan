<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Laporan_skpg extends Backend_Controller {

    public function __construct()
	{
		parent::__construct();

		$this->_init();
		$this->data['uri_mod'] = 'laporan/laporan_skpg';
        $this->id_key = $this->private_key;
        $this->breadcrumbs->push('Laporan', 'laporan_skpg');
        $this->load->model([
            'm_pemanfaatan_pangan', 'm_wilayah','m_bulan'
        ]);
        // $this->load->library('Pdf');   

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
        $this->data['page_title'] = "Rekapitulasi Kerawanan Pangan dan Gizi";
        $this->data['page_description'] = "Halaman Rekapitulasi Kerawanan Pangan dan Gizi.";
        $this->data['breadcrumbs'] = $this->breadcrumbs->show();
        $this->data['id_key'] = $this->id_key;
        $this->data['card'] = "true";
        $this->data['bulan'] = $this->m_bulan->findAll();

		$this->load->view('laporan_skpg/v_index', $this->data);
    }

    public function list($jenis_rekap='', $bulan='', $tahun='')
    {

        $this->output->unset_template();

        $type = decrypt_url($jenis_rekap, $this->id_key);

        if ($type != FALSE){
            if ($type == '1'){
                $this->report_index_komposit($bulan, $tahun);
            } else if ($type == '2'){
                $this->report_ketersediaan_pangan($bulan, $tahun);
            } else if ($type == '3'){
                $this->report_akses_pangan($bulan, $tahun);
            } else if ($type == '4'){
                $this->report_pemanfaatan_pangan($bulan, $tahun);
            } else {
                show_404();
            }
        } else {

        }
    }

    public function report_index_komposit($bulan, $tahun)
    {
        $this->output->unset_template('backend');

        ini_set('memory_limit', '-1');

        $this->benchmark->mark('start_report');

        $bulan = decrypt_url($bulan, $this->id_key);
        $tahun = decrypt_url($tahun, $this->id_key);
        

        if ($bulan != FALSE) {
            $this->data['base64_logo_instansi'] = base64_encode(file_get_contents("./assets/global/images/agam.png"));
            $this->data['paper_size'] = "F4";
            $this->data['page_title'] = "Cetak Laporan Kerawanan Pangan dan Gizi";
            $this->data['tahun'] = $tahun;
            $this->data['tanggal'] = date("Y-m-d");

            $this->data['data_list'] = $this->m_wilayah->findAll();
            
            $this->data['reports'][] = lap_content('L', 'laporan_skpg/v_report_index_komposit', $this->data);

            $this->benchmark->mark('end_report');

            $this->data['benchmark'] = $this->benchmark->elapsed_time('start_report', 'end_report');

            $this->load->view('themes/report', $this->data);
        } else {
            show_404();
        }
    }

    public function report_ketersediaan_pangan($bulan, $tahun)
    {
        $this->output->unset_template('backend');

        ini_set('memory_limit', '-1');

        $this->benchmark->mark('start_report');

        $bulan = decrypt_url($bulan, $this->id_key);
        $tahun = decrypt_url($tahun, $this->id_key);
        

        if ($bulan != FALSE) {
            $this->data['base64_logo_instansi'] = base64_encode(file_get_contents("./assets/global/images/agam.png"));
            $this->data['paper_size'] = "F4";
            $this->data['page_title'] = "Cetak Laporan Kerawanan Pangan dan Gizi";
            $this->data['tahun'] = $tahun;
            $this->data['bulan'] = $bulan;
            
            $this->data['reports'][] = lap_content('L', 'laporan_skpg/v_report_ketersediaan_pangan', $this->data);

            $this->benchmark->mark('end_report');

            $this->data['benchmark'] = $this->benchmark->elapsed_time('start_report', 'end_report');

            $this->load->view('themes/report', $this->data);
        } else {
            show_404();
        }
    }

    public function report_akses_pangan($bulan, $tahun)
    {
        $this->output->unset_template('backend');

        ini_set('memory_limit', '-1');

        $this->benchmark->mark('start_report');

        $bulan = decrypt_url($bulan, $this->id_key);
        $tahun = decrypt_url($tahun, $this->id_key);
        

        if ($bulan != FALSE) {
            $this->data['base64_logo_instansi'] = base64_encode(file_get_contents("./assets/global/images/agam.png"));
            $this->data['paper_size'] = "F4";
            $this->data['page_title'] = "Cetak Laporan Kerawanan Pangan dan Gizi";
            $this->data['tahun'] = $tahun;
            $this->data['tanggal'] = date("Y-m-d");
            
            $this->data['reports'][] = lap_content('P', 'laporan_skpg/v_report_akses_pangan', $this->data);

            $this->benchmark->mark('end_report');

            $this->data['benchmark'] = $this->benchmark->elapsed_time('start_report', 'end_report');

            $this->load->view('themes/report', $this->data);
        } else {
            show_404();
        }
    }

    public function report_pemanfaatan_pangan($bulan, $tahun)
    {
        $this->output->unset_template('backend');

        ini_set('memory_limit', '-1');

        $this->benchmark->mark('start_report');

        $bulan = decrypt_url($bulan, $this->id_key);
        $tahun = decrypt_url($tahun, $this->id_key);
        

        if ($bulan != FALSE) {
            $this->data['base64_logo_instansi'] = base64_encode(file_get_contents("./assets/global/images/agam.png"));
            $this->data['paper_size'] = "F4";
            $this->data['page_title'] = "Cetak Laporan Kerawanan Pangan dan Gizi";
            $this->data['tahun'] = $tahun;
            $this->data['bulan'] = $bulan;

            $this->data['data_list'] = $this->m_pemanfaatan_pangan->get_all_pemanfaatan_pangan()->findAll();
            
            $this->data['reports'][] = lap_content('L', 'laporan_skpg/v_report_pemanfaatan_pangan', $this->data);

            $this->benchmark->mark('end_report');

            $this->data['benchmark'] = $this->benchmark->elapsed_time('start_report', 'end_report');

            $this->load->view('themes/report', $this->data);
        } else {
            show_404();
        }
    }
}



/* End of file laporan_skpg.php */
