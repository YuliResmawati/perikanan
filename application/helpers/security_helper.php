<?php if (!defined("BASEPATH")) exit("No direct script access allowed");

if (!function_exists('encrypt_url'))
{
    function encrypt_url($string, $key, $is_login = true) 
    {
        $CI=& get_instance();
        $output = false;
        $user_id = '';
        $level = '';

        if ($is_login == true) {
            $user_id = $CI->session->userdata('dkpp_user_id');
            $level = $CI->session->userdata('dkpp_level');
        }
        
        $string = $string;    
        
        $secret_key = 'DKPP'.$key.$user_id.$level;
        $secret_iv = 2456358494765231;
        $encrypt_method = "aes-256-cbc";
        $key = hash("sha256", $secret_key);
        $iv = substr(hash("sha256", $secret_iv), 0, 16);
        $result = openssl_encrypt($string, $encrypt_method, $key, 0, $iv);
        $output = base64_encode($result);

        return $output;
    }
}

if (!function_exists('decrypt_url'))
{
    function decrypt_url($string, $key, $is_login = true) {
        $CI=& get_instance();
        $output = false;
        $user_id = '';
        $level = '';

        if ($is_login == true) {
            $user_id = $CI->session->userdata('dkpp_user_id');
            $level = $CI->session->userdata('dkpp_level');
        }
        
        $secret_key = 'DKPP'.$key.$user_id.$level;
        $secret_iv = 2456358494765231;
        $encrypt_method = "aes-256-cbc";
        $key = hash("sha256", $secret_key);
        $iv = substr(hash("sha256", $secret_iv), 0, 16);
        $output = openssl_decrypt(base64_decode($string), $encrypt_method, $key, 0, $iv);
    
        return $output;
    }
}