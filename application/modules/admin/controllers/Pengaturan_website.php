<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pengaturan_website extends Backend_Controller {

    public function __construct()
	{
		parent::__construct();

		$this->_init();
		$this->data['uri_mod'] = 'admin/pengaturan_website';
        $this->id_key = $this->private_key;
        $this->breadcrumbs->push('Pengaturan Website', 'pengaturan_website');

        $this->load->css($this->data['theme_path'] . '/libs/dropify/css/dropify.min.css');
        $this->load->css($this->data['theme_path'] . '/libs/summernote/summernote-bs4.min.css');
        $this->load->js($this->data['theme_path'] . '/libs/summernote/summernote-bs4.min.js');
        $this->load->js($this->data['theme_path'] . '/libs/summernote/lang/summernote-id-ID.min.js');
        $this->load->js($this->data['theme_path'] . '/libs/dropify/js/dropify.min.js');
        $this->load->js($this->data['global_custom_path'] . '/js/file-upload-init.js');
        $this->load->js($this->data['global_custom_path'] . '/js/myapp.notes.js');
	}

	public function _init()
    {
        $this->output->set_template('backend');
	}

    public function index()
	{
        $this->data['page_title'] = "Pengaturan Website";
        $this->data['page_description'] = "Halaman Pengaturan Website.";
        $this->data['breadcrumbs'] = $this->breadcrumbs->show();
        $this->data['website_data'] = $this->m_website->findAll();
        $this->data['id_key'] = $this->id_key;
        $this->data['card'] = "true";

		$this->load->view('pengaturan_website/v_index', $this->data);
    }

    public function AjaxSave()
    {
        $this->output->unset_template();

        $id = decrypt_url($this->input->post('id'), $this->id_key);

        $this->form_validation->set_rules('name_site', 'Nama Website', 'required');
        $this->form_validation->set_rules('about', 'Tentang', 'required');
        $this->form_validation->set_rules('visi_content', 'Visi', 'required');
        $this->form_validation->set_rules('misi_content', 'Misi', 'required');
        $this->form_validation->set_rules('profile_content', 'Profil Silat Pendidikan', 'required');
        $this->form_validation->set_rules('email', 'Email', 'required');
        $this->form_validation->set_rules('address', 'Alamat', 'required');
        $this->form_validation->set_rules('phone_number', 'No Telepon', 'required');
        $this->form_validation->set_rules('whatsapp_number', 'No WhatsApp', 'required');
        $this->form_validation->set_rules('link_facebook', 'Link Facebook', 'required');
        $this->form_validation->set_rules('link_twitter', 'Link Twitter', 'required');
        $this->form_validation->set_rules('link_instagram', 'Link Instagram', 'required');
        $this->form_validation->set_rules('link_youtube', 'Link Youtube', 'required');
        $this->form_validation->set_error_delimiters(error_delimeter(1), error_delimeter(2));

        if ($this->form_validation->run() == TRUE) {
            if ($id == FALSE) {
                $id = null;
                $this->m_website->push_to_data('status', '1');
            }

            $this->return = $this->m_website->push_to_data('visi', str_replace("'"," ", $this->input->post('visi_content')))
                ->push_to_data('misi', str_replace("'"," ", $this->input->post('misi_content')))
                ->push_to_data('profile', str_replace("'"," ", $this->input->post('profile_content')))
                ->save($id);

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

/* End of file Pengaturan_website.php */
