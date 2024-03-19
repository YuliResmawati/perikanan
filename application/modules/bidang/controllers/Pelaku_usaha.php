<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pelaku_usaha extends Backend_Controller {
    public function __construct()
	{
		parent::__construct();

		$this->_init();
		$this->data['uri_mod'] = 'bidang/pelaku_usaha';
        $this->id_key = $this->private_key;
        $this->breadcrumbs->push('Pelaku Usaha', 'pelaku_usaha');
        $this->load->model(['m_pelaku_usaha','m_wilayah']);

        $this->load->css($this->data['theme_path'] . '/libs/bootstrap-select/css/bootstrap-select.min.css');
        $this->load->css($this->data['theme_path'] . '/libs/selectize/css/selectize.bootstrap3.css');
        $this->load->css($this->data['theme_path'] . '/libs/select2/css/select2.min.css');
        $this->load->js($this->data['theme_path'] . '/libs/bootstrap-select/js/bootstrap-select.min.js');
        $this->load->js($this->data['theme_path'] . '/libs/selectize/js/standalone/selectize.min.js');
        $this->load->js($this->data['theme_path'] . '/libs/select2/js/select2.min.js');
        $this->load->js($this->data['theme_path'] . '/libs/select2/js/i18n/id.js');
        $this->load->js($this->data['global_custom_path'] . '/js/select2-init.js');
        $this->load->js($this->data['theme_path'] . '/libs/jquery-mask-plugin/jquery.mask.min.js');
        $this->load->js($this->data['global_custom_path'] . '/js/init_mask.js');
        $this->load->js($this->data['theme_path'] . '/js/rupiah.js');

	}

	public function _init()
    {
        $this->output->set_template('backend');
	}

    public function index()
	{   
        $this->data['add_button_link'] = base_url('bidang/pelaku_usaha/add');
        $this->data['page_title'] = "Pelaku Usaha ";
        $this->data['page_description'] = "Halaman Pelaku Usaha.";
        $this->data['breadcrumbs'] = $this->breadcrumbs->show();
        $this->data['id_key'] = $this->id_key;
        $this->data['card'] = "true";
        $this->data['kec'] = $this->m_wilayah->findAll();

		$this->load->view('pelaku_usaha/v_index', $this->data);
    }

    public function add()
    {
        $this->breadcrumbs->push('Tambah', 'bidang/pelaku_usaha/add');
        $this->data['page_title'] = "Tambah Data Pelaku Usaha";
        $this->data['page_description'] = "Halaman Tambah Data Pelaku Usaha.";
        $this->data['card'] = "true";
        $this->data['breadcrumbs'] = $this->breadcrumbs->show();
        $this->data['id_key'] = $this->id_key;
        $this->data['kecamatan'] = $this->m_wilayah->findAll();

        $this->load->view('pelaku_usaha/v_add', $this->data);
    }

    public function edit($id = null)
    {        
        $id = decrypt_url($id, $this->id_key);
		
		if ($id == FALSE) {
			$this->load->view('errors/html/error_bootbox.php', array('message' => 'ID yang tertera tidak terdaftar', 'redirect_link' => base_url('bidang/pelaku_usaha')));
        }

        $this->breadcrumbs->push('Edit', 'bidang/pelaku_usaha/edit');
        $this->data['page_title'] = "Edit Data Pelaku Usaha";
        $this->data['page_description'] = "Halaman Edit Data Pelaku Usaha.";
        $this->data['card'] = "true";
        $this->data['breadcrumbs'] = $this->breadcrumbs->show();
        $this->data['id_key'] = $this->id_key;
        $this->data['id'] = $id;


        $this->load->view('pelaku_usaha/v_edit', $this->data);
    }

    public function AjaxGet($id = NULL)
    {
        $this->output->unset_template();

        $id = decrypt_url($id, $this->id_key);

        if ($id == FALSE) {
            $this->m_pelaku_usaha->push_select('status');

            $edit_link = 'bidang/pelaku_usaha/edit/';
            $response = $this->m_pelaku_usaha->get_all_pelaku_usaha()->datatables();

            if (decrypt_url($this->input->post('filter_kec'), $this->id_key) == FALSE) {
                $response->where('kecamatan_id', 0);
            } else {
                if (decrypt_url($this->input->post('filter_komoditas'), $this->id_key) !== 'ALL') {
                    $response->where('kecamatan_id', decrypt_url($this->input->post('filter_kec'), $this->id_key));
                }
            }

            if (decrypt_url($this->input->post('filter_bid'), $this->id_key) == FALSE) {
                $response->where('bidang', 0);
            } else {
                if (decrypt_url($this->input->post('filter_bid'), $this->id_key) !== 'ALL') {
                    $response->where('bidang', decrypt_url($this->input->post('filter_bid'), $this->id_key));
                }
            }

            $response->edit_column('id', '$1', "encrypt_url(id,' ', $this->id_key)");
            $response->edit_column('status', '$1', "str_status(status)");
            $response->edit_column('skala', '$1', "skala(skala)");
            $response->edit_column('telp', '$1', "two_row(telp,'fe-phone-call text-success mr-1', email,'fe-at-sign text-danger mr-1')");
            $response->edit_column('jumlah', '$1', "two_row(jumlah_karyawan,'fe-users text-success mr-1', skala)");
            $response->add_column('aksi', '$1 $2 $3', "tabel_icon(id,' ','edit','$edit_link ', $this->id_key, ' '),
                                                    tabel_icon(id,' ','delete',' ', $this->id_key),
                                                    active_status(id,' ',status,$this->id_key,' ')");
            $response->edit_column('kecamatan_id', '$1', "encrypt_url(kecamatan_id,' ', $this->id_key)");


            $response = $this->m_pelaku_usaha->datatables(true);
    
            $this->output->set_output($response);
        } else {
            $this->return = $this->m_pelaku_usaha->get_all_pelaku_usaha()->find($id); 

            if ($this->return !== FALSE) {
                unset($this->return->id);

                $this->return->kecamatan_id = encrypt_url($this->return->kecamatan_id, 'app');
                $this->return->skala = encrypt_url($this->return->skala, $this->id_key);
                $this->return->bidang = encrypt_url($this->return->bidang, $this->id_key);

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
        $captcha_score = get_recapture_score($this->input->post('pl-token-response'));  

        if ($captcha_score < RECAPTCHA_ACCEPTABLE_SPAM_SCORE) {
            $this->result = array(
                'status' => FALSE,
                'message' => '<span class="text-danger"><i class="mdi mdi-alert"></i> Request yang anda jalankan dianggap SPAM oleh sistem.</span>'
            );
        } else {
            
            $this->form_validation->set_rules('kecamatan', 'Kecamatan', 'required');
            $this->form_validation->set_rules('pelaku', 'Nama Pelaku Usaha', 'required');
            $this->form_validation->set_rules('email', 'Email', 'required');
            $this->form_validation->set_rules('telp', 'No Telephone', 'required');
            $this->form_validation->set_rules('alamat', 'Alamat', 'required');
            $this->form_validation->set_rules('jum', 'Jumlah Karyawan', 'required');
            $this->form_validation->set_error_delimiters(error_delimeter(1), error_delimeter(2));

            if ($this->form_validation->run() == TRUE) {

                if ($id == FALSE) {
                    $id = null;
                    $this->m_pelaku_usaha->push_to_data('status', '1');
                }
                    $kecamatan = decrypt_url($this->input->post('kecamatan'), 'app');
                    $telp = preg_replace("/[^0-9]/", "", $this->input->post('telp'));

                    $this->m_pelaku_usaha->push_to_data('nama_pelaku', $this->input->post('pelaku'))
                        ->push_to_data('email', $this->input->post('email'))
                        ->push_to_data('telp', $telp)
                        ->push_to_data('jumlah_karyawan', $this->input->post('jum'))
                        ->push_to_data('alamat', $this->input->post('alamat'))
                        ->push_to_data('skala', decrypt_url($this->input->post('skala'), $this->id_key))
                        ->push_to_data('bidang', decrypt_url($this->input->post('bidang'), $this->id_key))
                        ->push_to_data('kecamatan_id', $kecamatan);

            
                $this->return = $this->m_pelaku_usaha->save($id);

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
            $this->return = $this->m_pelaku_usaha->delete($id);

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
            $this->m_pelaku_usaha->push_select('status');

            $check = $this->m_pelaku_usaha->find($id);

            if ($check !== FALSE) {
                if ($check->status == 0) {
                    $this->m_pelaku_usaha->push_to_data('status', '1');
                } else {
                    $this->m_pelaku_usaha->push_to_data('status', '0');
                }

                $this->return = $this->m_pelaku_usaha->save($id);

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

/* End of file Pelaku_usaha.php */
