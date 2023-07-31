<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Persetujuan_cuti extends Backend_Controller {

    public function __construct()
	{
		parent::__construct();

		$this->_init();
		$this->data['uri_mod'] = 'admin/persetujuan_cuti';
        $this->id_key = $this->private_key;
        $this->breadcrumbs->push('Persetujuan Cuti', 'persetujuan_cuti');
        $this->load->model(array('m_cuti','m_tahun_ajaran','m_guru','m_sekolah'));  

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
        $this->data['add_button_link'] = base_url('admin/persetujuan_cuti/add');
        $this->data['page_title'] = "Data Persetujuan Cuti";
        $this->data['page_description'] = "Halaman Daftar Data Persetujuan Cuti.";
        $this->data['card'] = "true";
        $this->data['id_key'] = $this->id_key;
        $this->data['add_button_link'] = false;
        $this->data['guru'] = $this->m_guru->get_guru_by_sekolah($this->logged_sekolah_id)->findAll();
        $this->data['sekolah'] = $this->m_sekolah->get_all_sekolah()->findAll();

        $this->data['breadcrumbs'] = $this->breadcrumbs->show();
        
		$this->load->view('persetujuan_cuti/v_index', $this->data);
    }

    public function AjaxGet($id = NULL)
    {
        $this->output->unset_template();

        $id = decrypt_url($id, $this->id_key);

        if ($id == FALSE) {
            $this->modal_name = 'modal-tolak';

            $this->m_cuti->push_select('status');

            $response = $this->m_cuti->get_all_cuti()->datatables();

            if ($this->input->post('filter_sekolah') !== FALSE) {
                if ($this->input->post('filter_sekolah') !== 'ALL') {
                    $response->where('sekolah_id', decrypt_url($this->input->post('filter_sekolah'), $this->id_key));
                }
            }

            if ($this->input->post('filter_guru') !== FALSE) {
                if ($this->input->post('filter_guru') !== 'ALL') {
                    $response->where('cuti.guru_id', decrypt_url($this->input->post('filter_guru'), $this->id_key));
                }
            }

            if ($this->input->post('filter_status') !== FALSE) {
                if ($this->input->post('filter_status') !== 'ALL') {
                    $response->where('cuti.status', decrypt_url($this->input->post('filter_status'), $this->id_key));
                }
            }

            $response->edit_column('id', '$1', "encrypt_url(id,' ', $this->id_key)");
            $response->edit_column('nama_guru', '$1', "name_degree(gelar_depan,nama_guru,gelar_belakang)");   
            $response->edit_column('tahun_ajaran', '$1', "two_row(tahun_ajaran,' ', total_cuti,'fe-alert-octagon text-warning mr-1','ket')");
            $response->edit_column('lama_cuti', '$1', "lama_cuti(tgl_awal, tgl_akhir,lama_cuti)");
            $response->edit_column('files', '$1', "str_file_datatables(files, cuti/)");
            $response->edit_column('status', '$1', "str_status_cuti(status,alasan)");
            $response->add_column('aksi', '$1 $2', "tabel_icon_cuti(id,' ','terima',' ', $this->id_key,' ',' ','status',$this->logged_level),
                                                    tabel_icon_cuti(id,' ','tolak',' ', $this->id_key,$this->modal_name,' ','status',$this->logged_level)");
            
            $response = $this->m_cuti->datatables(true);
    
            $this->output->set_output($response);
        } else {
            $this->return = $this->m_cuti->get_all_cuti()->find($id); 

            if ($this->return !== FALSE) {
                unset($this->return->id);
                $this->return->tahun_ajaran_id = ($this->return->tahun_ajaran_id) ? encrypt_url($this->return->tahun_ajaran_id, $this->id_key) : '';
                $this->return->guru_id = ($this->return->guru_id) ? encrypt_url($this->return->guru_id, $this->id_key) : '';
                $this->return->nama_guru = ($this->return->nama_guru) ? name_degree($this->return->gelar_depan,$this->return->nama_guru,$this->return->gelar_belakang) : '';

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
            $this->m_cuti->push_select('status');

            $check = $this->m_cuti->find($id);

            if ($check !== FALSE) {
                if ($check->status == 0) {
                    $this->m_cuti->push_to_data('status', '1');
                } else {
                    $this->result = array(
                        'status'   => FALSE,
                        'message' => '<span class="text-danger"><i class="mdi mdi-alert"></i> Gagal Membatalkan Pengajuan.</span>'
                    );
                }

                $this->return = $this->m_cuti->save($id);

                if ($this->return) {
                    $this->result = array(
                        'status'   => TRUE,
                        'message' => '<span class="text-success"><i class="mdi mdi-check-decagram"></i> Status berhasil dirubah.</span>'
                    );
                } else {
                    $this->result = array(
                        'status'   => FALSE,
                        'message' => '<span class="text-danger"><i class="mdi mdi-alert"></i> Status gagal dirubah.</span>'
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
        $this->result = array('status' => TRUE, 'message' => NULL);
        $id = decrypt_url($id, $this->id_key);

        $this->form_validation->set_rules('alasan', 'Alasan Penolakan', 'required');
        
        $this->form_validation->set_error_delimiters(error_delimeter(1), error_delimeter(2));

        if ($this->form_validation->run() == TRUE) {
            if ($id == FALSE) {
                $this->result = array(
                    'status' => FALSE,
                    'message' => '<span class="text-danger"><i class="mdi mdi-alert"></i> Data gagal disimpan.</span>'
                );
            }

            $this->m_cuti->push_to_data('status', '2' );
            $this->m_cuti->push_to_data('alasan', $this->input->post('alasan') );

            $this->return = $this->m_cuti->save($id);

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

/* End of file Sample_upload.php */
