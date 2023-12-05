<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Struktur extends Backend_Controller {

    public function __construct()
	{
		parent::__construct();

		$this->_init();
		$this->data['uri_mod'] = 'admin/struktur';
        $this->id_key = $this->private_key;
        $this->breadcrumbs->push('Content', 'admin/struktur');
        $this->modal_name = 'modal-struktur';
        $this->load->model([
            'm_struktur'
        ]);
        $this->load->css($this->data['theme_path'] . '/libs/select2/css/select2.min.css');
        $this->load->css($this->data['theme_path'] . '/libs/dropify/css/dropify.min.css');
        $this->load->css($this->data['theme_path'] . '/libs/flatpickr/flatpickr.min.css');
        $this->load->js($this->data['theme_path'] . '/libs/flatpickr/flatpickr.min.js');
        $this->load->js($this->data['theme_path'] . '/libs/select2/js/select2.min.js');
        $this->load->js($this->data['theme_path'] . '/libs/select2/js/i18n/id.js');
        $this->load->js($this->data['global_custom_path'] . '/js/select2-init.js');
        $this->load->js($this->data['theme_path'] . '/libs/dropify/js/dropify.min.js');
        $this->load->js($this->data['global_custom_path'] . '/js/file-upload-init.js');

	}

	public function _init()
    {
        $this->output->set_template('backend');
	}

    public function index()
	{
        $this->data['add_button_link'] = base_url('admin/struktur/add');
        $this->data['page_title'] = "Data Struktur Organisasi";
        $this->data['page_description'] = "Halaman Daftar Data Struktur Organisasi.";
        $this->data['card'] = "true";
        $this->data['breadcrumbs'] = $this->breadcrumbs->show();
        $this->data['id_key'] = $this->id_key;
        $this->data['form_name'] = "form-struktur";
        $this->data['modal_name'] = $this->modal_name;
        
		$this->load->view('struktur/v_index', $this->data);
    }

    private function upload_thumbnail($id, $type = '')
    {
        $this->result = array('status' => TRUE, 'message' => NULL);
        $file_name = 'dpkk_struktur_organisasi'.'_'.date('ymdhis');

        if ($this->result['status'] == TRUE) {
            $config['upload_path'] = $this->data['image_path'].'struktur/';
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
                    $old_data = $this->m_struktur->find($id);

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
                    'message' => 'Upload struktur berhasil',
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
            $this->m_struktur->push_select('status');

            $edit_link = 'admin/struktur/edit/'; 
            $response = $this->m_struktur->datatables();

            $response->edit_column('id', '$1', "encrypt_url(id,' ', $this->id_key)");
            $response->edit_column('status', '$1', "str_status(status)");
            $response->add_column('struktur', '$1', "btn_view_images('struktur/','image')");
            $response->add_column('aksi', '$1 $2', "btn_struktur(id,' ','status',' ', $this->id_key, $this->modal_name),
                                                    active_status(id,' ',status,$this->id_key,' ')");
            
            $response = $this->m_struktur->datatables(true);
    
            $this->output->set_output($response);
        } else {
            $this->return = $this->m_struktur->find($id); 

            if ($this->return !== FALSE) {
                unset($this->return->id);

                $this->return->image = str_files_images('struktur/', $this->return->image);

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

    public function AjaxSave()
    {
        $this->output->unset_template();
        $captcha_score = get_recapture_score($this->input->post('st-token-response'));  

        if ($captcha_score < RECAPTCHA_ACCEPTABLE_SPAM_SCORE) {
            $this->result = array(
                'status' => FALSE,
                'message' => '<span class="text-danger"><i class="mdi mdi-alert"></i> Request yang anda jalankan dianggap SPAM oleh sistem.</span>'
            );
        } else {
            $this->result = array('status' => TRUE, 'message' => NULL);

            $type = decrypt_url($this->input->post('type'), $this->id_key);
            $_id = decrypt_url($this->input->post('struktur_id'), $this->id_key);
            $id = ($_id !== FALSE) ? $_id : null;

            $this->form_validation->set_rules('st-token-response', 'token', 'required'); // jika tidak pakai inputan selain gambar validasi tidak terbaca

            if (empty($_FILES["image"]["name"]) && $id == FALSE) {
                $_POST["image"] = null;
                $this->form_validation->set_rules('image', 'Gambar', 'required');
            }

            $this->form_validation->set_error_delimiters(error_delimeter(1), error_delimeter(2));

            if ($this->form_validation->run() == TRUE) {    
                if ($id == FALSE) {
                    $id = null;
                    $behavior = 'add';

                    $cek_Status_struktur = $this->m_struktur->where(['status' => '1'])->findAll();
                    
                    if (!empty($cek_Status_struktur)) {
                        foreach ($cek_Status_struktur as $key => $value) {
                            $update_status[] = array(
                                'id' => $value->id,
                                'status' => '0'
                            );
                        }

                        $this->db->update_batch('struktur', $update_status, 'id');
    
                    }
                    
                    $this->m_struktur->push_to_data('status', '1');

                } else {
                    $behavior = 'edit';
                }

                if (!empty($_FILES['image']['name'])) {
                    $data_upload = $this->upload_thumbnail($id, $behavior);

                    if ($data_upload['status'] == TRUE) {
                        $berkas = $data_upload['file_berkas'];
    
                        if (!empty($berkas)) {
                            $this->m_struktur->push_to_data('image', $berkas);
                        }
                    } else {
                        $this->result = $data_upload;
                    }
                }
    
                if ($this->result['status'] !== FALSE) {

                    $this->return =  $this->m_struktur->save($id);

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
            $old_data = $this->m_struktur->find($id);
            $_path = $this->data['image_path'].'struktur/';

            if ($old_data !== FALSE) {
                if (!empty($old_data->image)) {
                    if (file_exists($_path .$old_data->image)) {
                        unlink($_path .$old_data->image);
                    }
                }
            }

            $this->return = $this->m_struktur->delete($id);

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
            $this->m_struktur->push_select('status');

            $check = $this->m_struktur->find($id);

            if ($check !== FALSE) {
                if ($check->status == 0) {
                    $this->m_struktur->push_to_data('status', '1');
                } else {
                    $this->m_struktur->push_to_data('status', '0');
                }

                $this->return = $this->m_struktur->save($id);

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
