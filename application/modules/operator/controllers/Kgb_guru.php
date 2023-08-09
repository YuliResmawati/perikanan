<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Kgb_guru extends Backend_Controller {

    public function __construct()
	{
		parent::__construct();

		$this->_init();
		$this->data['uri_mod'] = 'operator/kgb_guru';
        $this->id_key = $this->private_key;
        $this->breadcrumbs->push('KGB (Kenaikan Gaji Berkala)', 'permohonan_kgb');
        $this->load->model(array('m_riwayat_kgb'));  

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
        $this->data['add_button_link'] = base_url('operator/permohonan_kgb/add');
        $this->data['page_title'] = "Data Permohonan KGB (Kenaikan Gaji Berkala";
        $this->data['page_description'] = "Halaman Daftar Data Permohonan KGB.";
        $this->data['card'] = "true";
        $this->data['id_key'] = $this->id_key;
        $this->data['breadcrumbs'] = $this->breadcrumbs->show();
        
		$this->load->view('kgb_guru/v_index', $this->data);
    }

    public function add($id = null)
    {
        $id = decrypt_url($id, $this->id_key);
        if ($id == FALSE) {
			$this->load->view('errors/html/error_bootbox.php', array('message' => 'ID yang tertera tidak terdaftar', 'redirect_link' => base_url('operator/kgb_guru/add')));
        }
        $this->breadcrumbs->push('Tambah', 'operator/permohonan_kgb/add');
        $this->data['page_title'] = "Tambah Permohonan KGB (Kenaikan Gaji Berkala)";
        $this->data['page_description'] = "Halaman Tambah Data Permohonan KGB.";
        $this->data['card'] = "true";
        $this->data['breadcrumbs'] = $this->breadcrumbs->show();
        $this->data['id_key'] = $this->id_key;
        $this->data['id'] = $id;

        $this->load->view('kgb_guru/v_add', $this->data);
    }

    public function edit($id = null)
    {        
        $id = decrypt_url($id, $this->id_key);
		
		if ($id == FALSE) {
			$this->load->view('errors/html/error_bootbox.php', array('message' => 'ID yang tertera tidak terdaftar', 'redirect_link' => base_url('operator/permohonan_cuti')));
        }

        $this->breadcrumbs->push('Edit', 'operator/permohonan_kgb/edit');
        $this->data['page_title'] = "Edit Data Permohonan KGB (Kenaikan Gaji Berkala)";
        $this->data['page_description'] = "Halaman Edit Data Permohonan KGB.";
        $this->data['card'] = "true";
        $this->data['breadcrumbs'] = $this->breadcrumbs->show();
        $this->data['id_key'] = $this->id_key;
        $this->data['id'] = $id;

        $this->load->view('permohonan_kgb/v_edit', $this->data);
    }

    private function upload_files_sample($id, $type = '')
    {
        $this->result = array('status' => TRUE, 'message' => NULL);
        $file_name = 'silatpendidikan_kgb'.$this->session->userdata('silatpendidikan_user_id').'_'.md5($_FILES['berkas']['name']).'_'.date('ymdhis');

        if ($this->result['status'] == TRUE) {
            $config['upload_path'] = $this->data['file_path'].'kgb/';
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
                    'message' => 'Upload file KGB berhasil',
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
            $date_month = decrypt_url($this->input->post('filter_bulan'), $this->id_key);
            $date_year = date('Y');

            $this->m_riwayat_kgb->push_select('status');

            $ajukan = 'operator/kgb_guru/add/'; 
            $response = $this->m_riwayat_kgb->get_riwayat_kgb()->datatables();
            $response->where('sekolah_id', $this->logged_sekolah_id);

            if ($this->input->post('filter_bulan') == FALSE) {
                $response->where('riwayat_kgb.id', 0);
            } else {
                if ($this->input->post('filter_bulan') !== 'ALL') {
                    $response->where([
                        "extract(month from tmt_awal) = '$date_month'" => NULL, 
                        "extract(year from tmt_awal) + 2 = '$date_year'" => NULL, 
                        'sekolah_id' => $this->logged_sekolah_id, 
                        'riwayat_kgb.status' => '1']);
                }
            }

            $response->edit_column('id', '$1', "encrypt_url(id,' ', $this->id_key)");  
            $response->edit_column('nama', '$1', "two_row(nama_guru,'fe-user text-danger mr-1', nip,' fe-clipboard text-success mr-1')");
            $response->edit_column('status', '$1', "str_status(status)");   
            $response->edit_column('jk', '$1', "jeniskelamin(jenis_kelamin)");   
            $response->edit_column('tanggal', '$1', "indo_date(tmt_awal)"); 
            $response->add_column('aksi', '$1', "tabel_icon(id,' ','ajukan','$ajukan', $this->id_key)");
            // $response->add_column('aksi', '$1 $2', "tabel_icon_cuti(id,' ','edit','$edit_link', $this->id_key,' ',' ',status,$this->logged_level),
            //                                         tabel_icon_cuti(id,' ','batal',' ', $this->id_key,' ',' ',status,$this->logged_level)");
            
            $response = $this->m_riwayat_kgb->datatables(true);
    
            $this->output->set_output($response);
        } else {
            $this->return = $this->m_riwayat_kgb->get_riwayat_kgb()->find($id); 

            if ($this->return !== FALSE) {
                unset($this->return->id);
                $this->return->guru_id = ($this->return->guru_id) ? encrypt_url($this->return->guru_id, $this->id_key) : '';
                $this->return->nama_guru = ($this->return->nama_guru) ? name_degree($this->return->gelar_depan,$this->return->nama_guru,$this->return->gelar_belakang) : '';

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
        $captcha_score = get_recapture_score($this->input->post('kgb-token-response'));  

        if ($captcha_score < RECAPTCHA_ACCEPTABLE_SPAM_SCORE) {
            $this->result = array(
                'status' => FALSE,
                'message' => '<span class="text-danger"><i class="mdi mdi-alert"></i> Request yang anda jalankan dianggap SPAM oleh sistem.</span>'
            );
        } else {
            $this->result = array('status' => TRUE, 'message' => NULL);
            $id = decrypt_url($id, $this->id_key);

            $this->form_validation->set_rules('guru_id', 'Guru', 'required');

            $guru_id = decrypt_url($this->input->post('guru_id'), $this->id_key);

            if (empty($_FILES["berkas"]["name"]) && $id == FALSE) {
                $_POST["berkas"] = null;
                $this->form_validation->set_rules('berkas', 'File', 'required');
            }

            $this->form_validation->set_error_delimiters(error_delimeter(1), error_delimeter(2));

            if ($this->form_validation->run() == TRUE) {    
                if ($id == FALSE) {
                    $id = null;
                    $behavior = 'add';

                    $this->m_riwayat_kgb->push_to_data('status', '0');
                } else {
                    $behavior = 'edit';
                }

                if (!empty($_FILES['berkas']['name'])) {
                    $data_upload = $this->upload_files_sample($id, $behavior);
    
                    if ($data_upload['status'] == TRUE) {
                        $berkas = $data_upload['file_berkas'];
    
                        if (!empty($berkas)) {
                            $this->m_riwayat_kgb->push_to_data('berkas', $berkas);
                        }
                    } else {
                        $this->result = $data_upload;
                    }
                }

                $this->m_riwayat_kgb->push_to_data('guru_id', $guru_id );

                if ($this->result['status'] !== FALSE) {
                    $this->return = $this->m_riwayat_kgb->save($id);
    
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
            $this->m_cuti->push_select('status');

            $check = $this->m_cuti->find($id);

            if ($check !== FALSE) {
                if ($check->status == 0) {
                    $this->m_cuti->push_to_data('status', '3');
                } else {
                    $this->result = array(
                        'status'   => FALSE,
                        'message' => '<span class="text-danger"><i class="mdi mdi-alert"></i> Gagal Membatalkan Pengajuan.</span>'
                    );
                }

                $this->return = $this->m_cuti->save($id);

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
