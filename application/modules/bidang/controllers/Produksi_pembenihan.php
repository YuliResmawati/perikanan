<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Produksi_pembenihan extends Backend_Controller {
    public function __construct()
	{
		parent::__construct();

		$this->_init();
		$this->data['uri_mod'] = 'bidang/produksi_pembenihan';
        $this->id_key = $this->private_key;
        $this->breadcrumbs->push('Produksi Pembenihan Ikan', 'produksi_pembenihan');
        $this->load->model(['m_produksi_pembenihan', 'm_komoditas']);

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
        $this->data['add_button_link'] = base_url('bidang/produksi_pembenihan/add');
        $this->data['page_title'] = "Produksi Pembenihan Ikan ";
        $this->data['page_description'] = "Halaman Produksi Pembenihan Ikan.";
        $this->data['breadcrumbs'] = $this->breadcrumbs->show();
        $this->data['id_key'] = $this->id_key;
        $this->data['card'] = "true";

		$this->load->view('produksi_pembenihan/v_index', $this->data);
    }

    public function add()
    {
        $this->breadcrumbs->push('Tambah', 'bidang/produksi_pembenihan/add');
        $this->data['page_title'] = "Tambah Data Produksi Pembenihan Ikan";
        $this->data['page_description'] = "Halaman Tambah Data Produksi Pembenihan Ikan.";
        $this->data['card'] = "true";
        $this->data['breadcrumbs'] = $this->breadcrumbs->show();
        $this->data['id_key'] = $this->id_key;

        $this->load->view('produksi_pembenihan/v_add', $this->data);
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

        $this->load->view('produksi_pembenihan/v_edit', $this->data);
    }

    public function AjaxGet($id = NULL)
    {
        $this->output->unset_template();

        $id = decrypt_url($id, $this->id_key);

        if ($id == FALSE) {
            $this->m_produksi_pembenihan->push_select('status');

            $edit_link = 'bidang/produksi_pembenihan/edit/';
            $response = $this->m_produksi_pembenihan->get_all_produksi_pembenihan()->datatables();

            if (decrypt_url($this->input->post('filter_jenis'), $this->id_key) == FALSE) {
                $response->where('jenis', 0);
            } else {
                if (decrypt_url($this->input->post('filter_komoditas'), $this->id_key) !== 'ALL') {
                    $response->where('jenis', decrypt_url($this->input->post('filter_jenis'), $this->id_key));
                }
            }
            
            $response->edit_column('id', '$1', "encrypt_url(id,' ', $this->id_key)");
            $response->edit_column('jenis', '$1', "jenis_komoditas(jenis)");
            $response->edit_column('komoditas', '$1', "two_row(komoditas,'fe-alert-circle text-success mr-1', jenis)");
            $response->edit_column('induk_jantan', '$1', "produksi(induk_jantan)");
            $response->edit_column('induk_betina', '$1', "produksi(induk_betina)");
            $response->edit_column('produksi', '$1', "produksi(produksi)");
            $response->add_column('aksi', '$1 $2', "tabel_icon(id,' ','edit','$edit_link ', $this->id_key, ' '),
                                                    tabel_icon(id,' ','delete',' ', $this->id_key)");
            $response->edit_column('komoditas_id', '$1', "encrypt_url(komoditas_id,' ', $this->id_key)");
            $response = $this->m_produksi_pembenihan->datatables(true);
    
            $this->output->set_output($response);
        } else {
            $this->return = $this->m_produksi_pembenihan->get_all_produksi_pembenihan()->find($id); 

            if ($this->return !== FALSE) {
                unset($this->return->id);

                $this->return->jenis = encrypt_url($this->return->jenis, 'app');
                $this->return->komoditas_id = encrypt_url($this->return->komoditas_id, 'app');

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
        $captcha_score = get_recapture_score($this->input->post('pm-token-response'));  

        if ($captcha_score < RECAPTCHA_ACCEPTABLE_SPAM_SCORE) {
            $this->result = array(
                'status' => FALSE,
                'message' => '<span class="text-danger"><i class="mdi mdi-alert"></i> Request yang anda jalankan dianggap SPAM oleh sistem.</span>'
            );
        } else {
            
            $this->form_validation->set_rules('komoditas', 'Komoditas', 'required');
            $this->form_validation->set_rules('rtp', 'RTP', 'required');
            $this->form_validation->set_rules('lahan', 'Luas Lahan', 'required');
            $this->form_validation->set_rules('jum_jantan', 'Jumlah Induk Jantan', 'required');
            $this->form_validation->set_rules('jum_betina', 'Jumlah Induk Betina', 'required');
            $this->form_validation->set_rules('produksi', 'Produksi', 'required');
            $this->form_validation->set_error_delimiters(error_delimeter(1), error_delimeter(2));

            if ($this->form_validation->run() == TRUE) {

                if ($id == FALSE) {
                    $id = null;
                    $this->m_produksi_pembenihan->push_to_data('status', '1');
                }

                    $jum_jantan = preg_replace("/[^0-9]/", "", $this->input->post('jum_jantan'));
                    $jum_betina = preg_replace("/[^0-9]/", "", $this->input->post('jum_betina'));
                    $produksi = preg_replace("/[^0-9]/", "", $this->input->post('produksi'));
                    

                    $this->m_produksi_pembenihan->push_to_data('komoditas_id', decrypt_url($this->input->post('komoditas'), 'app'))
                        ->push_to_data('rtp', $this->input->post('rtp'))
                        ->push_to_data('luas_lahan', $this->input->post('lahan'))
                        ->push_to_data('induk_jantan', $jum_jantan)
                        ->push_to_data('induk_betina', $jum_betina)
                        ->push_to_data('produksi', $produksi);

                $this->return = $this->m_produksi_pembenihan->save($id);

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
            $this->return = $this->m_produksi_pembenihan->delete($id);

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

/* End of file produksi_pembenihan.php */
