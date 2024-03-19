<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Armada_tangkap_ikan extends Backend_Controller {

    public function __construct()
	{
		parent::__construct();

		$this->_init();
		$this->data['uri_mod'] = 'bidang/armada_tangkap_ikan';
        $this->id_key = $this->private_key;
        $this->breadcrumbs->push('Armada, Alat Penangkapan Ikan', 'armada_tangkap_ikan');
        $this->load->model(['m_armada_tangkap_ikan', 'm_indikator_tangkap_ikan']);
        
        $this->load->css($this->data['theme_path'] . '/libs/bootstrap-select/css/bootstrap-select.min.css');
        $this->load->js($this->data['theme_path'] . '/libs/bootstrap-select/js/bootstrap-select.min.js');
        $this->load->css($this->data['theme_path'] . '/libs/select2/css/select2.min.css');
        $this->load->js($this->data['theme_path'] . '/libs/select2/js/select2.min.js');
        $this->load->js($this->data['theme_path'] . '/libs/select2/js/i18n/id.js');
        $this->load->js($this->data['global_custom_path'] . '/js/select2-init.js');
        $this->load->js($this->data['global_custom_path'] . '/js/init_mask.js');

	}

	public function _init()
    {
        $this->output->set_template('backend');
	}

    public function index()
	{   
        
        $this->data['add_button_link'] = base_url('bidang/armada_tangkap_ikan/add');
        $this->data['page_title'] = "Armada dan Alat Tangkap Ikan";
        $this->data['page_description'] = "Halaman Data Armada dan Alat Tangkap Ikan.";
        $this->data['breadcrumbs'] = $this->breadcrumbs->show();
        $this->data['id_key'] = $this->id_key;
        $this->data['card'] = "true";

		$this->load->view('armada_alat_tangkap_ikan/v_index', $this->data);
    }

    public function add()
    {
        $this->breadcrumbs->push('Tambah', 'bidang/armada_tangkap_ikan/add');
        $this->data['page_title'] = "Tambah Armada dan Alat Tangkap Ikan";
        $this->data['page_description'] = "Halaman Data Armada dan Alat Tangkap Ikan.";
        $this->data['card'] = "true";
        $this->data['breadcrumbs'] = $this->breadcrumbs->show();
        $this->data['id_key'] = $this->id_key;

        $this->load->view('armada_alat_tangkap_ikan/v_add', $this->data);
    }

    public function edit($id = null)
    {        
        $id = decrypt_url($id, $this->id_key);
		
		if ($id == FALSE) {
			$this->load->view('errors/html/error_bootbox.php', array('message' => 'ID yang tertera tidak terdaftar', 'redirect_link' => base_url('bidang/armada_alat_tangkap_ikan')));
        }

        $this->breadcrumbs->push('Edit', 'bidang/armada_alat_tangkap_ikan/edit');
        $this->data['page_title'] = "Edit Data Armada dan Alat Tangkap Ikan";
        $this->data['page_description'] = "Halaman Edit Data Armada dan Alat Tangkap Ikan.";
        $this->data['card'] = "true";
        $this->data['breadcrumbs'] = $this->breadcrumbs->show();
        $this->data['id_key'] = $this->id_key;
        $this->data['id'] = $id;

        $this->load->view('armada_alat_tangkap_ikan/v_edit', $this->data);
    }

    public function AjaxGet($id = NULL)
    {
        $this->output->unset_template();

        $id = decrypt_url($id, $this->id_key);

        if ($id == FALSE) {
            $this->m_armada_tangkap_ikan->push_select('status');
            $edit_link = 'bidang/armada_tangkap_ikan/edit/';
            $response = $this->m_armada_tangkap_ikan->get_all_armada_tangkap()->datatables();

            if (decrypt_url($this->input->post('filter_jenis'), $this->id_key) == FALSE) {
                $response->where('type', 0);
            } else {
                if (decrypt_url($this->input->post('filter_jenis'), $this->id_key) !== 'ALL') {
                    $response->where('type', decrypt_url($this->input->post('filter_jenis'), $this->id_key));
                }
            }

            $response->edit_column('id', '$1', "encrypt_url(id,' ', $this->id_key)");
            $response->edit_column('status', '$1', "str_status(status)");
            $response->edit_column('alat_bantu', '$1', "set_null(nama_alat_bantu)");
            $response->edit_column('jumlah_c', '$1', "set_null(jumlah_c)");
            $response->add_column('aksi', '$1 $2', "tabel_icon(id,' ','edit','$edit_link ', $this->id_key, ' '),
                                                    tabel_icon(id,' ','delete',' ', $this->id_key)");
            
            $response = $this->m_armada_tangkap_ikan->datatables(true);
    
            $this->output->set_output($response);
        } else {
            $this->return = $this->m_armada_tangkap_ikan->get_all_armada_tangkap()->find($id); 

            if ($this->return !== FALSE) {
                unset($this->return->id);
                
                $this->return->type= encrypt_url(($this->return->type), 'app');
                $this->return->armada= encrypt_url(($this->return->armada), 'app');
                $this->return->alat_tangkap= encrypt_url(($this->return->alat_tangkap), 'app');
                $this->return->alat_bantu= encrypt_url(($this->return->alat_bantu), 'app');

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
        $captcha_score = get_recapture_score($this->input->post('at-token-response'));  

        if ($captcha_score < RECAPTCHA_ACCEPTABLE_SPAM_SCORE) {
            $this->result = array(
                'status' => FALSE,
                'message' => '<span class="text-danger"><i class="mdi mdi-alert"></i> Request yang anda jalankan dianggap SPAM oleh sistem.</span>'
            );
        } else {
            
            $this->form_validation->set_rules('type', 'Type Perairan', 'required');
            $this->form_validation->set_rules('armada', 'Armada', 'required');
            $this->form_validation->set_rules('jumlah_a', 'Jumlah Armada', 'required');
            $this->form_validation->set_error_delimiters(error_delimeter(1), error_delimeter(2));

            if ($this->form_validation->run() == TRUE) {

                if ($id == FALSE) {
                    $id = null;
                    $this->m_armada_tangkap_ikan->push_to_data('status', '1');
                }
                    $type = decrypt_url($this->input->post('type'), 'app');
                    $armada = !empty(decrypt_url($this->input->post('armada'), 'app'))?decrypt_url($this->input->post('armada'), 'app'):  null  ;
                    $alat_tangkap = !empty(decrypt_url($this->input->post('alat_tangkap'), 'app'))?decrypt_url($this->input->post('alat_tangkap'), 'app'):  null  ;
                    $alat_bantu = !empty(decrypt_url($this->input->post('alat_bantu'), 'app'))?decrypt_url($this->input->post('alat_bantu'), 'app'):  null  ;
                    $jumlah_a = !empty($this->input->post('jumlah_a'))?$this->input->post('jumlah_a'):  null  ;
                    $jumlah_b = !empty($this->input->post('jumlah_b'))?$this->input->post('jumlah_b'):  null  ;
                    $jumlah_c = !empty($this->input->post('jumlah_c'))?$this->input->post('jumlah_c'):  null  ;
                    
                
                    $this->m_armada_tangkap_ikan->push_to_data('armada', $armada)
                        ->push_to_data('jumlah_a', $jumlah_a)
                        ->push_to_data('alat_tangkap', $alat_tangkap)
                        ->push_to_data('jumlah_b', $jumlah_b)
                        ->push_to_data('alat_bantu', $alat_bantu)
                        ->push_to_data('jumlah_c', $jumlah_c)
                        ->push_to_data('type', $type);

            
                $this->return = $this->m_armada_tangkap_ikan->save($id);

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
            $this->return = $this->m_armada_tangkap_ikan->delete($id);

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

/* End of file rmada_tangkap_ikan.php */
