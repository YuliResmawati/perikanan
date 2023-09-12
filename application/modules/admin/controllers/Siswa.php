<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Siswa extends Backend_Controller {

    public function __construct()
	{
		parent::__construct();

		$this->_init();
		$this->data['uri_mod'] = 'admin/siswa';
        $this->id_key = $this->private_key;
        $this->breadcrumbs->push('Siswa', 'siswa');
        $this->load->model(array('m_sekolah', 'm_app','m_siswa','m_users','m_rombel'));  

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
        if($this->logged_level == "3"){
            $this->data['add_button_link'] = false;
        }else{
            $this->data['add_button_link'] = base_url('admin/siswa/add');
        }

        $this->data['page_title'] = "Data Siswa";
        $this->data['page_description'] = "Halaman Daftar Data Siswa.";
        $this->data['card'] = "true";
        $this->data['id_key'] = $this->id_key;
        $this->data['tipe_sekolah'] = $this->m_sekolah->get_distinct_tipe()->findAll();
        $this->data['sekolah'] = $this->m_sekolah->get_all_sekolah()->findAll();
        if($this->logged_level == "3"){
            $this->data['rombel'] = $this->m_rombel->get_rombel_by_sekolah($this->logged_sekolah_id)->findAll();
        }
        $this->data['breadcrumbs'] = $this->breadcrumbs->show();

		$this->load->view('siswa/v_index', $this->data);
    }

    public function add()
    {
        $this->breadcrumbs->push('Tambah', 'admin/siswa/add');
        $this->data['page_title'] = "Tambah Data Siswa";
        $this->data['page_description'] = "Halaman Tambah Data Siswa.";
        $this->data['card'] = "true";
        $this->data['breadcrumbs'] = $this->breadcrumbs->show();
        $this->data['sekolah'] = $this->m_sekolah->get_all_sekolah()->findAll();
        $this->data['id_key'] = $this->id_key;

        $this->load->view('siswa/v_add', $this->data);
    }

    public function edit($id = null)
    {        
        $id = decrypt_url($id, $this->id_key);
		
		if ($id == FALSE) {
			$this->load->view('errors/html/error_bootbox.php', array('message' => 'ID yang tertera tidak terdaftar', 'redirect_link' => base_url('supadmin/sample_upload')));
        }

        $this->breadcrumbs->push('Edit', 'admin/siswa/edit');
        $this->data['page_title'] = "Edit Data Siswa";
        $this->data['page_description'] = "Halaman Edit Data Siswa.";
        $this->data['card'] = "true";
        $this->modal_name = 'modal-siswa';
        $this->data['breadcrumbs'] = $this->breadcrumbs->show();
        $this->data['sekolah'] = $this->m_sekolah->get_all_sekolah()->findAll();
        $this->data['id_key'] = $this->id_key;
        $this->data['id'] = $id;

        $this->load->view('siswa/v_edit', $this->data);
    }

    

    public function AjaxGet($id = NULL)
    {
        $this->output->unset_template();

        $id = decrypt_url($id, $this->id_key);

        if ($id == FALSE) {
            $this->modal_name = 'modal-siswa'; 

            $this->m_siswa->push_select('status');

            $edit_link = 'admin/siswa/edit/'; 
            $response = $this->m_siswa->get_all_siswa()->datatables();

            if($this->logged_level !== "3"){
                if ($this->input->post('filter_tipe_sekolah') == FALSE) {
                    $response->where('siswa.id', 0);
                } else {
                    if ($this->input->post('filter_tipe_sekolah') !== 'ALL') {
                        $response->where('s.tipe_sekolah', $this->input->post('filter_tipe_sekolah'));
                    }
                }

                if ($this->input->post('filter_sekolah') == FALSE) {
                    $response->where('siswa.id', 0);
                } else {
                    if ($this->input->post('filter_sekolah') !== 'ALL') {
                        $response->where('sekolah_id', decrypt_url($this->input->post('filter_sekolah'), 'app'));
                    }
                }
                if ($this->input->post('filter_rombel') == FALSE) {
                    $response->where('siswa.id', 0);
                } else {
                    if ($this->input->post('filter_rombel') !== 'ALL') {
                        $response->where('rombel_id', decrypt_url($this->input->post('filter_rombel'), 'app'));
                    }
                }
            }else{
                $response->where('sekolah_id', $this->logged_sekolah_id);
                if ($this->input->post('filter_rombel') == FALSE) {
                    $response->where('siswa.id', 0);
                } else {
                    if ($this->input->post('filter_rombel') !== 'ALL') {
                        $response->where('rombel_id', decrypt_url($this->input->post('filter_rombel'), $this->id_key));
                    }
                }
            }

            
           
            $response->edit_column('id', '$1', "encrypt_url(id,' ', $this->id_key)");
            $response->edit_column('alamat', '$1', "format_alamat(nama_nagari,nama_kecamatan,nama_kabupaten,nama_provinsi,'fe-map-pin text-danger mr-1',alamat_lengkap,'fe-phone-call text-success mr-1',no_hp)");
            $response->edit_column('kelas', '$1 $2', "tingkatan, nama_rombel");
            $response->add_column('detail_siswa', '$1', "tabel_icon(id,' ','view',' ', $this->id_key, $this->modal_name)");
            $response->edit_column('status', '$1', "str_status(status)");
            $response->add_column('aksi', '$1 $2 $3', "tabel_icon(id,' ','edit','$edit_link', $this->id_key),
                                                    tabel_icon(id,' ','delete',' ', $this->id_key),
                                                    active_status(id,' ',status,$this->id_key,' ')");
            
            $response = $this->m_siswa->datatables(true);
    
            $this->output->set_output($response);
        } else {
            $this->return = $this->m_siswa->get_all_siswa()->find($id); 

            if ($this->return !== FALSE) {
                unset($this->return->id);
                $this->return->nagari_id = ($this->return->nagari_id) ? encrypt_url($this->return->nagari_id, 'app') : '';
                $this->return->sekolah_lama_id = ($this->return->sekolah_lama_id) ? encrypt_url($this->return->sekolah_lama_id, $this->id_key) : '';
                $this->return->jenis_kelamin = ($this->return->jenis_kelamin) ? $this->return->jenis_kelamin : '';
                $this->return->jenis_kelamin_view = ($this->return->jenis_kelamin) ? jk($this->return->jenis_kelamin) : '';
                $this->return->rombel = ($this->return->rombel_id) ? $this->return->tingkatan.' '.$this->return->nama_rombel : '';

                if (decrypt_url($this->return->nagari_id, 'app') != NULL) {
                    $this->return->alamat = "Kelurahan " . uc_words($this->return->nama_nagari) . ", Kecamatan " . uc_words($this->return->nama_kecamatan) . ", " . uc_words($this->return->nama_kabupaten) . ", Provinsi " . uc_words($this->return->nama_provinsi);
                } else {
                    $this->return->alamat = NULL;
                }
    
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
        $captcha_score = get_recapture_score($this->input->post('sw-token-response'));  

        if ($captcha_score < RECAPTCHA_ACCEPTABLE_SPAM_SCORE) {
            $this->result = array(
                'status' => FALSE,
                'message' => '<span class="text-danger"><i class="mdi mdi-alert"></i> Request yang anda jalankan dianggap SPAM oleh sistem.</span>'
            );
        } else {
            $this->result = array('status' => TRUE, 'message' => NULL);
            $id = decrypt_url($id, $this->id_key);

            $this->form_validation->set_rules('nama_siswa', 'Nama Siswa', 'required');
            $this->form_validation->set_rules('nik', 'NIK', 'required');
            $this->form_validation->set_rules('no_kk', 'No Kartu Keluarga', 'required');
            $this->form_validation->set_rules('nipd', 'NIPD', 'required');
            $this->form_validation->set_rules('nisn', 'NISN', 'required');
            $this->form_validation->set_rules('jenis_kelamin', 'Jenis Kelamin', 'required');
            $this->form_validation->set_rules('agama', 'Agama', 'required');
            $this->form_validation->set_rules('tempat_lahir', 'Tempat Lahir', 'required');
            $this->form_validation->set_rules('tgl_lahir', 'Tanggal Lahir', 'required');
            $this->form_validation->set_rules('nagari_id', 'Alamat', 'required');
            $this->form_validation->set_rules('alamat_lengkap', ' Detail Alamat', 'required');

            $nagari_id = decrypt_url($this->input->post('nagari_id'), 'app');
            $sekolah_lama_id = decrypt_url($this->input->post('sekolah_lama_id'), $this->id_key);

            
            $this->form_validation->set_error_delimiters(error_delimeter(1), error_delimeter(2));

            if ($this->form_validation->run() == TRUE) {
                if ($id == FALSE) {
                    $id = null;
                    $this->m_siswa->push_to_data('status', '1');

                }
    
                $this->m_siswa->push_to_data('nagari_id', $nagari_id );
                $this->m_siswa->push_to_data('sekolah_lama_id', $sekolah_lama_id );

                $this->return = $this->m_siswa->save($id);
    
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
            $this->return = $this->m_siswa->delete($id);

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
            $this->m_siswa->push_select('status');

            $check = $this->m_siswa->find($id);

            if ($check !== FALSE) {
                if ($check->status == 0) {
                    $this->m_siswa->push_to_data('status', '1');
                } else {
                    $this->m_siswa->push_to_data('status', '0');
                }

                $this->return = $this->m_siswa->save($id);

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

    public function view($id = null)
    {        
       
        $id = decrypt_url($id, $this->id_key); 
        	
		if ($id == FALSE) {
			$this->load->view('errors/html/error_bootbox.php', array('message' => 'ID yang tertera tidak terdaftar', 'redirect_link' => base_url('master/golongan')));
        }

        $this->data['page_title'] = "Data Siswa";
        $this->data['page_description'] = "Halaman Data Siswa.";
        $this->data['card'] = "true";
        $this->data['breadcrumbs'] = $this->breadcrumbs->show();
        $this->data['id_key'] = $this->id_key;
        $this->data['id'] = $id;
        $this->breadcrumbs->push('Edit', 'admin/siswa/edit');

        $this->load->view('siswa/v_edit', $this->data);
    }

    


}

/* End of file Sample_upload.php */
