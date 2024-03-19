<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Upr extends Backend_Controller {
    public function __construct()
	{
		parent::__construct();

		$this->_init();
		$this->data['uri_mod'] = 'bidang/upr';
        $this->id_key = $this->private_key;
        $this->breadcrumbs->push('Unit Pembenihan Rakyat', 'upr');
        $this->load->model(['m_upr', 'm_wilayah','m_bulan']);

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
        $this->data['add_button_link'] = base_url('bidang/upr/add');
        $this->data['page_title'] = "Unit Pembenihan Rakyat ";
        $this->data['page_description'] = "Halaman Unit Pembenihan Rakyat.";
        $this->data['breadcrumbs'] = $this->breadcrumbs->show();
        $this->data['id_key'] = $this->id_key;
        $this->data['card'] = "true";

		$this->load->view('upr/v_index', $this->data);
    }

    public function index_panel($id = null)
	{   
        $id = decrypt_url($id, $this->id_key);

        if ($id == FALSE) {
			$this->load->view('errors/html/error_bootbox.php', array('message' => 'ID yang tertera tidak terdaftar', 'redirect_link' => base_url('bidang/upr')));
        }
        $nama_kec = $this->m_wilayah->where(['id' => $id])->findAll();
        $kecamatan = strtolower($nama_kec[0]->nama_kecamatan);

        $this->data['add_button_link'] = base_url('bidang/upr/add_panel/').encrypt_url($id, $this->id_key);
        $this->data['page_title'] = "UPR Kecamatan ".ucfirst($kecamatan) ;
        $this->data['page_description'] = "Halaman Data Unit Pembenihan Rakyat.";
        $this->data['breadcrumbs'] = $this->breadcrumbs->show();
        $this->data['id_key'] = $this->id_key;
        $this->data['id'] = $id; 
        $this->data['card'] = "true";

		$this->load->view('upr/v_index_panel', $this->data);
    }

    public function add()
    {
        $this->breadcrumbs->push('Tambah', 'bidang/upr/add');
        $this->data['page_title'] = "Tambah Data Unit Pembenihan Rakyat";
        $this->data['page_description'] = "Halaman Tambah Data Unit Pembenihan Rakyat.";
        $this->data['card'] = "true";
        $this->data['breadcrumbs'] = $this->breadcrumbs->show();
        $this->data['id_key'] = $this->id_key;
        $this->data['kecamatan'] = $this->m_wilayah->findAll();

        $this->load->view('upr/v_add', $this->data);
    }

    public function add_panel($id = null)
    {
        $id = decrypt_url($id, $this->id_key);

        $this->breadcrumbs->push('Tambah', 'bidang/upr/add');
        $this->data['page_title'] = "Tambah Unit Pembenihan Rakyat";
        $this->data['page_description'] = "Halaman Data Unit Pembenihan Rakyat.";
        $this->data['card'] = "true";
        $this->data['breadcrumbs'] = $this->breadcrumbs->show();
        $this->data['id_key'] = $this->id_key;
        $this->data['id'] = $id; // kecamatan_id

        $this->load->view('upr/v_add_panel', $this->data);
    }

    public function edit($id = null)
    {        
        $id = decrypt_url($id, $this->id_key);

		if ($id == FALSE) {
			$this->load->view('errors/html/error_bootbox.php', array('message' => 'ID yang tertera tidak terdaftar', 'redirect_link' => base_url('bidang/upr')));
        }

        $this->breadcrumbs->push('Edit', 'bidang/upr/edit');
        $this->data['page_title'] = "Edit Data Unit Pembenihan Rakyat";
        $this->data['page_description'] = "Halaman Edit Data Unit Pembenihan Rakyat.";
        $this->data['card'] = "true";
        $this->data['breadcrumbs'] = $this->breadcrumbs->show();
        $this->data['id_key'] = $this->id_key;
        $this->data['id'] = $id;
        $this->data['kec_id'] = $this->m_upr->find($id)->kecamatan_id;
        $this->load->view('upr/v_edit', $this->data);
    }

    public function AjaxGet($id = NULL)
    {
        $this->output->unset_template();

        $id = decrypt_url($id, $this->id_key);

        if ($id == FALSE) {
            $this->m_wilayah->push_select('status');
            
            $panel = 'bidang/upr/index_panel/'; 
            $response = $this->m_wilayah->get_all_upr()->datatables();
            $response->edit_column('id', '$1', "encrypt_url(id,' ', $this->id_key)");
            $response->edit_column('status', '$1', "str_status(status)");
            $response->edit_column('jumlah', '$1', "jumlah_sum(jumlah_upr)");
            $response->edit_column('luas_lahan', '$1', "cekdesimal(luas_lahan)");
            $response->add_column('aksi', '$1', "tabel_icon(id,' ','panel_harga','$panel ', $this->id_key, '')");
            
            $response = $this->m_wilayah->datatables(true);
    
            $this->output->set_output($response);
        } else {
            show_404();
        }

        return $this->output->set_output($response);
    }

    public function AjaxGetPanel($add = NULL, $id = NULL)
    {
        $this->output->unset_template();
        $id = decrypt_url($id, $this->id_key);

        if ($id !== FALSE) {
            if($add == 'list'){
                $this->m_upr->push_select('status');
                $edit_link = 'bidang/upr/edit/'; 

                $response = $this->m_upr->get_all_upr()->datatables();
                $response->where('kecamatan_id', $id);
                $response->edit_column('id', '$1', "encrypt_url(id,' ', $this->id_key)");
                $response->edit_column('status', '$1', "str_status(status)");
                $response->edit_column('luas_lahan', '$1', "cekdesimal(luas_lahan)");
                $response->add_column('aksi', '$1 $2', "tabel_icon(id,' ','edit','$edit_link', $this->id_key),
                                                                tabel_icon(id,' ','delete',' ', $this->id_key)");
                $response->edit_column('kecamatan_id', '$1', "encrypt_url(kecamatan_id,' ', $this->id_key)");
                $response->edit_column('komoditas_id', '$1', "encrypt_url(komoditas_id,' ', $this->id_key)");

                $response = $this->m_upr->datatables(true);
        
                $this->output->set_output($response);
            }else{
                $this->return = $this->m_upr->get_all_upr()->find($id); 

                if ($this->return !== FALSE) {
                    unset($this->return->id);
                    $this->return->kecamatan_id = ($this->return->kecamatan_id) ? encrypt_url($this->return->kecamatan_id, $this->id_key) : '';
                    $this->return->komoditas_id = ($this->return->komoditas_id) ? encrypt_url($this->return->komoditas_id, 'app') : '';

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
            
        }

        return $this->output->set_output($response);
    }

    public function AjaxSave($id = null)
    {
        $this->output->unset_template();

        $id = decrypt_url($id, $this->id_key);
        $captcha_score = get_recapture_score($this->input->post('upr-token-response'));  

        if ($captcha_score < RECAPTCHA_ACCEPTABLE_SPAM_SCORE) {
            $this->result = array(
                'status' => FALSE,
                'message' => '<span class="text-danger"><i class="mdi mdi-alert"></i> Request yang anda jalankan dianggap SPAM oleh sistem.</span>'
            );
        } else {
            
            $this->form_validation->set_rules('kecamatan[]', 'Kecamatan', 'required'); 
            $this->form_validation->set_rules('komoditas', 'Komoditas', 'required'); 
            $this->form_validation->set_rules('jumlah', 'Jumlah Unit', 'required');
            $this->form_validation->set_rules('lahan', 'Luas Lahan', 'required');
            $this->form_validation->set_error_delimiters(error_delimeter(1), error_delimeter(2));

            if ($this->form_validation->run() == TRUE) {  

                if ($id == FALSE) {
                    $arr_kecamatan_id = $this->input->post('kecamatan[]'); 
                    $_data = [];

                    foreach ($arr_kecamatan_id as $row) {
                        $_data[] = array(
                            'kecamatan_id' => decrypt_url($row, $this->id_key),
                            'komoditas_id' => decrypt_url($this->input->post('komoditas'), 'app'),
                            'jumlah_upr'    => $this->input->post('jumlah'),
                            'luas_lahan'    => $this->input->post('lahan'),
                            'status'     => '1',
                        );
                    }
                }

                if ($this->result['status'] !== FALSE) {

                    $this->return =  $this->m_upr->save_batch($_data);

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

    public function AjaxSavePanel($id = null)
    {
        $this->output->unset_template();
        $captcha_score = get_recapture_score($this->input->post('uprp-token-response'));  

        if ($captcha_score < RECAPTCHA_ACCEPTABLE_SPAM_SCORE) {
            $this->result = array(
                'status' => FALSE,
                'message' => '<span class="text-danger"><i class="mdi mdi-alert"></i> Request yang anda jalankan dianggap SPAM oleh sistem.</span>'
            );
        } else {
            $this->result = array('status' => TRUE, 'message' => NULL);

            $id = decrypt_url($id, $this->id_key);

            $this->form_validation->set_rules('komoditas', 'Komoditas', 'required'); 
            $this->form_validation->set_rules('jumlah', 'Jumlah Unit', 'required');
            $this->form_validation->set_rules('lahan', 'Luas Lahan', 'required');

            $this->form_validation->set_error_delimiters(error_delimeter(1), error_delimeter(2));

            if ($this->form_validation->run() == TRUE) {  

                if ($id == FALSE) {
                    $this->m_upr->push_to_data('status', '1');
                }

                $this->m_upr->push_to_data('komoditas_id', decrypt_url($this->input->post('komoditas'), 'app'))
                    ->push_to_data('jumlah_upr', $this->input->post('jumlah'))
                    ->push_to_data('kecamatan_id', decrypt_url($this->input->post('kec_id'), $this->id_key))
                    ->push_to_data('luas_lahan', $this->input->post('lahan'));


                if ($this->result['status'] !== FALSE) {

                    $this->return =  $this->m_upr->save($id);

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
            $this->return = $this->m_upr->delete($id);

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

}

/* End of file upr.php */
