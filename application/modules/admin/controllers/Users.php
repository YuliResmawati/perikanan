<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Users extends Backend_Controller {

    public function __construct()
	{
		parent::__construct();

		$this->_init();
		$this->data['uri_mod'] = 'admin/users';
        $this->id_key = $this->private_key;
        $this->breadcrumbs->push('Pengguna', 'users');
        $this->load->model([
            'm_users','m_sekolah'
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
        $this->data['add_button_link'] = base_url('admin/users/add');
        $this->data['page_title'] = "Data Pengguna";
        $this->data['page_description'] = "Halaman Daftar Data Pengguna.";
        $this->data['card'] = "true";
        $this->data['tipe_sekolah'] = $this->m_sekolah->get_distinct_tipe()->findAll();
        $this->data['breadcrumbs'] = $this->breadcrumbs->show();
        
		$this->load->view('users/v_index', $this->data);
    }

    public function add()
    {
        $this->breadcrumbs->push('Tambah', 'admin/users/add');
        $this->data['page_title'] = "Tambah Data Pengguna";
        $this->data['page_description'] = "Halaman Tambah Data Pengguna.";
        $this->data['card'] = "true";
        $this->data['breadcrumbs'] = $this->breadcrumbs->show();
        $this->data['tipe_sekolah'] = $this->m_sekolah->get_distinct_tipe()->findAll();
        $this->data['id_key'] = $this->id_key;

        $this->load->view('users/v_add', $this->data);
    }

    public function edit($id = null)
    {        
        $id = decrypt_url($id, $this->id_key);
		
		if ($id == FALSE) {
			$this->load->view('errors/html/error_bootbox.php', array('message' => 'ID yang tertera tidak terdaftar', 'redirect_link' => base_url('supadmin/sample_upload')));
        }

        $this->breadcrumbs->push('Edit', 'admin/sekolah/edit');
        $this->data['page_title'] = "Edit Data Sekolah";
        $this->data['page_description'] = "Halaman Edit Data Sekolah.";
        $this->data['card'] = "true";
        $this->data['breadcrumbs'] = $this->breadcrumbs->show();
        $this->data['id_key'] = $this->id_key;
        $this->data['tipe_sekolah'] = $this->m_sekolah->get_distinct_tipe()->findAll();
        $this->data['id'] = $id;

        $this->load->view('sekolah/v_edit', $this->data);
    }

    

    public function AjaxGet($id = NULL)
    {
        $this->output->unset_template();

        $id = decrypt_url($id, $this->id_key);

        if ($id == FALSE) {
            $this->m_users->push_select('users.status');
            $response = $this->m_users->get_detail_sekolah()->datatables();

            if ($this->input->post('filter_tipe_sekolah') == FALSE) {
                $response->where('tipe_sekolah', 0);
            } else {
                if ($this->input->post('filter_tipe_sekolah') !== 'ALL') {
                    $response->where('tipe_sekolah', $this->input->post('filter_tipe_sekolah'));
                }
            }

            $response->edit_column('id', '$1', "encrypt_url(id,' ', $this->id_key)");
            $response->edit_column('tipe_sekolah', '$1', "tipe_sekolah(tipe_sekolah)");
            $response->edit_column('two_row', '$1', "two_row(display_name,'fe-user text-danger mr-1', email,'fe-mail text-success mr-1')");
            $response->edit_column('status', '$1', "str_status(status)");
            $response->add_column('reset_pass', '$1', "tabel_icon(id,' ','reset_pass',' ', $this->id_key)");
            $response->add_column('aksi', '$1 $2', "tabel_icon(id,' ','delete',' ', $this->id_key),
                                                    active_status(id,' ',status,$this->id_key,' ')");
            
            $response = $this->m_users->datatables(true);
    
            $this->output->set_output($response);
        } else {
            $this->return = $this->m_users->find($id); 

            if ($this->return !== FALSE) {
                unset($this->return->id);

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
        $captcha_score = get_recapture_score($this->input->post('usr-token-response'));  

        if ($captcha_score < RECAPTCHA_ACCEPTABLE_SPAM_SCORE) {
            $this->result = array(
                'status' => FALSE,
                'message' => '<span class="text-danger"><i class="mdi mdi-alert"></i> Request yang anda jalankan dianggap SPAM oleh sistem.</span>'
            );
        } else {
            $this->result = array('status' => TRUE, 'message' => NULL);
            $id = decrypt_url($id, $this->id_key);

            $this->form_validation->set_rules('display_name', 'Nama Lengkap', 'required');
            $this->form_validation->set_rules('email', 'Email', 'required|valid_email|is_unique[users.email]');
            $this->form_validation->set_rules('tipe_sekolah', 'Tingkatan Sekolah', 'required');
            $this->form_validation->set_rules('sekolah_id', 'Nama Sekolah', 'required');
            $this->form_validation->set_rules('username', 'Username', 'required|is_unique[users.username]');
    
            $this->form_validation->set_error_delimiters(error_delimeter(1), error_delimeter(2));

            if ($this->form_validation->run() == TRUE) {
                if ($id == FALSE) {
                    $id = null;
                    $this->m_users->push_to_data('status', '1');
                }
    
                $this->return = $this->m_users->push_to_data('level', '3')
                                ->push_to_data('sekolah_id', decrypt_url($this->input->post('sekolah_id'), $this->id_key))
                                ->push_to_data('password', $this->m_users->ghash('silatpendidikan_pass'))
                                ->push_to_data('deleted', '0')
                                ->save($id);
    
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
            $this->return = $this->m_users->delete($id);

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
            $this->m_users->push_select('status');

            $check = $this->m_users->find($id);

            if ($check !== FALSE) {
                if ($check->status == 0) {
                    $this->m_users->push_to_data('status', '1');
                } else {
                    $this->m_users->push_to_data('status', '0');
                }

                $this->return = $this->m_users->save($id);

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

    public function AjaxGetSekolahByTipe($tipe_sekolah = null)
    {
        $this->output->unset_template();
        $tipe_sekolah = $this->input->post('tipe_sekolah'); 

            if ($tipe_sekolah != FALSE) {
                
                $this->return = $this->m_sekolah->get_sekolah_by_tipe($tipe_sekolah)->findAll();
                foreach ($this->return as $key => $value) {
                    $this->return[$key]->id = encrypt_url($value->id, $this->id_key);

                    unset($this->return[$key]->npsn);
                    unset($this->return[$key]->tipe_sekolah);
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

    public function AjaxGetSekolahById($id = null)
    {
        $this->output->unset_template();
        $id = decrypt_url($this->input->post('id'), $this->id_key);
            if ($id != FALSE) {
                $this->return = $this->m_sekolah->find($id);
                $this->return->id = encrypt_url($this->return->id, $this->id_key);
                unset($this->return->alamat);
                unset($this->return->foto);
                unset($this->return->link_g_site);
                unset($this->return->no_telp);

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

    public function AjaxResetPass($id = null)
    {
        $this->output->unset_template();

        $id = decrypt_url($id, $this->id_key);

        if ($id !== FALSE) {
            $check = $this->m_users->find($id);

            if ($check !== FALSE) {
                $this->m_users->push_to_data('password', $this->m_users->ghash('silatpendidikan_pass'));
                $this->return = $this->m_users->save($id);

                if ($this->return) {
                    $this->result = array(
                        'status'   => TRUE,
                        'message' => '<span class="text-success"><i class="mdi mdi-check-decagram"></i> Password berhasil di reset menjadi "silatpendidikan_pass".</span>'
                    );
                } else {
                    $this->result = array(
                        'status'   => FALSE,
                        'message' => '<span class="text-danger"><i class="mdi mdi-alert"></i> Password gagal direset.</span>'
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
