<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Sekolah extends Backend_Controller {

    public function __construct()
	{
		parent::__construct();

		$this->_init();
		$this->data['uri_mod'] = 'admin/sekolah';
        $this->id_key = $this->private_key;
        $this->breadcrumbs->push('Sekolah', 'sekolah');
        $this->load->model(array('m_sekolah', 'm_app'));  

        $this->load->css($this->data['theme_path'] . '/libs/select2/css/select2.min.css');
        $this->load->css($this->data['theme_path'] . '/libs/dropify/css/dropify.min.css');
        $this->load->js($this->data['theme_path'] . '/libs/select2/js/select2.min.js');
        $this->load->js($this->data['theme_path'] . '/libs/select2/js/i18n/id.js');
        $this->load->js($this->data['global_custom_path'] . '/js/select2-init.js');
        $this->load->js($this->data['theme_path'] . '/libs/dropify/js/dropify.min.js');
        $this->load->js($this->data['global_custom_path'] . '/js/file-upload-init.js');
        $this->load->js($this->data['global_plugin_path'] . '/jquerymask/jquery-mask.min.js');

	}

	public function _init()
    {
        $this->output->set_template('backend');
	}

    public function index()
	{
        $this->data['add_button_link'] = base_url('admin/sekolah/add');
        $this->data['page_title'] = "Data Sekolah";
        $this->data['page_description'] = "Halaman Daftar Data Sekolah.";
        $this->data['card'] = "true";
        $this->data['tipe_sekolah'] = $this->m_sekolah->get_distinct_tipe()->findAll();
        $this->data['breadcrumbs'] = $this->breadcrumbs->show();
        
		$this->load->view('sekolah/v_index', $this->data);
    }

    public function add()
    {
        $this->breadcrumbs->push('Tambah', 'admin/sekolah/add');
        $this->data['page_title'] = "Tambah Data Sekolah";
        $this->data['page_description'] = "Halaman Tambah Data Sekolah.";
        $this->data['card'] = "true";
        $this->data['breadcrumbs'] = $this->breadcrumbs->show();
        $this->data['id_key'] = $this->id_key;

        $this->load->view('sekolah/v_add', $this->data);
    }

    public function edit($id = null)
    {        
        $id = decrypt_url($id, $this->id_key);
		
		if ($id == FALSE) {
			$this->load->view('errors/html/error_bootbox.php', array('message' => 'ID yang tertera tidak terdaftar', 'redirect_link' => base_url('supadmin/sample_upload')));
        }

        $this->breadcrumbs->push('Edit', 'admin/sekolah/edit');
        $this->data['page_title'] = "Edit Data Sekolah";
        $this->data['page_description'] = "Halaman Edit Data Sekolah.";
        $this->data['card'] = "true";
        $this->data['breadcrumbs'] = $this->breadcrumbs->show();
        $this->data['id_key'] = $this->id_key;
        $this->data['id'] = $id;

        $this->load->view('sekolah/v_edit', $this->data);
    }

    

    public function AjaxGet($id = NULL)
    {
        $this->output->unset_template();

        $id = decrypt_url($id, $this->id_key);

        if ($id == FALSE) {
            $this->m_sekolah->push_select('status');

            $edit_link = 'admin/sekolah/edit/'; 
            $response = $this->m_sekolah->datatables();

            if ($this->input->post('filter_tipe_sekolah') == FALSE) {
                $response->where('id', 0);
            } else {
                if ($this->input->post('filter_tipe_sekolah') !== 'ALL') {
                    $response->where('tipe_sekolah', $this->input->post('filter_tipe_sekolah'));
                }
            }

            $response->edit_column('id', '$1', "encrypt_url(id,' ', $this->id_key)");
            $response->edit_column('link', '$1', "btn_link(link_g_site)");
            $response->edit_column('tipe_sekolah', '$1', "tipe_sekolah(tipe_sekolah)");
            $response->edit_column('two_row', '$1', "two_row(alamat,'fe-map-pin text-danger mr-1', no_telp,'fe-phone-call text-success mr-1')");
            $response->edit_column('status', '$1', "str_status(status)");
            $response->add_column('aksi', '$1 $2 $3', "tabel_icon(id,' ','edit','$edit_link', $this->id_key),
                                                    tabel_icon(id,' ','delete',' ', $this->id_key),
                                                    active_status(id,' ',status,$this->id_key,' ')");
            
            $response = $this->m_sekolah->datatables(true);
    
            $this->output->set_output($response);
        } else {
            $this->return = $this->m_sekolah->find($id); 

            if ($this->return !== FALSE) {
                unset($this->return->id);

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
        $captcha_score = get_recapture_score($this->input->post('sklh-token-response'));  

        if ($captcha_score < RECAPTCHA_ACCEPTABLE_SPAM_SCORE) {
            $this->result = array(
                'status' => FALSE,
                'message' => '<span class="text-danger"><i class="mdi mdi-alert"></i> Request yang anda jalankan dianggap SPAM oleh sistem.</span>'
            );
        } else {
            $this->result = array('status' => TRUE, 'message' => NULL);
            $id = decrypt_url($id, $this->id_key);

            $this->form_validation->set_rules('tipe_sekolah', 'Tingkatan Sekolah', 'required');
            $this->form_validation->set_rules('npsn', 'NPSN', 'required');
            $this->form_validation->set_rules('nama_sekolah', 'Nama Sekolah', 'required');
            $this->form_validation->set_rules('link_g_site', 'Link Google Site', 'required');
    
            $this->form_validation->set_error_delimiters(error_delimeter(1), error_delimeter(2));

            if ($this->form_validation->run() == TRUE) {
                if ($id == FALSE) {
                    $id = null;
                    $this->m_sekolah->push_to_data('status', '1');
                }
    
                $this->return = $this->m_sekolah->save($id);
    
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
    
            if ($this->result) {
                $this->output->set_output(json_encode($this->result));
            } else {
                $this->output->set_output(json_encode(['status'=> FALSE, 'message'=> 'Gagal mengambil data.']));
            }
        }

        
    }

    public function AjaxDel($id = null)
    {
        $this->output->unset_template();

        $id = decrypt_url($id, $this->id_key);

        if ($id !== FALSE) {
            $this->return = $this->m_sekolah->delete($id);

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

    public function AjaxActive($id = null)
    {
        $this->output->unset_template();

        $id = decrypt_url($id, $this->id_key);

        if ($id !== FALSE) {
            $this->m_sekolah->push_select('status');

            $check = $this->m_sekolah->find($id);

            if ($check !== FALSE) {
                if ($check->status == 0) {
                    $this->m_sekolah->push_to_data('status', '1');
                } else {
                    $this->m_sekolah->push_to_data('status', '0');
                }

                $this->return = $this->m_sekolah->save($id);

                if ($this->return) {
                    $this->result = array(
                        'status'   => TRUE,
                        'message' => '<span class="text-success"><i class="mdi mdi-check-decagram"></i> Status berhasil dirubah.</span>'
                    );
                } else {
                    $this->result = array(
                        'status'   => FALSE,
                        'message' => '<span class="text-danger"><i class="mdi mdi-alert"></i> Status gagal dirubah.</span>'
                    );
                }
            } else {
                $this->result = array(
                    'status'   => FALSE,
                    'message' => '<span class="text-danger"><i class="mdi mdi-alert"></i> ID tidak valid.</span>'
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

/* End of file Sample_upload.php */
