<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Publikasi extends Backend_Controller {

    public function __construct()
	{
		parent::__construct();

		$this->_init();
		$this->data['uri_mod'] = 'admin/publikasi';
        $this->id_key = $this->private_key;
        $this->breadcrumbs->push('Content', 'admin/publikasi');
        $this->load->model([
            'm_content', 'm_kategori_content'
        ]);
        $this->load->css($this->data['theme_path'] . '/libs/select2/css/select2.min.css');
        $this->load->css($this->data['theme_path'] . '/libs/dropify/css/dropify.min.css');
        $this->load->css($this->data['theme_path'] . '/libs/summernote/summernote-bs4.min.css');
        $this->load->css($this->data['theme_path'] . '/libs/flatpickr/flatpickr.min.css');
        $this->load->js($this->data['theme_path'] . '/libs/flatpickr/flatpickr.min.js');
        $this->load->js($this->data['theme_path'] . '/libs/select2/js/select2.min.js');
        $this->load->js($this->data['theme_path'] . '/libs/select2/js/i18n/id.js');
        $this->load->js($this->data['global_custom_path'] . '/js/select2-init.js');
        $this->load->js($this->data['theme_path'] . '/libs/dropify/js/dropify.min.js');
        $this->load->js($this->data['global_custom_path'] . '/js/file-upload-init.js');
        $this->load->js($this->data['theme_path'] . '/libs/summernote/summernote-bs4.min.js');
        $this->load->js($this->data['theme_path'] . '/libs/summernote/lang/summernote-id-ID.min.js');
        $this->load->js($this->data['global_custom_path'] . '/js/myapp.notes.js');

	}

	public function _init()
    {
        $this->output->set_template('backend');
	}

    public function index()
	{
        $this->data['add_button_link'] = base_url('admin/publikasi/add');
        $this->data['page_title'] = "Data Publikasi";
        $this->data['page_description'] = "Halaman Daftar Data Publikasi.";
        $this->data['card'] = "true";
        $this->data['breadcrumbs'] = $this->breadcrumbs->show();
        $this->data['id_key'] = $this->id_key;
        
		$this->load->view('publikasi/v_index', $this->data);
    }

    public function add()
    {
        $this->breadcrumbs->push('Tambah', 'admin/publikasi/add');
        $this->data['page_title'] = "Tambah Data Publikasi";
        $this->data['page_description'] = "Halaman Tambah Data Publikasi.";
        $this->data['card'] = "true";
        $this->data['breadcrumbs'] = $this->breadcrumbs->show();
        $this->data['id_key'] = $this->id_key;

        $this->load->view('publikasi/v_add', $this->data);
    }

    public function edit($id = null)
    {        
        $id = decrypt_url($id, $this->id_key);
		
		if ($id == FALSE) {
			$this->load->view('errors/html/error_bootbox.php', array('message' => 'ID yang tertera tidak terdaftar', 'redirect_link' => base_url('admin/publikasi')));
        }

        $this->breadcrumbs->push('Edit', 'admin/publikasi/edit');
        $this->data['page_title'] = "Edit Data Publikasi";
        $this->data['page_description'] = "Halaman Edit Data Publikasi.";
        $this->data['card'] = "true";
        $this->data['breadcrumbs'] = $this->breadcrumbs->show();
        $this->data['id_key'] = $this->id_key;
        $this->data['id'] = $id;

        $this->load->view('publikasi/v_edit', $this->data);
    }

    private function upload_publikasi($id, $type = '')
    {
        $this->result = array('status' => TRUE, 'message' => NULL);
        $file_name = 'dkpp_publikasi'.'_'.date('ymdhis');

        if ($this->result['status'] == TRUE) {
            $config['upload_path'] = $this->data['file_path'].'publikasi/';
            $config['allowed_types'] = 'pdf';
            $config['file_name'] = $file_name;
            $config['max_size'] = "1024";

            $this->load->library('upload', $config);
        
            if (!$this->upload->do_upload('berkas')) {
                $this->result = array(
                    'status' => false,
                    'message' => $this->upload->display_errors()
                );
            } else {
                if ($type == 'edit') {
                    $old_data = $this->m_content->find($id);

                    if ($old_data !== FALSE) {
                        if (!empty($old_data->berkas)) {
                            if (file_exists($config['upload_path'] .$old_data->berkas)) {
                                unlink($config['upload_path'] .$old_data->berkas);
                            }
                        }
                    }
                }

                $data_upload = array('upload_data' => $this->upload->data());
                $file_berkas = $data_upload['upload_data']['file_name'];
                $file_size = $data_upload['upload_data']['file_size'];

                $this->result = array(
                    'status' => true,
                    'message' => 'Upload file publikasi berhasil',
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
            $this->m_content->push_select('status');

            $edit_link = 'admin/publikasi/edit/'; 
            $response = $this->m_content->get_all_content()->where(['kategori_konten_id' => '4'])->datatables();

            $response->edit_column('id', '$1', "encrypt_url(id,' ', $this->id_key)");
            $response->edit_column('tanggal', '$1', "indo_date(tanggal)");
            $response->edit_column('hits', '$1x', "hits");   
            $response->edit_column('judul', '$1', "two_row(judul_konten,' fe-star-on text-success mr-1', tanggal,' fe-crosshair text-danger mr-1')");  
            $response->add_column('file', '$1', "dt_btn_file(publikasi/, berkas, Lihat publikasi, Belum publikasi)");
            $response->edit_column('status', '$1', "str_status(status)");
            $response->add_column('aksi', '$1 $2 $3', "tabel_icon(id,' ','edit','$edit_link', $this->id_key),
                                                    tabel_icon(id,' ','delete',' ', $this->id_key),
                                                    active_status(id,' ',status,$this->id_key,' ')");
            
            $response = $this->m_content->datatables(true);
    
            $this->output->set_output($response);
        } else {
            $this->return = $this->m_content->get_all_content()->find($id); 

            if ($this->return !== FALSE) {
                unset($this->return->id);

                $this->return->kategori_konten_id = encrypt_url($this->return->kategori_konten_id, $this->id_key);

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
        $captcha_score = get_recapture_score($this->input->post('p-token-response'));  

        if ($captcha_score < RECAPTCHA_ACCEPTABLE_SPAM_SCORE) {
            $this->result = array(
                'status' => FALSE,
                'message' => '<span class="text-danger"><i class="mdi mdi-alert"></i> Request yang anda jalankan dianggap SPAM oleh sistem.</span>'
            );
        } else {
            $this->result = array('status' => TRUE, 'message' => NULL);
            $id = decrypt_url($id, $this->id_key);
            $check_data = $this->m_content->find($id);

            $this->form_validation->set_rules('judul', 'Judul Content', 'required');
            $this->form_validation->set_rules('isi_content', 'Isi Content', 'required');
            // $this->form_validation->set_rules('tgl', 'Tanggal Content', 'required');

            if (empty($_FILES["berkas"]["name"]) && $id == FALSE) {
                $_POST["berkas"] = null;
                $this->form_validation->set_rules('file', 'Berkas', 'required');
            }

            $this->form_validation->set_error_delimiters(error_delimeter(1), error_delimeter(2));

            if ($this->form_validation->run() == TRUE) {    
                if ($id == FALSE) {
                    $id = null;
                    $behavior = 'add';

                    $this->m_content->push_to_data('status', '1')
                        ->push_to_data('slug', generate_slug('konten', 'judul_konten', $this->input->post('judul')))
                        ->push_to_data('judul_konten', $this->input->post('judul'))
                        // ->push_to_data('tgl_konten', $this->input->post('tgl'))
                        ->push_to_data('kategori_konten_id', '4')
                        ->push_to_data('hits', '0');

                } else {
                    $behavior = 'edit';

                    if ($check_data->judul_konten !== $this->input->post('judul')) {
                        $this->m_content->push_to_data('judul_konten', $this->input->post('judul'))
                            ->push_to_data('slug', generate_slug('konten', 'judul_konten', $this->input->post('judul')));
                    }

                }
                
                if (!empty($_FILES['berkas']['name'])) {
                    $data_upload = $this->upload_publikasi($id, $behavior);

                    if ($data_upload['status'] == TRUE) {
                        $berkas = $data_upload['file_berkas'];
                        
                        if (!empty($berkas)) {
                            $this->m_content->push_to_data('berkas', $berkas);
                        }
                    } else {
                        $this->result = $data_upload;
                    }
                }
                
    
                if ($this->result['status'] !== FALSE) {
                    $isi = str_replace("'"," ", $this->input->post('isi_content'));

                    $this->return = $this->m_content->push_to_data('isi_konten', $isi)->save($id);
    
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
            $old_data = $this->m_content->find($id);
            $_path = $this->data['image_path'].'content/';

            if ($old_data !== FALSE) {
                if (!empty($old_data->image)) {
                    if (file_exists($_path .$old_data->image)) {
                        unlink($_path .$old_data->image);
                    }
                }
            }

            $this->return = $this->m_content->delete($id);

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
            $this->m_content->push_select('status');

            $check = $this->m_content->find($id);

            if ($check !== FALSE) {
                if ($check->status == 0) {
                    $this->m_content->push_to_data('status', '1');
                } else {
                    $this->m_content->push_to_data('status', '0');
                }

                $this->return = $this->m_content->save($id);

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

/* End of file content.php */
