<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Kelompok_nelayan extends Backend_Controller {
    public function __construct()
	{
		parent::__construct();

		$this->_init();
		$this->data['uri_mod'] = 'bidang/kelompok_nelayan';
        $this->id_key = $this->private_key;
        $this->breadcrumbs->push('Kelompok Nelayan', 'kelompok_nelayan');
        $this->load->model(['m_kelompok_nelayan']);

        $this->load->css($this->data['theme_path'] . '/libs/select2/css/select2.min.css');
        $this->load->js($this->data['theme_path'] . '/libs/select2/js/select2.min.js');
        $this->load->js($this->data['theme_path'] . '/libs/select2/js/i18n/id.js');
        $this->load->js($this->data['global_custom_path'] . '/js/select2-init.js');

	}

	public function _init()
    {
        $this->output->set_template('backend');
	}

    public function index()
	{   
        $this->data['add_button_link'] = base_url('bidang/kelompok_nelayan/add');
        $this->data['page_title'] = "Kelompok Nelayan";
        $this->data['page_description'] = "Halaman Kelompok Nelayan.";
        $this->data['breadcrumbs'] = $this->breadcrumbs->show();
        $this->data['id_key'] = $this->id_key;
        $this->data['card'] = "true";

		$this->load->view('kelompok_nelayan/v_index', $this->data);
    }

    public function add()
    {
        $this->breadcrumbs->push('Tambah', 'bidang/kelompok_nelayan/add');
        $this->data['page_title'] = "Tambah Data Kelompok Nelayan";
        $this->data['page_description'] = "Halaman Tambah Data Kelompok Nelayan.";
        $this->data['card'] = "true";
        $this->data['breadcrumbs'] = $this->breadcrumbs->show();
        $this->data['id_key'] = $this->id_key;

        $this->load->view('kelompok_nelayan/v_add', $this->data);
    }

    public function edit($id = null)
    {        
        $id = decrypt_url($id, $this->id_key);
		
		if ($id == FALSE) {
			$this->load->view('errors/html/error_bootbox.php', array('message' => 'ID yang tertera tidak terdaftar', 'redirect_link' => base_url('bidang/kelompok_nelayan')));
        }

        $this->breadcrumbs->push('Edit', 'bidang/kelompok_nelayan/edit');
        $this->data['page_title'] = "Edit Data Kelompok Nelayan";
        $this->data['page_description'] = "Halaman Edit Data Kelompok Nelayan.";
        $this->data['card'] = "true";
        $this->data['breadcrumbs'] = $this->breadcrumbs->show();
        $this->data['id_key'] = $this->id_key;
        $this->data['id'] = $id;

        $this->load->view('kelompok_nelayan/v_edit', $this->data);
    }

    public function AjaxGet($id = NULL)
    {
        $this->output->unset_template();

        $id = decrypt_url($id, $this->id_key);

        if ($id == FALSE) {
            $this->m_kelompok_nelayan->push_select('status');

            $edit_link = 'bidang/kelompok_nelayan/edit/';
            $response = $this->m_kelompok_nelayan->datatables();
            $response->edit_column('id', '$1', "encrypt_url(id,' ', $this->id_key)");
            $response->edit_column('status', '$1', "str_status(status)");
            $response->edit_column('nama_koperasi', '$1', "two_row(nama_koperasi,'fe-home text-danger mr-1', tahun_berdiri,'fe-type text-success mr-1')");
            $response->add_column('aksi', '$1 $2 $3', "tabel_icon(id,' ','edit','$edit_link ', $this->id_key, ' '),
                                                    tabel_icon(id,' ','delete',' ', $this->id_key),
                                                    active_status(id,' ',status,$this->id_key,' ')");
            
            $response = $this->m_kelompok_nelayan->datatables(true);
    
            $this->output->set_output($response);
        } else {
            $this->return = $this->m_kelompok_nelayan->find($id); 

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
        $id = decrypt_url($id, $this->id_key);
        $captcha_score = get_recapture_score($this->input->post('nl-token-response'));  

        if ($captcha_score < RECAPTCHA_ACCEPTABLE_SPAM_SCORE) {
            $this->result = array(
                'status' => FALSE,
                'message' => '<span class="text-danger"><i class="mdi mdi-alert"></i> Request yang anda jalankan dianggap SPAM oleh sistem.</span>'
            );
        } else {
            $this->result = array('status' => TRUE, 'message' => NULL);

            $this->form_validation->set_rules('nama_koperasi', 'Nama Koperasi', 'required'); 
            $this->form_validation->set_rules('nama_ketua', 'Nama Ketua', 'required'); 
            $this->form_validation->set_rules('alamat', 'Alamat Koperasi', 'required'); 
            $this->form_validation->set_rules('jumlah', 'Jumlah Anggota', 'required'); 
            $this->form_validation->set_rules('tahun', 'Tahun Berdiri', 'required'); 


            $this->form_validation->set_error_delimiters(error_delimeter(1), error_delimeter(2));

            if ($this->form_validation->run() == TRUE) {  

                if ($id == FALSE) {
                    $this->m_kelompok_nelayan->push_to_data('status', '1');
                }

                $this->m_kelompok_nelayan->push_to_data('nama_koperasi', $this->input->post('nama_koperasi'))
                    ->push_to_data('nama_ketua', $this->input->post('nama_ketua'))
                    ->push_to_data('alamat', $this->input->post('alamat'))
                    ->push_to_data('jumlah_anggota', $this->input->post('jumlah'))
                    ->push_to_data('tahun_berdiri', $this->input->post('tahun'));

                if ($this->result['status'] !== FALSE) {

                    $this->return =  $this->m_kelompok_nelayan->save($id);

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
            $this->return = $this->m_kelompok_nelayan->delete($id);

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
            $this->m_kelompok_nelayan->push_select('status');

            $check = $this->m_kelompok_nelayan->find($id);

            if ($check !== FALSE) {
                if ($check->status == 0) {
                    $this->m_kelompok_nelayan->push_to_data('status', '1');
                } else {
                    $this->m_kelompok_nelayan->push_to_data('status', '0');
                }

                $this->return = $this->m_kelompok_nelayan->save($id);

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

/* End of file kelompok_ nelayan.php */
