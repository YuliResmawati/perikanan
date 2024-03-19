<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Ketersediaan_pangan extends Backend_Controller {
    public function __construct()
	{
		parent::__construct();

		$this->_init();
		$this->data['uri_mod'] = 'bidang/ketersediaan_pangan';
        $this->id_key = $this->private_key;
        $this->breadcrumbs->push('Ketersediaan Pangan', 'ketersediaan_pangan');
        $this->load->model(['m_ketersediaan_pangan','m_wilayah','m_bulan']);

        $this->load->css($this->data['theme_path'] . '/libs/bootstrap-select/css/bootstrap-select.min.css');
        $this->load->css($this->data['theme_path'] . '/libs/selectize/css/selectize.bootstrap3.css');
        $this->load->css($this->data['theme_path'] . '/libs/select2/css/select2.min.css');
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
        $this->data['add_button_link'] = base_url('bidang/ketersediaan_pangan/add');
        $this->data['page_title'] = "Pemanfaatan Pangan ";
        $this->data['page_description'] = "Halaman Pemanfaatan Pangan.";
        $this->data['breadcrumbs'] = $this->breadcrumbs->show();
        $this->data['id_key'] = $this->id_key;
        $this->data['card'] = "true";
        $this->data['kecamatan'] = $this->m_wilayah->findAll();
        $this->data['bulan'] = $this->m_bulan->findAll();

		$this->load->view('ketersediaan_pangan/v_index', $this->data);
    }

    public function add()
    {
        $this->breadcrumbs->push('Tambah', 'bidang/ketersediaan_pangan/add');
        $this->data['page_title'] = "Tambah Data Pemanfaatan Pangan";
        $this->data['page_description'] = "Halaman Tambah Data Pemanfaatan Pangan.";
        $this->data['card'] = "true";
        $this->data['breadcrumbs'] = $this->breadcrumbs->show();
        $this->data['id_key'] = $this->id_key;
        $this->data['kecamatan'] = $this->m_wilayah->findAll();

        $this->load->view('ketersediaan_pangan/v_add', $this->data);
    }

    public function edit($id = null)
    {        
        $id = decrypt_url($id, $this->id_key);
		
		if ($id == FALSE) {
			$this->load->view('errors/html/error_bootbox.php', array('message' => 'ID yang tertera tidak terdaftar', 'redirect_link' => base_url('bidang/ketersediaan_pangan')));
        }

        $this->breadcrumbs->push('Edit', 'bidang/ketersediaan_pangan/edit');
        $this->data['page_title'] = "Edit Data Pemanfaatan Pangan";
        $this->data['page_description'] = "Halaman Edit Data Pemanfaatan Pangan.";
        $this->data['card'] = "true";
        $this->data['breadcrumbs'] = $this->breadcrumbs->show();
        $this->data['id_key'] = $this->id_key;
        $this->data['id'] = $id;


        $this->load->view('ketersediaan_pangan/v_edit', $this->data);
    }

    public function AjaxGet($id = NULL)
    {
        $this->output->unset_template();

        $id = decrypt_url($id, $this->id_key);

        if ($id == FALSE) {
            $this->m_ketersediaan_pangan->push_select('status');

            $edit_link = 'bidang/ketersediaan_pangan/edit/';
            $response = $this->m_ketersediaan_pangan->get_all_ketersediaan_pangan()->datatables();

            $response->edit_column('id', '$1', "encrypt_url(id,' ', $this->id_key)");
            $response->add_column('aksi', '$1 $2', "tabel_icon(id,' ','edit','$edit_link ', $this->id_key, ' '),
                                                    tabel_icon(id,' ','delete',' ', $this->id_key)");
            $response->edit_column('kecamatan_id', '$1', "encrypt_url(kecamatan_id,' ', $this->id_key)");


            $response = $this->m_ketersediaan_pangan->datatables(true);
    
            $this->output->set_output($response);
        } else {
            $this->return = $this->m_ketersediaan_pangan->get_all_ketersediaan_pangan()->find($id); 

            if ($this->return !== FALSE) {
                unset($this->return->id);

                $this->return->kecamatan_id = encrypt_url($this->return->kecamatan_id, 'app');

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
        $captcha_score = get_recapture_score($this->input->post('kp-token-response'));  

        if ($captcha_score < RECAPTCHA_ACCEPTABLE_SPAM_SCORE) {
            $this->result = array(
                'status' => FALSE,
                'message' => '<span class="text-danger"><i class="mdi mdi-alert"></i> Request yang anda jalankan dianggap SPAM oleh sistem.</span>'
            );
        } else {
            
            $this->form_validation->set_rules('kecamatan', 'Kecamatan', 'required');
            $this->form_validation->set_rules('tanam_padi', 'Luas Tanam Padi', 'required');
            $this->form_validation->set_rules('puso_padi', 'Luas Puso Padi', 'required');
            $this->form_validation->set_error_delimiters(error_delimeter(1), error_delimeter(2));

            if ($this->form_validation->run() == TRUE) {

                if ($id == FALSE) {
                    $id = null;
                    $this->m_ketersediaan_pangan->push_to_data('status', '1');
                }
                    $kecamatan = decrypt_url($this->input->post('kecamatan'), 'app');
                
                    $this->m_ketersediaan_pangan->push_to_data('luas_tanam_padi', $this->input->post('tanam_padi'))
                        ->push_to_data('luas_puso_padi', $this->input->post('puso_padi'))
                        ->push_to_data('kecamatan_id', $kecamatan);

            
                $this->return = $this->m_ketersediaan_pangan->save($id);

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
            $this->return = $this->m_ketersediaan_pangan->delete($id);

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

    public function report($bulan, $tahun)
    {
        $this->output->unset_template();

        ini_set('memory_limit', '-1');

        $this->benchmark->mark('start_report');

        $bulan = decrypt_url($bulan, $this->id_key);
        $tahun = decrypt_url($tahun, $this->id_key);

        if ($tahun != FALSE) {
            $this->data['base64_logo_instansi'] = base64_encode(file_get_contents("./assets/global/images/agam.png"));
            $this->data['paper_size'] = "F4";
            $this->data['page_title'] = "Cetak Laporan Harga Ikan";

            $this->data['data_list'] = $this->m_ketersediaan_pangan->get_all_ketersediaan_pangan()->where(["extract(month from ketersediaan_pangan.created_at) = '$bulan'" => null, "extract(year from ketersediaan_pangan.created_at) = '$tahun'" => null])->findAll();
            $this->data['reports'][] = lap_content('L', 'ketersediaan_pangan/v_report', $this->data);

            $this->benchmark->mark('end_report');

            $this->data['benchmark'] = $this->benchmark->elapsed_time('start_report', 'end_report');

            $this->load->view('themes/report', $this->data);
        } else {
            show_404();
        }
    }

}

/* End of file ketersediaan_pangan.php */
