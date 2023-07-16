<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Detail_rombel extends Backend_Controller {

    public function __construct()
	{
		parent::__construct();

		$this->_init();
		$this->data['uri_mod'] = 'admin/detail_rombel';
        $this->id_key = $this->private_key;
        $this->breadcrumbs->push('Wali Kelas', 'detail_rombel');
        $this->load->model(array('m_detail_rombel','m_rombel','m_sekolah','m_guru'));  

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
        $this->data['add_button_link'] = base_url('admin/detail_rombel/add');
        $this->data['page_title'] = "Data Wali Kelas";
        $this->data['page_description'] = "Halaman Daftar Data Wali Kelas.";
        $this->data['card'] = "true";
        $this->data['id_key'] = $this->id_key;
        $this->data['sekolah'] = $this->m_sekolah->get_all_sekolah()->findAll();

        $this->data['breadcrumbs'] = $this->breadcrumbs->show();
        
		$this->load->view('detail_rombel/v_index', $this->data);
    }

    public function add()
    {
        $this->breadcrumbs->push('Tambah', 'admin/detail_rombel/add');
        $this->data['page_title'] = "Tambah Data Wali Kelas";
        $this->data['page_description'] = "Halaman Tambah Data Wali Kelas.";
        $this->data['card'] = "true";
        $this->data['breadcrumbs'] = $this->breadcrumbs->show();
        $this->data['id_key'] = $this->id_key;
        $this->data['rombel'] = $this->m_rombel->findAll();
        $this->data['sekolah'] = $this->m_sekolah->get_all_sekolah()->findAll();
        if($this->logged_level == "3"){
            $this->data['guru'] = $this->m_guru->get_guru_by_sekolah($this->logged_sekolah_id)->findAll();
        }
        $this->load->view('detail_rombel/v_add', $this->data);
    }

    public function edit($id = null)
    {        
        $id = decrypt_url($id, $this->id_key);
		
		if ($id == FALSE) {
			$this->load->view('errors/html/error_bootbox.php', array('message' => 'ID yang tertera tidak terdaftar', 'redirect_link' => base_url('supadmin/sample_upload')));
        }

        $this->breadcrumbs->push('Edit', 'admin/detail_rombel/edit');
        $this->data['page_title'] = "Edit Data Wali Kelas";
        $this->data['page_description'] = "Halaman Edit Data Wali Kelas.";
        $this->data['card'] = "true";
        $this->data['breadcrumbs'] = $this->breadcrumbs->show();
        $this->data['id_key'] = $this->id_key;
        $this->data['id'] = $id;
        $this->data['rombel'] = $this->m_rombel->findAll();
        $this->data['sekolah'] = $this->m_sekolah->get_all_sekolah()->findAll();
        if($this->logged_level == "3"){
            $this->data['guru'] = $this->m_guru->get_guru_by_sekolah($this->logged_sekolah_id)->findAll();
        }else{
            $this->data['guru'] = $this->m_guru->findAll();
        }


        $this->load->view('detail_rombel/v_edit', $this->data);
    }

    

    public function AjaxGet($id = NULL)
    {
        $this->output->unset_template();

        $id = decrypt_url($id, $this->id_key);

        if ($id == FALSE) {
            $this->m_detail_rombel->push_select('status');

            $edit_link = 'admin/detail_rombel/edit/'; 
            $response = $this->m_detail_rombel->get_all_rombel()->datatables();

            if($this->logged_level !== "3"){
                if ($this->input->post('filter_sekolah') == FALSE) {
                    $response->where('id', 0);
                } else {
                    if ($this->input->post('filter_sekolah') !== 'ALL') {
                        $response->where('detail_rombel.sekolah_id', decrypt_url($this->input->post('filter_sekolah'), $this->id_key));
                    }
                }
            }else{
                $response->where('detail_rombel.sekolah_id', $this->logged_sekolah_id);
            }

            $response->edit_column('id', '$1', "encrypt_url(id,' ', $this->id_key)");
            $response->edit_column('status', '$1', "str_status(detail_rombel_status)");
            $response->edit_column('nama_rombel', '$1 $2', "tingkatan,nama_rombel");
            $response->edit_column('jumlah_siswa', '$1', "jumlah(jumlah_siswa,Siswa)");
            $response->add_column('aksi', '$1 $2 $3', "tabel_icon(id,' ','edit','$edit_link', $this->id_key),
                                                    tabel_icon(id,' ','delete',' ', $this->id_key),
                                                    active_status(id,' ',status,$this->id_key,' ')");
            
            $response = $this->m_detail_rombel->datatables(true);
    
            $this->output->set_output($response);
        } else {
            $this->return = $this->m_detail_rombel->get_all_rombel()->find($id); 

            if ($this->return !== FALSE) {
                unset($this->return->id);
                $this->return->sekolah_id = ($this->return->sekolah_id) ? encrypt_url($this->return->sekolah_id, $this->id_key) : '';
                $this->return->rombel_id = ($this->return->rombel_id) ? encrypt_url($this->return->rombel_id, $this->id_key) : '';
                $this->return->walas_id = ($this->return->walas_id) ? encrypt_url($this->return->walas_id, $this->id_key) : '';

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
        $captcha_score = get_recapture_score($this->input->post('wl-token-response'));  

        if ($captcha_score < RECAPTCHA_ACCEPTABLE_SPAM_SCORE) {
            $this->result = array(
                'status' => FALSE,
                'message' => '<span class="text-danger"><i class="mdi mdi-alert"></i> Request yang anda jalankan dianggap SPAM oleh sistem.</span>'
            );
        } else {
            $this->result = array('status' => TRUE, 'message' => NULL);
            $id = decrypt_url($id, $this->id_key);

            if($this->logged_level !== "3"){
                $this->form_validation->set_rules('sekolah_id', 'Nama Sekolah', 'required');
                $sekolah_id = decrypt_url($this->input->post('sekolah_id'), $this->id_key);
            }else{
                $sekolah_id = $this->logged_sekolah_id;
            }
            $this->form_validation->set_rules('rombel_id', 'Nama Rombel', 'required');
            $this->form_validation->set_rules('walas_id', 'Nama Wali Kelas', 'required');

            $rombel_id = decrypt_url($this->input->post('rombel_id'), $this->id_key);
            $walas_id = decrypt_url($this->input->post('walas_id'), $this->id_key);

            
            $this->form_validation->set_error_delimiters(error_delimeter(1), error_delimeter(2));

            if ($this->form_validation->run() == TRUE) {
                if ($id == FALSE) {
                    $id = null;
                    $this->m_detail_rombel->push_to_data('status', '1');

                }
                $this->m_detail_rombel->push_to_data('sekolah_id', $sekolah_id );
                $this->m_detail_rombel->push_to_data('rombel_id', $rombel_id );
                $this->m_detail_rombel->push_to_data('walas_id', $walas_id );

                $this->return = $this->m_detail_rombel->save($id);

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
            $this->return = $this->m_detail_rombel->delete($id);

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
            $this->m_detail_rombel->push_select('status');

            $check = $this->m_detail_rombel->find($id);

            if ($check !== FALSE) {
                if ($check->status == 0) {
                    $this->m_detail_rombel->push_to_data('status', '1');
                } else {
                    $this->m_detail_rombel->push_to_data('status', '0');
                }

                $this->return = $this->m_detail_rombel->save($id);

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

    public function AjaxGetGuruBySekolah($sekolah_id = null)
    {
        $this->output->unset_template();
        $sekolah_id = decrypt_url($this->input->post('sekolah_id'),$this->id_key);

            if ($sekolah_id != FALSE) {
                
                $this->return = $this->m_guru->get_guru_by_sekolah($sekolah_id)->findAll();
                foreach ($this->return as $key => $value) {
                    $this->return[$key]->id = encrypt_url($value->id, $this->id_key);
                    $this->return[$key]->nama_guru = name_degree($value->gelar_depan,$value->nama_guru,$value->gelar_belakang);

                    unset($this->return[$key]->nip);
                }

                if ($this->return) {
                    $this->result = array (
                        'status' => TRUE,
                        'message' => 'Berhasil mengambil data',
                        'token' => $this->security->get_csrf_hash(),
                        'data' => $this->return
                    );
                } else {
                    $this->result = array (
                        'status' => FALSE,
                        'message' => 'Sekolah tidak dapat ditampilkan',
                        'data' => []
                    );
                }
            } else {
                $this->result = array('status' => FALSE, 'message' => 'ID tidak valid');
            }
        

        if ($this->result) {
            $this->output->set_output(json_encode($this->result));
        } else {
            $this->output->set_output(json_encode(['status'=> FALSE, 'message'=> 'Terjadi kesalahan.']));
        }

    }

}

/* End of file Sample_upload.php */
