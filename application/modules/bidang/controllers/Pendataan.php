<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pendataan extends Backend_Controller {

    public function __construct()
	{
		parent::__construct();

		$this->_init();
		$this->data['uri_mod'] = 'bidang/pendataan';
        $this->id_key = $this->private_key;
        $this->breadcrumbs->push('Pendataan Unit Usaha', 'pendataan'); 
        $this->load->model(['m_kusioner','m_pendataan','m_pelaku_usaha','m_wilayah']);
        
        $this->load->css($this->data['theme_path'] . '/libs/bootstrap-select/css/bootstrap-select.min.css');
        $this->load->js($this->data['theme_path'] . '/libs/bootstrap-select/js/bootstrap-select.min.js');
        $this->load->css($this->data['theme_path'] . '/libs/select2/css/select2.min.css');
        $this->load->js($this->data['theme_path'] . '/libs/select2/js/select2.min.js');
        $this->load->js($this->data['theme_path'] . '/libs/select2/js/i18n/id.js');
        $this->load->js($this->data['global_custom_path'] . '/js/select2-init.js');
        $this->load->js($this->data['global_custom_path'] . '/js/init_mask.js');

	}

	public function _init()
    {
        $this->output->set_template('backend');
	}

    public function index()
	{   
        
        $this->data['add_button_link'] = base_url('bidang/pendataan/add');
        $this->data['page_title'] = "Pendataan";
        $this->data['page_description'] = "Halaman Data Pendataan Unit Usaha.";
        $this->data['breadcrumbs'] = $this->breadcrumbs->show();
        $this->data['id_key'] = $this->id_key;
        $this->data['card'] = "true";
        $this->data['kecamatan'] = $this->m_wilayah->findAll();

		$this->load->view('pendataan/v_index', $this->data);
    }

    public function index_pelaku($id = null)
	{   
        $id = decrypt_url($id, $this->id_key);

        $this->data['add_button_link'] = base_url('bidang/pendataan/add').encrypt_url($id, $this->id_key);;
        $this->data['page_title'] = "Pendataan";
        $this->data['page_description'] = "Halaman Data Pendataan Unit Usaha.";
        $this->data['breadcrumbs'] = $this->breadcrumbs->show();
        $this->data['id_key'] = $this->id_key;
        $this->data['card'] = "true";
        $this->data['id'] = $id;

		$this->load->view('pendataan/v_index_pelaku', $this->data);
    }

    public function index_kusioner($id = null)
	{   
        $id = decrypt_url($id, $this->id_key);

        $this->data['add_button_link'] = base_url('bidang/pendataan/add_kusioner/').encrypt_url($id, $this->id_key);
        $this->data['page_title'] = "Pendataan Unit Usaha";
        $this->data['page_description'] = "Halaman Data Kuesioner.";
        $this->data['breadcrumbs'] = $this->breadcrumbs->show();
        $this->data['card'] = "true";
        $this->data['id_key'] = $this->id_key;
        $this->data['id'] = $id;

		$this->load->view('pendataan/v_index_kusioner', $this->data);
    }

    public function add_kusioner($id = null)
	{   
        $id = decrypt_url($id, $this->id_key);

        $this->breadcrumbs->push('Tambah', 'bidang/pendataan/add');
        $this->data['page_title'] = "Pendataan Unit Usaha";
        $this->data['page_description'] = "Halaman Data Kuesioner.";
        $this->data['breadcrumbs'] = $this->breadcrumbs->show();
        $this->data['header_title'] = 'none';
        $this->data['id_key'] = $this->id_key;
        $this->data['id'] = $id;
        $this->data['kusioner'] = $this->m_kusioner->where(['type' => $id])->findAll();

		$this->load->view('pendataan/v_add_kusioner', $this->data);
    }

    public function AjaxGet($id = NULL)
    {
        $this->output->unset_template();

        $id = decrypt_url($id, $this->id_key);

        if ($id == FALSE) {
            $this->m_wilayah->push_select('status');
            $pelaku ='bidang/pendataan/index_pelaku/';
            $this->db->order_by('id', 'ASC');
            $response = $this->m_wilayah->get_all_pelaku()->datatables();
            $response->edit_column('id', '$1', "encrypt_url(id,' ', $this->id_key)");
            $response->edit_column('status', '$1', "str_status(status)");
            $response->add_column('aksi', '$1',"tabel_icon(id,' ','detail','$pelaku', $this->id_key)");
            
            $response = $this->m_wilayah->datatables(true);
    
            $this->output->set_output($response);
        } else {
            $this->m_pelaku_usaha->push_select('status');
            $kusioner ='bidang/pendataan/index_kusioner/';
            $response = $this->m_pelaku_usaha->get_all_pelaku_usaha()->where(['kecamatan_id' => $id])->datatables();

            $response->edit_column('id', '$1', "encrypt_url(id,' ', $this->id_key)");
            $response->edit_column('status', '$1', "str_status(status)");
            $response->edit_column('bidang', '$1', "jenis_kusioner(bidang)");
            $response->add_column('aksi', '$1',"tabel_icon(id,' ','child','$kusioner', $this->id_key)");
            
            $response = $this->m_pelaku_usaha->datatables(true);
    
            $this->output->set_output($response);
        }

        return $this->output->set_output($response);
    }

    public function AjaxGetKusioner($id = null)
    {
        $this->output->unset_template();

        $id = decrypt_url($id, $this->id_key);

        if ($id != FALSE) {
            $this->m_pendataan->push_select('status');
            $edit_link = 'bidang/pelaku_usaha/edit/';
            $response = $this->m_pendataan->get_all_pendataan()->where(['pelaku_usaha_id' => $id])->datatables();

            $response->edit_column('id', '$1', "encrypt_url(id,' ', $this->id_key)");
            $response->edit_column('status', '$1', "str_status(status)");
            $response->edit_column('opsi', '$1', "opsi(opsi)");
            $response->add_column('aksi', '$1 $2', "tabel_icon(id,' ','edit','$edit_link ', $this->id_key, ' '),
                                        tabel_icon(id,' ','delete',' ', $this->id_key)");
            
            $response = $this->m_pendataan->datatables(true);
    
            $this->output->set_output($response);
        } else {
            show_404();
        }

        return $this->output->set_output($response);
    }
    

    public function AjaxSave($id = null)
    {
        $this->output->unset_template();

        $id = decrypt_url($id, $this->id_key);
        $captcha_score = get_recapture_score($this->input->post('pd-token-response'));  

        if ($captcha_score < RECAPTCHA_ACCEPTABLE_SPAM_SCORE) {
            $this->result = array(
                'status' => FALSE,
                'message' => '<span class="text-danger"><i class="mdi mdi-alert"></i> Request yang anda jalankan dianggap SPAM oleh sistem.</span>'
            );
        } else {
            
            $this->form_validation->set_rules('opsi[]', 'Jawaban', 'required');
            $this->form_validation->set_error_delimiters(error_delimeter(1), error_delimeter(2));

            if ($this->form_validation->run() == TRUE) {

                if ($id == FALSE) {
                    $id = null;
                    $this->m_pendataan->push_to_data('status', '1');
                }
                    $kusioner = $this->input->post('kusioner[]'); 
                    $opsi = $this->input->post('opsi'); 
                    $data = array();

                    $index=0;
                    foreach ($kusioner as $index => $row) {
                        $data[] = array(
                            'kusioner_id' => decrypt_url($row, $this->id_key),
                            'nama_petugas' => $this->input->post('petugas'),
                            'komoditas_id' => decrypt_url($this->input->post('komoditas_id'), 'app'),
                            'pelaku_usaha_id' => $id,
                            'opsi' => $opsi[$index],
                            'status' => '1'
                        );
                    }
                $this->return = $this->m_pendataan->save_batch($data);

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
            $this->return = $this->m_pendataan->delete($id);

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

/* End of file Pendataan.php */
