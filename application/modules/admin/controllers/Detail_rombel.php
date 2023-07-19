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
        $this->load->model(array('m_detail_rombel','m_rombel','m_sekolah','m_guru','m_siswa','m_tahun_ajaran','m_detail_siswa'));  

        $this->load->css($this->data['theme_path'] . '/libs/select2/css/select2.min.css');
        $this->load->css($this->data['theme_path'] . '/libs/dropify/css/dropify.min.css');
        $this->load->js($this->data['theme_path'] . '/libs/select2/js/select2.min.js');
        $this->load->js($this->data['theme_path'] . '/libs/select2/js/i18n/id.js');
        $this->load->js($this->data['global_custom_path'] . '/js/select2-init.js');
        $this->load->js($this->data['theme_path'] . '/libs/dropify/js/dropify.min.js');
        $this->load->js($this->data['global_custom_path'] . '/js/file-upload-init.js');
        $this->load->js($this->data['global_plugin_path'] . '/jquerymask/jquery-mask.min.js');
        $this->load->css($this->data['theme_path'] . '/libs/bootstrap-select/css/bootstrap-select.min.css');
        $this->load->js($this->data['theme_path'] . '/libs/bootstrap-select/js/bootstrap-select.min.js');


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
        $this->data['tahun_ajaran'] = $this->m_tahun_ajaran->get_aktif_ta()->findAll();
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

    public function index_detail($id = null)
	{
        $id = decrypt_url($id, $this->id_key);
		
		if ($id == FALSE) {
			$this->load->view('errors/html/error_bootbox.php', array('message' => 'ID yang tertera tidak terdaftar', 'redirect_link' => base_url('supadmin/sample_upload')));
        }

        $rombel = $this->m_detail_rombel->get_detail_rombel_by_rombel($id)->findAll()['0']; // detail_rombel_id

        $this->data['add_button_link'] = base_url('admin/detail_rombel/add_detail/').encrypt_url($id, $this->id_key);
        $this->data['page_title'] = "Daftar Siswa Rombel ".$rombel->tingkatan." ".$rombel->nama_rombel;
        $this->data['page_description'] = $rombel->nama_sekolah." - ".$rombel->tahun_ajaran;
        $this->data['card'] = "true";
        $this->data['id_key'] = $this->id_key;
        $this->data['id'] = $id;
        $this->data['rombel'] = $rombel;
        $this->data['siswa'] = $this->m_siswa->get_all_siswa()->findAll();
        $this->db->where(['rombel_id' => $id, 'siswa.status' => '1']);
        $this->data['breadcrumbs'] = $this->breadcrumbs->show();
        
		$this->load->view('detail_rombel/v_index_detail', $this->data);
    }

    public function add_detail($id = NULL)
    {
        $id = decrypt_url($id, $this->id_key);
        $rombel = $this->m_detail_rombel->get_detail_rombel_by_rombel($id)->findAll()['0'];

        $this->breadcrumbs->push('Tambah', 'admin/detail_rombel/add_detail');
        $this->data['page_title'] = "Tambah Siswa ".$rombel->tingkatan." ".$rombel->nama_rombel;
        $this->data['page_description'] = $rombel->nama_sekolah." - ".$rombel->tahun_ajaran;
        $this->data['card'] = "true";
        $this->data['breadcrumbs'] = $this->breadcrumbs->show();
        $this->data['id_key'] = $this->id_key;
        $this->data['id'] = $id;
        $this->data['siswa'] = $this->m_siswa->get_siswa_for_rombel()->findAll();
        $this->data['rombel'] = $rombel;
        

        $this->load->view('detail_rombel/v_add_detail', $this->data);
    }

    public function AjaxGet($id = NULL)
    {
        $this->output->unset_template();

        $id = decrypt_url($id, $this->id_key);

        if ($id == FALSE) {
            $this->m_detail_rombel->push_select('status');

            $edit_link = 'admin/detail_rombel/edit/'; 
            $detail_link = 'admin/detail_rombel/index_detail/'; 
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
            $response->edit_column('nama_guru', '$1', "name_degree(gelar_depan,nama_guru,gelar_belakang)");        
            $response->edit_column('jumlah_siswa', '$1', "jumlah(jumlah_siswa,Siswa)");
            $response->add_column('aksi', '$1 $2 $3 $4', "tabel_icon(id,' ','detail','$detail_link', $this->id_key),
                                                    tabel_icon(id,' ','edit','$edit_link', $this->id_key),
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
                $this->return->tahun_ajaran_id = ($this->return->tahun_ajaran_id) ? encrypt_url($this->return->tahun_ajaran_id, $this->id_key) : '';

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
            $this->form_validation->set_rules('walas_id', 'Nama Wali Kelas', 'required');
            $this->form_validation->set_rules('tahun_ajaran_id', 'Tahun Ajaran', 'required');

            $rombel_id = decrypt_url($this->input->post('rombel_id'), $this->id_key);
            $walas_id = decrypt_url($this->input->post('walas_id'), $this->id_key);
            $tahun_ajaran_id = decrypt_url($this->input->post('tahun_ajaran_id'), $this->id_key);

            $this->form_validation->set_error_delimiters(error_delimeter(1), error_delimeter(2));

            if ($this->form_validation->run() == TRUE) {
                if ($id == FALSE) {
                    $id = null;
                    $this->m_detail_rombel->push_to_data('status', '1');

                }
                $this->m_detail_rombel->push_to_data('sekolah_id', $sekolah_id );
                $this->m_detail_rombel->push_to_data('rombel_id', $rombel_id );
                $this->m_detail_rombel->push_to_data('walas_id', $walas_id );
                $this->m_detail_rombel->push_to_data('tahun_ajaran_id', $tahun_ajaran_id );

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

    public function AjaxGetDetail($add = NULL, $id = NULL)
    {
        $this->output->unset_template();

        $id = decrypt_url($id, $this->id_key);

        if ($id !== FALSE) {
            if($add == 'list'){
                $this->modal_name = 'modal-siswa';

                $this->m_siswa->push_select('status');
    
                $response = $this->m_detail_siswa->get_all_detail_siswa()->datatables();
                $response->where('detail_rombel_id', $id);
    
                if($this->logged_level == "3"){
                    $response->where('sekolah_id', $this->logged_sekolah_id);
                }
               
                $response->edit_column('id', '$1', "encrypt_url(id,' ', $this->id_key)");
                $response->edit_column('detail_siswa_id', '$1', "encrypt_url(detail_siswa_id,' ', $this->id_key)");
                $response->edit_column('alamat', '$1', "format_alamat(nama_nagari,nama_kecamatan,nama_kabupaten,nama_provinsi,'fe-map-pin text-danger mr-1',alamat_lengkap,'fe-phone-call text-success mr-1',no_hp)");
                $response->edit_column('kelas', '$1 $2', "tingkatan, nama_rombel");
                $response->add_column('detail_siswa', '$1', "tabel_icon(id,' ','view',' ', $this->id_key, $this->modal_name)");
                $response->add_column('aksi', '$1', "tabel_icon(id,' ','delete',' ', $this->id_key)");

                $response = $this->m_detail_siswa->datatables(true);
        
                $this->output->set_output($response);
            }else{
                $this->return = $this->m_detail_siswa->get_all_detail_siswa()->find($id); 

                if ($this->return !== FALSE) {
                    unset($this->return->id);
                    $this->return->nagari_id = ($this->return->nagari_id) ? encrypt_url($this->return->nagari_id, 'app') : '';
                    $this->return->sekolah_lama_id = ($this->return->sekolah_lama_id) ? encrypt_url($this->return->sekolah_lama_id, $this->id_key) : '';
                    $this->return->jenis_kelamin = ($this->return->jenis_kelamin) ? jk($this->return->jenis_kelamin) : '';
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
            
        }

        return $this->output->set_output($response);
    }

    public function AjaxSaveDetail($id = null)
    {
        $this->output->unset_template();
        $captcha_score = get_recapture_score($this->input->post('ds-token-response'));  
        if ($captcha_score < RECAPTCHA_ACCEPTABLE_SPAM_SCORE) {
            $this->result = array(
                'status' => FALSE,
                'message' => '<span class="text-danger"><i class="mdi mdi-alert"></i> Request yang anda jalankan dianggap SPAM oleh sistem.</span>'
            );
        } else {
            $this->result = array('status' => TRUE, 'message' => NULL);
            $id = decrypt_url($id, $this->id_key);

            $this->form_validation->set_rules('siswa_multiple[]', 'Siswa', 'required');
            $this->form_validation->set_rules('detail_rombel_id', 'Rombel', 'required');
            $this->form_validation->set_error_delimiters(error_delimeter(1), error_delimeter(2));

            if ($this->form_validation->run() == TRUE) {
                if ($id == FALSE) {
                    $id = null;

                    $arr_siswa = $this->input->post('siswa_multiple[]');
                    $data = [];
        
                    foreach ($arr_siswa as $key => $value) {
                        $data[] = array(
                            'siswa_id' => decrypt_url($value, $this->id_key),
                            'detail_rombel_id' => decrypt_url($this->input->post('detail_rombel_id'), $this->id_key),
                            'status' => '1'
                        );  
                    }

                }

                $this->return = $this->m_detail_siswa->save_batch($data);

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

    public function AjaxDelDetail($id = null)
    {
        $this->output->unset_template();

        $id = decrypt_url($id, $this->id_key);
        if ($id !== FALSE) {
            $this->return = $this->m_detail_siswa->delete($id);
            if ($this->return) {
                $this->m_detail_siswa->push_to_data('status', '0');
                $this->return = $this->m_detail_siswa->save($id);
    
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
