<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Wilayah extends Backend_Controller {

    public function __construct()
	{
		parent::__construct();

		$this->_init();
		$this->data['uri_mod'] = 'admin/wilayah';
        $this->id_key = $this->private_key;
        $this->breadcrumbs->push('Kecamatan', 'admin/wilayah');
        $this->load->model([
            'm_users','m_wilayah'
        ]);
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
        // $this->data['add_button_link'] = base_url('admin/users/add');
        $this->data['page_title'] = "Data Kecamatan";
        $this->data['page_description'] = "Halaman Daftar Data Kecamatan.";
        $this->data['card'] = "true";
        $this->data['breadcrumbs'] = $this->breadcrumbs->show();
        
		$this->load->view('wilayah/v_index', $this->data);
    }

    public function AjaxGet($id = NULL)
    {
        $this->output->unset_template();

        $id = decrypt_url($id, $this->id_key);

        if ($id == FALSE) {
            $this->m_wilayah->push_select('status');

            $response = $this->m_wilayah->get_kecamatan()->datatables();
            $response->order_by('id', 'ASC');
            $response->edit_column('kode', '$1', "encrypt_url(id,' ', $this->id_key)");
            $response->add_column('id', '$1',"id");
            $response->edit_column('status', '$1', "str_status(status)");
            
            $response = $this->m_wilayah->get_kecamatan()->datatables(true);
    
            $this->output->set_output($response);
        } else { 
            show_404();
        }

        return $this->output->set_output($response);
    }

}

/* End of file Wilayah.php */
