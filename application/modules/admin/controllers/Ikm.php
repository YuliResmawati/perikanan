<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Ikm extends Backend_Controller {

    public function __construct()
	{
		parent::__construct();

		$this->_init();
		$this->data['uri_mod'] = 'admin/ikm';
        $this->id_key = $this->private_key;
        $this->breadcrumbs->push('Kusioner Kepuasan Masyarakat', 'ikm');
        $this->load->model(['m_ikm', 'm_kategori_ikm', 'm_detail_ikm','m_api']);
        
        $this->load->css($this->data['theme_path'] . '/libs/bootstrap-select/css/bootstrap-select.min.css');
        $this->load->js($this->data['theme_path'] . '/libs/bootstrap-select/js/bootstrap-select.min.js');
        $this->load->css($this->data['theme_path'] . '/libs/flatpickr/flatpickr.min.css');
        $this->load->js($this->data['theme_path'] . '/libs/flatpickr/flatpickr.min.js');
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
        $this->data['add_button_link'] = base_url('admin/ikm/add');
        $this->data['page_title'] = "Kusioner Kepuasan Masyarakat";
        $this->data['page_description'] = "Halaman Kusioner Kepuasan Masyarakat.";
        $this->data['breadcrumbs'] = $this->breadcrumbs->show();
        $this->data['id_key'] = $this->id_key;
        $this->data['card'] = "true";

		$this->load->view('ikm/v_index', $this->data);
    }

    public function add()
    {
        $this->breadcrumbs->push('Tambah', 'admin/ikm/add');
        $this->data['page_title'] = "Tambah Data IKM";
        $this->data['page_description'] = "Halaman Tambah Data IKM.";
        $this->data['card'] = "true";
        $this->data['breadcrumbs'] = $this->breadcrumbs->show();
        $this->data['id_key'] = $this->id_key;
        $this->data['kategori'] = $this->m_kategori_ikm->where(['status' => '1'])->findAll();

        $this->load->view('ikm/v_add', $this->data);
    }

    public function edit($id = null)
    {        
        $id = decrypt_url($id, $this->id_key);
		
		if ($id == FALSE) {
			$this->load->view('errors/html/error_bootbox.php', array('message' => 'ID yang tertera tidak terdaftar', 'redirect_link' => base_url('admin/ikm')));
        }

        $this->breadcrumbs->push('Edit', 'admin/ikm/edit');
        $this->data['page_title'] = "Edit Data IKM";
        $this->data['page_description'] = "Halaman Edit Data IKM.";
        $this->data['card'] = "true";
        $this->data['breadcrumbs'] = $this->breadcrumbs->show();
        $this->data['id_key'] = $this->id_key;
        $this->data['id'] = $id;

        $this->load->view('ikm/v_edit', $this->data);
    }

    public function AjaxGet_($id = NULL)
    {
        $this->output->unset_template();

        $id = decrypt_url($id, $this->id_key);

        if ($id == FALSE) {
            $this->m_ikm->push_select('status');

            $response = $this->m_ikm->get_all_poin_ikm()->datatables();
            $response->order_by('nilai', 'asc');
            $response->edit_column('id', '$1', "encrypt_url(id,' ', $this->id_key)");
            $response->edit_column('status', '$1', "str_status(status)");
            $response->add_column('aksi', '$1 $2 $3', "tabel_icon(id,' ','edit',' ', $this->id_key, ''),
                                                    tabel_icon(id,' ','delete',' ', $this->id_key),
                                                    active_status(id,' ',status,$this->id_key,' ')");
            
            $response = $this->m_ikm->datatables(true);
    
            $this->output->set_output($response);
        } else {
            $this->return = $this->m_ikm->find($id); 

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

    public function AjaxGet()
    {
        $this->output->unset_template();

        $data = $this->m_api->get_data_from_api();

        $no_urut = 1;
        foreach ($data as &$row) {
            $row['id'] = $no_urut++;
            $row['aksi'] = tabel_icon($row['id'],' ','add',' ', $this->id_key, '');
        }

        $output = [
            'draw' => intval($this->input->post('draw')),
            'recordsTotal' => count($data),
            'recordsFiltered' => count($data), 
            'data' => $data,
        ];

        if (!empty($this->input->post('search')['value'])) {
            $search = $this->input->post('search')['value'];
            $filtered_data = [];
    
            foreach ($data as $row) {
                if (stripos($row['pertanyaan'], $search) !== false) {
                    $filtered_data[] = $row;
                }
            }
    
            $output['data'] = $filtered_data;
            $output['recordsFiltered'] = count($filtered_data);
        }
    
        echo json_encode($output);
    }  

    public function AjaxSave($id = null)
    {
        $this->output->unset_template();
        $captcha_score = get_recapture_score($this->input->post('ikm-token-response'));  

        if ($captcha_score < RECAPTCHA_ACCEPTABLE_SPAM_SCORE) {
            $this->result = array(
                'status' => FALSE,
                'message' => '<span class="text-danger"><i class="mdi mdi-alert"></i> Request yang anda jalankan dianggap SPAM oleh sistem.</span>'
            );
        } else {
            $this->result = array('status' => TRUE, 'message' => NULL);

            $id = decrypt_url($id, $this->id_key);

            $this->form_validation->set_rules('ikm', 'Index', 'required'); 
            $this->form_validation->set_rules('poin[]', 'Poin', 'required');


            $this->form_validation->set_error_delimiters(error_delimeter(1), error_delimeter(2));

            if ($this->form_validation->run() == TRUE) {  

                if ($id == FALSE) {
                    $this->m_ikm->push_to_data('status', '1');
                }

                $ikm_id = null;
                $save_ikm = $this->m_ikm->push_to_data('ikm', $this->input->post('ikm'))
                        ->push_to_data('status', '1')
                        ->save($ikm_id);

                $arr_poin_value_id = $this->input->post('poin[]'); 
                $_data = [];

                foreach ($arr_poin_value_id as $key => $poin_row) {
                    $_data[] = array(
                        'kategori_ikm_id' => decrypt_url($poin_row, $this->id_key),
                        'ikm_id'        => $save_ikm,
                        'status'    => '1'
                    );  
                }

                if ($this->result['status'] !== FALSE) {

                    $this->return =  $this->m_detail_ikm->save_batch($_data);

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
            $this->return = $this->m_kategori_ikm->delete($id);

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


    public function AjaxActive($id = null)
    {
        $this->output->unset_template();

        $id = decrypt_url($id, $this->id_key);

        if ($id !== FALSE) {
            $this->m_kategori_ikm->push_select('status');

            $check = $this->m_kategori_ikm->find($id);

            if ($check !== FALSE) {
                if ($check->status == 0) {
                    $this->m_kategori_ikm->push_to_data('status', '1');
                } else {
                    $this->m_kategori_ikm->push_to_data('status', '0');
                }

                $this->return = $this->m_kategori_ikm->save($id);

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


}

/* End of file Pengaturan_website.php */
