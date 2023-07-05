<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Verifikasi_mutasi_guru extends Backend_Controller {

    public function __construct()
	{
		parent::__construct();

		$this->_init();
		$this->data['uri_mod'] = 'operator/verifikasi_mutasi_guru';
        $this->id_key = $this->private_key;
        $this->breadcrumbs->push('Verifikasi Mutasi Guru', 'operator/verifikasi_mutasi_guru');
        $this->load->model(['m_mutasi_guru','m_sekolah']);

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
        $this->data['page_title'] = "Data Mutasi Guru";
        $this->data['page_description'] = "Halaman Daftar Data Mutasi Guru.";
        $this->data['card'] = "true";
        $this->data['breadcrumbs'] = $this->breadcrumbs->show();
        
		$this->load->view('verifikasi_mutasi_guru/v_index', $this->data);
    }
    

    public function AjaxGet($id = NULL)
    {
        $this->output->unset_template();

        $id = decrypt_url($id, $this->id_key);

        if ($id == FALSE) {
            $this->m_mutasi_guru->push_select('status');

            $edit_link = 'operator/mutasi_guru/edit/'; 
            $response = $this->m_mutasi_guru->get_detail_mutasi_guru()->datatables();


            $response->edit_column('id', '$1', "encrypt_url(id,' ', $this->id_key)");  
            $response->edit_column('nama', '$1', "two_row(nama_guru,'fe-user text-danger mr-1', nip,' fe-clipboard text-success mr-1')");
            $response->edit_column('link', '$1', "btn_link(link)");
            $response->edit_column('status', '$1', "str_status_mutasi(status)");  
            $response->add_column('aksi', '$1', "btn_verifikasi_mutasi(id,' ',status,$this->id_key,' ',' ')");
            
            $response = $this->m_mutasi_guru->datatables(true);
    
            $this->output->set_output($response);
        } else {
            $this->return = $this->m_sekolah->find($id); 

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

    public function AjaxDel($id = null)
    {
        $this->output->unset_template();

        $id = decrypt_url($id, $this->id_key);

        if ($id !== FALSE) {
            $this->return = $this->m_sekolah->delete($id);

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

    public function AjaxTerima($id = null)
    {
        $this->output->unset_template();

        $id = decrypt_url($id, $this->id_key);

        if ($id !== FALSE) {
            $this->m_mutasi_guru->push_select('status');

            $check = $this->m_mutasi_guru->find($id);

            if ($check !== FALSE) {
                if ($check->status == 0) {
                    $this->m_mutasi_guru->push_to_data('status', '1');
                } else {
                    $this->m_mutasi_guru->push_to_data('status', '0');
                }

                $this->return = $this->m_mutasi_guru->save($id);

                if ($this->return) {
                    $this->result = array(
                        'status'   => TRUE,
                        'message' => '<span class="text-success"><i class="mdi mdi-check-decagram"></i> Mutasi berhasil diterima.</span>'
                    );
                } else {
                    $this->result = array(
                        'status'   => FALSE,
                        'message' => '<span class="text-danger"><i class="mdi mdi-alert"></i> Mutasi gagal diterima.</span>'
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

    public function AjaxTolak($id = null)
    {
        $this->output->unset_template();

        $id = decrypt_url($id, $this->id_key);

        if ($id !== FALSE) {
            $this->m_mutasi_guru->push_select('status');

            $check = $this->m_mutasi_guru->find($id);

            if ($check !== FALSE) {
                if ($check->status == 0) {
                    $this->m_mutasi_guru->push_to_data('status', '2');
                    
                } else {
                    $this->m_mutasi_guru->push_to_data('status', '0');
                }

                $this->return = $this->m_mutasi_guru->save($id);

                if ($this->return) {
                    $this->result = array(
                        'status'   => TRUE,
                        'message' => '<span class="text-success"><i class="mdi mdi-check-decagram"></i> Mutasi berhasil ditolak.</span>'
                    );
                } else {
                    $this->result = array(
                        'status'   => FALSE,
                        'message' => '<span class="text-danger"><i class="mdi mdi-alert"></i> Mutasi gagal ditolak.</span>'
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

/* End of file Sample_upload.php */