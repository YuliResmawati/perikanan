<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Data_pengumuman extends Backend_Controller {

    public function __construct()
	{
		parent::__construct();

		$this->_init();
		$this->data['uri_mod'] = 'admin/data_pengumuman';
        $this->id_key = $this->private_key;
        $this->breadcrumbs->push('Pengumuman', 'admin/data_pengumuman');
        $this->load->model('m_pengumuman');
        $this->load->helper(array('string', 'text'));

        $this->load->css($this->data['theme_path'] . '/libs/dropify/css/dropify.min.css');
        $this->load->css($this->data['theme_path'] . '/libs/summernote/summernote-bs4.min.css');
        $this->load->js($this->data['theme_path'] . '/libs/summernote/summernote-bs4.min.js');
        $this->load->js($this->data['theme_path'] . '/libs/summernote/lang/summernote-id-ID.min.js');
        $this->load->js($this->data['theme_path'] . '/libs/dropify/js/dropify.min.js');
        $this->load->js($this->data['global_custom_path'] . '/js/file-upload-init.js');
        $this->load->js($this->data['global_custom_path'] . '/js/myapp.notes.js');
	}

	public function _init()
    {
        $this->output->set_template('backend');
	}

    public function index()
	{
        $this->data['add_button_link'] = base_url('admin/data_pengumuman/add');
        $this->data['page_title'] = "Pengumuman";
        $this->data['page_description'] = "Halaman Daftar Pengumuman.";
        $this->data['breadcrumbs'] = $this->breadcrumbs->show();
        $this->data['card'] = "true";
        
		$this->load->view('data_pengumuman/v_index', $this->data);
    }

    public function add()
    {
        $this->data['page_title'] = "Tambah Pengumuman";
        $this->data['page_description'] = "Halaman Tambah Data Pengumuman.";
        $this->breadcrumbs->push('Tambah', 'admin/data_pengumuman/add');
        $this->data['breadcrumbs'] = $this->breadcrumbs->show();
        $this->data['card'] = "true";

        $this->load->view('data_pengumuman/v_add', $this->data);
    }

    public function edit($id = null)
    {        
        $id = decrypt_url($id, $this->id_key);
		
		if ($id == FALSE) {
			$this->load->view('errors/html/error_bootbox.php', array('message' => 'ID yang tertera tidak terdaftar', 'redirect_link' => base_url('admin/data_pengumuman')));
        }

        $this->breadcrumbs->push('Edit', 'admin/data_pengumuman/edit');
        $this->data['page_title'] = "Edit Pengumuman";
        $this->data['page_description'] = "Halaman Edit Data Pengumuman.";
        $this->data['breadcrumbs'] = $this->breadcrumbs->show();
        $this->data['card'] = "true";
        $this->data['id_key'] = $this->id_key;
        $this->data['id'] = $id;

        $this->load->view('data_pengumuman/v_edit', $this->data);
    }

    private function upload_pengumuman($id, $type = '')
    {
        $this->result = array('status' => TRUE, 'message' => NULL);
        $file_name = 'silatpendidikan_pengumuman'.'_'.date('ymdhis');

        if ($this->result['status'] == TRUE) {
            $config['upload_path'] = $this->data['file_path'].'pengumuman/';
            $config['allowed_types'] = 'pdf';
            $config['file_name'] = $file_name;
            $config['max_size'] = "1024";

            $this->load->library('upload', $config);
        
            if (!$this->upload->do_upload('file')) {
                $this->result = array(
                    'status' => false,
                    'message' => $this->upload->display_errors()
                );
            } else {
                if ($type == 'edit') {
                    $old_data = $this->m_pengumuman->find($id);

                    if ($old_data !== FALSE) {
                        if (!empty($old_data->file)) {
                            if (file_exists($config['upload_path'] .$old_data->file)) {
                                unlink($config['upload_path'] .$old_data->file);
                            }
                        }
                    }
                }

                $data_upload = array('upload_data' => $this->upload->data());
                $file_berkas = $data_upload['upload_data']['file_name'];
                $file_size = $data_upload['upload_data']['file_size'];

                $this->result = array(
                    'status' => true,
                    'message' => 'Upload file pengumuman berhasil',
                    'file_berkas' => $file_berkas,
                    'file_size' => $file_size
                );
            }
        }

        return $this->result;
    }

    public function AjaxGet($id = NULL)
    {
        $this->output->unset_template();

        $id = decrypt_url($id, $this->id_key);

        if ($id == FALSE) {
            $this->m_pengumuman->push_select('status');

            $edit_link = 'admin/data_pengumuman/edit/'; 
            $response = $this->m_pengumuman->datatables();

            $response->edit_column('id', '$1', "encrypt_url(id,' ', $this->id_key)");
            $response->edit_column('tanggal', '$1', "indo_date(tanggal)");
            $response->edit_column('file', '$1', "str_file_dt(file, pengumuman/)");
            $response->edit_column('status', '$1', "str_status(status)");
            $response->add_column('aksi', '$1 $2 $3', "tabel_icon(id,' ','edit','$edit_link', $this->id_key),
                                                    tabel_icon(id,' ','delete',' ', $this->id_key),
                                                    active_status(id,' ',status,$this->id_key,' ')");
            
            $response = $this->m_pengumuman->datatables(true);
    
            $this->output->set_output($response);
        } else {
            $this->return = $this->m_pengumuman->find($id); 

            if ($this->return !== FALSE) {
                unset($this->return->id);

                $this->return->file = str_btn_public_files('pengumuman/', $this->return->file);

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
        $captcha_score = get_recapture_score($this->input->post('pn-token-response'));  

        if ($captcha_score < RECAPTCHA_ACCEPTABLE_SPAM_SCORE) {
            $this->result = array(
                'status' => FALSE,
                'message' => '<span class="text-danger"><i class="mdi mdi-alert"></i> Request yang anda jalankan dianggap SPAM oleh sistem.</span>'
            );
        } else {
            $this->result = array('status' => TRUE, 'message' => NULL);
            $id = decrypt_url($id, $this->id_key);
            $check_data = $this->m_pengumuman->find($id);

            $this->form_validation->set_rules('title', 'Judul', 'required');
            $this->form_validation->set_rules('description', 'Deskripsi Singkat', 'required');
    
            if (empty($_FILES["file"]["name"]) && $id == FALSE) {
                $_POST["file"] = null;
                $this->form_validation->set_rules('file', 'Berkas', 'required');
            }

            $this->form_validation->set_error_delimiters(error_delimeter(1), error_delimeter(2));

            if ($this->form_validation->run() == TRUE) {    
                if ($id == FALSE) {
                    $id = null;
                    $behavior = 'add';

                    $this->m_pengumuman->push_to_data('status', '1')
                        ->push_to_data('slug', generate_slug('pengumuman', 'title', $this->input->post('title')))
                        ->push_to_data('hits', '0');
                } else {
                    $behavior = 'edit';

                    if ($check_data->title !== $this->input->post('title')) {
                        $this->m_pengumuman->push_to_data('slug', generate_slug('pengumuman', 'title', $this->input->post('title')));
                    }
                }

                if (!empty($_FILES['file']['name'])) {
                    $data_upload = $this->upload_pengumuman($id, $behavior);
    
                    if ($data_upload['status'] == TRUE) {
                        $berkas = $data_upload['file_berkas'];
    
                        if (!empty($berkas)) {
                            $this->m_pengumuman->push_to_data('file', $berkas);
                        }
                    } else {
                        $this->result = $data_upload;
                    }
                }
    
                if ($this->result['status'] !== FALSE) {

                    $this->return = $this->m_pengumuman->save($id);
    
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
            $old_data = $this->m_pengumuman->find($id);
            $_path = $this->data['file_path'].'pengumuman/';

            if ($old_data !== FALSE) {
                if (!empty($old_data->file)) {
                    if (file_exists($_path .$old_data->file)) {
                        unlink($_path .$old_data->file);
                    }
                }
            }

            $this->return = $this->m_pengumuman->delete($id);

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
            $this->m_pengumuman->push_select('status');

            $check = $this->m_pengumuman->find($id);

            if ($check !== FALSE) {
                if ($check->status == 0) {
                    $this->m_pengumuman->push_to_data('status', '1');
                } else {
                    $this->m_pengumuman->push_to_data('status', '0');
                }

                $this->return = $this->m_pengumuman->save($id);

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

/* End of file Data_pengumuman.php */
