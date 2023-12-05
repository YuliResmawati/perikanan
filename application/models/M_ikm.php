<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_ikm extends MY_Model {

    protected $_table = 'ikm';
    protected $_timestamps = TRUE;
    protected $_log_user = TRUE;
    protected $_softdelete = TRUE;
    protected $_order_by = 'id';
    protected $_order = 'DESC';
    protected $_fields_toshow = [
        'id','ikm', 'status'
    ];
    protected $_fields = [
       'id' => 'id',
    ];

    public function __construct()
    {
        parent::__construct();
    }

    public function get_all_poin_ikm()
    {
        parent::clear_join();

        $this->_fields_toshow = ['detail_ikm.id','ikm', 'nilai', 'ikm.status','nama_kategori'];

        parent::join('detail_ikm ','ikm.id=detail_ikm.ikm_id');
        parent::join('kategori_ikm ','detail_ikm.kategori_ikm_id=kategori_ikm.id');
        $this->db->where('ikm.status', '1');

        return $this;
    }

    public function get_ikm_by_api($nik = null, $captcha = null)
    {
        $ch = curl_init( $this->_api_base . "nik");
        
        $data_string = json_encode(array(
            'token' => $this->_token,
            'nik' => $nik,
            'captcha' => $captcha
        ));

        curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string); 
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1); 
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json', 'Client-Key: ' . $this->_client_key)); 
        
        $response = curl_exec($ch);
        $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        
        if(is_json($response)) {
            $response = json_decode($response);
            if($response->status == true) {
                $response->data = (array) $response->data;
                $key_to_remove = ["FOTO", "STATUS_KAWIN", "NIK_IBU","TGL_KWN","NO_AKTA_KWN","TGL_CRAI","NO_AKTA_LHR","NIK_AYAH","NO_AKTA_CRAI"];
                $response->data = (object) array_diff_key($response->data, array_flip($key_to_remove));

                $return = ["status" => true, "data" => $response->data, "message" => $response->messages];
            }else{
                $return = ["status" => false, "message" => $response->messages];
            }
        }else{
            $return = ["status" => false, "message" => "Terdapat error pada server."];
            if(ENVIRONMENT !== 'production') {
                $return['server_response_code'] = $httpcode;
                $return['server_response'] = '<pre>'.htmlspecialchars($response).'</pre>';
            }
        }

        return (object) $return;
    }

}

/* End of file M_ikm.php */
