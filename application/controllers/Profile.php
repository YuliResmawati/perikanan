<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Profile extends Backend_Controller {

    public function __construct()
    {
        parent::__construct();

        $this->_init();
        $this->data['uri_mod'] = 'profile';
        $this->breadcrumbs->push('Profile Saya', 'profile');
        $this->load->model(array('m_users', 'm_token_history'));  

        $this->load->css($this->data['theme_path'] . '/libs/dropify/css/dropify.min.css');
        $this->load->css($this->data['theme_path'] . '/libs/lightbox2/src/css/lightbox.css');
        $this->load->js($this->data['theme_path'] . '/libs/jquery-mask-plugin/jquery.mask.min.js');
        $this->load->js($this->data['theme_path'] . '/libs/apexcharts/apexcharts.min.js');
        $this->load->js($this->data['theme_path'] . '/libs/dropify/js/dropify.min.js');
        $this->load->js($this->data['theme_path'] . '/libs/lightbox2/src/js/lightbox.js');
        $this->load->js($this->data['global_custom_path'] . '/js/init_mask.js');
        $this->load->js($this->data['global_custom_path'] . '/js/file-upload-init.js');
    }

   public function _init()
   {
       $this->output->set_template('backend');
   }

    public function index()
    {
        $this->data['page_title'] = "Profile Saya";
        $this->data['page_description'] = "Halaman informasi profile saya.";
        $this->data['header_title'] = 'none';
        $this->data['breadcrumbs'] = $this->breadcrumbs->show();
        
        $this->load->view('profile/v_index', $this->data);
    }

    private function upload_foto_pegawai($id)
    {
         $this->result = array('status' => TRUE, 'message' => NULL);
 
         if (!empty($this->session->userdata('simpeg_nip'))) {
             $_file_name = $this->session->userdata('simpeg_nip');
         } else {
             $_file_name = $this->session->userdata('simpeg_pegawai_id');
         }
 
         $file_name = 'FOTO_'.$_file_name;
 
         if ($this->result['status'] == TRUE) {
             $config['upload_path'] = $this->data['image_path'].'profile_picture/';
             $config['allowed_types'] = "jpg|png|jpeg|JPG|PNG";
             $config['file_name'] = $file_name;
             $config['overwrite'] = true;
             $config['max_size'] = "1024";
 
             $this->load->library('upload', $config);
         
             if (!$this->upload->do_upload('photo')) {
                 $this->result = array(
                     'status' => false,
                     'message' => $this->upload->display_errors()
                 );
             } else {
                 $data_upload = array('upload_data' => $this->upload->data());
                 $file_berkas = $data_upload['upload_data']['file_name'];
                 $file_size = $data_upload['upload_data']['file_size'];
 
                 $this->result = array(
                     'status' => true,
                     'message' => 'Upload foto berhasil',
                     'file_berkas' => $file_berkas,
                     'file_size' => $file_size
                 );
             }
         }
 
         return $this->result;
    }

    public function AjaxGet()
    {
        $this->output->unset_template();

        $mod = $this->input->get('id');

        if ($mod == "account") {
            $this->load->view('profile/v_akun', $this->data);
        } else if ($mod == "device") {
            $this->load->view('profile/v_device', $this->data);
        } else if ($this->input->post('page') == "get_devices") {
            $this->load->model('m_cookie');
			echo $this->m_cookie->get_device($this->logged_user_id);
        } else if ($this->input->post('page') == "ajax_delete_cookie") {
            $cookie = $this->input->post('cookie');
            if ($cookie !== FALSE) {
                $this->return = $this->db->update('cookie',['deleted' => 1], ['cookie' => $cookie]);
    
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
        } else if ($this->input->post('page') == "ajax_change_password") {
            if (!empty($this->input->post('silatpendidikan_username'))) {
                if ($this->input->post('silatpendidikan_username') !== $this->input->post('old_username')) {
                    $this->form_validation->set_rules('silatpendidikan_username', 'Nama Pengguna', "required|is_unique[users.username]");
                }
            }

            if (!empty($this->input->post('old_password') || $this->input->post('new_password') || $this->input->post('confirm_new_password'))) {
                $this->form_validation->set_rules('old_password', 'Kata Sandi Lama', "trim|required|password_matches[users.password.$this->logged_user_id]");
                $this->form_validation->set_rules('new_password', 'Kata Sandi Baru', "trim|required|min_length[8]|password_unique[users.password.$this->logged_user_id]");
                $this->form_validation->set_rules('confirm_new_password', 'Konfirmasi Kata Sandi Baru', 'trim|required|min_length[8]|matches[new_password]');
            }
           
            $this->form_validation->set_error_delimiters(error_delimeter(1), error_delimeter(2));

            if ($this->form_validation->run() == TRUE) {
                $new_password = $this->m_users->ghash($this->input->post('new_password'));

                if ($this->input->post('silatpendidikan_username') !== $this->input->post('old_username')) {
                    $this->session->set_userdata(array('silatpendidikan_username' => $this->input->post('silatpendidikan_username')));
                }

                if (!empty($this->input->post('new_password'))) {
                    if ($this->m_users->default_password == $this->input->post('new_password')) {
                        $this->session->set_userdata(array('silatpendidikan_is_default_password' => true));
                    } else {
                        $this->session->set_userdata(array('silatpendidikan_is_default_password' => false));
                    }

                    $this->m_users->push_to_data('password', $new_password);
                }
    
                $this->return = $this->m_users->save($this->logged_user_id);
    
                if ($this->return) {
                    $this->result = array(
                        'status' => TRUE,
                        'message' => '<span class="text-success"><i class="mdi mdi-check-decagram"></i> Data Akun berhasil dirubah.</span>'
                    );
                } else {
                    $this->result = array(
                        'status' => FALSE,
                        'message' => '<span class="text-danger"><i class="mdi mdi-alert"></i> Data Akun gagal dirubah.</span>'
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
                $this->output->set_output(json_encode(['status'=>false, 'message'=> 'Gagal mengambil data.']));
            }
        }
    }

    public function AjaxChangeProfilePicture() 
    {
        $this->output->unset_template();

        $this->result = array('status' => TRUE, 'message' => NULL);
        $id = $this->logged_pegawai_id;

        if (empty($_FILES["photo"]["name"])) {
            $_POST["photo"] = null;
            $_form = FALSE;
        } else {
            $_form = TRUE;
        }

        if ($_form == TRUE) {
            if (!empty($_FILES['photo']['name'])) {
                $data_upload = $this->upload_foto_pegawai($id);

                if ($data_upload['status'] == TRUE) {
                    $photo = $data_upload['file_berkas'];

                    if (!empty($photo)) {
                        $this->m_pegawai->push_to_data('photo', $photo);
                        $images_behaviour = TRUE;
                    }
                } else {
                    $this->result = $data_upload;
                }
            }

            if ($this->result['status'] !== FALSE) {
                $this->return = $this->m_pegawai->save($id);

                if ($this->return) {
                    if ($images_behaviour == TRUE) {
                        $this->session->set_userdata('simpeg_photo', $photo);
                    }

                    $this->result = array(
                        'status' => TRUE,
                        'message' => '<span class="text-success"><i class="mdi mdi-check-decagram"></i> Berhasil merubah foto profile.</span>'
                    );
                } else {
                    $this->result = array(
                        'status' => FALSE,
                        'message' => '<span class="text-danger"><i class="mdi mdi-alert"></i> Gagal merubah foto profile.</span>'
                    );
                }
            }
        } else {
            $this->result = array(
                'status' => FALSE,
                'message' => '<span class="text-danger"><i>*Bidang Foto Profile dibutuhkan.</i></span>'
            );
        }

        if ($this->result) {
            $this->output->set_output(json_encode($this->result));
        } else {
            $this->output->set_output(json_encode(['message'=>false, 'msg'=> 'Terjadi kesalahan.']));
        }   
    }

}

/* End of file Account.php */