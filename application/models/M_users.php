<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_users extends MY_Model {

    protected $_table = 'users';
    protected $_order_by = 'id';
    protected $_order = 'DESC';
    protected $_softdelete = TRUE;
    protected $_timestamps = TRUE;
    protected $_log_user = TRUE;
    protected $_fields_toshow = ['username','password', 'email', 'display_name', 'level','pegawai_id'];
    protected $_fields = [
        'username' => 'username',
        'password' => 'password',
        'level' => 'level',
        'pegawai_id' => 'pegawai_id',
    ];

    public $default_password = "dkpp_pass";

    public function __construct()
    {
        parent::__construct();
    }

    public function _is_default_password($password){
        return password_verify($this->default_password, $password);
    }

    public function ghash($string)
    {
        $options = [
            'cost' => 12,
        ];

        return password_hash($string, PASSWORD_BCRYPT, $options);
    }

    public function _select($id)
    {
        $this->db->select('a.id, a.display_name, a.pegawai.id, a.username, a.password, a.email, a.level, a.last_login, a.last_ip_login, a.status, a.reason_disabled')
            ->from('users a')
            ->where('a.deleted', '0')
            ->where('a.id', $id)
            ->limit(1);
        
        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            return $query->row();
        } else {
            return false;
        }
    }

    public function loggedin ()
    {
	    return (bool) $this->session->userdata('dkpp_loggedin');
	}
    
    public function is_email_active($user_id)
    {
        $this->db->select('*')
                ->from('users')
                ->where('id', $user_id)
                ->where('is_email_active', 1);

        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function authentication_check()
    {
        $username = $this->input->post('dkpp_username');
        $password = $this->input->post('dkpp_password');

        $this->db->select('a.id, a.display_name, a.pegawai_id, a.username, a.password, a.email, a.level, a.last_login, a.last_ip_login, a.status, a.reason_disabled')
            ->from('users a')
            ->where('a.username', $username)
            ->or_where('a.email', $username)
            ->where('a.deleted', '0')
            ->limit(1);

        $result = $this->db->get();
        if ($result->num_rows() == 0) {
            return FALSE;
        } else {
            $data = $result->row();
            if (password_verify($password, $data->password)) {
                $return = $data;
            }

            if (!empty($return)) {
                return $return;
            } else {
                return FALSE;
            }
        }
    }

    public function user_check($cookie) 
    {
        $data = $this->db->select('level')
                    ->where(['cookie' => $cookie, 'a.deleted' => 0])
                    ->where("a.cookie_expires > NOW() - INTERVAL '1 minute'")
                    ->join('users b', 'a.users_id = b.id')
                    ->get('cookie a')->row();

        if ($data) {
            $this->db->update('cookie', ['last_login' => date('Y-m-d H:i:s')], ['cookie' => $cookie]);

            $data = array(
                'dkpp_level'   => $data->level
            );

            $this->session->set_userdata($data);	
        } else {
            $this->db->update('cookie', ['deleted' => 1] , ['cookie' => $cookie ]);

			delete_cookie('dkpp_users_cookie');
		 	$this->session->sess_destroy();

		 	redirect('auth', 'refresh');
        }
    }

    public function save_cookie($key, $user_id, $expired)
	{
		$data = array(
            'users_id' => $user_id,
            'cookie' => $key, 
            'browser_agent' => $this->agent->browser(),
            'version_agent' => $this->agent->version(),
            'platform_agent' => $this->agent->platform(),
            'ip_address' => $this->input->ip_address(),
            'time_cookie' => gmdate("Y-m-d H:i:s", time()+60*60*7),
            'cookie_expires' => date("Y-m-d H:i:s", time()+$expired),
            'last_login' => gmdate("Y-m-d H:i:s", time()+60*60*7),
            'deleted' => 0
        );

        $this->db->insert('cookie', $data);
	}

    public function get_by_cookie($cookie)
    {
        return $this->db->select('b.id, b.pegawai_id, b.display_name, b.username, b.password, b.email, b.level, b.last_login, b.last_ip_login, b.status, b.reason_disabled')
                ->where(['a.cookie' => $cookie, 'a.deleted' => 0])
                ->join('users b','a.users_id = b.id')
                ->get('cookie a');
    }

    public function change_profile_picture()
    {
        $config = array(
            'upload_path' => $this->data['image_path'],
            'allowed_types' => 'gif|jpg|png',
            'file_name' => 'dkpp_profile_picture'.$this->session->userdata('dkpp_pegawai_id').'_'.md5($_FILES['file']['name']).'-'.date('ymdhis'),
            'max_size' => 2048
        );

        $this->load->library('upload', $config);

        if (!$this->upload->do_upload('file')) {
            $data_res = json_encode(['status'=> false, 'msg'=> $this->upload->display_errors()]);
        } else {
            $img = $this->upload->data();
            $img_result = $img['file_name'];
            $last_profile_picture =  $this->db->select('photo')->get_where('pegawai', ['id' => $this->session->userdata('dkpp_pegawai_id')])->row()->photo;
            $img_data = array('photo' => $img_result);
            $result = $this->db->update('pegawai', $img_data, ['id' => $this->session->userdata('dkpp_pegawai_id')]);

            if ($result) {
                if (!empty($last_profile_picture)) {
                    $unlink_data =  base_url($this->data['file_image_path'] . '' . $last_profile_picture);
                    unlink($unlink_data);
                }

                $this->session->set_userdata(array('dkpp_photo' => $img_result));

                $data_res = json_encode([
                    'status' => true, 
                    'msg' => 'foto berhasil diperbarui',
                    'url' => base_url($this->data['file_image_path'] . '' . $img_result)
                ]);
            } else {
                $data_res = json_encode([
                    'status'=> false, 
                    'msg'=> 'gagal mengabil data'
                ]);
            }
        }

        return $data_res;
    }

    public function dkpp_session_register($row)
    {
        $data = ([
            'dkpp_user_id' => $row->id,
            'dkpp_pegawai_id' => $row->pegawai_id,
            'dkpp_username' => xss_escape($row->username),
            'dkpp_level' => $row->level,
            'dkpp_display_name' => xss_escape($row->display_name),
            'dkpp_email' => $row->email,
            'dkpp_last_login' => $row->last_login,
            'dkpp_last_ip_login' => $row->last_ip_login,
            'dkpp_user_active' => $row->status,
            'dkpp_deactive_reason' => $row->reason_disabled,
            'dkpp_is_default_password' => $this->_is_default_password($row->password),
            'dkpp_loggedin' => TRUE,
        ]);

        $this->session->set_userdata($data);
    }

    public function dkpp_session_destroy()
    {
        $this->session->sess_destroy();
    }

    public function get_detail_pegawai()
    {
        parent::clear_join();

        $this->_fields_toshow = ['pegawai_id','nama_pegawai','nip','username','display_name','email','users.status'];
        parent::join('v_pegawai_dkpp e','users.pegawai_id=e.id', 'left');
        $this->db->where(['pegawai_id !=' => 0]);

        return $this;
    }
    
}

/* End of file M_users.php */