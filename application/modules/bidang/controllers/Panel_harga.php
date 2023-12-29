<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Panel_harga extends Backend_Controller {

    public function __construct()
	{
		parent::__construct();

		$this->_init();
		$this->data['uri_mod'] = 'bidang/panel_harga';
        $this->id_key = $this->private_key;
        $this->breadcrumbs->push('Panel Harga Bahan Pokok', 'panel_harga');
        $this->load->model([
            'm_panel_harga', 'm_wilayah','m_komoditas','m_kamus_data', 'm_bulan'
        ]);
        
        $this->load->css($this->data['theme_path'] . '/libs/bootstrap-select/css/bootstrap-select.min.css');
        $this->load->css($this->data['theme_path'] . '/libs/flatpickr/flatpickr.min.css');
        $this->load->css($this->data['theme_path'] . '/libs/select2/css/select2.min.css');
        $this->load->js($this->data['theme_path'] . '/libs/bootstrap-select/js/bootstrap-select.min.js');
        $this->load->js($this->data['theme_path'] . '/libs/select2/js/select2.min.js');
        $this->load->js($this->data['theme_path'] . '/libs/select2/js/i18n/id.js');
        $this->load->js($this->data['global_custom_path'] . '/js/select2-init.js');
        $this->load->js($this->data['global_custom_path'] . '/js/init_mask.js');
        $this->load->js($this->data['theme_path'] . '/libs/flatpickr/flatpickr.min.js');
        $this->load->js($this->data['theme_path'] . '/js/rupiah.js');

	}

	public function _init()
    {
        $this->output->set_template('backend');
	}

    public function index()
	{   
        $this->data['add_button_link'] = base_url('bidang/panel_harga/add');
        $this->data['page_title'] = "Panel Harga Bahan Pokok";
        $this->data['page_description'] = "Halaman Data Harga Bahan Pokok Konsumen.";
        $this->data['breadcrumbs'] = $this->breadcrumbs->show();
        $this->data['id_key'] = $this->id_key;
        $this->data['card'] = "true";

		$this->load->view('panel_harga/v_index', $this->data);
    }

    public function index_panel($id = null)
	{   
        $id = decrypt_url($id, $this->id_key);

        if ($id == FALSE) {
			$this->load->view('errors/html/error_bootbox.php', array('message' => 'ID yang tertera tidak terdaftar', 'redirect_link' => base_url('bidang/panel_harga')));
        }


        $this->data['add_button_link'] = base_url('bidang/panel_harga/add_panel/').encrypt_url($id, $this->id_key);
        $this->data['page_title'] = "Panel Harga Bahan Pokok";
        $this->data['page_description'] = "Halaman Data Harga Bahan Pokok Konsumen.";
        $this->data['breadcrumbs'] = $this->breadcrumbs->show();
        $this->data['id_key'] = $this->id_key;
        $this->data['id'] = $id; 
        $this->data['card'] = "true";
        $this->data['bulan'] = $this->m_bulan->findAll();
        $this->data['komoditas'] = $this->m_komoditas->get_all_komoditas_bahan_pokok()->findAll();

		$this->load->view('panel_harga/v_index_panel', $this->data);
    }

    public function add()
    {
        $this->breadcrumbs->push('Tambah', 'bidang/panel_harga/add');
        $this->data['page_title'] = "Tambah Panel Harga Bahan Pokok";
        $this->data['page_description'] = "Halaman Data Harga Bahan Pokok Konsumen.";
        $this->data['card'] = "true";
        $this->data['breadcrumbs'] = $this->breadcrumbs->show();
        $this->data['id_key'] = $this->id_key;
        $this->data['kecamatan'] = $this->m_wilayah->findAll();
        $this->data['komoditas'] = $this->m_komoditas->get_all_komoditas_bahan_pokok()->findAll();
        $this->data['satuan'] = $this->m_kamus_data->get_all_satuan()->findAll();

        $this->load->view('panel_harga/v_add', $this->data);
    }

    public function add_panel($id = null)
    {
        $id = decrypt_url($id, $this->id_key);

        $this->breadcrumbs->push('Tambah', 'bidang/panel_harga/add');
        $this->data['page_title'] = "Tambah Panel Harga Bahan Pokok";
        $this->data['page_description'] = "Halaman Data Harga Bahan Pokok Konsumen.";
        $this->data['card'] = "true";
        $this->data['breadcrumbs'] = $this->breadcrumbs->show();
        $this->data['id_key'] = $this->id_key;
        $this->data['id'] = $id; // kecamatan_id
        $this->data['komoditas'] = $this->m_komoditas->get_all_komoditas_bahan_pokok()->findAll();
        $this->data['satuan'] = $this->m_kamus_data->get_all_satuan()->findAll();

        $this->load->view('panel_harga/v_add_panel', $this->data);
    }

    public function edit($id = null)
    {        
        $id = decrypt_url($id, $this->id_key);
		
		if ($id == FALSE) {
			$this->load->view('errors/html/error_bootbox.php', array('message' => 'ID yang tertera tidak terdaftar', 'redirect_link' => base_url('admin/gallery')));
        }

        $this->breadcrumbs->push('Edit', 'admin/gallery/edit');
        $this->data['page_title'] = "Edit Panel Harga Bahan Pokok";
        $this->data['page_description'] = "Halaman Data Harga Bahan Pokok Konsumen.";
        $this->data['card'] = "true";
        $this->data['breadcrumbs'] = $this->breadcrumbs->show();
        $this->data['id_key'] = $this->id_key;
        $this->data['id'] = $id;
        $this->data['kec_id'] = $this->m_panel_harga->find($id)->kecamatan_id;
        $this->data['komoditas'] = $this->m_komoditas->get_all_komoditas_bahan_pokok()->findAll();
        $this->data['satuan'] = $this->m_kamus_data->get_all_satuan()->findAll();

        $this->load->view('panel_harga/v_edit', $this->data);
    }

    public function AjaxGet($id = NULL)
    {
        $this->output->unset_template();

        $id = decrypt_url($id, $this->id_key);

        if ($id == FALSE) {
            $this->m_wilayah->push_select('status');
            
            $panel = 'bidang/panel_harga/index_panel/'; 
            $response = $this->m_wilayah->get_all_panel_kecamatan()->datatables();
            $response->edit_column('id', '$1', "encrypt_url(id,' ', $this->id_key)");
            $response->edit_column('status', '$1', "str_status(status)");
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
        $date_month = decrypt_url($this->input->post('filter_bulan'), $this->id_key);

        if ($id !== FALSE) {
            if($add == 'list'){
                $this->m_panel_harga->push_select('status');
                $edit_link = 'bidang/panel_harga/edit/'; 

                $response = $this->m_panel_harga->get_all_komoditas_by_kecamatan()->datatables();

                if ($date_month == FALSE) {
                    $response->where("extract(month from tanggal) = '0'" , null);
                } else {
                    if (decrypt_url($this->input->post('filter_unor'), $this->id_key) !== 'ALL') {
                        $response->where("extract(month from tanggal) = '$date_month'" , NULL);
                    }
                }

                if (decrypt_url($this->input->post('filter_komoditas'), $this->id_key) == FALSE) {
                    $response->where('komoditas_id', 0);
                } else {
                    if (decrypt_url($this->input->post('filter_komoditas'), $this->id_key) !== 'ALL') {
                        $response->where('komoditas_id', decrypt_url($this->input->post('filter_komoditas'), $this->id_key));
                    }
                }

                $response->where('kecamatan_id', $id);

                $response->edit_column('id', '$1', "encrypt_url(id,' ', $this->id_key)");
                $response->edit_column('status', '$1', "str_status(status)");
                $response->edit_column('tanggal', '$1', "indo_date(tanggal)");
                $response->edit_column('harga', '$1', "rupiah(harga)");
                $response->add_column('aksi', '$1 $2', "tabel_icon(id,' ','edit','$edit_link', $this->id_key),
                                                                tabel_icon(id,' ','delete',' ', $this->id_key)");

                $response = $this->m_panel_harga->datatables(true);
        
                $this->output->set_output($response);
            }else{
                $this->return = $this->m_panel_harga->get_all_komoditas_by_kecamatan()->find($id); 

                if ($this->return !== FALSE) {
                    unset($this->return->id);
                    $this->return->kecamatan_id = ($this->return->kecamatan_id) ? encrypt_url($this->return->kecamatan_id, $this->id_key) : '';
                    $this->return->komoditas_id = ($this->return->komoditas_id) ? encrypt_url($this->return->komoditas_id, $this->id_key) : '';
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
            
        }

        return $this->output->set_output($response);
    }

    public function AjaxSave($id = null)
    {
        $this->output->unset_template();
        $captcha_score = get_recapture_score($this->input->post('pn-token-response'));  

        if ($captcha_score < RECAPTCHA_ACCEPTABLE_SPAM_SCORE) {
            $this->result = array(
                'status' => FALSE,
                'message' => '<span class="text-danger"><i class="mdi mdi-alert"></i> Request yang anda jalankan dianggap SPAM oleh sistem.</span>'
            );
        } else {
            $this->result = array('status' => TRUE, 'message' => NULL);

            $id = decrypt_url($id, $this->id_key);

            $this->form_validation->set_rules('kecamatan[]', 'Kecamatan', 'required'); 
            $this->form_validation->set_rules('komoditas', 'Komoditas', 'required'); 
            $this->form_validation->set_rules('harga', 'Harga', 'required');
            $this->form_validation->set_rules('satuan', 'Satuan', 'required');
            $this->form_validation->set_rules('tanggal', 'Tanggal', 'required');


            $this->form_validation->set_error_delimiters(error_delimeter(1), error_delimeter(2));

            if ($this->form_validation->run() == TRUE) {  

                if ($id == FALSE) {
                    $arr_kecamatan_id = $this->input->post('kecamatan[]'); 
                    $harga = preg_replace("/[^0-9]/", "", $this->input->post('harga'));
                    $_data = [];

                    foreach ($arr_kecamatan_id as $row) {
                        $_data[] = array(
                            'kecamatan_id' => decrypt_url($row, $this->id_key),
                            'komoditas_id' => decrypt_url($this->input->post('komoditas'), $this->id_key),
                            'harga'      => $harga,
                            'satuan'     => decrypt_url($this->input->post('satuan'), $this->id_key),
                            'tanggal'    => $this->input->post('tanggal'),
                            'status'     => '1',
                            'type'       => '1'
                        );
                    }
                }

                if ($this->result['status'] !== FALSE) {

                    $this->return =  $this->m_panel_harga->save_batch($_data);

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
        $captcha_score = get_recapture_score($this->input->post('pnl-token-response'));  

        if ($captcha_score < RECAPTCHA_ACCEPTABLE_SPAM_SCORE) {
            $this->result = array(
                'status' => FALSE,
                'message' => '<span class="text-danger"><i class="mdi mdi-alert"></i> Request yang anda jalankan dianggap SPAM oleh sistem.</span>'
            );
        } else {
            $this->result = array('status' => TRUE, 'message' => NULL);

            $id = decrypt_url($id, $this->id_key);

            $this->form_validation->set_rules('komoditas', 'Komoditas', 'required'); 
            $this->form_validation->set_rules('harga', 'Harga', 'required');
            $this->form_validation->set_rules('satuan', 'Satuan', 'required');
            $this->form_validation->set_rules('tanggal', 'Tanggal', 'required');


            $this->form_validation->set_error_delimiters(error_delimeter(1), error_delimeter(2));

            if ($this->form_validation->run() == TRUE) {  

                if ($id == FALSE) {
                    $this->m_panel_harga->push_to_data('status', '1');
                    $this->m_panel_harga->push_to_data('type', '1');
                }
                $harga = preg_replace("/[^0-9]/", "", $this->input->post('harga'));

                $this->m_panel_harga->push_to_data('komoditas_id', decrypt_url($this->input->post('komoditas'), $this->id_key))
                    ->push_to_data('harga', $harga)
                    ->push_to_data('satuan', decrypt_url($this->input->post('satuan'), $this->id_key))
                    ->push_to_data('kecamatan_id', decrypt_url($this->input->post('kec_id'), $this->id_key))
                    ->push_to_data('tanggal', $this->input->post('tanggal'));


                if ($this->result['status'] !== FALSE) {

                    $this->return =  $this->m_panel_harga->save($id);

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
            $this->return = $this->m_panel_harga->delete($id);

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

/* End of file Pengaturan_website.php */
