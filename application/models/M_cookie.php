<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_cookie extends CI_Model {

    public function get_device($user_id = '')
	{
		$this->db->where("cookie_expires < NOW() - INTERVAL '1 minute'");
		$this->db->where('users_id', $user_id);
		$this->db->where('deleted', 0);
		$this->db->update('cookie', ['deleted' => 1]);

        $this->datatables->select('id, browser_agent, version_agent, platform_agent, last_login, cookie_expires, cookie')
        	->from('cookie')
        	->add_column('browser_agent', '$1', 'browser_icon(browser_agent)')
        	->add_column('cookie_expires', '$1', 'format_indo(cookie_expires, no)')
        	->add_column('last_login', '$1', 'format_indo(last_login, no)')
			->add_column('aksi', '$1', 'cookie_action_button(cookie)')
        	->where('users_id', $user_id)
        	->where('deleted', '0')
        	->order_by('last_login', 'DESC');

        return $this->datatables->generate();
	}

}

/* End of file M_cookies.php */
