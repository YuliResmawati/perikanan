<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mutasi_siswa extends Backend_Controller {

    public function __construct()
	{
		parent::__construct();

		$this->_init();
		$this->data['uri_mod'] = 'operator/mutasi_siswa';
        $this->id_key = $this->private_key;
        $this->breadcrumbs->push('Mutasi Siswa', 'operator/mutasi_siswa');
        $this->load->model([
            'm_mutasi_siswa','m_sekolah','m_siswa', 'm_detail_rombel'
        ]);

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
        $this->data['add_button_link'] = base_url('operator/mutasi_siswa/add');
        $this->data['page_title'] = "Data Mutasi Siswa";
        $this->data['page_description'] = "Halaman Daftar Data Mutasi Siswa.";
        $this->data['card'] = "true";
        $this->data['breadcrumbs'] = $this->breadcrumbs->show();
        
		$this->load->view('mutasi_siswa/v_index', $this->data);
    }

    public function add()
    {
        $this->breadcrumbs->push('Tambah', 'operator/mutasi_siswa/add');
        $this->data['page_title'] = "Tambah Data Mutasi Siswa";
        $this->data['page_description'] = "Halaman Tambah Data Mutasi Siswa.";
        $this->data['card'] = "true";
        $this->data['breadcrumbs'] = $this->breadcrumbs->show();
        $this->data['id_key'] = $this->id_key;

        $this->load->view('mutasi_siswa/v_add', $this->data);
    }

    public function edit($id = null)
    {        
        $id = decrypt_url($id, $this->id_key);
		
		if ($id == FALSE) {
			$this->load->view('errors/html/error_bootbox.php', array('message' => 'ID yang tertera tidak terdaftar', 'redirect_link' => base_url('supadmin/sample_upload')));
        }

        $this->breadcrumbs->push('Edit', 'operator/mutasi_guru/add');
        $this->data['page_title'] = "Edit Data Sekolah";
        $this->data['page_description'] = "Halaman Edit Data Sekolah.";
        $this->data['card'] = "true";
        $this->data['breadcrumbs'] = $this->breadcrumbs->show();
        $this->data['id_key'] = $this->id_key;
        $this->data['id'] = $id;

        $this->load->view('sekolah/v_edit', $this->data);
    }

    

    public function AjaxGet($id = NULL)
    {
        $this->output->unset_template();

        $id = decrypt_url($id, $this->id_key);

        if ($id == FALSE) {
            $this->m_mutasi_siswa->push_select('status');

            $edit_link = 'operator/mutasi_siswa/edit/'; 
            $response = $this->m_mutasi_siswa->get_detail_mutasi_siswa()->datatables();


            $response->edit_column('id', '$1', "encrypt_url(id,' ', $this->id_key)");  
            $response->edit_column('nama', '$1', "two_row(nama_siswa,'fe-user text-danger mr-1', nisn,' fe-clipboard text-success mr-1')");
            $response->edit_column('awal', '$1', "two_row(sekolah_awal,'fe-home text-info mr-1', rombel_awal,' fe-book text-warning mr-1')");
            $response->edit_column('tujuan', '$1', "two_row(sekolah_tujuan,'fe-home text-info mr-1', rombel_tujuan,' fe-book text-warning mr-1')");
            $response->edit_column('link', '$1', "btn_link(link)");
            $response->edit_column('status', '$1', "str_status_mutasi(status)");  
            $response->add_column('aksi', '$1 $2', "tabel_icon_mutasi(id,' ','edit','$edit_link', $this->id_key,' ',' ',status),
                        tabel_icon_mutasi(id,' ','delete',' ', $this->id_key,' ',' ',status)");
            
            $response = $this->m_mutasi_siswa->datatables(true);
    
            $this->output->set_output($response);
        } else {
            $this->return = $this->m_sekolah->find($id); 

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

    public function AjaxGetSiswa()
    {
        $this->output->unset_template();

        $search = $this->input->post('search');
        $page = $this->input->post('page');
		$perPage = 10;
        $results = $this->m_mutasi_siswa->get_all_siswa_by_paging($perPage, $page, $search, 'data');
		$countResults = $this->m_mutasi_siswa->get_all_siswa_by_paging($perPage, $page, $search, 'count');

        $this->return = [];

        foreach ($results as $row) {
            $this->return[] = array(
                'id' => encrypt_url($row['id'], 'silat_pendidikan'),
                'text' => $row['nisn'] . " - " . $row['nama_siswa']
            );
        }

        if ($this->return) {
            $this->result = array ( 
                'status' => TRUE, 
                'message' => 'Berhasil mengambil data', 
                'items' => $this->return,
                'total_count' => $countResults
            ); 
        } else {
            $this->result = array ( 
                'status' => FALSE, 
                'message' => 'Gagal mengambil data', 
                'items' => [],
                'total_count' => 0
            ); 
        }

        if ($this->result) { 
            $this->output->set_content_type('application/json')->set_output(json_encode($this->result));
        } else { 
            $this->output->set_output(json_encode(['status'=> FALSE, 'message'=> 'Terjadi kesalahan pada response server.'])); 
        } 
    }

    public function AjaxGetSekolah()
    {
        $this->output->unset_template();

        $search = $this->input->post('search');
        $page = $this->input->post('page');
		$perPage = 10;
        $results = $this->m_sekolah->get_all_sekolah_by_paging($perPage, $page, $search, 'data');
		$countResults = $this->m_sekolah->get_all_sekolah_by_paging($perPage, $page, $search, 'count');

        $this->return = [];

        foreach ($results as $row) {
            $this->return[] = array(
                'id' => encrypt_url($row['id'], 'silat_pendidikan'),
                'text' => $row['npsn'] . " - " . $row['nama_sekolah']
            );
        }

        if ($this->return) {
            $this->result = array ( 
                'status' => TRUE, 
                'message' => 'Berhasil mengambil data', 
                'items' => $this->return,
                'total_count' => $countResults
            ); 
        } else {
            $this->result = array ( 
                'status' => FALSE, 
                'message' => 'Gagal mengambil data', 
                'items' => [],
                'total_count' => 0
            ); 
        }

        if ($this->result) { 
            $this->output->set_content_type('application/json')->set_output(json_encode($this->result));
        } else { 
            $this->output->set_output(json_encode(['status'=> FALSE, 'message'=> 'Terjadi kesalahan pada response server.'])); 
        } 
    }

    public function AjaxGetValueBySiswa($id = null)
    {
        $this->output->unset_template();
        $siswa_id = decrypt_url($this->input->post('id'), 'silat_pendidikan');

            if ($siswa_id != FALSE) { 
                $this->return = $this->m_siswa->get_All_Detail_siswa($siswa_id)->findAll()[0];
                $this->return->id = encrypt_url($this->return->id, 'silat_pendidikan');
                $this->return->detail_rombel_awal_id = encrypt_url($this->return->detail_rombel_awal_id, 'silat_pendidikan');
                $this->return->jenis_kelamin=jenisKelamin($this->return->jenis_kelamin);

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
                        'message' => 'Guru tidak memiliki Sekolah',
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

    public function AjaxGetValueBySekolah($id = null)
    {
        $this->output->unset_template();
        $sekolah_id = decrypt_url($this->input->post('id'), 'silat_pendidikan');

            if ($sekolah_id != FALSE) { //1
                
                $this->return = $this->m_detail_rombel->get_rombel_by_sekolah($sekolah_id)->findAll();
        
                foreach ($this->return as $key => $value) {
                $this->return[$key]->id = encrypt_url($value->id, $this->id_key);
                $this->return[$key]->sekolah_id = encrypt_url($value->sekolah_id, $this->id_key);
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
                        'message' => 'Sekolah tidak memiliki Rombel',
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

    public function AjaxSave($id = null)
    {
        $this->output->unset_template();
        $captcha_score = get_recapture_score($this->input->post('msiswa-token-response'));  

        if ($captcha_score < RECAPTCHA_ACCEPTABLE_SPAM_SCORE) {
            $this->result = array(
                'status' => FALSE,
                'message' => '<span class="text-danger"><i class="mdi mdi-alert"></i> Request yang anda jalankan dianggap SPAM oleh sistem.</span>'
            );
        } else {
            $this->result = array('status' => TRUE, 'message' => NULL);
            $id = decrypt_url($id, $this->id_key);

            $this->form_validation->set_rules('siswa_id', 'Nama Siswa', 'required');
            $this->form_validation->set_rules('sekolah_tujuan', 'Sekolah Tujuan', 'required');
            $this->form_validation->set_rules('link', 'Link Dokumen', 'required');
    
            $this->form_validation->set_error_delimiters(error_delimeter(1), error_delimeter(2));

            if ($this->form_validation->run() == TRUE) {
                if ($id == FALSE) {
                    $id = null;
                    $this->m_mutasi_siswa->push_to_data('status', '0');
                }

                $this->m_mutasi_siswa->push_to_data('siswa_id', decrypt_url($this->input->post('siswa_id'), 'silat_pendidikan'))
                    ->push_to_data('detail_rombel_awal_id', decrypt_url($this->input->post('sekolah_awal_id'), 'silat_pendidikan'))
                    ->push_to_data('detail_rombel_tujuan_id', decrypt_url($this->input->post('rombel_id'),  $this->id_key));
    
                $this->return = $this->m_mutasi_siswa->save($id);
    
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
            $this->return = $this->m_mutasi_siswa->delete($id);

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
