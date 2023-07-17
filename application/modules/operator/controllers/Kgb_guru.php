<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Kgb_guru extends Backend_Controller {

    public function __construct()
	{
		parent::__construct();

		$this->_init();
		$this->data['uri_mod'] = 'operator/kgb_guru';
        $this->id_key = $this->private_key;
        $this->breadcrumbs->push('Kenaikan Gaji Berkala Guru', 'operator/kgb_guru');
        $this->modal_name = 'modal-ajukan-kgb';
        $this->load->model(['m_guru','m_sekolah', 'm_riwayat_kgb']);

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
        // $this->data['add_button_link'] = base_url('operator/kgb_guru/add');
        $this->data['page_title'] = "Data Kenaiakan Gaji Berkala Guru";
        $this->data['page_description'] = "Halaman Daftar Data KGB Guru.";
        $this->data['card'] = "true";
        $this->data['breadcrumbs'] = $this->breadcrumbs->show();
        $this->data['id_key'] = $this->id_key;
        $this->data['form_name'] = "form-ajukan-kgb";
        $this->data['modal_name'] = $this->modal_name;
        
		$this->load->view('kgb_guru/v_index', $this->data);
    }

    public function edit($id = null)
    {        
        $id = decrypt_url($id, $this->id_key);
		
		if ($id == FALSE) {
			$this->load->view('errors/html/error_bootbox.php', array('message' => 'ID yang tertera tidak terdaftar', 'redirect_link' => base_url('operator/mutasi_guru/edit')));
        }

        $this->breadcrumbs->push('Edit', 'operator/mutasi_guru/edit');
        $this->data['page_title'] = "Edit Data Mutasi Guru";
        $this->data['page_description'] = "Halaman Edit Data Mutasi Guru.";
        $this->data['card'] = "true";
        $this->data['breadcrumbs'] = $this->breadcrumbs->show();
        $this->data['id_key'] = $this->id_key;
        $this->data['id'] = $id;

        $this->load->view('mutasi_guru/v_edit', $this->data);
    }

    

    public function AjaxGet($id = NULL)
    {
        $this->output->unset_template();

        $id = decrypt_url($id, $this->id_key);
        $date_month = decrypt_url($this->input->post('filter_bulan'), $this->id_key);
        $date_year = date('Y');

        if ($id == FALSE) {
            $this->m_riwayat_kgb->push_select('riwayat_kgb.status');

            $edit_link = 'operator/mutasi_guru/edit/'; 
            $response = $this->m_riwayat_kgb->get_riwayat_kgb()->datatables();
            
            if ($this->input->post('filter_bulan') == FALSE) {
                $response->where('sekolah_id', 0);
            } else {
                if ($this->input->post('filter_bulan') !== 'ALL') {
                    $response->where(["extract(month from tmt_awal) = '$date_month'" => NULL, "extract(year from tmt_awal) + 2 = '$date_year'" => NULL, 
                    'sekolah_id' => $this->logged_sekolah_id, 'riwayat_kgb.status' => '1']);
                }
            }
            $response->edit_column('id', '$1', "encrypt_url(id,' ', $this->id_key)");  
            $response->edit_column('nama', '$1', "two_row(nama_guru,'fe-user text-danger mr-1', nip,' fe-clipboard text-success mr-1')");
            $response->edit_column('status', '$1', "str_status(status)");   
            $response->edit_column('jk', '$1', "jeniskelamin(jenis_kelamin)");   
            $response->edit_column('tanggal', '$1', "indo_date(tmt_awal)"); 
            $response->add_column('aksi', '$1', "aksi_rekening_media(id, ' ', ' ', $this->id_key, $this->modal_name, ' ',  guru_id, status)");  
            
            $response = $this->m_riwayat_kgb->datatables(true);
    
            $this->output->set_output($response);
        } else {
            $this->return = $this->m_riwayat_kgb->get_riwayat_kgb()->find($id); 

            if ($this->return !== FALSE) {
                $this->return->id = encrypt_url($this->return->id, $this->id_key);
                $this->return->id_guru = encrypt_url($this->return->id_guru, $this->id_key);
                // unset($this->return->id);

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

    private function upload_files_sample($id, $type = '')
    {
        $this->result = array('status' => TRUE, 'message' => NULL);
        $file_name = 'silatpendidikan_riwayatkgb'.$this->session->userdata('silatpendidikan_user_id').'_'.md5($_FILES['berkas']['name']).'_'.date('ymdhis');

        if ($this->result['status'] == TRUE) {
            $config['upload_path'] = $this->data['file_path'].'riwayat_kgb/';
            $config['allowed_types'] = "pdf";
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
                    $old_data = $this->m_riwayat_kgb->find($id);

                    if ($old_data !== FALSE) {
                        if (!empty($old_data->files)) {
                            if (file_exists($config['upload_path'] .$old_data->files)) {
                                unlink($config['upload_path'] .$old_data->files);
                            }
                        }
                    }
                }

                $data_upload = array('upload_data' => $this->upload->data());
                $file_berkas = $data_upload['upload_data']['file_name'];
                $file_size = $data_upload['upload_data']['file_size'];

                $this->result = array(
                    'status' => true,
                    'message' => 'Upload file sample upload berhasil',
                    'file_berkas' => $file_berkas,
                    'file_size' => $file_size
                );
            }
        }

        return $this->result;
    }

    public function AjaxSave($id = NULL)
    {
        $this->output->unset_template();

        $captcha_score = get_recapture_score($this->input->post('kgb-token-response')); 

        if ($captcha_score < RECAPTCHA_ACCEPTABLE_SPAM_SCORE) {
            $this->result = array(
                'status' => FALSE,
                'message' => '<span class="text-danger"><i class="mdi mdi-alert"></i> Request yang anda jalankan dianggap SPAM oleh sistem.</span>'
            );
        } else {
            $this->result = array('status' => TRUE, 'message' => NULL);
            $id = decrypt_url($id, $this->id_key);

                // if (empty($_FILES["berkas"]["name"]) && $id == FALSE) {
                //     $_POST["berkas"] = null;
                    $this->form_validation->set_rules('berkas', 'File', 'required');
                // }

                $this->form_validation->set_error_delimiters(error_delimeter(1), error_delimeter(2));

                if ($this->form_validation->run() == TRUE) {
                    if ($id == FALSE) {
                        $id = null;
                        $behavior = 'add';
    
                        $this->m_riwayat_kgb->push_to_data('status', '0');
                        $this->m_riwayat_kgb->push_to_data('guru_id', decrypt_url($this->input->post('guru_id'), $this->id_key));
                    } else {
                        $behavior = 'edit';
                    }
    
                    if (!empty($_FILES['berkas']['name'])) {
                        $data_upload = $this->upload_files_sample($id, 'add');
        
                        if ($data_upload['status'] == TRUE) {
                            $berkas = $data_upload['file_berkas'];
        
                            if (!empty($berkas)) {
                                $this->m_riwayat_kgb->push_to_data('berkas', $berkas);
                            }
                        } else {
                            $this->result = $data_upload;
                        }
                    }
                    $this->return = $this->m_riwayat_kgb->save();

                    if ($this->return) {
                        $this->result = array(
                            'status' => TRUE,
                            'message' => '<span class="text-success"><i class="mdi mdi-check"></i> Data berhasil disimpan.</span>'
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
            $this->return = $this->m_mutasi_guru->delete($id);

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

/* End of file Sample_upload.php */
