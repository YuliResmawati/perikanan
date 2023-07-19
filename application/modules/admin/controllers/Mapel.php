<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mapel extends Backend_Controller {

    public function __construct()
	{
		parent::__construct();

		$this->_init();
		$this->data['uri_mod'] = 'admin/mapel';
        $this->id_key = $this->private_key;
        $this->breadcrumbs->push('Mata Pelajaran', 'mapel');
        $this->load->model(array('m_mapel','m_materi'));  
	}

	public function _init()
    {
        $this->output->set_template('backend');
	}

    public function index()
	{
        $this->data['add_button_link'] = base_url('admin/mapel/add');
        $this->data['page_title'] = "Data Mata Pelajaran";
        $this->data['page_description'] = "Halaman Daftar Data Mata Pelajaran.";
        $this->data['card'] = "true";
        $this->data['id_key'] = $this->id_key;
        $this->data['breadcrumbs'] = $this->breadcrumbs->show();
        
		$this->load->view('mapel/v_index', $this->data);
    }

    public function add()
    {
        $this->breadcrumbs->push('Tambah', 'admin/mapel/add');
        $this->data['page_title'] = "Tambah Data Mata Pelajaran";
        $this->data['page_description'] = "Halaman Tambah Data Tahun Ajaran.";
        $this->data['card'] = "true";
        $this->data['breadcrumbs'] = $this->breadcrumbs->show();
        $this->data['id_key'] = $this->id_key;

        $this->load->view('mapel/v_add', $this->data);
    }

    public function edit($id = null)
    {        
        $id = decrypt_url($id, $this->id_key);
		
		if ($id == FALSE) {
			$this->load->view('errors/html/error_bootbox.php', array('message' => 'ID yang tertera tidak terdaftar', 'redirect_link' => base_url('supadmin/sample_upload')));
        }

        $this->breadcrumbs->push('Edit', 'admin/mapel/edit');
        $this->data['page_title'] = "Edit Data Mata Pelajaran";
        $this->data['page_description'] = "Halaman Edit Data Mata Pelajaran.";
        $this->data['card'] = "true";
        $this->data['breadcrumbs'] = $this->breadcrumbs->show();
        $this->data['id_key'] = $this->id_key;
        $this->data['id'] = $id;

        $this->load->view('mapel/v_edit', $this->data);
    }

    public function index_materi($id = NULL)
	{
        $id = decrypt_url($id, $this->id_key);

		if ($id == FALSE) {
			$this->load->view('errors/html/error_bootbox.php', array('message' => 'ID yang tertera tidak terdaftar', 'redirect_link' => base_url('supadmin/sample_upload')));
        }

        $mapel = $this->m_mapel->find($id);

        $this->data['add_button_link'] = base_url('admin/mapel/add_materi/').encrypt_url($id, $this->id_key);
        $this->data['page_title'] = "Daftar Materi ".$mapel->nama_mapel;
        $this->data['page_description'] = "Halaman Daftar Materi ";
        $this->data['card'] = "true";
        $this->data['id_key'] = $this->id_key;
        $this->data['id'] = $id;
        $this->data['materi'] = $this->m_materi->get_materi_by_mapel($id)->findAll();
        $this->data['breadcrumbs'] = $this->breadcrumbs->show();
        
		$this->load->view('mapel/v_index_materi', $this->data);
    }

    public function add_materi($id = NULL)
    {
        $id = decrypt_url($id, $this->id_key);
        $mapel = $this->m_mapel->find($id);

        $this->breadcrumbs->push('Tambah', 'admin/materi/add_materi');
        $this->data['page_title'] = "Tambah Materi ".$mapel->nama_mapel;
        $this->data['page_description'] = "Halaman Tambah Materi ";
        $this->data['card'] = "true";
        $this->data['breadcrumbs'] = $this->breadcrumbs->show();
        $this->data['id_key'] = $this->id_key;
        $this->data['id'] = $id; // mapel_id
        $this->data['materi'] = $this->m_materi->get_materi_by_mapel($id)->findAll();

        $this->load->view('mapel/v_add_materi', $this->data);
    }

    public function edit_materi($id = null)
    {        
        $id = decrypt_url($id, $this->id_key); // materi_id
		
		if ($id == FALSE) {
			$this->load->view('errors/html/error_bootbox.php', array('message' => 'ID yang tertera tidak terdaftar', 'redirect_link' => base_url('supadmin/sample_upload')));
        }

        $this->breadcrumbs->push('Edit', 'admin/mapel/edit_materi');
        $this->data['page_title'] = "Edit Data Materi";
        $this->data['page_description'] = "Halaman Edit Data Materi.";
        $this->data['card'] = "true";
        $this->data['breadcrumbs'] = $this->breadcrumbs->show();
        $this->data['id_key'] = $this->id_key;
        $this->data['id'] = $id;

        $this->load->view('mapel/v_edit_materi', $this->data);
    }

    public function AjaxGet($id = NULL)
    {
        $this->output->unset_template();

        $id = decrypt_url($id, $this->id_key);

        if ($id == FALSE) {
            $this->m_mapel->push_select('status');

            $edit_link = 'admin/mapel/edit/'; 
            $list_materi = 'admin/mapel/index_materi/'; 
            $response = $this->m_mapel->datatables();
            $response->edit_column('id', '$1', "encrypt_url(id,' ', $this->id_key)");
            $response->edit_column('status', '$1', "str_status(status)");
            $response->add_column('aksi', '$1 $2 $3 $4', "tabel_icon(id,' ','list_materi','$list_materi', $this->id_key),
                                                    tabel_icon(id,' ','edit','$edit_link', $this->id_key),
                                                    tabel_icon(id,' ','delete',' ', $this->id_key),
                                                    active_status(id,' ',status,$this->id_key,' ')");
            
            $response = $this->m_mapel->datatables(true);
    
            $this->output->set_output($response);
        } else {
            $this->return = $this->m_mapel->find($id); 

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
        $captcha_score = get_recapture_score($this->input->post('mp-token-response'));  

        if ($captcha_score < RECAPTCHA_ACCEPTABLE_SPAM_SCORE) {
            $this->result = array(
                'status' => FALSE,
                'message' => '<span class="text-danger"><i class="mdi mdi-alert"></i> Request yang anda jalankan dianggap SPAM oleh sistem.</span>'
            );
        } else {
            $this->result = array('status' => TRUE, 'message' => NULL);
            $id = decrypt_url($id, $this->id_key);

            $this->form_validation->set_rules('nama_mapel', 'Mata Pelajaran', 'required');
            $this->form_validation->set_error_delimiters(error_delimeter(1), error_delimeter(2));

            if ($this->form_validation->run() == TRUE) {
                if ($id == FALSE) {
                    $id = null;
                    $this->m_mapel->push_to_data('status', '1');

                }

                $this->return = $this->m_mapel->save($id);
    
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
            $check = $this->m_materi->get_materi_by_mapel($id)->findAll();
            if (!empty($check)) {
                $this->result = array(
                    'status'   => FALSE,
                    'message' => '<span class="text-danger"><i class="mdi mdi-alert"></i> Silahkan Non Aktifkan atau Hapus Semua Materi pada Mata Pelajaran ini</span>'
                );
            }else{
                $this->return = $this->m_mapel->delete($id);
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
            $check_materi = $this->m_materi->get_materi($id)->findAll();
            if (!empty($check_materi)) {
                $this->result = array(
                    'status'   => FALSE,
                    'message' => '<span class="text-danger"><i class="mdi mdi-alert"></i> Silahkan Non Aktifkan atau Hapus Semua Materi pada Mata Pelajaran ini</span>'
                );
            }else{
                $this->m_mapel->push_select('status');
                $check = $this->m_mapel->find($id);

                if ($check !== FALSE) {
                    if ($check->status == 0) {
                        $this->m_mapel->push_to_data('status', '1');
                    } else {
                        $this->m_mapel->push_to_data('status', '0');
                    }

                    $this->return = $this->m_mapel->save($id);

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
            }
        } else {
            $this->result = array(
                'status'   => FALSE,
                'message' => '<span class="text-danger"><i class="mdi mdi-alert"></i> ID tidak valid.</span>'
            );
        }

        $this->output->set_output(json_encode($this->result));
    }

    public function AjaxGetMateri($add = NULL, $id = NULL)
    {
        $this->output->unset_template();

        $id = decrypt_url($id, $this->id_key);

        if ($id !== FALSE) {
            if($add == 'list'){
                $this->m_materi->push_select('status');
                $edit_link = 'admin/mapel/edit_materi/'; 

                $response = $this->m_materi->datatables();
                $response->where('mapel_id', $id);

                $response->edit_column('id', '$1', "encrypt_url(id,' ', $this->id_key)");
                $response->edit_column('status', '$1', "str_status(status)");

                $response->add_column('aksi', '$1 $2 $3', "tabel_icon(id,' ','edit','$edit_link', $this->id_key),
                                                                tabel_icon(id,' ','delete',' ', $this->id_key),
                                                                active_status(id,' ',status,$this->id_key,' ')");

                $response = $this->m_materi->datatables(true);
        
                $this->output->set_output($response);
            }else{
                $this->return = $this->m_materi->get_materi()->find($id); 

                if ($this->return !== FALSE) {
                    unset($this->return->id);
                    $this->return->mapel_id = ($this->return->mapel_id) ? encrypt_url($this->return->mapel_id, $this->id_key) : '';

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

    public function AjaxSaveMateri($id = null)
    {
        $this->output->unset_template();
        $captcha_score = get_recapture_score($this->input->post('mt-token-response'));  
        if ($captcha_score < RECAPTCHA_ACCEPTABLE_SPAM_SCORE) {
            $this->result = array(
                'status' => FALSE,
                'message' => '<span class="text-danger"><i class="mdi mdi-alert"></i> Request yang anda jalankan dianggap SPAM oleh sistem.</span>'
            );
        } else {
            $this->result = array('status' => TRUE, 'message' => NULL);
            $id = decrypt_url($id, $this->id_key);

            $this->form_validation->set_rules('nama_materi', 'Materi', 'required');
            $mapel_id = decrypt_url($this->input->post('mapel_id'), $this->id_key);

            $this->form_validation->set_error_delimiters(error_delimeter(1), error_delimeter(2));

            if ($this->form_validation->run() == TRUE) {
                if ($id == FALSE) {
                    $id = null;
                    $this->m_materi->push_to_data('status', '1');
                }
                $this->m_materi->push_to_data('mapel_id', $mapel_id );

                $this->return = $this->m_materi->save($id);

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

    public function AjaxDelMateri($id = null)
    {
        $this->output->unset_template();

        $id = decrypt_url($id, $this->id_key);

        if ($id !== FALSE) {
            $this->return = $this->m_materi->delete($id);
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

    public function AjaxActiveMateri($id = null)
    {
        $this->output->unset_template();

        $id = decrypt_url($id, $this->id_key);
        if ($id !== FALSE) {
            $this->m_materi->push_select('status');
            $check = $this->m_materi->find($id);

            if ($check !== FALSE) {
                if ($check->status == 0) {
                    $this->m_materi->push_to_data('status', '1');
                } else {
                    $this->m_materi->push_to_data('status', '0');
                }

                $this->return = $this->m_materi->save($id);

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
