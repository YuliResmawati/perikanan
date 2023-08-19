<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Data_article extends Backend_Controller {

    public function __construct()
	{
		parent::__construct();

		$this->_init();
		$this->data['uri_mod'] = 'admin/data_article';
        $this->id_key = $this->private_key;
        $this->breadcrumbs->push('Artikel', 'admin/data_article');
        $this->load->model('m_article');
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
        $this->data['add_button_link'] = base_url('admin/data_article/add');
        $this->data['page_title'] = "Artikel";
        $this->data['page_description'] = "Halaman Daftar Artikel.";
        $this->data['breadcrumbs'] = $this->breadcrumbs->show();
        $this->data['card'] = "true";
        
		$this->load->view('data_article/v_index', $this->data);
    }

    public function add()
    {
        $this->data['page_title'] = "Tambah Artikel";
        $this->data['page_description'] = "Halaman Tambah Data Artikel.";
        $this->breadcrumbs->push('Tambah', 'admin/data_article/add');
        $this->data['breadcrumbs'] = $this->breadcrumbs->show();
        $this->data['card'] = "true";

        $this->load->view('data_article/v_add', $this->data);
    }

    public function edit($id = null)
    {        
        $id = decrypt_url($id, $this->id_key);
		
		if ($id == FALSE) {
			$this->load->view('errors/html/error_bootbox.php', array('message' => 'ID yang tertera tidak terdaftar', 'redirect_link' => base_url('admin/data_article')));
        }

        $this->breadcrumbs->push('Edit', 'admin/data_article/edit');
        $this->data['page_title'] = "Edit Artikel";
        $this->data['page_description'] = "Halaman Edit Data Artikel.";
        $this->data['breadcrumbs'] = $this->breadcrumbs->show();
        $this->data['card'] = "true";
        $this->data['id_key'] = $this->id_key;
        $this->data['id'] = $id;

        $this->load->view('data_article/v_edit', $this->data);
    }

    private function upload_thumbnail($id, $type = '')
    {
        $this->result = array('status' => TRUE, 'message' => NULL);
        $file_name = 'silatpendidikan_thumbnail_article'.'_'.date('ymdhis');

        if ($this->result['status'] == TRUE) {
            $config['upload_path'] = $this->data['image_path'].'article/';
            $config['allowed_types'] = 'jpg|gif|png|jpeg|JPG|PNG';
            $config['file_name'] = $file_name;
            $config['max_size'] = "1024";

            $this->load->library('upload', $config);
        
            if (!$this->upload->do_upload('image')) {
                $this->result = array(
                    'status' => false,
                    'message' => $this->upload->display_errors()
                );
            } else {
                if ($type == 'edit') {
                    $old_data = $this->m_article->find($id);

                    if ($old_data !== FALSE) {
                        if (!empty($old_data->image)) {
                            if (file_exists($config['upload_path'] .$old_data->image)) {
                                unlink($config['upload_path'] .$old_data->image);
                            }
                        }
                    }
                }

                $data_upload = array('upload_data' => $this->upload->data());
                $file_berkas = $data_upload['upload_data']['file_name'];
                $file_size = $data_upload['upload_data']['file_size'];

                $this->result = array(
                    'status' => true,
                    'message' => 'Upload thumbnail artikel berhasil',
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
            $this->m_article->push_select('status');

            $edit_link = 'admin/data_article/edit/'; 
            $response = $this->m_article->datatables();

            $response->edit_column('id', '$1', "encrypt_url(id,' ', $this->id_key)");
            $response->edit_column('tanggal', '$1', "indo_date(tanggal)");
            $response->edit_column('hits', '$1x', "hits");
            $response->edit_column('link', '$1', "btn_article_view(slug)");
            $response->edit_column('status', '$1', "str_status(status)");
            $response->add_column('aksi', '$1 $2 $3', "tabel_icon(id,' ','edit','$edit_link', $this->id_key),
                                                    tabel_icon(id,' ','delete',' ', $this->id_key),
                                                    active_status(id,' ',status,$this->id_key,' ')");
            
            $response = $this->m_article->datatables(true);
    
            $this->output->set_output($response);
        } else {
            $this->return = $this->m_article->find($id); 

            if ($this->return !== FALSE) {
                unset($this->return->id);

                $this->return->image = str_files_images('article/', $this->return->image);

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
        $captcha_score = get_recapture_score($this->input->post('ar-token-response'));  

        if ($captcha_score < RECAPTCHA_ACCEPTABLE_SPAM_SCORE) {
            $this->result = array(
                'status' => FALSE,
                'message' => '<span class="text-danger"><i class="mdi mdi-alert"></i> Request yang anda jalankan dianggap SPAM oleh sistem.</span>'
            );
        } else {
            $this->result = array('status' => TRUE, 'message' => NULL);
            $id = decrypt_url($id, $this->id_key);
            $check_data = $this->m_article->find($id);

            $this->form_validation->set_rules('title', 'Judul', 'required');
            $this->form_validation->set_rules('isi_content', 'Deskripsi', 'required');
    
            if (empty($_FILES["image"]["name"]) && $id == FALSE) {
                $_POST["image"] = null;
                $this->form_validation->set_rules('image', 'Thumbnail', 'required');
            }

            $this->form_validation->set_error_delimiters(error_delimeter(1), error_delimeter(2));

            if ($this->form_validation->run() == TRUE) {    
                if ($id == FALSE) {
                    $id = null;
                    $behavior = 'add';

                    $this->m_article->push_to_data('status', '1')
                        ->push_to_data('slug', generate_slug('article', 'title', $this->input->post('title')))
                        ->push_to_data('hits', '0');
                } else {
                    $behavior = 'edit';

                    if ($check_data->title !== $this->input->post('title')) {
                        $this->m_article->push_to_data('slug', generate_slug('article', 'title', $this->input->post('title')));
                    }
                }

                if (!empty($_FILES['image']['name'])) {
                    $data_upload = $this->upload_thumbnail($id, $behavior);
    
                    if ($data_upload['status'] == TRUE) {
                        $berkas = $data_upload['file_berkas'];
    
                        if (!empty($berkas)) {
                            $this->m_article->push_to_data('image', $berkas);
                        }
                    } else {
                        $this->result = $data_upload;
                    }
                }
    
                if ($this->result['status'] !== FALSE) {
                    $isi = str_replace("'"," ", $this->input->post('isi_content'));

                    $this->return = $this->m_article->push_to_data('description', $isi)->save($id);
    
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
            $old_data = $this->m_article->find($id);
            $_path = $this->data['image_path'].'article/';

            if ($old_data !== FALSE) {
                if (!empty($old_data->image)) {
                    if (file_exists($_path .$old_data->image)) {
                        unlink($_path .$old_data->image);
                    }
                }
            }

            $this->return = $this->m_article->delete($id);

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
            $this->m_article->push_select('status');

            $check = $this->m_article->find($id);

            if ($check !== FALSE) {
                if ($check->status == 0) {
                    $this->m_article->push_to_data('status', '1');
                } else {
                    $this->m_article->push_to_data('status', '0');
                }

                $this->return = $this->m_article->save($id);

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

/* End of file Data_article.php */
