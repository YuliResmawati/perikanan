<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mutasi_guru extends Backend_Controller {

    public function __construct()
	{
		parent::__construct();

		$this->_init();
		$this->data['uri_mod'] = 'operator/mutasi_guru';
        $this->id_key = $this->private_key;
        $this->breadcrumbs->push('Mutasi Guru', 'operator/mutasi_guru');
        $this->load->model(['m_mutasi_guru','m_sekolah','m_guru']);

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
        $this->data['add_button_link'] = base_url('operator/mutasi_guru/add');
        $this->data['page_title'] = "Data Mutasi Guru";
        $this->data['page_description'] = "Halaman Daftar Data Mutasi Guru.";
        $this->data['card'] = "true";
        $this->data['id_key'] = $this->id_key;

        $this->data['breadcrumbs'] = $this->breadcrumbs->show();
        
		$this->load->view('mutasi_guru/v_index', $this->data);
    }

    public function add()
    {
        $this->breadcrumbs->push('Tambah', 'operator/mutasi_guru/add');
        $this->data['page_title'] = "Tambah Data Mutasi Guru";
        $this->data['page_description'] = "Halaman Tambah Data Mutasi Guru.";
        $this->data['card'] = "true";
        $this->data['breadcrumbs'] = $this->breadcrumbs->show();
        $this->data['id_key'] = $this->id_key;

        $this->load->view('mutasi_guru/v_add', $this->data);
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

        if ($id == FALSE) {
            $this->m_mutasi_guru->push_select('status');

            $edit_link = 'operator/mutasi_guru/edit/'; 
            $response = $this->m_mutasi_guru->get_detail_mutasi_guru()->datatables();
            
            $response->where('sekolah_awal_id', $this->logged_sekolah_id);

            if ($this->input->post('filter_tipe') == FALSE) {
                $response->where('mutasi_guru.id', 0);
            } else {
                if ($this->input->post('filter_tipe') !== 'ALL') {
                    $response->where('mutasi_guru.tipe_mutasi', decrypt_url($this->input->post('filter_tipe'), $this->id_key));
                }
            }

            if ($this->input->post('filter_status') == FALSE) {
                $response->where('mutasi_guru.id', 0);
            } else {
                if ($this->input->post('filter_status') !== 'ALL') {
                    $response->where('mutasi_guru.status', decrypt_url($this->input->post('filter_status'), $this->id_key));
                }
            }

            $response->edit_column('id', '$1', "encrypt_url(id,' ', $this->id_key)");  
            $response->edit_column('nama', '$1', "two_row(nama_guru,'fe-user text-danger mr-1', nip,' fe-clipboard text-success mr-1')");
            $response->edit_column('tipe', '$1', "tipe_mutasi(tipe_mutasi)");
            $response->edit_column('tujuan', '$1 $2', "sekolah_tujuan, sekolah_luar");
            $response->edit_column('link', '$1', "btn_link(link)");
            $response->edit_column('status', '$1', "str_status_mutasi(status)");  
            $response->add_column('aksi', '$1', "tabel_icon_mutasi(id,' ','delete',' ', $this->id_key,' ',' ',status)");
            
            $response = $this->m_mutasi_guru->datatables(true);
    
            $this->output->set_output($response);
        } else {
            $this->return = $this->m_mutasi_guru->get_detail_mutasi_guru()->find($id); 

            if ($this->return !== FALSE) {
                $this->return->id = encrypt_url($this->return->id, $this->id_key);
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

    public function AjaxGetValueByGuru($id = null)
    {
        $this->output->unset_template();
        $guru_id = decrypt_url($this->input->post('id'), 'silat_pendidikan');

            if ($guru_id != FALSE) { 
                $this->return = $this->m_sekolah->get_sekolah_by_guru($guru_id)->findAll()[0];
                $this->return->id = encrypt_url($this->return->id, 'silat_pendidikan');

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

    public function AjaxSave($id = null)
    {
        $this->output->unset_template();
        $captcha_score = get_recapture_score($this->input->post('mguru-token-response'));  

        if ($captcha_score < RECAPTCHA_ACCEPTABLE_SPAM_SCORE) {
            $this->result = array(
                'status' => FALSE,
                'message' => '<span class="text-danger"><i class="mdi mdi-alert"></i> Request yang anda jalankan dianggap SPAM oleh sistem.</span>'
            );
        } else {
            $this->result = array('status' => TRUE, 'message' => NULL);
            $id = decrypt_url($id, $this->id_key);

            $this->form_validation->set_rules('tipe_mutasi', 'Jenis Mutasi', 'required');
            $this->form_validation->set_rules('guru_id', 'Nama Guru', 'required');
            $this->form_validation->set_rules('link', 'Link Dokumen', 'required');
    
            $this->form_validation->set_error_delimiters(error_delimeter(1), error_delimeter(2));

            if($this->input->post('tipe_mutasi') == "0"){
                $this->form_validation->set_rules('sekolah_luar', 'Nama Sekolah Tujuan', 'required');
            }else{
                $this->form_validation->set_rules('sekolah_tujuan', 'Sekolah Tujuan', 'required');
            }

            $guru_id = decrypt_url($this->input->post('guru_id'), 'silat_pendidikan');

            if ($this->form_validation->run() == TRUE) {
                if ($id == FALSE) {
                    $id = null;
                    $this->m_mutasi_guru->push_to_data('status', '0');
                }

                $this->m_mutasi_guru
                    ->push_to_data('tipe_mutasi', $this->input->post('tipe_mutasi'))
                    ->push_to_data('guru_id', $guru_id)
                    ->push_to_data('sekolah_awal_id', decrypt_url($this->input->post('sekolah_awal_id'), 'silat_pendidikan'))
                    ->push_to_data('link', $this->input->post('link'));

                if($this->input->post('tipe_mutasi') == "0"){
                    $this->m_mutasi_guru->push_to_data('sekolah_luar', $this->input->post('sekolah_luar'));
                }else{
                    $this->m_mutasi_guru->push_to_data('sekolah_tujuan_id', decrypt_url($this->input->post('sekolah_tujuan'), 'silat_pendidikan'));
                }
    
                $this->return = $this->m_mutasi_guru->save($id);
    
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
