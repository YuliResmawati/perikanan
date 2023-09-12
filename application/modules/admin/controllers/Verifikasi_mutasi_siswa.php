<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Verifikasi_mutasi_siswa extends Backend_Controller {

    public function __construct()
	{
		parent::__construct();

		$this->_init();
		$this->data['uri_mod'] = 'admin/verifikasi_mutasi_siswa';
        $this->id_key = $this->private_key;
        $this->breadcrumbs->push('Verifikasi Mutasi Siswa', 'admin/verifikasi_mutasi_siswa');
        $this->modal_name = 'modal-verifikasi-mutasi';
        $this->load->model(['m_mutasi_siswa','m_sekolah','m_guru']);

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
        $this->data['page_title'] = "Data Mutasi Siswa";
        $this->data['page_description'] = "Halaman Daftar Data Mutasi Siswa.";
        $this->data['card'] = "true";
        $this->data['breadcrumbs'] = $this->breadcrumbs->show();
        $this->data['form_name'] = "form-verifikasi-siswa";
        $this->data['modal_name'] = $this->modal_name;
        
		$this->load->view('verifikasi_mutasi_siswa/v_index', $this->data);
    }
    

    public function AjaxGet($id = NULL)
    {
        $this->output->unset_template();

        $id = decrypt_url($id, $this->id_key);

        if ($id == FALSE) {
            $this->m_mutasi_siswa->push_select('status');

            $edit_link = 'admin/mutasi_siswa/edit/'; 
            $response = $this->m_mutasi_siswa->get_detail_mutasi_siswa()->datatables();

            $response->edit_column('id', '$1', "encrypt_url(id,' ', $this->id_key)");  
            $response->edit_column('nama', '$1', "two_row(nama_siswa,'fe-user text-danger mr-1', nisn,' fe-clipboard text-success mr-1')");
            $response->edit_column('link', '$1', "btn_link(link)");
            $response->edit_column('awal', '$1', "two_row(sekolah_awal,'fe-home text-info mr-1', rombel_awal,' fe-book text-warning mr-1')");
            $response->edit_column('tujuan', '$1', "two_row(sekolah_tujuan,'fe-home text-info mr-1', rombel_tujuan,' fe-book text-warning mr-1')");
            $response->edit_column('status', '$1', "str_status_mutasi(status)");  
            $response->add_column('aksi', '$1', "btn_verifikasi_mutasi(id,' ',status,$this->id_key,' ',$this->modal_name)");
            
            $response = $this->m_mutasi_siswa->datatables(true);
    
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

    public function AjaxTerima($id = null)
    {
        $this->output->unset_template();

        $id = decrypt_url($id, $this->id_key);

        if ($id !== FALSE) {
            $this->m_mutasi_siswa->push_select('status');

            $check = $this->m_mutasi_siswa->find($id);
            $siswa_id = $check->siswa_id;
            $rombel_id = $check->detail_rombel_tujuan_id;

            if ($check !== FALSE) {
                if ($check->status == 0) {

                    $this->m_mutasi_siswa->push_to_data('status', '1');
                    
                    $data = array(
                        'detail_rombel_id' => $rombel_id
                    );

                } else {
                    $this->m_mutasi_siswa->push_to_data('status', '0');
                }

                $this->return = $this->m_mutasi_siswa->save($id);

                if ($this->return) {

                    $this->db->where('siswa_id', $siswa_id);
                    $this->db->update('detail_siswa', $data);

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
            $this->form_validation->set_rules('keterangan', 'Keterangan', 'required');
            $this->form_validation->set_error_delimiters(error_delimeter(1), error_delimeter(2));
        
            if ($this->form_validation->run() == TRUE) {
                if ($id == FALSE) {
                    $id = null;
                }

                $this->m_mutasi_siswa->push_to_data('alasan', $this->input->post('keterangan'))
                    ->push_to_data('status', '2');

                $this->return = $this->m_mutasi_siswa->save($id);

                if ($this->return) {
                    $this->result = array(
                        'status' => TRUE,
                        'message' => '<span class="text-success"><i class="mdi mdi-check"></i> Data berhasil ditolak.</span>'
                    );
                } else {
                    $this->result = array(
                        'status' => FALSE,
                        'message' => '<span class="text-danger"><i class="mdi mdi-alert"></i> Data gagal ditolak.</span>'
                    );
                }
            } else {
                $this->result = array(
                    'status' => FALSE,
                    'message' => validation_errors()
                );
            }
        } else {
            $this->result = array(
                'status'   => FALSE,
                'message' => '<span class="text-danger"><i class="mdi mdi-alert"></i> ID tidak valid.</span>'
            );
        }

        if ($this->result) {
            $this->output->set_output(json_encode($this->result));
        } else {
            $this->output->set_output(json_encode(['status'=> FALSE, 'message'=> 'Gagal mengambil data.']));
        }
    }
}

/* End of file Sample_upload.php */
