<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Migrate extends CI_Controller {

    public function __construct()
    {
        parent::__construct();

        if (!$this->input->is_cli_request()) {
            show_404();
            exit;
        }
        
        $this->load->library('migration');
    }

    function current($dev)
    { 
        if ($dev == 'development') {
            $this->data['default_db'] = 'default_dev';
        } else if ($dev == 'bimtek') {
            $this->data['default_db'] = 'default_bimtek';
        } else {
            $this->data['default_db'] = 'default';
        }

        $this->db = $this->load->database($this->data['default_db'], TRUE);

        if ($this->migration->current()) {
            log_message('error', 'Migration Success.');
            echo "Migration Success";
        } else {
            log_message('error', $this->migration->error_string());
            echo $this->migration->error_string();
        }
    }

    function rollback($version, $dev)
    {
        if ($dev == 'development') {
            $this->data['default_db'] = 'default_dev';
        } else if ($dev == 'bimtek') {
            $this->data['default_db'] = 'default_bimtek';
        } else {
            $this->data['default_db'] = 'default';
        }

        $this->db = $this->load->database($this->data['default_db'], TRUE);

        if ($this->migration->version($version)) {
            log_message('error', 'Migration Success.');
            echo "Migration Success";
        } else {
            log_message('error', $this->migration->error_string());
            echo $this->migration->error_string();
        }
    }

    function latest($dev)
    {
        if ($dev == 'development') {
            $this->data['default_db'] = 'default_dev';
        } else if ($dev == 'bimtek') {
            $this->data['default_db'] = 'default_bimtek';
        } else {
            $this->data['default_db'] = 'default';
        }

        $this->db = $this->load->database($this->data['default_db'], TRUE);

        if ($this->migration->latest()) {
            log_message('error', 'Migration Success.');
            echo "Migration Success";
        } else {
            log_message('error', $this->migration->error_string());
            echo $this->migration->error_string();
        }
    }

    function sync_acl($dev)
    {
        if ($dev == 'development') {
            $this->data['default_db'] = 'default_dev';
        } else if ($dev == 'bimtek') {
            $this->data['default_db'] = 'default_bimtek';
        } else {
            $this->data['default_db'] = 'default';
        }

        $this->db = $this->load->database($this->data['default_db'], TRUE);
        $query = '';
        $this->db->empty_table('_acl');
        $this->db->query($query);
    }

}

/* End of file Migrate.php */