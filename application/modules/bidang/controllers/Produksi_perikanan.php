<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Produksi_perikanan extends Backend_Controller {
    public function __construct()
	{
		parent::__construct();

		$this->_init();
		$this->data['uri_mod'] = 'bidang/produksi_perikanan';
        $this->id_key = $this->private_key;
        $this->breadcrumbs->push('Produksi Perikanan', 'produksi_perikanan');
        $this->load->model(['m_produksi_perikanan', 'm_komoditas', 'm_kamus_data']);

        $this->load->css($this->data['theme_path'] . '/libs/bootstrap-select/css/bootstrap-select.min.css');
        $this->load->css($this->data['theme_path'] . '/libs/flatpickr/flatpickr.min.css');
        $this->load->css($this->data['theme_path'] . '/libs/selectize/css/selectize.bootstrap3.css');
        $this->load->css($this->data['theme_path'] . '/libs/select2/css/select2.min.css');
        $this->load->js($this->data['theme_path'] . '/libs/flatpickr/flatpickr.min.js');
        $this->load->js($this->data['theme_path'] . '/libs/bootstrap-select/js/bootstrap-select.min.js');
        $this->load->js($this->data['theme_path'] . '/libs/selectize/js/standalone/selectize.min.js');
        $this->load->js($this->data['theme_path'] . '/libs/select2/js/select2.min.js');
        $this->load->js($this->data['theme_path'] . '/libs/select2/js/i18n/id.js');
        $this->load->js($this->data['global_custom_path'] . '/js/select2-init.js');
        $this->load->js($this->data['global_custom_path'] . '/js/init_mask.js');
        $this->load->js($this->data['theme_path'] . '/js/rupiah.js');

	}

	public function _init()
    {
        $this->output->set_template('backend');
	}

    public function index()
	{   
        $this->data['add_button_link'] = base_url('bidang/produksi_perikanan/add');
        $this->data['page_title'] = "Produksi Perikanan Tangkap";
        $this->data['page_description'] = "Halaman Produksi Perikanan Tangkap.";
        $this->data['breadcrumbs'] = $this->breadcrumbs->show();
        $this->data['id_key'] = $this->id_key;
        $this->data['card'] = "true";

		$this->load->view('produksi_perikanan/v_index', $this->data);
    }

    public function add()
    {
        $this->breadcrumbs->push('Tambah', 'bidang/produksi_perikanan/add');
        $this->data['page_title'] = "Tambah Data Produksi Perikanan";
        $this->data['page_description'] = "Halaman Tambah Data Produksi Perikanan.";
        $this->data['card'] = "true";
        $this->data['breadcrumbs'] = $this->breadcrumbs->show();
        $this->data['id_key'] = $this->id_key;
        $this->data['satuan'] = $this->m_kamus_data->get_all_satuan()->findAll();

        $this->load->view('produksi_perikanan/v_add', $this->data);
    }

    public function edit($id = null)
    {        
        $id = decrypt_url($id, $this->id_key);
		
		if ($id == FALSE) {
			$this->load->view('errors/html/error_bootbox.php', array('message' => 'ID yang tertera tidak terdaftar', 'redirect_link' => base_url('bidang/produksi_perikanan')));
        }

        $this->breadcrumbs->push('Edit', 'bidang/produksi_perikanan/edit');
        $this->data['page_title'] = "Edit Data Produksi Perikanan";
        $this->data['page_description'] = "Halaman Edit Data Produksi Perikanan.";
        $this->data['card'] = "true";
        $this->data['breadcrumbs'] = $this->breadcrumbs->show();
        $this->data['id_key'] = $this->id_key;
        $this->data['id'] = $id;
        $this->data['satuan'] = $this->m_kamus_data->get_all_satuan()->findAll();

        $this->load->view('produksi_perikanan/v_edit', $this->data);
    }

    public function AjaxGet($id = NULL)
    {
        $this->output->unset_template();

        $id = decrypt_url($id, $this->id_key);

        if ($id == FALSE) {
            $this->m_produksi_perikanan->push_select('status');

            $edit_link = 'bidang/produksi_perikanan/edit/';
            $response = $this->m_produksi_perikanan->get_all_produksi()->datatables();

            if (decrypt_url($this->input->post('filter_jenis'), $this->id_key) == FALSE) {
                $response->where('jenis', 0);
            } else {
                if (decrypt_url($this->input->post('filter_komoditas'), $this->id_key) !== 'ALL') {
                    $response->where('jenis', decrypt_url($this->input->post('filter_jenis'), $this->id_key));
                }
            }
            
            $response->edit_column('id', '$1', "encrypt_url(id,' ', $this->id_key)");
            $response->edit_column('jenis', '$1', "jenis_komoditas(jenis)");
            $response->edit_column('produksi', '$1', "jum_produksi(produksi, nama_satuan)");
            $response->edit_column('tanggal', '$1', "indo_date(created_at)");
            $response->add_column('aksi', '$1 $2', "tabel_icon(id,' ','edit','$edit_link ', $this->id_key, ' '),
                                                    tabel_icon(id,' ','delete',' ', $this->id_key)");
            $response->edit_column('komoditas_id', '$1', "encrypt_url(komoditas_id,' ', $this->id_key)");
            $response->edit_column('satuan', '$1', "encrypt_url(satuan,' ', $this->id_key)");
            
            $response = $this->m_produksi_perikanan->datatables(true);
    
            $this->output->set_output($response);
        } else {
            $this->return = $this->m_produksi_perikanan->get_all_produksi()->find($id); 

            if ($this->return !== FALSE) {
                unset($this->return->id);

                $this->return->jenis = encrypt_url($this->return->jenis, 'app');
                $this->return->komoditas_id = encrypt_url($this->return->komoditas_id, 'app');
                $this->return->satuan = ($this->return->satuan) ? encrypt_url($this->return->satuan, $this->id_key) : '';

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
        $captcha_score = get_recapture_score($this->input->post('pi-token-response'));  

        if ($captcha_score < RECAPTCHA_ACCEPTABLE_SPAM_SCORE) {
            $this->result = array(
                'status' => FALSE,
                'message' => '<span class="text-danger"><i class="mdi mdi-alert"></i> Request yang anda jalankan dianggap SPAM oleh sistem.</span>'
            );
        } else {

            $this->form_validation->set_rules('filter_komoditas[]', 'Komoditas', 'required');
            $this->form_validation->set_rules('produksi', 'Harga', 'required');
            $this->form_validation->set_rules('satuan', 'Satuan', 'required');
            $this->form_validation->set_error_delimiters(error_delimeter(1), error_delimeter(2));

            if ($this->form_validation->run() == TRUE) {

                if ($id == FALSE) {
                    $id = null;

                    $produksi = preg_replace("/[^0-9]/", "", $this->input->post('produksi'));
                    $arr_komoditas = $this->input->post('filter_komoditas[]');
                    $data = [];

                    foreach ($arr_komoditas as $key => $value) {
                        $data[] = array(
                            'komoditas_id'  => decrypt_url($value, 'app'),
                            'satuan'       => decrypt_url($this->input->post('satuan'), $this->id_key),
                            'produksi'       => $produksi,
                            'status'     => '1'
                        );  
                    }
                } 
                $this->return = $this->m_produksi_perikanan->save_batch($data);

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

    public function AjaxSaveEdit($id = null)
    {
        $this->output->unset_template();

        $id = decrypt_url($id, $this->id_key);
        $captcha_score = get_recapture_score($this->input->post('pie-token-response'));  

        if ($captcha_score < RECAPTCHA_ACCEPTABLE_SPAM_SCORE) {
            $this->result = array(
                'status' => FALSE,
                'message' => '<span class="text-danger"><i class="mdi mdi-alert"></i> Request yang anda jalankan dianggap SPAM oleh sistem.</span>'
            );
        } else {

            $this->form_validation->set_rules('komoditas', 'Komoditas', 'required');
            $this->form_validation->set_rules('produksi', 'Produksi', 'required');
            $this->form_validation->set_rules('satuan', 'Satuan', 'required');
            $this->form_validation->set_error_delimiters(error_delimeter(1), error_delimeter(2));

            if ($this->form_validation->run() == TRUE) {

                
                $produksi = preg_replace("/[^0-9]/", "", $this->input->post('produksi'));
                $komoditas = decrypt_url($this->input->post('komoditas'), 'app');
                
                $this->m_produksi_perikanan->push_to_data('satuan', decrypt_url($this->input->post('satuan'), $this->id_key))
                    ->push_to_data('produksi', $produksi)
                    ->push_to_data('komoditas_id', $komoditas);

                $this->return = $this->m_produksi_perikanan->save($id);

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
            $this->return = $this->m_produksi_perikanan->delete($id);

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

/* End of file produksi_perikanan.php */
