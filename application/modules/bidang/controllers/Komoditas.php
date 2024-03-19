<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Komoditas extends Backend_Controller {

    public function __construct()
	{
		parent::__construct();

		$this->_init();
		$this->data['uri_mod'] = 'bidang/komoditas';
        $this->id_key = $this->private_key;
        $this->breadcrumbs->push('Komoditas', 'komoditas');
        $this->modal_name = 'modal-komoditas';
        $this->load->model(['m_komoditas']);
        
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
        if ($this->logged_level != '7') {
            $this->data['add_button_link'] = base_url('bidang/komoditas/add');
        }
        $this->data['page_title'] = "Komoditas";
        $this->data['page_description'] = "Halaman Data Komoditas.";
        $this->data['breadcrumbs'] = $this->breadcrumbs->show();
        $this->data['id_key'] = $this->id_key;
        $this->data['card'] = "true";
        $this->data['form_name'] = "form-komoditas";
        $this->data['modal_name'] = $this->modal_name;

		$this->load->view('komoditas/v_index', $this->data);
    }

    public function AjaxGet($id = NULL)
    {
        $this->output->unset_template();

        $id = decrypt_url($id, $this->id_key);

        if ($id == FALSE) {
            $this->m_komoditas->push_select('status');

            if ($this->logged_level == '3') {
                $response = $this->m_komoditas->where(['jenis' => '3'])->datatables();
            } else if ($this->logged_level == '5') {
                $response = $this->m_komoditas->where(['jenis' => '4'])->datatables();
            } else {
                $response = $this->m_komoditas->datatables();

                if (decrypt_url($this->input->post('filter_jenis'), $this->id_key) == FALSE) {
                    $response->where('jenis', 0);
                } else {
                    if (decrypt_url($this->input->post('filter_jenis'), $this->id_key) !== 'ALL') {
                        $response->where('jenis', decrypt_url($this->input->post('filter_jenis'), $this->id_key));
                    }
                }
            }

            $response->edit_column('id', '$1', "encrypt_url(id,' ', $this->id_key)");
            $response->edit_column('status', '$1', "str_status(status)");
            $response->edit_column('jenis', '$1', "jenis_komoditas(jenis)");
            $response->add_column('aksi', '$1 $2', "tabel_icon_komoditas(id,' ','edit',' ', $this->id_key, $this->modal_name,' ', $this->logged_level ),
                                                    tabel_icon_komoditas(id,' ','delete',' ', $this->id_key,' ',' ', $this->logged_level)");
            
            $response = $this->m_komoditas->datatables(true);
    
            $this->output->set_output($response);
        } else {
            $this->return = $this->m_komoditas->find($id); 

            if ($this->return !== FALSE) {
                unset($this->return->id);
                
                $this->return->jenis= encrypt_url(($this->return->jenis), $this->id_key);

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

    public function AjaxSave($id = null)
    {
        $this->output->unset_template();
        $captcha_score = get_recapture_score($this->input->post('km-token-response'));  

        if ($captcha_score < RECAPTCHA_ACCEPTABLE_SPAM_SCORE) {
            $this->result = array(
                'status' => FALSE,
                'message' => '<span class="text-danger"><i class="mdi mdi-alert"></i> Request yang anda jalankan dianggap SPAM oleh sistem.</span>'
            );
        } else {
            $this->result = array('status' => TRUE, 'message' => NULL);

            $_id = decrypt_url($this->input->post('data-id'), $this->id_key);
            $id = ($_id !== FALSE) ? $_id : null;

            $this->form_validation->set_rules('komoditas', 'Komoditas', 'required'); 


            $this->form_validation->set_error_delimiters(error_delimeter(1), error_delimeter(2));

            if ($this->form_validation->run() == TRUE) {  

                if ($id == FALSE) {
                    $this->m_komoditas->push_to_data('status', '1');
                }

                if ($this->logged_level == '3'){
                    $jenis = '3';
                }else if ($this->logged_level == '5'){
                    $jenis = '4';
                } else {
                    $jenis = decrypt_url($this->input->post('jenis'), $this->id_key);
                }

                $this->m_komoditas->push_to_data('komoditas', $this->input->post('komoditas'))
                    ->push_to_data('jenis', $jenis);


                if ($this->result['status'] !== FALSE) {

                    $this->return =  $this->m_komoditas->save($id);

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
            $this->return = $this->m_komoditas->delete($id);

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
            $this->m_komoditas->push_select('status');

            $check = $this->m_komoditas->find($id);

            if ($check !== FALSE) {
                if ($check->status == 0) {
                    $this->m_komoditas->push_to_data('status', '1');
                } else {
                    $this->m_komoditas->push_to_data('status', '0');
                }

                $this->return = $this->m_komoditas->save($id);

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

/* End of file komoditas.php */
