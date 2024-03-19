<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Laporan_bid_budi_daya extends Backend_Controller {

    public function __construct()
	{
		parent::__construct();

		$this->_init();
		$this->data['uri_mod'] = 'laporan/laporan_bid_budi_daya';
        $this->id_key = $this->private_key;
        $this->breadcrumbs->push('Laporan', 'laporan_bid_budi_daya');
        $this->load->model([
            'm_produksi_perikanan','m_bulan','m_kelompok_nelayan','m_panel_harga_ikan',
            'm_armada_tangkap_ikan', 'm_produksi_pembenihan','m_pembudidaya','m_wilayah',
            'm_panel_harga','m_produksi_budidaya','m_kamus_data','m_upr'
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
        $this->data['page_title'] = "Rekapitulasi Perikanan Budi daya dan Tangkap";
        $this->data['page_description'] = "Halaman Rekapitulasi Perikanan Budi daya dan Tangkap.";
        $this->data['breadcrumbs'] = $this->breadcrumbs->show();
        $this->data['id_key'] = $this->id_key;
        $this->data['card'] = "true";
        $this->data['bulan'] = $this->m_bulan->findAll();

		$this->load->view('laporan_bid_budi_daya/v_index', $this->data);
    }

    public function list($jenis_rekap='', $filter='', $bulan='', $triwulan='', $tahun='', $tanggal='')
    {

        $this->output->unset_template();


        if ($this->input->post('link')) {
            echo encrypt_url($_POST['tanggal'],'tanggal');
            exit;
        }

        $type = decrypt_url($jenis_rekap, $this->id_key);
        $tanggal = decrypt_url($tanggal, 'tanggal');

        if ($type != FALSE){
            if ($type == '1'){
                $this->report_produksi_ikan_tangkap($filter, $bulan, $triwulan, $tahun);
            } else if ($type == '2'){
                $this->report_kelompok_nelayan();
            } else if ($type == '3'){
                $this->report_harga_ikan_tangkap_nelayan($tanggal);
            } else if ($type == '4'){
                $this->report_armada_alat_bantu($tahun);
            } else if ($type == '5'){
                $this->report_harga_ikan_budidaya($tanggal);
            } else if ($type == '6'){
                $this->report_produksi_budidaya($filter, $bulan, $triwulan, $tahun);
            } else if ($type == '7'){
                $this->report_jum_upr($tahun);
            } else if ($type == '8'){
                $this->report_produksi_pembenihan($tahun);
            } else if ($type == '9'){
                $this->report_kelompok_pembudidaya($tahun);
            } else if ($type == '10'){
                $this->report_pembudidaya($tahun);
            } else {
                show_404();
            }
        } else {

        }
    }

    public function report_produksi_ikan_tangkap($filter, $bulan, $triwulan, $tahun)
    {
        $this->output->unset_template('backend');

        ini_set('memory_limit', '-1');

        $this->benchmark->mark('start_report');

        $filter = decrypt_url($filter, $this->id_key);
        $bulan = decrypt_url($bulan, $this->id_key);
        $triwulan = decrypt_url($triwulan, $this->id_key);
        $tahun = decrypt_url($tahun, $this->id_key);
        

        if ($filter != FALSE) {
            $this->data['base64_logo_instansi'] = base64_encode(file_get_contents("./assets/global/images/agam.png"));
            $this->data['paper_size'] = "F4";
            $this->data['page_title'] = "Cetak Laporan Produksi Perikanan Tangkap";
            $this->data['tahun'] = $tahun;
            $this->data['tanggal'] = date("Y-m-d");

            if ($filter == '1'){
                $this->data['data_list'][0]  = $this->m_produksi_perikanan->get_all_produksi_by_jenis($filter, $bulan, $tahun, '0')->findAll();
                $this->data['data_list'][1]  = $this->m_produksi_perikanan->get_all_produksi_by_jenis($filter, $bulan, $tahun, '1')->findAll();
            } else if ($filter == '2'){
                $this->data['data_list'][0]  = $this->m_produksi_perikanan->get_all_produksi_by_jenis($filter, $triwulan, $tahun, '0')->findAll();
                $this->data['data_list'][1]  = $this->m_produksi_perikanan->get_all_produksi_by_jenis($filter, $triwulan, $tahun, '1')->findAll();
            } else {
                $this->data['data_list'][0]  = $this->m_produksi_perikanan->get_all_produksi_by_jenis($filter, '', $tahun, '0')->findAll();
                $this->data['data_list'][1]  = $this->m_produksi_perikanan->get_all_produksi_by_jenis($filter, '', $tahun, '1')->findAll();
            }
            

            //$this->data['data_list'] = array_merge($this->data['data_list'][0], $this->data['data_list'][1]);
            
            $this->data['reports'][] = lap_content('P', 'laporan_bid_budi_daya/v_report_produksi_tangkap', $this->data);

            $this->benchmark->mark('end_report');

            $this->data['benchmark'] = $this->benchmark->elapsed_time('start_report', 'end_report');

            $this->load->view('themes/report', $this->data);
        } else {
            show_404();
        }
    }

    public function report_kelompok_nelayan()
    {
        $this->output->unset_template('backend');

        ini_set('memory_limit', '-1');

        $this->benchmark->mark('start_report');
        
        $this->data['base64_logo_instansi'] = base64_encode(file_get_contents("./assets/global/images/agam.png"));
        $this->data['paper_size'] = "F4";
        $this->data['page_title'] = "Cetak Registrasi Kelompok Nelayan";
        $this->data['data_list'] = $this->m_kelompok_nelayan->findAll();
        
        $this->data['reports'][] = lap_content('P', 'laporan_bid_budi_daya/v_report_nelayan', $this->data);

        $this->benchmark->mark('end_report');

        $this->data['benchmark'] = $this->benchmark->elapsed_time('start_report', 'end_report');

        $this->load->view('themes/report', $this->data);
    
    }

    public function report_harga_ikan_tangkap_nelayan($tanggal)
    {
        $this->output->unset_template('backend');

        ini_set('memory_limit', '-1');

        $this->benchmark->mark('start_report');
        
        if ($tanggal != FALSE) {
            $this->data['base64_logo_instansi'] = base64_encode(file_get_contents("./assets/global/images/agam.png"));
            $this->data['paper_size'] = "F4";
            $this->data['page_title'] = "Cetak Laporan Daftar Harga Ikan Hasil Tangkap";
            $this->data['tanggal'] = $tanggal;

            $this->data['data_list'][0]  = $this->m_panel_harga_ikan->get_report_harga_ikan_by_jenis($tanggal, '0', '2')->findAll();
            $this->data['data_list'][1]  = $this->m_panel_harga_ikan->get_report_harga_ikan_by_jenis($tanggal, '1', '2')->findAll();
            
            $this->data['reports'][] = lap_content('P', 'laporan_bid_budi_daya/v_report_harga_ikan_tangkapan', $this->data);

            $this->benchmark->mark('end_report');

            $this->data['benchmark'] = $this->benchmark->elapsed_time('start_report', 'end_report');

            $this->load->view('themes/report', $this->data);
        } else {
            show_404();
        }
    }

    public function report_armada_alat_bantu($tahun)
    {
        $this->output->unset_template('backend');

        ini_set('memory_limit', '-1');

        $this->benchmark->mark('start_report');

        $tahun = decrypt_url($tahun, $this->id_key);
        

        if ($tahun != FALSE) {
            $this->data['base64_logo_instansi'] = base64_encode(file_get_contents("./assets/global/images/agam.png"));
            $this->data['paper_size'] = "F4";
            $this->data['page_title'] = "Cetak Rekapitulasi Armada, Alat Tangkap dan Alat Bantu";
            $this->data['tahun'] = $tahun;

            $this->data['data_list'][0]= $this->m_armada_tangkap_ikan->get_all_armada_tangkap()->where(["extract(year from armada_tangkap_ikan.created_at) = '$tahun'" => null, 'armada_tangkap_ikan.type' => '1'])->findAll();
            $this->data['data_list'][1]= $this->m_armada_tangkap_ikan->get_all_armada_tangkap()->where(["extract(year from armada_tangkap_ikan.created_at) = '$tahun'" => null, 'armada_tangkap_ikan.type' => '2'])->findAll();
            
            $this->data['reports'][] = lap_content('L', 'laporan_bid_budi_daya/v_report_alat_bantu', $this->data);

            $this->benchmark->mark('end_report');

            $this->data['benchmark'] = $this->benchmark->elapsed_time('start_report', 'end_report');

            $this->load->view('themes/report', $this->data);
        } else {
            show_404();
        }
    }

    public function report_produksi_pembenihan($tahun)
    {
        $this->output->unset_template('backend');

        ini_set('memory_limit', '-1');

        $this->benchmark->mark('start_report');

        $tahun = decrypt_url($tahun, $this->id_key);
        

        if ($tahun != FALSE) {
            $this->data['base64_logo_instansi'] = base64_encode(file_get_contents("./assets/global/images/agam.png"));
            $this->data['paper_size'] = "F4";
            $this->data['page_title'] = "Cetak Rekapitulasi Produksi Pembenihan";
            $this->data['tahun'] = $tahun;

            $this->data['data_list']= $this->m_produksi_pembenihan->get_all_produksi_pembenihan()->where(["extract(year from produksi_pembenihan.created_at) = '$tahun'" => null])->findAll();
            
            $this->data['reports'][] = lap_content('L', 'laporan_bid_budi_daya/v_report_produksi_pembenihan', $this->data);

            $this->benchmark->mark('end_report');

            $this->data['benchmark'] = $this->benchmark->elapsed_time('start_report', 'end_report');

            $this->load->view('themes/report', $this->data);
        } else {
            show_404();
        }
    }

    public function report_kelompok_pembudidaya($tahun)
    {
        $this->output->unset_template('backend');

        ini_set('memory_limit', '-1');

        $this->benchmark->mark('start_report');

        $tahun = decrypt_url($tahun, $this->id_key);
        

        if ($tahun != FALSE) {
            $this->data['base64_logo_instansi'] = base64_encode(file_get_contents("./assets/global/images/agam.png"));
            $this->data['paper_size'] = "F4";
            $this->data['page_title'] = "Cetak Rekapitulasi Jumlah Kelompok Pembudidaya";
            $this->data['tahun'] = $tahun;

            $this->data['data_list']= $this->m_pembudidaya->get_report_pembudidya($tahun)->findAll();
            
            $this->data['reports'][] = lap_content('L', 'laporan_bid_budi_daya/v_report_kelompok_pembudidaya', $this->data);

            $this->benchmark->mark('end_report');

            $this->data['benchmark'] = $this->benchmark->elapsed_time('start_report', 'end_report');

            $this->load->view('themes/report', $this->data);
        } else {
            show_404();
        }
    }

    public function report_pembudidaya($tahun)
    {
        $this->output->unset_template('backend');

        ini_set('memory_limit', '-1');

        $this->benchmark->mark('start_report');

        $tahun = decrypt_url($tahun, $this->id_key);
        

        if ($tahun != FALSE) {
            $this->data['base64_logo_instansi'] = base64_encode(file_get_contents("./assets/global/images/agam.png"));
            $this->data['paper_size'] = "F4";
            $this->data['page_title'] = "Cetak Rekapitulasi Jumlah Pembudidaya";
            $this->data['tahun'] = $tahun;

            $this->data['data_list']= $this->m_pembudidaya->get_report_pembudidya($tahun)->findAll();
            
            $this->data['reports'][] = lap_content('L', 'laporan_bid_budi_daya/v_report_pembudidaya', $this->data);

            $this->benchmark->mark('end_report');

            $this->data['benchmark'] = $this->benchmark->elapsed_time('start_report', 'end_report');

            $this->load->view('themes/report', $this->data);
        } else {
            show_404();
        }
    }

    public function report_harga_ikan_budidaya($tanggal)
    {
        $this->output->unset_template('backend');

        ini_set('memory_limit', '-1');

        $this->benchmark->mark('start_report');

        if ($tanggal != FALSE) {
            $this->data['base64_logo_instansi'] = base64_encode(file_get_contents("./assets/global/images/agam.png"));
            $this->data['paper_size'] = "F4";
            $this->data['page_title'] = "Cetak Laporan Daftar Harga Ikan Budidaya";
            $this->data['tanggal'] = $tanggal;

            $this->data['data_list'][0]  = $this->m_wilayah->findAll();
            $this->data['data_list'][1]  = $this->m_panel_harga->get_all_komoditas_by_kecamatan_distinct()->where(['date(panel_harga.created_at)' => $tanggal, 'panel_harga.type' => '2'])->findAll();
            $this->data['data_list'][2]  = $this->m_panel_harga->get_all_komoditas_by_kecamatan()->where(['date(panel_harga.created_at)' => $tanggal, 'panel_harga.type' => '2'])->findAll();
            $this->data['reports'][] = lap_content('L', 'laporan_bid_budi_daya/v_report_harga_ikan_budidaya', $this->data);
            $this->benchmark->mark('end_report');

            $this->data['benchmark'] = $this->benchmark->elapsed_time('start_report', 'end_report');

            $this->load->view('themes/report', $this->data);
        } else {
            show_404();
        }
    }

    public function report_produksi_budidaya($filter, $bulan, $triwulan, $tahun)
    {
        $this->output->unset_template('backend');

        ini_set('memory_limit', '-1');

        $this->benchmark->mark('start_report');
        $filter = decrypt_url($filter, $this->id_key);
        $bulan = decrypt_url($bulan, $this->id_key);
        $triwulan = decrypt_url($triwulan, $this->id_key);
        $tahun = decrypt_url($tahun, $this->id_key);

        if ($filter != FALSE) {
            $this->data['base64_logo_instansi'] = base64_encode(file_get_contents("./assets/global/images/agam.png"));
            $this->data['paper_size'] = "F4";
            $this->data['page_title'] = "Cetak Laporan Produksi Budidaya Perikanan";
            $this->data['tahun'] = $tahun;    
            $this->data['tanggal'] = date("Y-m-d");

            if ($filter == '1'){
                $this->data['data_list'][0]  = $this->m_kamus_data->get_all_media()->findAll();
                $this->data['data_list'][1]  = $this->m_produksi_budidaya->get_report_produksi_budidaya_distinct($filter, $bulan, $tahun)->findAll();
                $this->data['data_list'][2]  = $this->m_produksi_budidaya->get_report_produksi_budidaya($filter, $bulan, $tahun)->findAll();
            } else if ($filter == '2'){
                $this->data['data_list'][0]  = $this->m_kamus_data->get_all_media()->findAll();
                $this->data['data_list'][1]  = $this->m_produksi_budidaya->get_report_produksi_budidaya_distinct($filter, $triwulan, $tahun)->findAll();
                $this->data['data_list'][2]  = $this->m_produksi_budidaya->get_report_produksi_budidaya($filter, $triwulan, $tahun)->findAll();
            } else {
                $this->data['data_list'][0]  = $this->m_kamus_data->get_all_media()->findAll();
                $this->data['data_list'][1]  = $this->m_produksi_budidaya->get_report_produksi_budidaya_distinct($filter, ' ', $tahun)->findAll();
                $this->data['data_list'][2]  = $this->m_produksi_budidaya->get_report_produksi_budidaya($filter, ' ', $tahun)->findAll();
            }
            $this->data['reports'][] = lap_content('L', 'laporan_bid_budi_daya/v_report_produksi_budidaya', $this->data);
            $this->benchmark->mark('end_report');

            $this->data['benchmark'] = $this->benchmark->elapsed_time('start_report', 'end_report');

            $this->load->view('themes/report', $this->data);
        } else {
            show_404();
        }
    }

    public function report_jum_upr($tahun)
    {
        $this->output->unset_template('backend');

        ini_set('memory_limit', '-1');

        $this->benchmark->mark('start_report');

        $tahun = decrypt_url($tahun, $this->id_key);
        

        if ($tahun != FALSE) {
            $this->data['base64_logo_instansi'] = base64_encode(file_get_contents("./assets/global/images/agam.png"));
            $this->data['paper_size'] = "F4";
            $this->data['page_title'] = "Cetak Rekapitulasi Jumlah Unit Pembenihan Rakyat";
            $this->data['tahun'] = $tahun;
            $this->data['tanggal'] = date("Y-m-d");

            $this->data['data_list'][0]  = $this->m_wilayah->findAll();
            $this->data['data_list'][1]  = $this->m_upr->get_report_upr_distinct($tahun)->findAll();
            $this->data['data_list'][2]  = $this->m_upr->get_report_upr($tahun)->findAll();
            
            $this->data['reports'][] = lap_content('L', 'laporan_bid_budi_daya/v_report_upr', $this->data);

            $this->benchmark->mark('end_report');

            $this->data['benchmark'] = $this->benchmark->elapsed_time('start_report', 'end_report');

            $this->load->view('themes/report', $this->data);
        } else {
            show_404();
        }
    }
}



/* End of file laporan_bid_budi_daya.php */
