<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Hook_akses {

	public function run() 
    {
        $this->ci =& get_instance();
        $white_list = array('sitemap','manifest','migrate');

        if (is_integer(array_search($this->ci->router->fetch_class(), $white_list))==FALSE) {
            $this->ci->load->model('M_acl');
            $check['data'] = $this->ci->M_acl->privilage();

            if ($check['data']==FALSE) {
                show_404();
            } else {
                if ($check['data']['error']==true) {
                    if (!empty($check['data']['error_json'] && $check['data']['error_json']==true)) {
                        $this->ci->load->view('errors/cli/error_json.php', $check);
                    } else {
                        $this->ci->load->view('errors/html/error_bootbox.php', $check['data']);
                    }
                }
            }
        }
    }

}

/* End of file Hook_akses.php */
/* Location: ./application/hooks/Hook_akses.php */