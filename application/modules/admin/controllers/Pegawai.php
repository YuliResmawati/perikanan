<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pegawai extends Backend_Controller {

    public function __construct()
	{
		parent::__construct();

		$this->_init();
		$this->data['uri_mod'] = 'admin/pegawai';
        $this->id_key = $this->private_key;
        $this->breadcrumbs->push('Pegawai', 'admin/pegawai');
        $this->modal_name = 'modal-pegawai';
        $this->load->model([
            'm_users','m_pegawai'
        ]);
        $this->load->css($this->data['theme_path'] . '/libs/select2/css/select2.min.css');
        $this->load->css($this->data['theme_path'] . '/libs/dropify/css/dropify.min.css');
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
        // $this->data['add_button_link'] = base_url('admin/users/add');
        $this->data['page_title'] = "Data Kepegawaian";
        $this->data['page_description'] = "Halaman Daftar Data Kepegawaian.";
        $this->data['card'] = "true";
        $this->data['breadcrumbs'] = $this->breadcrumbs->show();
        $this->data['form_name'] = "form-struktur";
        $this->data['modal_name'] = $this->modal_name;
        
		$this->load->view('pegawai/v_index', $this->data);
    }

    private function upload_foto_pegawai($id, $type = '', $nip)
    {
        $this->result = array('status' => TRUE, 'message' => NULL);
        $file_name = 'FOTO_'.$nip;

        if ($this->result['status'] == TRUE) {
            $config['upload_path'] = $this->data['image_path'].'profil_pegawai/';
            $config['allowed_types'] = "jpg|png|jpeg|JPG|PNG";
            $config['file_name'] = $file_name;
            $config['overwrite'] = true;
            $config['max_size'] = "1024";

            $this->load->library('upload', $config);
        
            if (!$this->upload->do_upload('image')) {
                $this->result = array(
                    'status' => false,
                    'message' => $this->upload->display_errors()
                );
            } else {
                if ($type == 'edit') {
                    $old_data = $this->m_pegawai->find($id);

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
                    'message' => 'Upload foto berhasil',
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
            $this->m_pegawai->push_select('status');

            $response = $this->m_pegawai->get_pegawai()->datatables();
            $response->order_by('eselon_id', 'ASC');
            $response->edit_column('id', '$1', "encrypt_url(id,' ', $this->id_key)");    
            $response->edit_column('unor_id', '$1', "encrypt_url(unor_id,' ', $this->id_key)");    
            $response->edit_column('status_pegawai_id', '$1', "encrypt_url(status_pegawai_id,' ', $this->id_key)");    
            $response->edit_column('nama','$1',"icon_employee(nama_pegawai, gelar_depan, gelar_blkng, nip, status_pegawai, type, image, 1)");  
            $response->edit_column('kedudukan_hukum', '$1', "str_kedudukan_hukum(kedudukan_hukum)");
            $response->edit_column('jenis', '$1', "jk(jenis_kelamin)");
            $response->edit_column('nama_unor', '$1', "two_row(nama_jabatan,'fe-alert-circle text-success mr-1', nama_unor,'fe-home text-danger mr-1')");
            $response->add_column('lihat', '$1', "btn_view_images('profil_pegawai/','image')");
            $response->add_column('aksi', '$1', "aksi_upload_foto(id, ' ', ' ', $this->id_key, modal-pegawai, ' ',  image, nip, pegawai_id)");
            $response->edit_column('detail_jabatan_id', '$1', "encrypt_url(detail_jabatan_id,' ', $this->id_key)");   
            $response->edit_column('jabatan_id', '$1', "encrypt_url(jabatan_id,' ', $this->id_key)");   
            $response->edit_column('jorong_id', '$1', "encrypt_url(jorong_id,' ', $this->id_key)");   
            $response->edit_column('pegawai_id', '$1', "encrypt_url(pegawai_id,' ', $this->id_key)");   
            $response->edit_column('status_perkawinan_pegawai', '$1', "encrypt_url(status_perkawinan_pegawai,' ', $this->id_key)"); 
            
            $response = $this->m_pegawai->datatables(true);
    
            $this->output->set_output($response);
        } else {
            $this->return = $this->m_pegawai->find($id); 

            if ($this->return !== FALSE) {
                unset($this->return->id);

                $this->return->image = str_files_images('profil_pegawai/', $this->return->image);

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
        $captcha_score = get_recapture_score($this->input->post('pr-token-response'));  

        if ($captcha_score < RECAPTCHA_ACCEPTABLE_SPAM_SCORE) {
            $this->result = array(
                'status' => FALSE,
                'message' => '<span class="text-danger"><i class="mdi mdi-alert"></i> Request yang anda jalankan dianggap SPAM oleh sistem SIMPEG Agam.</span>'
            );
        } else {
            if ($this->logged_level == '1') {
                $this->result = array('status' => TRUE, 'message' => NULL);

                $this->form_validation->set_rules('nip', 'NIP', 'required');
                $this->form_validation->set_error_delimiters(error_delimeter(1), error_delimeter(2));

                if ($this->form_validation->run() == TRUE) {   
                    
                    $id = decrypt_url($this->input->post('data_id'), $this->id_key);
                    $nip = $this->input->post('nip');

                    if ($id == FALSE) {
                        $id = null;
                        $behavior = 'add';
    
                        $this->m_pegawai->push_to_data('simpeg_pegawai_id', decrypt_url($this->input->post('pegawai_id'), $this->id_key))
                            ->push_to_data('status', '1');
    
                    } else {
                        $behavior = 'edit';
                    }

                    if (!empty($_FILES['image']['name'])) {
                        $data_upload = $this->upload_foto_pegawai($id, $behavior, $nip);
        
                        if ($data_upload['status'] == TRUE) {
                            $photo = $data_upload['file_berkas'];
        
                            if (!empty($photo)) {
                                $this->m_pegawai->push_to_data('image', $photo);
                            }
                        } else {
                            $this->result = $data_upload;
                        }
                    }

                    if ($this->result['status'] !== FALSE) {

                        $this->return =  $this->m_pegawai->save($id);
    
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
            } else {
                $this->result = array(
                    'status' => FALSE,
                    'message' => '<span class="text-danger"><i class="mdi mdi-alert"></i> Tidak memiliki akses untuk menyimpan data.</span>'
                );
            }  
        }

        if ($this->result) {
            $this->output->set_output(json_encode($this->result));
        } else {
            $this->output->set_output(json_encode(['status'=> FALSE, 'message'=> 'Gagal mengambil data.']));
        }
    }
}

/* End of file pegawai.php */
