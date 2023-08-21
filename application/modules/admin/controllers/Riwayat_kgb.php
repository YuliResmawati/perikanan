<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Riwayat_kgb extends Backend_Controller {

    public function __construct()
	{
		parent::__construct();

		$this->_init();
		$this->data['uri_mod'] = 'admin/riwayat_kgb';
        $this->id_key = $this->private_key;
        $this->breadcrumbs->push('Riwayat KGB', 'admin/riwayat_kgb');
        $this->load->model(['m_riwayat_kgb','m_sekolah','m_guru']);

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
        // $this->data['add_button_link'] = base_url('operator/verifikasi_mutasi_guru/add');
        $this->data['page_title'] = "Data Riwayat KGB";
        $this->data['page_description'] = "Halaman Daftar Data Riwayat KGB.";
        $this->data['card'] = "true";
        $this->data['breadcrumbs'] = $this->breadcrumbs->show();
        $this->data['id_key'] = $this->id_key;
        $this->data['tipe_sekolah'] = $this->m_sekolah->get_distinct_tipe()->findAll();
        $this->data['sekolah'] = $this->m_sekolah->get_all_sekolah()->findAll();
        if($this->logged_level == "3"){
            $this->data['guru'] = $this->m_guru->get_guru_by_sekolah($this->logged_sekolah_id)->findAll();
        }

		$this->load->view('riwayat_kgb/v_index', $this->data);
    }
    

    public function AjaxGet($id = NULL)
    {
        $this->output->unset_template();

        $id = decrypt_url($id, $this->id_key);

        if ($id == FALSE) {
            $this->m_riwayat_kgb->push_select('status');
            $response = $this->m_riwayat_kgb->get_riwayat_kgb()->datatables();

            if($this->logged_level !== "3"){
                if ($this->input->post('filter_tipe_sekolah') == FALSE) {
                    $response->where('riwayat_kgb.id', 0);
                } else {
                    if ($this->input->post('filter_tipe_sekolah') !== 'ALL') {
                        $response->where('tipe_sekolah', $this->input->post('filter_tipe_sekolah'));
                    }
                }

                if ($this->input->post('filter_sekolah') == FALSE) {
                    $response->where('riwayat_kgb.id', 0);
                } else {
                    if ($this->input->post('filter_sekolah') !== 'ALL') {
                        $response->where('sekolah_id', decrypt_url($this->input->post('filter_sekolah'), 'app'));
                    }
                }

                if ($this->input->post('filter_guru') == FALSE) {
                    $response->where('riwayat_kgb.id', 0);
                } else {
                    if ($this->input->post('filter_guru') !== 'ALL') {
                        $response->where('guru_id', decrypt_url($this->input->post('filter_guru'), 'app'));
                    }
                }

            }else{
                if ($this->input->post('filter_guru') == FALSE) {
                    $response->where('riwayat_kgb.id', 0);
                } else {
                    if ($this->input->post('filter_guru') !== 'ALL') {
                        $response->where('guru_id', decrypt_url($this->input->post('filter_guru'), $this->id_key));
                    }
                }
                $response->where('sekolah_id', $this->logged_sekolah_id);
            }


            $response->edit_column('id', '$1', "encrypt_url(id,' ', $this->id_key)");  
            $response->edit_column('nama', '$1', "two_row(nama_guru,'fe-user text-danger mr-1', nip,' fe-clipboard text-success mr-1')");
            $response->edit_column('sekolah', '$1', "two_row(nama_sekolah,'fe-user text-danger mr-1', npsn,' fe-clipboard text-success mr-1')");
            $response->edit_column('status_', '$1', "status_kgb(status_kgb)");   
            $response->edit_column('jk', '$1', "jeniskelamin(jenis_kelamin)");   
            $response->edit_column('tanggal', '$1', "tgl(tmt_awal)");
            $response->edit_column('berkas', '$1', "str_file_datatables(berkas, kgb/)"); 
            
            $response = $this->m_riwayat_kgb->datatables(true);
    
            $this->output->set_output($response);
        }

        return $this->output->set_output($response);
    }

}

/* End of file Sample_upload.php */
