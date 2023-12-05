<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_website extends MY_Model {

    protected $_table = 'profile';
    protected $_timestamps = TRUE;
    protected $_log_user = TRUE;
    protected $_softdelete = TRUE;
    protected $_order_by = 'id';
    protected $_order = 'DESC';
    protected $_fields_toshow = [
        'id', 'name_site', 'email', 'address', 'phone_number', 'whatsapp_number', 'about',
        'link_facebook', 'link_twitter', 'link_instagram', 'link_youtube', 'visi', 'misi', 'profile'
    ];
    protected $_fields = [
       'name_site' => 'name_site',
       'owner_site' => 'owner_site',
       'email' => 'email',
       'address' => 'address',
       'phone_number' => 'phone_number',
       'whatsapp_number' => 'whatsapp_number',
       'about' => 'about',
       'link_facebook' => 'link_facebook',
       'link_twitter' => 'link_twitter',
       'link_instagram' => 'link_instagram',
       'link_youtube' => 'link_youtube'
    ];

    public function __construct()
    {
        parent::__construct();
    }

}

/* End of file M_website.php */
