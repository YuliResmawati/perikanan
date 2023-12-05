<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_api extends CI_Model {

    public function get_data_from_api()
    {

        $api_url ='https://rangkiang.agamkab.go.id/api/ikm/ajaxGetSurvei';
        $ch = curl_init($api_url);

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($ch);
        curl_close($ch);


        return json_decode($response, true);
    }

}

/* End of file M_api.php */
