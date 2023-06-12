<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_acl extends CI_Model {

	public function privilage()
	{
        $return = array(
            'status' => true,
            'error' => false,
            'error_login' => false,
            'error_json' => false,
            'message' => null
        );

		$class_name = $this->router->fetch_class();
        $function = $this->router->fetch_method();
        $login = $this->session->userdata('silatpendidikan_loggedin');
        $loged_level = $this->session->userdata('silatpendidikan_level');
        $is_default_password = $this->session->userdata('silatpendidikan_is_default_password');
        $is_acc_active = $this->session->userdata('silatpendidikan_user_active');
        $acc_deactive_reason = $this->session->userdata('silatpendidikan_deactive_reason');

        $this->db->select('id, level, type, isjson')
                ->where('controller', $class_name)
                ->where("'$function'",'any(method)', FALSE)
                ->where('status', 1);

        $acl = $this->db->get('_acl')->row();
        
        if (!empty($acl) && $acl!== FALSE) {
            $level = pg_to_array($acl->level);

            if ($acl->type !== 'frontend') {
                if ($login == true && (!empty($loged_level) && $loged_level !== 0)) {
                    if (in_array($loged_level, $level) == FALSE) {
                        $return = array(
                            'status' => FALSE,
                            'error' => TRUE,
                            'message' => 'Anda tidak dapat mengakses laman ini',
                            'error_login' => FALSE
                        );
                    }

                    if ($class_name !== 'auth') {
                        if ($return['status'] == TRUE) {
                            if ($is_acc_active == FALSE && $is_acc_active == 0 && $is_acc_active == '0') {
                                $reason = '';

                                if (!empty($acc_deactive_reason)) {
                                    $reason = 'dengan alasan '.$acc_deactive_reason;
                                }

                                $return = array(
                                    'status' => FALSE,
                                    'error' => TRUE,
                                    'message' => 'Akun telah dinonaktifkan '.$reason.' hubungi admin untuk mengaktifkan kembali.',
                                    'error_login' => FALSE,
                                    'redirect_link' => base_url('logout')
                                );
                            }
                        }
                    }

                    if (base_url() == "https://silatpendidikan.agamkab.go.id/" || base_url() == "http://silatpendidikan.agamkab.go.id/") {
                        if ($class_name !== 'auth' && $class_name !== 'introduction') {
                            if ($return['status'] == TRUE) {
                                if ($class_name !== 'profile') {
                                    if ($is_default_password == TRUE) {
                                        $return = array(
                                            'status' => FALSE,
                                            'error' => TRUE,
                                            'message' => 'Anda masih menggunakan password default. Harap ganti password anda dihalaman akun.',
                                            'error_login' => FALSE,
                                        );
            
                                        $return['redirect_link'] = base_url('profile');
                                    }
                                }
                            }
                        }
                    } 
                } else {
                    $return = array(
                        'status' => false,
                        'error' => true,
                        'message' => 'Anda belum login',
                        'error_login' => true
                    );
                }

                if ($acl->isjson == 0) {
                    $return['error_json'] = false;
                } else {
                    $return['error_json'] = true;
                }
            }
        } else {
            $return = false;
        }

        return $return;
    }
    
    public function _acl_menu($level, $menu_type = 'sidebar_menu')
	{
		$this->db->where("$level", "any(level)",false)
				 ->where('status', 1)
				 ->where('type', $menu_type)
				 ->order_by('position');
		return $this->db->get('_acl')->result();
	}

}

/* End of file M_acl.php */
/* Location: ./application/models/M_acl.php */