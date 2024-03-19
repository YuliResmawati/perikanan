<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Panel_harga_ikan extends Backend_Controller {

    public function __construct()
	{
		parent::__construct();

		$this->_init();
		$this->data['uri_mod'] = 'bidang/panel_harga_ikan';
        $this->id_key = $this->private_key;
        $this->breadcrumbs->push('Panel Harga Ikan', 'panel_harga');
        $this->load->model([
            'm_panel_harga_ikan', 'm_wilayah','m_komoditas','m_kamus_data', 'm_bulan'
        ]);

        $this->load->css($this->data['theme_path'] . '/libs/bootstrap-select/css/bootstrap-select.min.css');
        $this->load->css($this->data['theme_path'] . '/libs/flatpickr/flatpickr.min.css');
        $this->load->css($this->data['theme_path'] . '/libs/selectize/css/selectize.bootstrap3.css');
        $this->load->css($this->data['theme_path'] . '/libs/select2/css/select2.min.css');
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
        $this->data['add_button_link'] = base_url('bidang/panel_harga_ikan/add');
        $this->data['page_title'] = "Panel Harga Ikan";
        $this->data['page_description'] = "Halaman Data Harga Bahan Ikan.";
        $this->data['breadcrumbs'] = $this->breadcrumbs->show();
        $this->data['id_key'] = $this->id_key;
        $this->data['card'] = "true";
        $this->data['tahun'] = $this->m_panel_harga_ikan->get_tahun('1')->findAll();

		$this->load->view('panel_harga_ikan/v_index', $this->data);
    }


    public function add()
    {
        $this->breadcrumbs->push('Tambah', 'bidang/panel_harga/add');
        $this->data['page_title'] = "Tambah Panel Harga Ikan";
        $this->data['page_description'] = "Halaman Data Harga Ikan.";
        $this->data['card'] = "true";
        $this->data['breadcrumbs'] = $this->breadcrumbs->show();
        $this->data['id_key'] = $this->id_key;
        $this->data['komoditas'] = $this->m_komoditas->get_all_komoditas_ikan()->findAll();
        $this->data['satuan'] = $this->m_kamus_data->get_all_satuan()->findAll();

        $this->load->view('panel_harga_ikan/v_add', $this->data);
    }

    public function edit($id = null)
    {        
        $id = decrypt_url($id, $this->id_key);
		
		if ($id == FALSE) {
			$this->load->view('errors/html/error_bootbox.php', array('message' => 'ID yang tertera tidak terdaftar', 'redirect_link' => base_url('bidang/harga_panel_ikan')));
        }

        $this->breadcrumbs->push('Edit', 'bidang/panel_harga_ikan/edit');
        $this->data['page_title'] = "Edit Panel Harga Ikan";
        $this->data['page_description'] = "Halaman Data Harga Ikan.";
        $this->data['card'] = "true";
        $this->data['breadcrumbs'] = $this->breadcrumbs->show();
        $this->data['id_key'] = $this->id_key;
        $this->data['id'] = $id;
        $this->data['satuan'] = $this->m_kamus_data->get_all_satuan()->findAll();

        $this->load->view('panel_harga_ikan/v_edit', $this->data);
    }

    public function AjaxGet($id = NULL)
    {
        $this->output->unset_template();

        $id = decrypt_url($id, $this->id_key);
        $date_year = decrypt_url($this->input->post('filter_tahun'), $this->id_key);

        if ($id == FALSE) {
            $this->m_panel_harga_ikan->push_select('status');
            
            $edit_link = 'bidang/panel_harga_ikan/edit/'; 
            $response = $this->m_panel_harga_ikan->get_all_panel_ikan()->datatables();

            if ($date_year == FALSE) {
                $response->where("extract(year from panel_harga_ikan.created_at) = '0'" , null);
            } else {
                if ($date_year !== 'ALL') {
                    $response->where("extract(year from panel_harga_ikan.created_at) = '$date_year'" , NULL);
                }
            }

            $response->where('panel_harga_ikan.type','1');
            $response->edit_column('id', '$1', "encrypt_url(id,' ', $this->id_key)");
            $response->edit_column('status', '$1', "str_status(status)");
            $response->edit_column('tanggal', '$1', "indo_date(tanggal)");
            $response->edit_column('harga', '$1', "rupiah(harga)");
            $response->edit_column('volume', '$1', "produksi(volume)");
            $response->add_column('aksi', '$1 $2 $3', "tabel_icon(id,' ','edit','$edit_link ', $this->id_key, ''),
                                                    tabel_icon(id,' ','delete',' ', $this->id_key),");
            
            $response = $this->m_panel_harga_ikan->datatables(true);
    
            $this->output->set_output($response);
        } else {
            $this->return = $this->m_panel_harga_ikan->get_all_panel_ikan()->find($id); 

            if ($this->return !== FALSE) {
                unset($this->return->id);

                $this->return->jenis = encrypt_url($this->return->jenis, 'app');
                $this->return->komoditas_id = encrypt_url($this->return->komoditas_id, 'app');
                $this->return->satuan = ($this->return->satuan) ? encrypt_url($this->return->satuan, $this->id_key) : '';

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

            $response = json_encode($response);
        }

        return $this->output->set_output($response);
    }

    public function AjaxSave($id = null)
    {
        $this->output->unset_template();

        $id = decrypt_url($id, $this->id_key);
        $captcha_score = get_recapture_score($this->input->post('pni-token-response'));  

        if ($captcha_score < RECAPTCHA_ACCEPTABLE_SPAM_SCORE) {
            $this->result = array(
                'status' => FALSE,
                'message' => '<span class="text-danger"><i class="mdi mdi-alert"></i> Request yang anda jalankan dianggap SPAM oleh sistem.</span>'
            );
        } else {

            $this->form_validation->set_rules('filter_komoditas[]', 'Komoditas', 'required');
            $this->form_validation->set_rules('harga', 'Harga', 'required');
            $this->form_validation->set_rules('satuan', 'Satuan', 'required');
            $this->form_validation->set_error_delimiters(error_delimeter(1), error_delimeter(2));

            if ($this->form_validation->run() == TRUE) {

                if ($id == FALSE) {
                    $id = null;

                    $arr_komoditas = $this->input->post('filter_komoditas[]');
                    $harga = preg_replace("/[^0-9]/", "", $this->input->post('harga'));
                    $volume = preg_replace("/[^0-9]/", "", $this->input->post('volume'));
                    $data = [];

                    foreach ($arr_komoditas as $key => $value) {
                        $data[] = array(
                            'komoditas_id'  => decrypt_url($value, 'app'),
                            'satuan'       => decrypt_url($this->input->post('satuan'), $this->id_key),
                            'harga'       => $harga,
                            'volume'       => $volume,
                            'status'     => '1',
                            'type'       => '1'
                        );  
                    }
                } 

                $this->return = $this->m_panel_harga_ikan->save_batch($data);

                if ($this->return) {
                    $this->result = array(
                        'status' => TRUE,
                        'message' => '<span class="text-success"><i class="mdi mdi-check-decagram"></i> Data berhasil disimpan.</span>'
                    );
                } else {
                    $this->result = array(
                        'status' => FALSE,
                        'message' => '<span class="text-danger"><i class="mdi mdi-alert"></i> Data gagal disimpan.</span>'
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
            $this->output->set_output(json_encode(['status'=> FALSE, 'message'=> 'Gagal mengambil data.']));
        }
    }

    public function AjaxSaveEdit($id = null)
    {
        $this->output->unset_template();

        $id = decrypt_url($id, $this->id_key);
        $captcha_score = get_recapture_score($this->input->post('pnie-token-response'));  

        if ($captcha_score < RECAPTCHA_ACCEPTABLE_SPAM_SCORE) {
            $this->result = array(
                'status' => FALSE,
                'message' => '<span class="text-danger"><i class="mdi mdi-alert"></i> Request yang anda jalankan dianggap SPAM oleh sistem.</span>'
            );
        } else {

            $this->form_validation->set_rules('komoditas', 'Komoditas', 'required');
            $this->form_validation->set_rules('harga', 'Harga', 'required');
            $this->form_validation->set_rules('satuan', 'Satuan', 'required');
            $this->form_validation->set_error_delimiters(error_delimeter(1), error_delimeter(2));

            if ($this->form_validation->run() == TRUE) {

                
                $harga = preg_replace("/[^0-9]/", "", $this->input->post('harga'));
                $volume = preg_replace("/[^0-9]/", "", $this->input->post('volume'));
                $komoditas = decrypt_url($this->input->post('komoditas'), 'app');
                
                $this->m_panel_harga_ikan->push_to_data('satuan', decrypt_url($this->input->post('satuan'), $this->id_key))
                    ->push_to_data('harga', $harga)
                    ->push_to_data('volume', $volume)
                    ->push_to_data('komoditas_id', $komoditas);

                $this->return = $this->m_panel_harga_ikan->save($id);

                if ($this->return) {
                    $this->result = array(
                        'status' => TRUE,
                        'message' => '<span class="text-success"><i class="mdi mdi-check-decagram"></i> Data berhasil disimpan.</span>'
                    );
                } else {
                    $this->result = array(
                        'status' => FALSE,
                        'message' => '<span class="text-danger"><i class="mdi mdi-alert"></i> Data gagal disimpan.</span>'
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
            $this->output->set_output(json_encode(['status'=> FALSE, 'message'=> 'Gagal mengambil data.']));
        }
    }

    public function AjaxDel($id = null)
    {
        $this->output->unset_template();

        $id = decrypt_url($id, $this->id_key);

        if ($id !== FALSE) {
            $this->return = $this->m_panel_harga_ikan->delete($id);

            if ($this->return) {
                $this->result = array(
                    'status'   => TRUE,
                    'message' => '<span class="text-success"><i class="mdi mdi-check-decagram"></i> Data berhasil dihapus.</span>'
                );
            } else {
                $this->result = array(
                    'status'   => FALSE,
                    'message' => '<span class="text-danger"><i class="mdi mdi-alert"></i> Data gagal dihapus.</span>'
                );
            }
        } else {
            $this->result = array(
                'status'   => FALSE,
                'message' => '<span class="text-danger"><i class="mdi mdi-alert"></i> ID tidak valid.</span>'
            );
        }

        $this->output->set_output(json_encode($this->result));
    }

    public function report($tahun)
    {
        $this->output->unset_template();

        ini_set('memory_limit', '-1');

        $this->benchmark->mark('start_report');

        $tahun = decrypt_url($tahun, $this->id_key);
        $date_now = date('Y-m-d');

        if ($tahun != FALSE) {
            $this->data['base64_logo_instansi'] = base64_encode(file_get_contents("./assets/global/images/agam.png"));
            $this->data['paper_size'] = "F4";
            $this->data['page_title'] = "Cetak Laporan Harga Ikan";

            $this->data['date_now'] = $date_now;
            $this->data['data_list'] = $this->m_panel_harga_ikan->get_all_panel_ikan()->where(["extract(year from panel_harga_ikan.created_at) = '$tahun'" => null, 'panel_harga_ikan.type' => '1'])->findAll();
            $this->data['reports'][] = lap_content('L', 'panel_harga_ikan/v_report', $this->data);

            $this->benchmark->mark('end_report');

            $this->data['benchmark'] = $this->benchmark->elapsed_time('start_report', 'end_report');

            $this->load->view('themes/report', $this->data);
        } else {
            show_404();
        }
    }


}

/* End of file Pengaturan_website.php */
