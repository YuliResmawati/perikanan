<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Verifikasi_kgb extends Backend_Controller {

    public function __construct()
	{
		parent::__construct();

		$this->_init();
		$this->data['uri_mod'] = 'admin/verifikasi_kgb';
        $this->id_key = $this->private_key;
        $this->breadcrumbs->push('Verifikasi Permohonan KGB', 'admin/verifikasi_kgb');
        $this->modal_name = 'modal-verifikasi-kgb';
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
        $this->data['page_title'] = "Data Verifikasi KGB";
        $this->data['page_description'] = "Halaman Daftar Data Verifikasi KGB.";
        $this->data['card'] = "true";
        $this->data['breadcrumbs'] = $this->breadcrumbs->show();
        $this->data['form_name'] = "form-verifikasi-kgb";
        $this->data['modal_name'] = $this->modal_name;
        $this->data['id_key'] = $this->id_key;
        $this->data['sekolah'] = $this->m_sekolah->get_all_sekolah()->findAll();
        
		$this->load->view('verifikasi_kgb/v_index', $this->data);
    }
    

    public function AjaxGet($id = NULL)
    {
        $this->output->unset_template();

        $id = decrypt_url($id, $this->id_key);

        if ($id == FALSE) {
            $this->m_riwayat_kgb->push_select('status');

            $edit_link = 'admin/mutasi_guru/edit/'; 
            $response = $this->m_riwayat_kgb->get_riwayat_kgb()->datatables();

            if ($this->input->post('filter_sekolah') == FALSE) {
                $response->where('riwayat_kgb.id', 0);
            } else {
                if ($this->input->post('filter_sekolah') !== 'ALL') {
                    $response->where('sekolah_id', decrypt_url($this->input->post('filter_sekolah'), $this->id_key));
                }
            }

            $response->where('riwayat_kgb.status', '0');


            $response->edit_column('id', '$1', "encrypt_url(id,' ', $this->id_key)");  
            $response->edit_column('nama', '$1', "two_row(nama_guru,'fe-user text-danger mr-1', nip,' fe-clipboard text-success mr-1')");
            $response->edit_column('sekolah', '$1', "two_row(nama_sekolah,'fe-user text-danger mr-1', npsn,' fe-clipboard text-success mr-1')");
            $response->edit_column('status_', '$1', "status_kgb(status_kgb)");   
            $response->edit_column('jk', '$1', "jeniskelamin(jenis_kelamin)");   
            $response->edit_column('tanggal', '$1', "tgl(tmt_awal)");
            $response->add_column('aksi', '$1', "btn_verifikasi_mutasi(id,' ',status_kgb,$this->id_key,' ',$this->modal_name)");
            
            $response = $this->m_riwayat_kgb->datatables(true);
    
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
            $this->m_riwayat_kgb->push_select('status');

            $date_now = date('Y-m-d');
            $check = $this->m_riwayat_kgb->find($id);

            $guru_id = $check->guru_id;

            if ($check !== FALSE) {
                if ($check->status == 0) {

                    $data = array(
                        'status' => '2',
                        'tmt_akhir' => $date_now
                    );

                    $this->m_riwayat_kgb->push_to_data('status', '1');
                    $this->m_riwayat_kgb->push_to_data('tmt_awal', $date_now);

                } else {
                    $this->m_riwayat_kgb->push_to_data('status', '0');
                }

                $this->db->where(['guru_id' => $guru_id, 'status' => '1']);
                $this->db->update('riwayat_kgb', $data);

                
                $this->return = $this->m_riwayat_kgb->save($id);

                if ($this->return) {

                    $this->result = array(
                        'status'   => TRUE,
                        'message' => '<span class="text-success"><i class="mdi mdi-check-decagram"></i> KGB berhasil diterima.</span>'
                    );
                } else {
                    $this->result = array(
                        'status'   => FALSE,
                        'message' => '<span class="text-danger"><i class="mdi mdi-alert"></i> KGB gagal diterima.</span>'
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

                $this->m_mutasi_guru->push_to_data('alasan', $this->input->post('keterangan'))
                    ->push_to_data('status', '2');

                $this->return = $this->m_mutasi_guru->save($id);

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
