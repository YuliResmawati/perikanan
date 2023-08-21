<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Permohonan_kgb extends Backend_Controller {

    public function __construct()
	{
		parent::__construct();

		$this->_init();
		$this->data['uri_mod'] = 'operator/permohonan_kgb';
        $this->id_key = $this->private_key;
        $this->breadcrumbs->push('KGB (Kenaikan Gaji Berkala)', 'permohonan_kgb');
        $this->load->model(array('m_riwayat_kgb','m_guru'));  

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
        $this->data['add_button_link'] = false;
        $this->data['page_title'] = "Data Permohonan KGB (Kenaikan Gaji Berkala)";
        $this->data['page_description'] = "Halaman Daftar Data Permohonan KGB pada Bulan ".bulan(date('m'))." ".date('Y');
        $this->data['card'] = "true";
        $this->data['id_key'] = $this->id_key;
        $this->data['breadcrumbs'] = $this->breadcrumbs->show();
        
		$this->load->view('permohonan_kgb/v_index', $this->data);
    }

    public function add($id = null)
    {
        $id = decrypt_url($id, $this->id_key); //guru_id
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

        $this->load->view('permohonan_kgb/v_add', $this->data);
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
            // $date_month = decrypt_url($this->input->post('filter_bulan'), $this->id_key);
            $date_month = date('m');
            $date_year = date('Y');

            $this->m_guru->push_select('status');

            $ajukan = 'operator/permohonan_kgb/add/'; 
            $response = $this->m_guru->get_riwayat_kgb()->datatables();
            $response->where('sekolah_id', $this->logged_sekolah_id);

            $response->where([
                "extract(month from kgb_terakhir) = '$date_month'" => NULL, 
                "extract(year from kgb_terakhir) + 2 = '$date_year'" => NULL, 
                'sekolah_id' => $this->logged_sekolah_id]);

            $response->edit_column('id', '$1', "encrypt_url(id,' ', $this->id_key)");  
            $response->edit_column('nama', '$1', "two_row(nama_guru,'fe-user text-danger mr-1', nip,' fe-clipboard text-success mr-1')");
            $response->edit_column('status', '$1', "status_kgb(status_kgb,alasan)");   
            $response->edit_column('jk', '$1', "jeniskelamin(jenis_kelamin)");   
            $response->edit_column('tanggal', '$1', "indo_date(kgb_terakhir)"); 
            $response->edit_column('berkas', '$1', "str_file_datatables(berkas, kgb/)"); 
            $response->add_column('aksi', '$1', "tabel_icon_kgb(id,' ','ajukan','$ajukan', $this->id_key,' ',' ',status_kgb)");
            
            $response = $this->m_guru->datatables(true);
    
            $this->output->set_output($response);
        } else {
            $this->return = $this->m_guru->get_riwayat_kgb()->find($id); 

            if ($this->return !== FALSE) {
                unset($this->return->id);
                $this->return->nama_guru = ($this->return->nama_guru) ? name_degree($this->return->gelar_depan,$this->return->nama_guru,$this->return->gelar_belakang) : '';
                $this->return->tmt_awal = ($this->return->kgb_terakhir) ? $this->return->kgb_terakhir : '';

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
            $this->form_validation->set_rules('nama_guru', 'Guru', 'required');
            $this->form_validation->set_rules('tmt_awal', 'KGB Terakhir', 'required');

            $guru_id = decrypt_url($this->input->post('guru_id'), $this->id_key);

            if (empty($_FILES["berkas"]["name"]) && $id == FALSE) {
                $_POST["berkas"] = null;
                $this->form_validation->set_rules('berkas', 'File', 'required');
            }

            $this->form_validation->set_error_delimiters(error_delimeter(1), error_delimeter(2));

            if ($this->form_validation->run() == TRUE) {    
                $behavior = 'add';
                $this->m_riwayat_kgb->push_to_data('status', '0');

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
                $this->m_riwayat_kgb->push_to_data('tmt_awal', $this->input->post('tmt_awal') );

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
