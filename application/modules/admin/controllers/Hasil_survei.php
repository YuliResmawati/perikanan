<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Hasil_survei extends Backend_Controller {

    public function __construct()
	{
		parent::__construct();

		$this->_init();
		$this->data['uri_mod'] = 'admin/hasil_survei';
        $this->id_key = $this->private_key;
        $this->breadcrumbs->push('Hasil Survei', 'hasil_survei');
        $this->load->model(array('m_skm'));  

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
        $this->data['add_button_link'] = base_url('admin/hasil_survei/add');
        $this->data['page_title'] = "Data Hasil Survei";
        $this->data['page_description'] = "Halaman Daftar Data Hasil Survei.";
        $this->data['card'] = "true";
        $this->data['id_key'] = $this->id_key;
        $this->data['add_button_link'] = false;
        $this->data['breadcrumbs'] = $this->breadcrumbs->show();
        
		$this->load->view('hasil_survei/v_index', $this->data);
    }

    public function AjaxGet($id = NULL)
    {
        $this->output->unset_template();

        $id = decrypt_url($id, $this->id_key);
        $tgl_awal = $this->input->post('filter_awal');
        $tgl_akhir = $this->input->post('filter_akhir');
        $this->m_skm->push_select('status');

        $response = $this->m_skm->datatables();

        if ($this->input->post('filter_awal') !== FALSE && $this->input->post('filter_akhir') !== FALSE) {
            if ($this->input->post('filter_awal') !== '' && $this->input->post('filter_akhir') !== '') {
                $response->where(["TO_CHAR(created_at, 'YYYY-MM-DD') >=" => $tgl_awal, "TO_CHAR(created_at, 'YYYY-MM-DD') <=" => $tgl_akhir]);
            }else{
                $response->where('id', 0);
            }
        }else{
            $response->where('id', 0);
        }

        $response->edit_column('id', '$1', "encrypt_url(id,' ', $this->id_key)");   
        $response->edit_column('age', '$1', "age(age)");
        $response->edit_column('gender', '$1', "jenisKelamin_angka(gender)");
        $response->edit_column('education', '$1', "pendidikan(education)");
        $response->edit_column('phone_number', '$1', "phone_number(phone_number)");
         
        $response = $this->m_skm->datatables(true);

        $this->output->set_output($response);

        return $this->output->set_output($response);
    }
}

/* End of file Sample_upload.php */
