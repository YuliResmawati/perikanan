<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pembudidaya extends Backend_Controller {
    public function __construct()
	{
		parent::__construct();

		$this->_init();
		$this->data['uri_mod'] = 'bidang/pembudidaya';
        $this->id_key = $this->private_key;
        $this->breadcrumbs->push('Kelompok Pembudidaya', 'pembudidaya');
        $this->load->model(['m_pembudidaya','m_wilayah','m_kamus_data']);

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
        $this->data['add_button_link'] = base_url('bidang/pembudidaya/add');
        $this->data['page_title'] = "Kelompok pembudidaya Ikan ";
        $this->data['page_description'] = "Halaman Kelompok pembudidaya Ikan.";
        $this->data['breadcrumbs'] = $this->breadcrumbs->show();
        $this->data['id_key'] = $this->id_key;
        $this->data['card'] = "true";
        $this->data['kecamatan'] = $this->m_wilayah->findAll();

		$this->load->view('pembudidaya/v_index', $this->data);
    }

    public function add()
    {
        $this->breadcrumbs->push('Tambah', 'bidang/produksi_pembenihan/add');
        $this->data['page_title'] = "Tambah Data Produksi Pembenihan Ikan";
        $this->data['page_description'] = "Halaman Tambah Data Produksi Pembenihan Ikan.";
        $this->data['card'] = "true";
        $this->data['breadcrumbs'] = $this->breadcrumbs->show();
        $this->data['id_key'] = $this->id_key;
        $this->data['kecamatan'] = $this->m_wilayah->findAll();
        // $this->data['type'] = $this->m_kamus_data->where(['type' => 'type_pembudidaya'])->findAll();

        $this->load->view('pembudidaya/v_add', $this->data);
    }

    public function edit($id = null)
    {        
        $id = decrypt_url($id, $this->id_key);
		
		if ($id == FALSE) {
			$this->load->view('errors/html/error_bootbox.php', array('message' => 'ID yang tertera tidak terdaftar', 'redirect_link' => base_url('bidang/produksi_pembenihan')));
        }

        $this->breadcrumbs->push('Edit', 'bidang/produksi_pembenihan/edit');
        $this->data['page_title'] = "Edit Data Produksi Pembenihan Ikan";
        $this->data['page_description'] = "Halaman Edit Data Produksi Pembenihan Ikan.";
        $this->data['card'] = "true";
        $this->data['breadcrumbs'] = $this->breadcrumbs->show();
        $this->data['id_key'] = $this->id_key;
        $this->data['id'] = $id;
        // $this->data['type'] = $this->m_kamus_data->where(['type' => 'type_pembudidaya'])->findAll();


        $this->load->view('pembudidaya/v_edit', $this->data);
    }

    public function AjaxGet($id = NULL)
    {
        $this->output->unset_template();

        $id = decrypt_url($id, $this->id_key);

        if ($id == FALSE) {
            $this->m_pembudidaya->push_select('status');

            $edit_link = 'bidang/pembudidaya/edit/';
            $response = $this->m_pembudidaya->get_all_pembudidya()->datatables();

            $response->edit_column('id', '$1', "encrypt_url(id,' ', $this->id_key)");
            $response->edit_column('berkelompok', '$1', "produksi(berkelompok)");
            $response->edit_column('belum_berkelompok', '$1', "produksi(belum_berkelompok)");
            $response->add_column('aksi', '$1 $2', "tabel_icon(id,' ','edit','$edit_link ', $this->id_key, ' '),
                                                    tabel_icon(id,' ','delete',' ', $this->id_key)");
            $response->edit_column('kecamatan_id', '$1', "encrypt_url(kecamatan_id,' ', $this->id_key)");
            $response->edit_column('type', '$1', "encrypt_url(type,' ', $this->id_key)");


            $response = $this->m_pembudidaya->datatables(true);
    
            $this->output->set_output($response);
        } else {
            $this->return = $this->m_pembudidaya->get_all_pembudidya()->find($id); 

            if ($this->return !== FALSE) {
                unset($this->return->id);

                $this->return->kecamatan_id = encrypt_url($this->return->kecamatan_id, 'app');

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
        $captcha_score = get_recapture_score($this->input->post('pub-token-response'));  

        if ($captcha_score < RECAPTCHA_ACCEPTABLE_SPAM_SCORE) {
            $this->result = array(
                'status' => FALSE,
                'message' => '<span class="text-danger"><i class="mdi mdi-alert"></i> Request yang anda jalankan dianggap SPAM oleh sistem.</span>'
            );
        } else {
            
            $this->form_validation->set_rules('kecamatan', 'Kecamatan', 'required');
            $this->form_validation->set_rules('aktif', 'Jumlah Aktif', 'required');
            $this->form_validation->set_rules('tidak_aktif', 'Jumlah Tidak Aktif', 'required');
            $this->form_validation->set_rules('berkelompok', 'Jumlah Berkelompok', 'required');
            $this->form_validation->set_rules('non_berkelompok', 'Jumlah Belum Berkelompok', 'required');
            $this->form_validation->set_error_delimiters(error_delimeter(1), error_delimeter(2));

            if ($this->form_validation->run() == TRUE) {

                if ($id == FALSE) {
                    $id = null;
                    $this->m_pembudidaya->push_to_data('status', '1');
                }
                    $berkelompok = preg_replace("/[^0-9]/", "", $this->input->post('berkelompok'));
                    $non_berkelompok = preg_replace("/[^0-9]/", "", $this->input->post('non_berkelompok'));

                    $kecamatan = decrypt_url($this->input->post('kecamatan'), 'app');
                
                    $this->m_pembudidaya->push_to_data('aktif', $this->input->post('aktif'))
                        ->push_to_data('tidak_aktif', $this->input->post('tidak_aktif'))
                        ->push_to_data('berkelompok', $berkelompok)
                        ->push_to_data('belum_berkelompok', $non_berkelompok)
                        ->push_to_data('kecamatan_id', $kecamatan);

            
                $this->return = $this->m_pembudidaya->save($id);

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
            $this->return = $this->m_pembudidaya->delete($id);

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

/* End of file pembudidaya.php */
