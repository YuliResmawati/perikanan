<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

if (!function_exists('xss_echo')) 
{
    function xss_echo($str) 
    {
        return htmlentities($str, ENT_QUOTES, 'UTF-8');
    }
}

if (!function_exists('xss_escape'))
{
    function xss_escape($dirty_html)
    {
        $dirty_html_is_object = false;

        if (is_object($dirty_html)) {
            $dirty_html = (array) $dirty_html;
            $dirty_html_is_object = true;
        }

        if (is_array($dirty_html)) {
            foreach ($dirty_html as $key => $val) {
                $clean_html[$key] = xss_escape($val);
            }
        } else {
            $clean_html = strip_tags($dirty_html, '<p><a><span><button><i><hr><div><img><b><ol><li><label><input><small><br><h6>');
        }

        if ($dirty_html_is_object==true) {
            $clean_html = (object) $clean_html;
        }

        return $clean_html;
    }
}