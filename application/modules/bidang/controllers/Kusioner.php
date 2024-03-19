<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Kusioner extends Backend_Controller {

    public function __construct()
	{
		parent::__construct();

		$this->_init();
		$this->data['uri_mod'] = 'bidang/kusioner';
        $this->id_key = $this->private_key;
        $this->breadcrumbs->push('kuesioner ', 'kusioner');
        $this->modal_name = 'modal-kusioner';
        $this->load->model(['m_kusioner']);
        
        $this->load->css($this->data['theme_path'] . '/libs/bootstrap-select/css/bootstrap-select.min.css');
        $this->load->css($this->data['theme_path'] . '/libs/selectize/css/selectize.bootstrap3.css');
        $this->load->css($this->data['theme_path'] . '/libs/select2/css/select2.min.css');
        $this->load->js($this->data['theme_path'] . '/libs/bootstrap-select/js/bootstrap-select.min.js');
        $this->load->js($this->data['theme_path'] . '/libs/selectize/js/standalone/selectize.min.js');
        $this->load->js($this->data['theme_path'] . '/libs/select2/js/select2.min.js');
        $this->load->js($this->data['theme_path'] . '/libs/select2/js/i18n/id.js');
        $this->load->js($this->data['global_custom_path'] . '/js/select2-init.js');

	}

	public function _init()
    {
        $this->output->set_template('backend');
	}

    public function index()
	{   
        $this->data['add_button_link'] = base_url('bidang/kusioner/add');
        $this->data['page_title'] = "Kuesioner ";
        $this->data['page_description'] = "Halaman Data Kuesioner.";
        $this->data['breadcrumbs'] = $this->breadcrumbs->show();
        $this->data['id_key'] = $this->id_key;
        $this->data['card'] = "true";
        $this->data['form_name'] = "form-kusioner";
        $this->data['modal_name'] = $this->modal_name;

		$this->load->view('kusioner/v_index', $this->data);
    }

    public function AjaxGet($id = NULL)
    {
        $this->output->unset_template();

        $id = decrypt_url($id, $this->id_key);

        if ($id == FALSE) {
            $this->m_kusioner->push_select('status');
            $response = $this->m_kusioner->datatables();

            if (decrypt_url($this->input->post('filter_jenis'), $this->id_key) == FALSE) {
                $response->where('type', 0);
            } else {
                if (decrypt_url($this->input->post('filter_jenis'), $this->id_key) !== 'ALL') {
                    $response->where('type', decrypt_url($this->input->post('filter_jenis'), $this->id_key));
                }
            }

            $response->edit_column('id', '$1', "encrypt_url(id,' ', $this->id_key)");
            $response->edit_column('status', '$1', "str_status(status)");
            $response->edit_column('jenis', '$1', "jenis_kusioner(type)");
            $response->add_column('aksi', '$1 $2 $3', "tabel_icon(id,' ','edit',' ', $this->id_key, $this->modal_name,' ', $this->logged_level ),
                                                    tabel_icon(id,' ','delete',' ', $this->id_key,' ',' ', $this->logged_level),
                                                    active_status(id,' ',status,$this->id_key,' ')");
            
            $response = $this->m_kusioner->datatables(true);
    
            $this->output->set_output($response);
        } else {
            $this->return = $this->m_kusioner->find($id); 

            if ($this->return !== FALSE) {
                unset($this->return->id);
                
                $this->return->type= encrypt_url(($this->return->type), $this->id_key);
                $this->return->jenis_opsi= encrypt_url(($this->return->jenis_opsi), $this->id_key);

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
        $captcha_score = get_recapture_score($this->input->post('ks-token-response'));  

        if ($captcha_score < RECAPTCHA_ACCEPTABLE_SPAM_SCORE) {
            $this->result = array(
                'status' => FALSE,
                'message' => '<span class="text-danger"><i class="mdi mdi-alert"></i> Request yang anda jalankan dianggap SPAM oleh sistem.</span>'
            );
        } else {
            $this->result = array('status' => TRUE, 'message' => NULL);

            $_id = decrypt_url($this->input->post('data-id'), $this->id_key);
            $id = ($_id !== FALSE) ? $_id : null;

            $this->form_validation->set_rules('jenis', 'Jenis', 'required'); 
            $this->form_validation->set_rules('kusioner', 'Kuesioner', 'required'); 


            $this->form_validation->set_error_delimiters(error_delimeter(1), error_delimeter(2));

            if ($this->form_validation->run() == TRUE) {  

                if ($id == FALSE) {
                    $this->m_kusioner->push_to_data('status', '1');
                }

                
                $jenis = decrypt_url($this->input->post('jenis'), $this->id_key);
                $jenis_opsi = decrypt_url($this->input->post('myCheck'), $this->id_key);
                if ($jenis_opsi=='1'){
                    $opsi = '1';
                }else {
                    $opsi = '0';
                }

                $this->m_kusioner->push_to_data('kusioner', $this->input->post('kusioner'))
                    ->push_to_data('type', $jenis)
                    ->push_to_data('jenis_opsi', $opsi);


                if ($this->result['status'] !== FALSE) {

                    $this->return =  $this->m_kusioner->save($id);

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
            $this->return = $this->m_kusioner->delete($id);

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
            $this->m_kusioner->push_select('status');

            $check = $this->m_kusioner->find($id);

            if ($check !== FALSE) {
                if ($check->status == 0) {
                    $this->m_kusioner->push_to_data('status', '1');
                } else {
                    $this->m_kusioner->push_to_data('status', '0');
                }

                $this->return = $this->m_kusioner->save($id);

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
