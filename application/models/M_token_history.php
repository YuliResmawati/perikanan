<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_token_history extends MY_Model {

    protected $_table = 'token_history';
    protected $_timestamps = TRUE;
    protected $_log_user = TRUE;
    protected $_softdelete = FALSE;
    protected $_order_by = 'id';
    protected $_order = 'desc';
    protected $_fields_toshow = ['users_id', 'token', 'description', 'type', 'expired_date'];
    protected $_fields = [
        'description' => 'description',
        'type' => 'type'
    ];

    public function __construct()
    {
        parent::__construct();
    }

    public function get_active_token($user_id, $type = '', $limit = '') 
    {
        $this->db->where("expired_date < NOW()");
		$this->db->where('users_id', $user_id);
		$this->db->where('deleted', '0');
		$this->db->where('status', '1');
		$this->db->update('token_history', ['deleted' => '1', 'status' => '0']);

        $this->db->select('*')
            ->from('token_history')
            ->where('users_id', $user_id)
            ->where('type', $type)
            ->where('deleted', '0')
            ->where('status', '1')
            ->order_by('id', 'DESC');

        if ($limit) {
            $this->db->limit($limit);
        }

        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            return $query->row();
        } else {
            return false;
        }
    }

    public function disabled_token($user_id, $token)
    {
		$this->db->where('users_id', $user_id);
		$this->db->where('token', $token);
		$this->db->where('deleted', '0');
		$this->db->where('status', '1');
		$this->db->update('token_history', ['deleted' => '1', 'status' => '0']);
    }

}

/* End of file M_token_history.php */
