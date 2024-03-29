<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

if (!function_exists('error_delimeter')) 
{
    function error_delimeter($index)
    {
        $data = array('<div><span class="text-danger"><i>*', '</i></span></div>');

        if ($index > count($data)) {
            throw new Exception("Index value can't bigger than " . count($data));
        } else {
            $return = $data[$index - 1];
        }
        return $return;
    }
}

if (!function_exists('meta_tag_refresh')) {
    function meta_tag_refresh($delay, $url)
    {
        return "<meta http-equiv='refresh' content='$delay;url=$url'>";
    }
}

if (!function_exists('formatBytes')) {
    function formatBytes($bytes, $precision = 2)
    {
        $size = array('B','KB','MB','GB','TB','PB','EB','ZB','YB');
        $data = floor((strlen($bytes) - 1) / 3);

        return sprintf("%.{$precision}f", $bytes / pow(1024, $data)) .' ' . @$size[$data];
    }
}

if (!function_exists('is_json')) {
    function is_json($string) {
        json_decode($string);
        return (json_last_error() == JSON_ERROR_NONE);
   }
}

if (!function_exists('pg_to_array'))
{
    function pg_to_array($path)
    {
        if (!empty($path)) {
            return explode(',', trim($path, '{}'));
        } else {
            return null;
        }
    }
}

if (!function_exists('multi_pg_to_array')) 
{
    function multi_pg_to_array($path)
    {
        if (!empty($path)) {
            $return = explode('},{', trim($path, "{}"));
            
            for ($i = 0; $i < count($return); $i++) {
                $return[$i] = explode(',', str_replace('"', '', $return[$i]));
            }

            return $return;
        } else {
            return null;
        }
    }
}

if (!function_exists('array_to_pg')) 
{
    function array_to_pg($data_array)
    {
        if (!empty($data_array)) {
            return str_replace(['[', ']'], ['{', '}'], json_encode($data_array));
        } else {
            return null;
        }
    }
}

if (!function_exists('array_list_loop')) 
{
    function array_list_loop($count_loop, $value)
    {
        for ($i = 0; $i < $count_loop; $i++) $arr_id_key[] = $value;
        return $arr_id_key;
    }
}

if (!function_exists('data_expl')) 
{
    function data_expl($json, $name_json)
    {
        $a = '';

        if ($json) {
            $pgarray_nama = json_decode($json, true);
            $nip  = $pgarray_nama[$name_json];
            $no = 1;

            for ($i = 0; $i < count($nip); $i++) {
                $nama  = $nip[$i];
                $a .= $no++ . '.' . $nama . '<hr class="m-1">';
            }
        } else {
            $a = 'Tidak ada data';
        }

        return $a;
    }
}

if (!function_exists('db_in_list')) 
{
    function db_in_list($table, $field, $extra = NULL, $id_key = NULL)
    {
        $return = '';
        $CI = &get_instance();
        $extra;
        $data = $CI->db->select($field)->get($table);

        if ($data->num_rows() > 0) {
            if ($id_key !== NULL) {
                $array = array_map('encrypt_url', array_column($data->result(), $field), array_list_loop($data->num_rows(), $id_key));
            } else {
                $array = array_column($data->result(), $field);
            }

            $array_str = implode(',', $array);
            $return = 'in_list[' . $array_str . ']';
        }

        return $return;
    }
}

if (!function_exists('data_in_list')) 
{
    function data_in_list($data, $column, $id_key = NULL)
    {
        $return = '';

        if ($id_key !== NULL) {
            $array = array_map('encrypt_url', array_column($data, $column), array_list_loop(count($data), $id_key));
        } else {
            $array = array_column($data, $column);
        }

        $array_str = implode(',', $array);
        $return = 'in_list[' . $array_str . ']';

        return $return;
    }
}

if (!function_exists('tabel_icon')) {
    function tabel_icon($id, $session_id, $action, $link_url = '', $keyid = '', $modal_name = '', $attr =  '', $custom_class = '', $custom_icon = '', $custom_title = '', $option = '')
    {
        $a = '';

        if ($id !== $session_id) {
            if ($keyid !== '') {
                $id = encrypt_url($id, $keyid);
            }

            if ($link_url !== '') {
                $a_tag = 'a';
                $link_url = 'href="' . base_url($link_url . $id) . '"';
                $modal_attr = '';
            } else {
                $a_tag = 'span';
                $link_url = "";
                if ($modal_name !== '') {
                    $modal_attr = 'data-toggle="modal" data-target="#' . $modal_name . '"';
                } else {
                    $modal_attr = '';
                }
            }

            if (!empty($option)) {
                if ($option !== '1') {
                    if ($action == "delete") {
                        $a = '<' . $a_tag . ' ' . $link_url . '  '. $attr .' class="button-hapus btn btn-danger waves-effect waves-light btn-xs" title="Hapus" data-plugin="tippy" data-tippy-size="small" data-id="' . $id . '" >
                                        <i class="icon-trash"></i>
                                </' . $a_tag . '>';
                    } elseif ($action == "edit") {
                        $a = '<' . $a_tag . ' ' . $link_url . ' '. $attr .' class="button-edit btn btn-warning waves-effect waves-light btn-xs" title="Edit" data-plugin="tippy" data-tippy-size="small" data-id="' . $id . '" ' . $modal_attr . '>
                                        <i class="icon-note"></i>
                                </' . $a_tag . '>';
                    } elseif ($action == "reset") {
                        $a = '<' . $a_tag . ' ' . $link_url . ' '. $attr .' class="button-reset btn btn-blue waves-effect waves-light btn-xs" title="Reset" data-plugin="tippy" data-tippy-size="small" data-id="' . $id . '" >
                                        <i class="icon-refresh"></i>
                                </' . $a_tag . '>';
                    } elseif ($action == "add") {
                        $a = '<' . $a_tag . ' ' . $link_url . ' '. $attr .' class="button-add btn btn-blue waves-effect waves-light btn-xs" title="Tambah" data-plugin="tippy" data-tippy-size="small" data-id="' . $id . '" ' . $modal_attr . '>
                                        <i class="icon-plus"></i>
                                </' . $a_tag . '>';
                    } elseif ($action == "view") {
                        $a = '<' . $a_tag . ' ' . $link_url . ' '. $attr .' class="button-view btn btn-info waves-effect waves-light btn-xs" title="Lihat" data-plugin="tippy" data-tippy-size="small" data-id="' . $id . '" ' . $modal_attr . '>
                                        <i class="icon-info"></i>
                                </' . $a_tag . '>';
                    } elseif ($action == "child") {
                        $a = '<' . $a_tag . ' ' . $link_url . ' '. $attr .' class="button-add btn btn-soft-danger waves-effect waves-light btn-xs" title="Lihat Detail" data-plugin="tippy" data-tippy-size="small" data-id="' . $id . '">
                                        <i class="icon-share"></i>
                                </' . $a_tag . '>';
                    } elseif($action == "custom") {
                        $a = '<' . $a_tag . ' ' . $link_url . ' '. $attr .' class="'.$custom_class.'" title="'.$custom_title.'" data-plugin="tippy" data-tippy-size="small" data-id="' . $id . '" ' . $modal_attr . '>
                                        <i class="'.$custom_icon.'"></i>
                                </' . $a_tag . '>';
                    } elseif ($action == "verifikasi") {
                        $a = '<' . $a_tag . ' ' . $link_url . ' '. $attr .' class="button-check btn btn-warning waves-effect waves-light btn-xs" title="Verifikasi" data-plugin="tippy" data-tippy-size="small" data-id="' . $id . '" ' . $modal_attr . '>
                                        <i class="icon-check"></i>
                                </' . $a_tag . '>';
                    } elseif ($action == "detail") {
                        $a = '<' . $a_tag . ' ' . $link_url . ' '. $attr .' class="button-detail btn btn-info waves-effect waves-light btn-xs" title="Lihat Data Pelaku" data-plugin="tippy" data-tippy-size="small" data-id="' . $id . '" ' . $modal_attr . '>
                                        <i class="icon-people"></i>
                                </' . $a_tag . '>';
                    } elseif ($action == "list_materi") {
                        $a = '<' . $a_tag . ' ' . $link_url . ' '. $attr .' class="button-list btn btn-info waves-effect waves-light btn-xs" title="Lihat Materi" data-plugin="tippy" data-tippy-size="small" data-id="' . $id . '" ' . $modal_attr . '>
                                        <i class="icon-directions"></i>
                                </' . $a_tag . '>';
                    }
                }
            } else {
                if ($action == "delete") {
                    $a = '<' . $a_tag . ' ' . $link_url . '  '. $attr .' class="button-hapus btn btn-danger waves-effect waves-light btn-xs" title="Hapus" data-plugin="tippy" data-tippy-size="small" data-id="' . $id . '" >
                                    <i class="icon-trash"></i>
                            </' . $a_tag . '>';
                } elseif ($action == "edit") {
                    $a = '<' . $a_tag . ' ' . $link_url . ' '. $attr .' class="button-edit btn btn-warning waves-effect waves-light btn-xs" title="Edit" data-plugin="tippy" data-tippy-size="small" data-id="' . $id . '" ' . $modal_attr . '>
                                    <i class="icon-note"></i>
                            </' . $a_tag . '>';
                } elseif ($action == "reset") {
                    $a = '<' . $a_tag . ' ' . $link_url . ' '. $attr .' class="button-reset btn btn-blue waves-effect waves-light btn-xs" title="Reset" data-plugin="tippy" data-tippy-size="small" data-id="' . $id . '" >
                                    <i class="icon-refresh"></i>
                            </' . $a_tag . '>';
                } elseif ($action == "add") {
                    $a = '<' . $a_tag . ' ' . $link_url . ' '. $attr .' class="button-add btn btn-blue waves-effect waves-light btn-xs" title="Tambah" data-plugin="tippy" data-tippy-size="small" data-id="' . $id . '" ' . $modal_attr . '>
                                    <i class="icon-plus"></i>
                            </' . $a_tag . '>';
                } elseif ($action == "view") {
                    $a = '<' . $a_tag . ' ' . $link_url . ' '. $attr .' class="button-view btn btn-info waves-effect waves-light btn-xs" title="Lihat" data-plugin="tippy" data-tippy-size="small" data-id="' . $id . '" ' . $modal_attr . '>
                                    <i class="icon-info"></i>
                            </' . $a_tag . '>';
                } elseif ($action == "child") {
                    $a = '<' . $a_tag . ' ' . $link_url . ' '. $attr .' class="button-add btn btn-soft-danger waves-effect waves-light btn-xs" title="Lihat Kuesioner" data-plugin="tippy" data-tippy-size="small" data-id="' . $id . '">
                                    <i class="icon-share"></i>
                            </' . $a_tag . '>';
                } elseif($action == "custom") {
                    $a = '<' . $a_tag . ' ' . $link_url . ' '. $attr .' class="'.$custom_class.'" title="'.$custom_title.'" data-plugin="tippy" data-tippy-size="small" data-id="' . $id . '" ' . $modal_attr . '>
                                    <i class="'.$custom_icon.'"></i>
                            </' . $a_tag . '>';
                } elseif ($action == "verifikasi") {
                    $a = '<' . $a_tag . ' ' . $link_url . ' '. $attr .' class="button-check btn btn-warning waves-effect waves-light btn-xs" title="Verifikasi" data-plugin="tippy" data-tippy-size="small" data-id="' . $id . '" ' . $modal_attr . '>
                                    <i class="icon-check"></i>
                            </' . $a_tag . '>';
                }elseif ($action == "reset_pass") {
                    $a = '<' . $a_tag . ' ' . $link_url . ' '. $attr .' class="button-reset_pass btn btn-info waves-effect waves-light btn-xs" title="Reset Password" data-plugin="tippy" data-tippy-size="small" data-id="' . $id . '" >
                                    Reset Password
                            </' . $a_tag . '>';
                } elseif ($action == "detail") {
                    $a = '<' . $a_tag . ' ' . $link_url . ' '. $attr .' class="button-detail btn btn-info waves-effect waves-light btn-xs" title="Lihat Data Pelaku Usaha" data-plugin="tippy" data-tippy-size="small" data-id="' . $id . '" ' . $modal_attr . '>
                                    <i class="icon-people"></i>
                            </' . $a_tag . '>';
                } elseif ($action == "panel_harga") {
                    $a = '<' . $a_tag . ' ' . $link_url . ' '. $attr .' class="button-list-materi btn btn-info waves-effect waves-light btn-xs" title="Lihat Panel" data-plugin="tippy" data-tippy-size="small" data-id="' . $id . '" ' . $modal_attr . '>
                                    <i class="icon-notebook"></i>
                            </' . $a_tag . '>';
                } elseif ($action == "jadwal") {
                    $a = '<' . $a_tag . ' ' . $link_url . ' '. $attr .' class="button-jadwal btn btn-pink waves-effect waves-light btn-xs" title="Lihat Jadwal" data-plugin="tippy" data-tippy-size="small" data-id="' . $id . '" ' . $modal_attr . '>
                                    <i class="icon-layers"></i>
                            </' . $a_tag . '>';
                }elseif ($action == "ajukan") {
                    $a = '<' . $a_tag . ' ' . $link_url . ' '. $attr .' class="button-ajukan btn btn-icons btn-rounded btn-success btn-xs" title="Ajukan KGB" data-plugin="tippy" data-tippy-size="small" data-id="' . $id . '" ' . $modal_attr . '>
                                    <i class="mdi mdi-plus"></i>
                            </' . $a_tag . '>';
                }
            }
        }

        return $a;
    }
}

if (!function_exists('tabel_icon_komoditas')) {
    function tabel_icon_komoditas($id, $session_id, $action, $link_url = '', $keyid = '', $modal_name = '', $attr =  '', $level = '')
    {
        $a = '';
        
        if ($id !== $session_id) {
            if ($keyid !== '') {
                $id = encrypt_url($id, $keyid);
            }

            if ($link_url !== '') {
                $a_tag = 'a';
                $link_url = 'href="' . base_url($link_url . $id) . '"';
                $modal_attr = '';
            } else {
                $a_tag = 'span';
                $link_url = "";
                if ($modal_name !== '') {
                    $modal_attr = 'data-toggle="modal" data-target="#' . $modal_name . '"';
                } else {
                    $modal_attr = '';
                }
            }

            if ($level != '7'){
                if ($action == "delete") {
                    $a = '<' . $a_tag . ' ' . $link_url . '  '. $attr .' class="button-hapus btn btn-danger waves-effect waves-light btn-xs" title="Hapus" data-plugin="tippy" data-tippy-size="small" data-id="' . $id . '" >
                                    <i class="icon-trash"></i>
                            </' . $a_tag . '>';
                } elseif ($action == "edit") {
                    $a = '<' . $a_tag . ' ' . $link_url . ' '. $attr .' class="button-edit btn btn-warning waves-effect waves-light btn-xs" title="Edit" data-plugin="tippy" data-tippy-size="small" data-id="' . $id . '" ' . $modal_attr . '>
                                    <i class="icon-note"></i>
                            </' . $a_tag . '>';
                } elseif ($action == "add") {
                    $a = '<' . $a_tag . ' ' . $link_url . ' '. $attr .' class="button-add btn btn-blue waves-effect waves-light btn-xs" title="Tambah" data-plugin="tippy" data-tippy-size="small" data-id="' . $id . '" ' . $modal_attr . '>
                                    <i class="icon-plus"></i>
                            </' . $a_tag . '>';
                }
            } else {
                $a = '<a href="#" class="btn btn-warning waves-effect waves-light btn-xs" title="Tidak Memiliki Wewenang" data-plugin="tippy" data-tippy-size="small"><i class="icon-lock"></i></a>';
            }
        }

        return $a;
    }
}

if (!function_exists('tabel_icon_pegawai')) {
    function tabel_icon_pegawai($id, $logged_level, $action, $link_url = '', $keyid = '', $modal_name = '', $attr =  '', $type = '', $custom_url = '', $default_custom_url = '')
    {
        $a = '';

        if ($keyid !== '') {
            if ($custom_url !== '' && $default_custom_url !== '') {
                $id = encrypt_url($id.'#'.$default_custom_url, $keyid);
            } else {
                $id = encrypt_url($id, $keyid);
            }
        }

        if ($link_url !== '') {
            $a_tag = 'a';
            $link_url = 'href="' . base_url($link_url . $id) . '"';
            $modal_attr = '';
        } else {
            $a_tag = 'span';
            $link_url = "";
            if ($modal_name !== '') {
                $modal_attr = 'data-toggle="modal" data-target="#' . $modal_name . '"';
            } else {
                $modal_attr = '';
            }
        }

        if ($action == "delete") {
            if ($logged_level == '1') {
                if (strtolower($type) == 'pns' || strtolower($type) == 'cpns' || strtolower($type) == 'pppk') {
                    $a = '<' . $a_tag . ' ' . $link_url . '  '. $attr .' class="button-hapus btn btn-danger waves-effect waves-light btn-xs" title="Hapus" data-plugin="tippy" data-tippy-size="small" data-id="' . $id . '" ><i class="icon-trash"></i></' . $a_tag . '>';
                } else {
                    $a = '<a href="#" class="btn btn-danger waves-effect waves-light btn-xs" title="Tidak Memiliki Wewenang" data-plugin="tippy" data-tippy-size="small"><i class="icon-lock"></i></a>';
                }
            } else if ($logged_level == '3') {
                if (strtolower($type) == 'pns' || strtolower($type) == 'cpns' || strtolower($type) == 'pppk') {
                    $a = '<a href="#" class="btn btn-danger waves-effect waves-light btn-xs" title="Tidak Memiliki Wewenang" data-plugin="tippy" data-tippy-size="small"><i class="icon-lock"></i></a>';
                } else {
                    $a = '<' . $a_tag . ' ' . $link_url . '  '. $attr .' class="button-hapus btn btn-danger waves-effect waves-light btn-xs" title="Hapus" data-plugin="tippy" data-tippy-size="small" data-id="' . $id . '" ><i class="icon-trash"></i></' . $a_tag . '>';
                }
            } else {
                $a = '<a href="#" class="btn btn-danger waves-effect waves-light btn-xs" title="Tidak Memiliki Wewenang" data-plugin="tippy" data-tippy-size="small"><i class="icon-lock"></i></a>';
            }
        } else if ($action == "edit") {
            if ($logged_level == '1') {
                if (strtolower($type) == 'pns' || strtolower($type) == 'cpns' || strtolower($type) == 'pppk') {
                    $a = '<' . $a_tag . ' ' . $link_url . ' '. $attr .' class="button-edit btn btn-warning waves-effect waves-light btn-xs" title="Edit" data-plugin="tippy" data-tippy-size="small" data-id="' . $id . '" ' . $modal_attr . '><i class="icon-note"></i></' . $a_tag . '>';
                } else {
                    $a = '<a href="#" class="btn btn-warning waves-effect waves-light btn-xs" title="Tidak Memiliki Wewenang" data-plugin="tippy" data-tippy-size="small"><i class="icon-lock"></i></a>';
                }
            } else if ($logged_level == '3') {
                if (strtolower($type) == 'pns' || strtolower($type) == 'cpns' || strtolower($type) == 'pppk') {
                    $a = '<a href="#" class="btn btn-warning waves-effect waves-light btn-xs" title="Tidak Memiliki Wewenang" data-plugin="tippy" data-tippy-size="small"><i class="icon-lock"></i></a>';
                } else {
                    $a = '<' . $a_tag . ' ' . $link_url . ' '. $attr .' class="button-edit btn btn-warning waves-effect waves-light btn-xs" title="Edit" data-plugin="tippy" data-tippy-size="small" data-id="' . $id . '" ' . $modal_attr . '><i class="icon-note"></i></' . $a_tag . '>';
                }
            } else {
                $a = '<a href="#" class="btn btn-warning waves-effect waves-light btn-xs" title="Tidak Memiliki Wewenang" data-plugin="tippy" data-tippy-size="small"><i class="icon-lock"></i></a>';
            }            
        } else if($action == "detail") {
            if ($logged_level == '1') {
                if (strtolower($type) == 'pns' || strtolower($type) == 'cpns' || strtolower($type) == 'pppk') {
                    $a = '<' . $a_tag . ' ' . $link_url . ' '. $attr .' class="button-detail-pegawai btn btn-blue waves-effect waves-light btn-sm" title="Detail Pegawai" data-plugin="tippy" data-tippy-size="small" data-id="' . $id . '" ' . $modal_attr . '><i class="mdi mdi-account-check"></i></' . $a_tag . '>';
                } else {
                    $a = '<a href="#" class="btn btn-blue waves-effect waves-light btn-xs" title="Tidak Memiliki Wewenang" data-plugin="tippy" data-tippy-size="small"><i class="icon-lock"></i></a>';
                }
            } else if ($logged_level == '3') {
                if (strtolower($type) == 'pns' || strtolower($type) == 'cpns' || strtolower($type) == 'pppk') {
                    $a = '<a href="#" class="btn btn-blue waves-effect waves-light btn-xs" title="Tidak Memiliki Wewenang" data-plugin="tippy" data-tippy-size="small"><i class="icon-lock"></i></a>';
                } else {
                    $a = '<' . $a_tag . ' ' . $link_url . ' '. $attr .' class="button-detail-pegawai btn btn-blue waves-effect waves-light btn-sm" title="Detail Pegawai" data-plugin="tippy" data-tippy-size="small" data-id="' . $id . '" ' . $modal_attr . '><i class="mdi mdi-account-check"></i></' . $a_tag . '>';
                }
            } else {
                $a = '<a href="#" class="btn btn-blue waves-effect waves-light btn-xs" title="Tidak Memiliki Wewenang" data-plugin="tippy" data-tippy-size="small"><i class="icon-lock"></i></a>';
            }
        }

        return $a;
    }
}

if (!function_exists('cookie_action_button')) {
    function cookie_action_button($cookie)
    {
        $cookie_browser = get_cookie('dkpp_users_cookie');

        if ($cookie == $cookie_browser) {
            $result = '<h6><span class="badge bg-soft-success text-success">Perangkat Utama</span></h6>';
        } else {
            $result = '<h6><span class="cookie-action badge bg-soft-danger text-danger" title="Hapus Perangkat" data-plugin="tippy" data-tippy-size="small" style="cursor:pointer;" id="'.$cookie.'"><i class="mdi mdi-delete-forever"></i> Perangkat Lain</span></h6>';
        }

        return $result;
    }
}

if (!function_exists('active_status')) {
    function active_status($id, $session_id, $status_field, $keyid = '', $link_status = '', $modal_name = '')
    {
        $a = '';

        if ($id !== $session_id) {
            if ($keyid !== '') {
                $id = encrypt_url($id, $keyid);
            }

            if ($link_status !== '' && $link_status !== ' ' ) {
                $a_tag = 'a';
                $link_status = 'href="' . base_url($link_status . $id) . '"';
            } else {
                $a_tag = 'span';
                $link_status = "";

                if ($modal_name !== '') {
                    $modal_attr = 'data-toggle="modal" data-target="#' . $modal_name . '"';
                } else {
                    $modal_attr = '';
                }
            }

            if ($status_field == "0") {
                $a = '<' . $a_tag . ' ' . $link_status . '  data-status="0" class="button-status btn btn-success waves-effect waves-light btn-xs" title="Aktifkan" data-plugin="tippy" data-tippy-size="small" data-id="' . $id . '" >
                                <i class="icon-check"></i>
                        </' . $a_tag . '>';
            } else {
                $a = '<' . $a_tag . ' ' . $link_status . ' data-status="1" class="button-status btn btn-secondary waves-effect waves-light btn-xs" title="Non Aktifkan" data-plugin="tippy" data-tippy-size="small" data-id="' . $id . '" ' . $modal_attr . '>
                                <i class="icon-close"></i>
                    </' . $a_tag . '>';
            }
        }

        return $a;
    }
}

if (!function_exists('generate_avatar')) {
    function generate_avatar($avatar_url = null, $avatar_username = null, $avatar_class = null, $custom = null)
    {
        $CI =& get_instance();
        $return = '';
        if (empty($avatar_url)): 
            $return = '<img alt="User Avatar" class="avatar-initial '.$avatar_class.'" data-name="'.$avatar_username.'" '.$custom.'/>';
        else : 
            $avatar_path = str_files_images('profil_pegawai/', $avatar_url); 
            $return = '<img alt="User Avatar" class="'.$avatar_class.'" src="'.$avatar_path.'" '.$custom.'/>';
        endif;
        return $return;
    }
}

if (!function_exists('str_sensor')) {
    function str_sensor($str)
    {
        return substr($str, 0, 2).str_repeat('x', strlen($str)-2);
    }
}

if (!function_exists('str_status')) {
    function str_status($status)
    {
        $a = '';

        if ($status == '1') {
            $a = '<h6><span class="badge bg-soft-success text-success"><i class="mdi mdi-bookmark-check"></i> Aktif</span></h6>';
        } else {
            $a = '<h6><span class="badge bg-soft-secondary text-secondary"><i class="mdi mdi-bookmark-remove"></i> Tidak Aktif</span></h6>';
        }

        return $a;
    }
}

if (!function_exists('str_status_cuti')) {
    function str_status_cuti($status, $alasan = '')
    {
        $a = '';

        if ($status == '0') {
            $a = '<h6><span class="badge bg-soft-warning text-warning">Menunggu Persetujuan</span></h6>';
        } else if ($status == '1') {
            $a = '<h6><span class="badge bg-soft-success text-success">Permohonan Disetujui</span></h6>';
        } else if ($status == '2') {
            $a = '<h6><span class="badge bg-soft-danger text-danger">Permohonan Ditolak</span></h6>
                  <h6><span class="badge bg-soft-dark text-dark">Alasan : '.$alasan.'</span></h6><br>';
        } else if ($status == '3') {
            $a = '<h6><span class="badge bg-soft-secondary text-secondary">Permohonan Dibatalkan</span></h6>';
        } else {
            $a = '<h6><span class="badge bg-soft-info text-info">Status Tidak Diketahui</span></h6>';
        }

        return $a;
    }
}


if (!function_exists('str_status_mutasi')) {
    function str_status_mutasi($status,$alasan= '')
    {
        $a = '';

        if ($status == '1') {
            $a = '<h6><span class="badge bg-soft-success text-success"><i class="mdi mdi-check-all"></i> Diterima</span></h6>';
        } else  if ($status == '0') {
            $a = '<h6><span class="badge bg-soft-dark text-dark"><i class="mdi mdi-timer-sand"></i> Dalam Proses</span></h6>';
        } else {
            $a = '<h6><span class="badge bg-soft-danger text-danger"><i class="mdi mdi-bookmark-remove"></i> Ditolak</span></h6>
                <h6><span class="badge bg-soft-dark text-dark">Alasan : '.$alasan.'</span></h6><br>';

        }

        return $a;
    }
}

if (!function_exists('str_level')) 
{
    function str_level($status)
    {
        $a = '';

        if ($status == '1') {
            $a = 'Super Administrator';
        } else if ($status == '2') {
            $a = 'Administrator';
        } else if ($status == '3') {
            $a = 'Admin Bidang Ketersediaan dan Stabilitas Pangan ';
        } else if ($status == '4') {
            $a = 'Admin Bidang Kerawanan Pangan dan Gizi ';
        } else if ($status == '5') {
            $a = 'Admin Bidang Penganekaragaman Komsumsi dan Keamanan Pangan';
        } else if ($status == '6') {
            $a = 'Admin Bidang Perikanan Budi Daya dan Perikanan Tangkap';
        } else if ($status == '7') {
            $a = 'Admin Bidang Penguatan Daya Saing Produk Perikanan dan Pengawasan Sumber Daya Perikanan';
        } else {
            $a = 'Tidak Diketahui';
        }

        return $a;
    }
}

if (!function_exists('custom_tolower_text')) 
{
    function custom_tolower_text($text = '')
    {
        $_text = ucwords(strtolower($text));
        return xss_escape($_text);
    }
}

if (!function_exists('browser_icon')) 
{
    function browser_icon($browser_icon)
    {
        if (strtolower($browser_icon) == "chrome") {
            return '<i class="mdi mdi-google-chrome"></i> '.$browser_icon.'';
        } else if (strtolower($browser_icon) == "firefox") {
            return '<i class="mdi mdi-firefox"></i> '.$browser_icon.'';
        } else if (strtolower($browser_icon) == "safari") {
            return '<i class="mdi mdi-apple-safari"></i> '.$browser_icon.'';
        } else {
            return '<i class="mdi mdi-set-none"></i> '.$browser_icon.'';
        }
    }
}

if (!function_exists('str_files_images')) 
{
    function str_files_images($path, $filename)
    {
        $a = '';

        if (!empty($filename)) {
            $ci = &get_instance();
            $a = base_url($ci->data['file_image_path'] . $path . $filename);
        } else {
            $a = "";
        }

        return $a;
    }
}

if (!function_exists('cut_character_datatables')) {
    function cut_character_datatables($string, $lenght)
    {
        if (strlen($string) <= $lenght) {
            return $string;
        } else {
            return substr($string, 0, $lenght) . '...'; 
        }
    }
}

if (!function_exists('str_my_images')) 
{
    function str_my_images($path, $filename)
    {
        $a = '';

        if (!empty($filename)) {
            $ci = &get_instance();
            $a = base_url($ci->data['my_images'] . $path . $filename);
        } else {
            $a = "";
        }

        return $a;
    }
}

if (!function_exists('str_my_files')) 
{
    function str_my_files($path, $filename)
    {
        $a = '';

        if (!empty($filename)) {
            $ci = &get_instance();
            $a = base_url($ci->data['my_files'] . $path . $filename);
        } else {
            $a = "";
        }

        return $a;
    }
}

if (!function_exists('str_files_not_owner_must_login')) 
{
    function str_files_not_owner_must_login($path, $filename)
    {
        $a = '';

        if (!empty($filename)) {
            $ci = &get_instance();
            $a = base_url($ci->data['files_path_not_owner_must_login'] . $path . $filename);
        } else {
            $a = "";
        }

        return $a;
    }
}

if (!function_exists('str_files_authorization')) 
{
    function str_files_authorization($path, $filename, $prefix)
    {
        $a = '';

        if (!empty($filename)) {
            $ci = &get_instance();
            $prefix = encrypt_url($prefix, "files_pass");
            $a = base_url($ci->data['upload_authorization'] . $path.'/' . $filename .'?key=' . $prefix);
        } else {
            $a = "";
        }

        return $a;
    }
}

if (!function_exists('str_images_authorization')) 
{
    function str_images_authorization($path, $filename, $prefix)
    {
        $a = '';

        if (!empty($filename)) {
            $ci = &get_instance();
            $prefix = encrypt_url($prefix, "files_pass");
            $a = base_url($ci->data['image_authorization'] . $path.'/' . $filename .'?key=' . $prefix);
        } else {
            $a = "";
        }

        return $a;
    }
}

if (!function_exists('str_btn_files')) 
{
    function str_btn_files($path, $filename)
    {
        $a = '';

        if (!empty($filename)) {
            $ci = &get_instance();
            $a = base_url($ci->data['files_path'] . $path . $filename);
        } else {
            $a = "";
        }

        return $a;
    }
}

if (!function_exists('str_btn_public_files')) 
{
    function str_btn_public_files($path, $filename)
    {
        $a = '';

        if (!empty($filename)) {
            $ci = &get_instance();
            $a = base_url($ci->data['public_file_path'] . $path . $filename);
        } else {
            $a = "";
        }

        return $a;
    }
}

if (!function_exists('btn_view_file')) 
{
    function btn_view_file($path, $filename = null)
    {
        $a = '';

        if (!empty($filename)) {
            $ci = &get_instance();
            $a = base_url($ci->data['files_path'] . $path . $filename);
            $a = "<a class='btn btn-success btn-block' data-fancybox href=" . str_btn_files($path, $filename) . ">Lihat File</a>";
        } else {
            $a = '<label class="btn btn-danger btn-block">Tidak ada file</label>';
        }

        return $a;
    }
}

if (!function_exists('dt_btn_file')) {
    function dt_btn_file($path = '', $file = '', $btn_title_success = '', $btn_title_failed = '')
    {
        $_file = str_my_files($path, $file);

        if (!empty($file)) {
            return '<a class="btn btn-success btn-xs" href="'.$_file.'" target="_blank">'.$btn_title_success.'</a>';
        } else {
            return '<a class="btn btn-danger btn-xs" href="javascript:void(0);">'.$btn_title_failed.'</a>';
        }
    }
}

if (!function_exists('btn_content_view')) 
{
    function btn_content_view($link, $kategori)
    {
        $a = '';
        if ($kategori == 'Artikel'){
            $_link = base_url('article/'). $link;
        }else {
            $_link = base_url('berita/'). $link;
        }
        

        if (!empty($link)) {
            $a = "<a class='btn btn-blue btn-xs' href=".$_link." target='_blank'>Lihat $kategori</a>";
        } else {
            $a = '<label class="btn btn-danger btn-xs">-</label>';
        }

        return $a;
    }
}

if (!function_exists('btn_view_gallery')) 
{
    function btn_view_gallery($path, $filename, $link)
    {
        $a = '';

        $_link_image =  str_files_images('gallery/', $filename);

        if (!empty($filename)) {
            $a = "<a class='btn btn-blue btn-sm' data-fancybox href=" . $_link_image . " target='_blank'>Lihat</a>";
        } else {
            $a = "<a class='btn btn-blue btn-sm' data-fancybox href=".$link." target='_blank'>Lihat</a>";
        } 

        return $a;
    }
}


if (!function_exists('btn_view_images')) 
{
    function btn_view_images($path, $filename)
    {
        $a = '';

        if (!empty($filename)) {
            $a = "<a class='btn btn-info btn-sm' data-fancybox href=" . str_files_images($path, $filename) . " target='_blank'>Lihat File</a>";
        } else {
            $a = '<label class="btn btn-danger btn-sm">Tidak ada file</label>';
        }

        return $a;
    }
}

if (!function_exists('str_file_datatables')) 
{
    function str_file_datatables($file_url, $directory)
    {
        if (!empty($file_url)) {
            $result = "<a class='btn btn-success btn-xs' href=" . str_files_not_owner_must_login($directory, $file_url) . " target='_blank'>Lihat file</a>";
        } else {
            $result = '<h6><span class="badge bg-soft-secondary text-secondary"> Tidak memiliki file</span></h6>';
        }

        return $result;
    }
}

if (!function_exists('str_file_dt')) 
{
    function str_file_dt($file_url, $directory)
    {
        if (!empty($file_url)) {
            $result = "<a class='btn btn-blue btn-xs' href=" . str_btn_public_files($directory, $file_url) . " target='_blank'>Lihat Berkas</a>";
        } else {
            $result = '<h6><span class="badge bg-soft-secondary text-secondary"> Tidak memiliki berkas</span></h6>';
        }

        return $result;
    }
}

if (!function_exists('dkpp_upload_image')) 
{
    function dkpp_upload_image($field_name, $filename)
    {
        $ci = &get_instance();

        $config['upload_path'] = $ci->data['image_path'];
        $config['allowed_types'] = 'jpg|png|jpeg|JPG|PNG';
        $config['file_name'] = $filename;
        $config['overwrite'] = true;
        $config['max_size'] = 1024; // 1MB

        $ci->load->library('upload', $config);

        if ($ci->upload->do_upload($field_name)) {
            return array('status' => TRUE, 'message' => $ci->upload->data('file_name'));
        } else {
            return array('status' => FALSE, 'message' => $ci->upload->display_errors());
        }
    }
}

if (!function_exists('dkpp_upload_file')) 
{
    function dkpp_upload_file($field_name, $filename)
    {
        $ci = &get_instance();

        $config['upload_path'] = $ci->data['file_path'];
        $config['allowed_types'] = 'pdf';
        $config['file_name'] = $filename;
        $config['overwrite'] = true;
        $config['max_size'] = 1024; // 1MB

        $ci->load->library('upload', $config);

        if ($ci->upload->do_upload($field_name)) {
            return array('status' => TRUE, 'message' => $ci->upload->data('file_name'));
        } else {
            return array('status' => FALSE, 'message' => $ci->upload->display_errors());
        }
    }
}

if (!function_exists('jenisKelamin')) 
{
    function jenisKelamin($id)
    {
        switch ($id) {
            case 'L':
                $return = 'Laki-Laki';
                break;
            case 'P':
                $return = 'Perempuan';
                break;
            default:
                $return = '-';
                break;
        }

        return $return;
    }
}

if (!function_exists('jenisKelamin_angka')) 
{
    function jenisKelamin_angka($id)
    {
        switch ($id) {
            case '1':
                $return = 'Laki-Laki';
                break;
            case '2':
                $return = 'Perempuan';
                break;
            default:
                $return = '-';
                break;
        }

        return $return;
    }
}

if (!function_exists('pendidikan')) 
{
    function pendidikan($id)
    {
        switch ($id) {
            case '1':
                $return = 'SD';
                break;
            case '2':
                $return = 'SMP';
                break;
            case '3':
                $return = 'SMA';
                break;
            case '4':
                $return = 'D-III';
                break;
            case '5':
                $return = 'D-IV/S1';
                break;
            case '6':
                $return = 'S2';
                break;
            case '7':
                $return = 'S3';
                break;
            default:
                $return = '-';
                break;
        }

        return $return;
    }
}

if (!function_exists('status_anak')) 
{
    function status_anak($id)
    {
        switch ($id) {
            case '1':
                $return = 'Kandung';
                break;
            case '2':
                $return = 'Angkat';
                break;
            default:
                $return = 'Tidak Diketahui';
                break;
        }

        return $return;
    }
}

if (!function_exists('hubungan_keluarga')) 
{
    function hubungan_keluarga($id)
    {
        switch ($id) {
            case 1:
                $return = 'Ayah';
                break;
            case 2:
                $return = 'Ibu';
                break;
            case 3:
                $return = 'Suami';
                break;
            case 4:
                $return = 'Istri';
                break;
            default:
                $return = 'Tidak Diketahui';
                break;
        }

        return $return;
    }
}

if (!function_exists('status_hidup')) 
{
    function status_hidup($id)
    {
        switch ($id) {
            case 1:
                $return = '<h6><span class="badge bg-soft-success text-success">Hidup</span></h6>';
                break;
            case 2:
                $return = '<h6><span class="badge bg-soft-danger text-danger">Meninggal</span></h6>';
                break;
            default:
                $return = '<h6><span class="badge bg-soft-secondary text-secondary">-</span></h6>';
                break;
        }

        return $return;
    }
}

if (!function_exists('status_perkawinan')) 
{
    function status_perkawinan($id)
    {
        switch ($id) {
            case 1:
                $return = 'Belum Menikah';
                break;
            case 2:
                $return = 'Menikah';
                break;
            case 3:
                $return = 'Cerai Hidup';
                break;
            case 4:
                $return = 'Cerai Mati';
                break;
            default:
                $return = 'Tidak Diketahui';
                break;
        }

        return $return;
    }
}

if (!function_exists('agama')) 
{
    function agama($id)
    {
        switch ($id) {
            case 1:
                $return = 'Islam';
                break;
            case 2:
                $return = 'Protestan';
                break;
            case 3:
                $return = 'Katolik';
                break;
            case 4:
                $return = 'Hindu';
                break;
            case 5:
                $return = 'Buddha';
                break;
            case 6:
                $return = 'Khonghucu';
                break;
            default:
                $return = '-';
                break;
        }

        return $return;
    }
}

if (!function_exists('show_msg')) 
{
    function show_msg($messages, $status = false, $redirect_link = null)
    {
        
        $CI =& get_instance();
        $array = array('status' => $status, 'message' => $messages);
        
        if ($redirect_link !== null) {
            $array['redirect_link'] = $redirect_link;
        }

        return $CI->load->view('errors/html/error_bootbox', $array, TRUE);
    }
}

if (!function_exists('check_islogin')) 
{
    function check_islogin()
    {
        $CI =& get_instance();

        if ($CI->session->userdata('dkpp_loggedin') == FALSE || empty($CI->session->userdata('dkpp_loggedin')) || $CI->session->userdata('dkpp_loggedin') == NULL) {
            return FALSE;
        } else {
            return TRUE;
        }
    }
}

if (!function_exists('label_required')) 
{
    function label_required ($id = null)
    {
        return '<span id="'.$id.'" class="text-danger">*</span>';
    }
}

if (!function_exists('whitelist_label')) 
{
    function whitelist_label ($id = null)
    {
        return '<span id="'.$id.'" class="text-success">*</span>';
    }
}

if (!function_exists('make_button')) {
    function make_button($btn_name, $btn_label, $btn_tag, $btn_type, $btn_size='', $custom_class='', $btn_icon = '', $btn_link = '#', $modal = false, $modal_name = '')
    {
        if($btn_tag=='a') {
            $btn_link_tag = 'href';
        }else{
            $btn_link_tag = 'data-action';
        }

        if($btn_link !== '#') {
            $btn_link = base_url($btn_link);
        }

        if($btn_icon !== '') {
            $btn_icon = '<i class="'.$btn_icon.'"></i>';
        }

        if($modal == true) {
            $data_modal = 'data-toggle="modal" data-target="#'.$modal_name.'"';
        } else {
            $data_modal = '';
        }

        return '<'.$btn_tag.' id="'.$btn_name.'" '.$btn_link_tag.'="' . $btn_link . '" class="btn '.$btn_size.' '.$btn_type.' '.$custom_class.'" '.$data_modal.'>'.$btn_icon. ' ' .$btn_label.'</'.$btn_tag.'>';
    }
}

if (!function_exists('time_convert')) {
    function time_convert($time = '')
    {
       if ($time) {
           $result = date('H:i', strtotime($time));
       } else {
           $result = '';
       }

       return $result;
    }
}

if (!function_exists('uc_words')) 
{
    function uc_words($data)
    {
        $word = strtolower($data);
        $result = ucwords($word);
        
        return $result;
    }
}

if (!function_exists('phone_number')) {
    function phone_number($phone_number)
    {
        $data = sprintf(
            "%s-%s-%s",
            substr($phone_number, 0, 4),
            substr($phone_number, 4, 4),
            substr($phone_number, 8)
        );

        return $data;
    }
}

if (!function_exists('cut_character')) {
    function cut_character($string, $lenght)
    {
        if (strlen($string) <= $lenght) {
            return $string;
        } else {
            return substr($string, 0, $lenght) . '...'; 
        }
    }
}

if (!function_exists('age_counter')) {
    function age_counter($date, $year = FALSE)
    {
        $_date = new DateTime($date);
        $_today = new DateTime('today');
        $_year = $_today->diff($_date)->y;
        $_month = $_today->diff($_date)->m;
        $_day = $_today->diff($_date)->d;

        if ($year === TRUE) {
            return $_year ." Tahun " . $_month ." Bulan " . $_day ." Hari";
        } else {
            return $_year ." Tahun";
        }
    }
}

if (!function_exists('array_debug')) {
    function array_debug($data)
    {
        return "<pre>".print_r($data, true)."</pre>";
    }
}

if (!function_exists('tgl_dt')) {
    function tgl_dt($tgl = '')
    {
        $result = '
            <div class="d-flex align-items-center">
                <i class="mdi mdi-calendar-month-outline font-18 text-success me-1"></i>
                <div class="w-100">
                    <h5 class="mt-1 font-size-14">
                        '.(!empty($tgl) ? format_indo($tgl, '') : '').'
                    </h5>
                </div>
            </div>
        ';

        return $result;
    }
}

if (!function_exists('modal_feedback')) {
    function modal_feedback($type, $icon, $title, $desc, $flashdata_name)
    {
        $CI =& get_instance();
        $message = '
            <div class="alert alert-'.$type.' alert-dismissible fade show mt-4">
                <div class="d-flex justify-content-start">
                    <span class="alert-icon m-r-20 font-size-30">
                        <i class="anticon anticon-'.$icon.'-circle"></i>
                    </span>
                    <div>
                        <h5 class="alert-heading">'.$title.'</h5>
                        <p>'.$desc.'</p>
                    </div>
                </div>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        ';

        $CI->session->set_flashdata($flashdata_name, $message);
    }
}

if (!function_exists('generate_otp')) {
    function generate_otp($length)
    {
        $number = "1357902468";
        $result = "";

        for ($i = 1; $i <= $length; $i++) {
            $result .= substr($number, (rand() % (strlen($number))), 1);
        }

        return $result;
    }
}

if (!function_exists('generate_slug')) {
    function generate_slug($table = '', $name = '', $data = null)
    {
        
        $CI =& get_instance();
        
        $config = array(
            'table' 		=> $table,
            'name'  		=> $name,
            'id' 			=> 'id',
            'field' 		=> 'slug',
            'replacement' 	=> 'dash'
        );

        $CI->load->library('slug', $config);

        return $CI->slug->create_uri($data);
    }
}

if (!function_exists('get_user_ip')) {
    function get_user_ip()
    {
        if (isset($_SERVER["HTTP_CF_CONNECTING_IP"])) {
            $_SERVER['REMOTE_ADDR'] = $_SERVER["HTTP_CF_CONNECTING_IP"];
            $_SERVER['HTTP_CLIENT_IP'] = $_SERVER["HTTP_CF_CONNECTING_IP"];
        }

        $client  = @$_SERVER['HTTP_CLIENT_IP'];
        $forward = @$_SERVER['HTTP_X_FORWARDED_FOR'];
        $remote  = $_SERVER['REMOTE_ADDR'];

        if(filter_var($client, FILTER_VALIDATE_IP))
        {
            $ip = $client;
        }
        elseif(filter_var($forward, FILTER_VALIDATE_IP))
        {
            $ip = $forward;
        }
        else
        {
            $ip = $remote;
        }

        return $ip;
    }
}

if (!function_exists('files_get_file_path')) {
    function files_get_file_path($index)
    {
        $CI =& get_instance();
        $total_segments = $CI->uri->total_segments();
        $filename = '';
        for ($i=$index; $i <= $total_segments; $i++) { 
            if($i !== $total_segments){
                $filename .= $CI->uri->slash_segment($i);
            }else{
                $filename .= $CI->uri->segment($i);
            }
        }

        return $filename;
    }
}

if (!function_exists('lap_content')) {
    function lap_content($orientation, $view, $data = null, $multi=false)
    {
        $CI = &get_instance();

        if ($multi==true) {
            $ar_data = [];
            foreach ($view as $row) {
                $ar_data[] = $CI->load->view($row, $data, TRUE);
            }
    
            $c_data = $ar_data;
        }else {
            $c_data = $CI->load->view($view, $data, TRUE);
        }
       

        return array(
            'm' => $multi,
            'o' => $orientation,
            'c' => $c_data
        );
    }
}

if (!function_exists('array_key_tolower')) {
    function array_key_tolower(array $data) {
        $keys = array();
        foreach ($data as $key => $value) {
            $keys[$key] = strtolower($key);
        }
        $data = array_combine(array_merge($data, $keys), $data);
        return $data;
   }
}

if (!function_exists('fix_number')) {
    function fix_number($number, $digit)
    {
        $prefix = '';
        if (strlen($number) < $digit) {
            for ($i = strlen($number); $i < $digit; $i++) {
                $prefix .= '0';
            }
        }

        return $prefix . $number;
    }
}

function mask_email($str, $first, $last) {
    $len = strlen($str);
    $toShow = $first + $last;
    return substr($str, 0, $len <= $toShow ? 0 : $first).str_repeat("*", $len - ($len <= $toShow ? 0 : $toShow)).substr($str, $len - $last, $len <= $toShow ? 0 : $last);
}

function obfuscate_email($email) {
    $mail_parts = explode("@", $email);
    $domain_parts = explode('.', $mail_parts[1]);

    $mail_parts[0] = mask_email($mail_parts[0], 2, 1); // show first 2 letters and last 1 letter
    $domain_parts[0] = mask_email($domain_parts[0], 2, 1); // same here
    $mail_parts[1] = implode('.', $domain_parts);

    return implode("@", $mail_parts);
}

if (!function_exists('btn_link')) 
{
    function btn_link($link_g_site)
    {
        if (!empty($link_g_site)) {
            $result = "<a class='btn btn-success btn-xs' href=" . $link_g_site. " target='_blank'>Kunjungi Link</a>";
        } else {
            $result = "<a class='btn btn-outline-dark waves-effect waves-light btn-xs'>Kosong</a>";
        }

        return $result;
    }
}

if (!function_exists('two_row')) {
    function two_row($first_row = '', $icon1 = '', $second_row = '', $icon2 = '', $ket = '')
    {
        if(empty($second_row)){
            $second_row = "0";
        }
        if(!empty($ket)){
            $result = '
            <div class="media d-inline-flex align-items-center">
                <div class="media-body">
                    <div class="mb-1">
                        <i class="'.$icon1.'"></i>
                        <span class="font-13">
                        '.$first_row.'
                        </span>
                    </div>
                    <hr style="margin-bottom: 0.5em;margin-top: 0.5em;">

                    <i class="'.$icon2.'"></i>
                    <span class="font-13">
                        '.$second_row.' hari cuti sudah dipakai
                    </span>
                </div>
            </div>
        ';

        }else{
            $result = '
                <div class="media d-inline-flex align-items-center">
                    <div class="media-body">
                        <div class="mb-1">
                            <i class="'.$icon1.'"></i>
                            <span class="font-13">
                            '.$first_row.'
                            </span>
                        </div>
                        <hr style="margin-bottom: 0.5em;margin-top: 0.5em;">

                        <i class="'.$icon2.'"></i>
                        <span class="font-13">
                            '.$second_row.'
                        </span>
                    </div>
                </div>
            ';

        }

        return $result;
    }
}

if (!function_exists('jadwal_format')) {
    function jadwal_format($awal = '', $akhir = '', $hari = '')
    {
        $result = '
            <div class="media d-inline-flex align-items-center">
                <div class="media-body">
                    <div class="mb-1">
                        <span class="font-13">
                        '.$hari.'
                        </span>
                    </div>
                    <hr style="margin-bottom: 0.5em;margin-top: 0.5em;">

                    <i class="fe-clock text-success mr-1"></i>
                    <span class="font-13">
                        '.$awal.' s.d '.$akhir.'
                    </span>
                </div>
            </div>
        ';

        return $result;
    }
}

if (!function_exists('lama_cuti')) {
    function lama_cuti($awal = '', $akhir = '', $hari = '')
    {
        $result = '
            <div class="media d-inline-flex align-items-center">
                <div class="media-body">
                    <div class="mb-1">
                        <span class="font-13">
                        '.$hari.' Hari Kerja
                        </span>
                    </div>
                    <hr style="margin-bottom: 0.5em;margin-top: 0.5em;">

                    <i class="fe-clock text-success mr-1"></i>
                    <span class="font-13">
                        '.date('d-M-Y', strtotime($awal)).' s.d '.date('d-M-Y', strtotime($akhir)).'
                    </span>
                </div>
            </div>
        ';

        return $result;
    }
}



if (!function_exists('tipe_sekolah')) 
{
    function tipe_sekolah($tipe_sekolah)
    {
        if (!empty($tipe_sekolah)) {
            if($tipe_sekolah == 'TK'){
                $result = "<span class='badge bg-soft-success text-success'>TK</span>";
            }else if($tipe_sekolah == 'SD'){
                $result = "<span class='badge bg-soft-danger text-danger'>SD</span>";
            }else if($tipe_sekolah == 'SMP'){
                $result = "<span class='badge bg-soft-danger text-blue'>SMP</span>";
            }else if($tipe_sekolah == 'SPS'){
                $result = "<span class='badge bg-soft-info text-info'>SPS</span>";
            }else if($tipe_sekolah == 'SKB'){
                $result = "<span class='badge bg-soft-pink text-pink'>SKB</span>";
            }else if($tipe_sekolah == 'KB'){
                $result = "<span class='badge bg-soft-warning text-warning'>KB</span>";
            }else if($tipe_sekolah == 'PKBM'){
                $result = "<span class='badge bg-soft-secondary text-secondary'>PKBM</span>";
            }else{
                $result = "<span class='badge bg-soft-blue text-blue'>TPA</span>";
            }
        } else {
            $result = "<a class='btn btn-outline-dark waves-effect waves-light btn-xs'>Kosong</a>";
        }

        return $result;
    }
}

if (!function_exists('btn_verifikasi_mutasi')) 
{
    function btn_verifikasi_mutasi($id, $session_id, $status_field, $keyid = '', $link_status = '', $modal_name = '')
    {
        $a = '';
        
        if ($id !== $session_id) {
            if ($keyid !== '') {
                $id = encrypt_url($id, $keyid);
            }

            if ($link_status !== '' && $link_status !== ' ' ) {
                $a_tag = 'a';
                $link_status = 'href="' . base_url($link_status . $id) . '"';
            } else {
                $a_tag = 'span';
                $link_status = "";

                if ($modal_name !== '') {
                    $modal_attr = 'data-toggle="modal" data-target="#' . $modal_name . '"';
                } else {
                    $modal_attr = '';
                }
            }

            if ($status_field == '0'){
                $a = '<' . $a_tag . ' ' . $link_status . ' class="button-verif btn btn-icons btn-rounded btn-outline-success" data-tooltip="tooltip" data-placement="bottom" title="" data-original-title="Terima Verifikasi"  data-id="' . $id . '" ' . $modal_attr . '>
                <i class="mdi mdi-check-all"></i>
                </' . $a_tag . '> <' . $a_tag . ' ' . $link_status . ' data-status="1" class="button-ditolak btn btn-icons btn-rounded btn-outline-danger" data-tooltip="tooltip" data-placement="bottom" title="" data-original-title="Tolak Verifikasi"  data-id="' . $id . '">
                    <i class="mdi mdi-close-outline"></i>
                </' . $a_tag . '>';
            } else {
                $a = '<strong>-</strong>';
            }  
        }
        return $a;
    }
}

if (!function_exists('btn_verif_tolak')) 
{
    function btn_verif_tolak($id, $session_id, $action, $link_url = '', $keyid = '', $modal_name = '', $attr =  '', $status_field = '', $berkas = '', $directory = '')
    {
        $a = '';

        if ($id !== $session_id) {
            if ($keyid !== '') {
                $id = encrypt_url($id, $keyid);
            }

            if ($link_url !== '') {
                $a_tag = 'a';
                $link_url = 'href="' . base_url($link_url . $id) . '"';
                $modal_attr = '';
            } else {
                $a_tag = 'span';
                $link_url = "";
                if ($modal_name !== '') {
                    $modal_attr = 'data-toggle="modal" data-target="#' . $modal_name . '"';
                } else {
                    $modal_attr = '';
                }
            }

            if ($status_field == '0'){
                if ($action == "tolak") {
                    $a = '<' . $a_tag . ' ' . $link_url . ' data-status="1" class="button-ditolak btn btn-icons btn-rounded btn-outline-danger" data-tooltip="tooltip" data-placement="bottom" title="" data-original-title="Tolak Verifikasi"  data-id="' . $id . '">
                    <i class="mdi mdi-close-outline"></i> </' . $a_tag . '>';

                } elseif ($action == "verif") {
                    $a = '<' . $a_tag . ' ' . $link_url . ' '. $attr .' class="button-edit btn btn-icons btn-rounded btn-outline-success" title="Verifikasi" data-plugin="tippy" data-tippy-size="small" data-id="' . $id . '" ' . $modal_attr . '>
                    <i class="mdi mdi-check-all"></i>
                            </' . $a_tag . '>';
                }
            } else if ($status_field == '1'){
                if ($action == "verif") {
                    if (!empty($berkas)) {
                        $a = "<a class='btn btn-success btn-xs' href=" . str_files_not_owner_must_login($directory, $berkas) . " target='_blank'>Lihat file</a>";
                    } else {
                        $a = '<h6><span class="badge bg-soft-secondary text-secondary"> Tidak memiliki file</span></h6>';
                    }
                }
            }else {
                $a = '<strong>-</strong>';
            }

        }

        return $a;
    }
}


if (!function_exists('tabel_icon_mutasi')) {
    function tabel_icon_mutasi($id, $session_id, $action, $link_url = '', $keyid = '', $modal_name = '', $attr =  '', $status)
    {
        $a = '';

        if ($id !== $session_id) {
            if ($keyid !== '') {
                $id = encrypt_url($id, $keyid);
            }

            if ($link_url !== '') {
                $a_tag = 'a';
                $link_url = 'href="' . base_url($link_url . $id) . '"';
                $modal_attr = '';
            } else {
                $a_tag = 'span';
                $link_url = "";
                if ($modal_name !== '') {
                    $modal_attr = 'data-toggle="modal" data-target="#' . $modal_name . '"';
                } else {
                    $modal_attr = '';
                }
            }

            if($status == '0'){
                if ($action == "delete") {
                    $a = '<' . $a_tag . ' ' . $link_url . '  '. $attr .' class="button-hapus btn btn-danger waves-effect waves-light btn-xs" title="Hapus" data-plugin="tippy" data-tippy-size="small" data-id="' . $id . '" >
                                    <i class="icon-trash"></i>
                            </' . $a_tag . '>';
                } elseif ($action == "edit") {
                    $a = '<' . $a_tag . ' ' . $link_url . ' '. $attr .' class="button-edit btn btn-warning waves-effect waves-light btn-xs" title="Edit" data-plugin="tippy" data-tippy-size="small" data-id="' . $id . '" ' . $modal_attr . '>
                                    <i class="icon-note"></i>
                            </' . $a_tag . '>';
                }
            } else {
                $a = '<strong>-</strong>';
            }
                
            
        }

        return $a;
    }
}

if (!function_exists('two_row_two_line')) {
    function two_row_two_line($first_row = '', $line_1 = '', $second_row = '', $line_2 = '')
    {
        $result = '
            <div class="media d-inline-flex align-items-center">
                <div class="media-body">
                    <div class="mb-1">
                        <span class="font-13">
                        '.$first_row.' - '.date('d-m-Y', strtotime($line_1)).'
                        </span>
                        <hr style="margin-bottom: 0.5em;margin-top: 0.5em;">

                    </div>
                    <span class="font-13">
                        '.$second_row.' - '.date('d-m-Y', strtotime($line_2)).'
                    </span>
                </div>
            </div>
        ';

        return $result;
    }
}



if (!function_exists('format_alamat')) {
    function format_alamat($nagari = '', $kecamatan = '', $kabupaten = '', $provinsi = '', $icon = '', $alamat_lengkap = '', $icon2 = '', $no_telp = '')
    {
        $result = '
            <div class="media d-inline-flex align-items-center">
                <div class="media-body">
                    <span class="font-13">
                    '.uc_words($alamat_lengkap).'
                    </span>
                    <div class="mb-1">
                        <i class="'.$icon.'"></i>
                        <span class="font-13">
                        '.'Kelurahan ' . uc_words($nagari) . ', Kecamatan ' . uc_words($kecamatan) . ', ' . uc_words($kabupaten) . ', Provinsi ' . uc_words($provinsi).'
                        </span>
                    </div>
                    <hr style="margin-bottom: 0.5em;margin-top: 0.5em;">

                    <i class="'.$icon2.'"></i>
                    <span class="font-13">
                        '.$no_telp.'
                    </span>
                </div>
            </div>
        ';

        return $result;
    }
}

if (!function_exists('name_degree')) 
{
    function name_degree($gelar_depan, $nama_pegawai, $gelar_blkng, $xss_option = FALSE)
    {
        if ($xss_option == TRUE) {
            if ($gelar_depan) {
                $gelar_depan = xss_escape($gelar_depan.'. ');
            }
    
            if ($gelar_blkng) {
                $gelar_blkng = xss_escape(', '.$gelar_blkng);
            }
    
            $nama_pegawai = xss_escape($nama_pegawai);
        } else {
            if ($gelar_depan) {
                $gelar_depan = $gelar_depan.'. ';
            }
    
            if ($gelar_blkng) {
                $gelar_blkng = ', '.$gelar_blkng;
            } 
        }

        return $gelar_depan.$nama_pegawai.$gelar_blkng;
    }
}

if (!function_exists('icon_employee')) {
    function icon_employee($nama_pegawai = '', $gelar_depan = '', $gelar_blkng = '', $nip = '', $status_pegawai = '', $type = '', $profile = '', $marquee = '')
    {
        $_profile = generate_avatar($profile, $nama_pegawai, 'mr-2 avatar-sm rounded', 'width="44" alt="profile image"');
       
        if ($type == 'PNS'){
            $nama = name_degree($gelar_depan, $nama_pegawai, $gelar_blkng);
        }else {
            $nama = $nama_pegawai;
        }
        
            $result = '
                <div class="media d-inline-flex align-items-center">
                    '.(!empty($_profile) ? $_profile: '').'
                    <div class="media-body">
                        <div class="'.(!empty($marquee) ? 'marquee-md' : '').' ">
                            <a href="javascript: void(0);" class="text-default font-weight-semibold letter-icon-title">'.$nama.'</a>
                        </div>
                        <span class="font-13">
                            '.$nip.'
                        </span>
                    </div>
                </div>
            ';
        
        

        return $result;
    }
}

if (!function_exists('icon_username')) {
    function icon_username($username = '', $level = '',$marquee = '')
    {
        
        $result = '
           
            <div class="media-body">
                <div class="'.(!empty($marquee) ? 'marquee-md' : '').' ">
                    <a href="javascript: void(0);" class="text-default font-weight-semibold letter-icon-title">'.str_level($level).'</a>
                </div>
                <span class="font-13">
                    '.$username.'
                </span>
            </div>
        ';

        return $result;
    }
}

if (!function_exists('jk')) 
{
    function jk($jenis_kelamin)
    {
        if (!empty($jenis_kelamin)) {
            if($jenis_kelamin == 'L'){
                $result = "Laki-laki";
            } else{
                $result = "Perempuan";
            }
        } else {
            $result = "<a class='btn btn-outline-dark waves-effect waves-light btn-xs'>Kosong</a>";
        }

        return $result;
    }
}

if (!function_exists('jumlah')) 
{
    function jumlah($jumlah, $satuan)
    {
        if ($jumlah == "0") {
            $result = "<a class='btn btn-outline-dark waves-effect waves-light btn-xs'>Belum Ada $satuan</a>";
        } else {
            $result = "<a class='btn btn-outline-success waves-effect waves-light btn-xs'>$jumlah $satuan</a>";
        }

        return $result;
    }
}

if (!function_exists('status_kgb')) {
    function status_kgb($status,$alasan = '')
    {
        $a = '';
 
        if ($status == '0') {
            $a = '<h6><span class="badge bg-soft-warning text-warning"><i class="mdi mdi-bookmark-check"></i> Menunggu Persetujuan</span></h6>';
        }else if ($status == '1') {
            $a = '<h6><span class="badge bg-soft-success text-success"><i class="mdi mdi-bookmark-check"></i> Disetujui</span></h6>';
        } else if ($status == '2') {
            $a = '<h6><span class="badge bg-soft-secondary text-secondary"><i class="mdi mdi-bookmark-remove"></i> Ditolak</span></h6>
                <h6><span class="badge bg-soft-dark text-dark">Alasan : '.$alasan.'</span></h6><br>';
        } else {
            $a = '<h6><span class="badge bg-soft-info text-info"><i class="mdi mdi-bookmark-check"></i> Belum Diajukan</span></h6>';
        }

        return $a;
    }
}

if (!function_exists('age')) {
    function age($age)
    {
        if (!empty($age)) {
            return $age ." Tahun ";
        } else {
            return '<strong>-</strong>';
        }
    }
}

if (!function_exists('str_kedudukan_hukum')) {
    function str_kedudukan_hukum($status)
    {
        $a = '';

        if (strtolower($status) == '44' || strtolower($status) == '1'){
            $a = '<h6><span class="badge bg-soft-success text-success"><i class="mdi mdi-account-check-outline"></i> Aktif</span></h6>';
        } else if (strtolower($status) == '32') {
            $a = '<h6><span class="badge bg-soft-blue text-blue"><i class="mdi mdi-school-outline"></i> Tugas Belajar</span></h6>';
        } else if (strtolower($status) == '34') {
            $a = '<h6><span class="badge bg-soft-dark text-dark"><i class="mdi mdi-window-open-variant"></i> Meninggal</span></h6>';
        } else if (strtolower($status) == '35') {
            $a = '<h6><span class="badge bg-soft-secondary text-secondary"><i class="mdi mdi-human-wheelchair"></i> Pensiun</span></h6>';
        } else if (strtolower($status) == '150') {
            $a = '<h6><span class="badge bg-soft-secondary text-secondary"><i class="mdi mdi-human-wheelchair"></i> Pensiun BUP</span></h6>';
        } else {
            $a = '<h6><span class="badge bg-soft-secondary text-secondary"><i class="mdi mdi-close-box-multiple-outline"></i> Tidak Diketahui</span></h6>';
        }

        return $a;
    }
}

if (!function_exists('icon_gallery')) {
    function icon_gallery($judul = '', $type = '')
    {   
        
        if ($type == '1'){
            $a = 'Foto';
            $icon = 'fe-camera text-success mr-1';
        } else {
            $a = 'Video';
            $icon = 'fe-youtube text-danger mr-1';
        }

        if(empty($second_row)){
            $second_row = "0";
        }

        $result = '
            <div class="media d-inline-flex align-items-center">
                <div class="media-body">
                    <div class="mb-1">
                        <i class="fe-star-on text-success mr-1"></i>
                        <span class="font-13">
                        '.$judul.'
                        </span>
                    </div>
                    <hr style="margin-bottom: 0.5em;margin-top: 0.5em;">

                    <i class="'.$icon.'"></i>
                    <span class="font-13">
                        '.$a.'
                    </span>
                </div>
            </div>
        ';
        return $result;
    }
}

if (!function_exists('btn_struktur'))
{
    function btn_struktur($id, $session_id, $status, $link_url = '', $keyid = '', $modal_name = '', $attr = '')
    {
        $a = '';

        if ($id !== $session_id) {
            if ($keyid !== '') {
                $id = (!empty($id)) ? encrypt_url($id, $keyid) : null;
            }

            if ($link_url !== '') {
                $a_tag = 'a';
                $link_url = 'href="' . base_url($link_url . $id) . '"';
                $modal_attr = '';
            } else {
                $a_tag = 'span';
                $link_url = "";
                if ($modal_name !== '') {
                    $modal_attr = 'data-toggle="modal" data-target="#' . $modal_name . '"';
                } else {
                    $modal_attr = '';
                }
            }

            if ($status == "1") {
                $a = '<' . $a_tag . ' ' . $link_url . ' '. $attr .' class="button-edit btn btn-warning waves-effect waves-light btn-xs" title="Edit" data-plugin="tippy" data-tippy-size="small" data-id="' . $id . '" ' . $modal_attr . '>
                    <i class="icon-note"></i>
                    </' . $a_tag . '> <' . $a_tag . ' ' . $link_url . '  '. $attr .' class="button-hapus btn btn-danger waves-effect waves-light btn-xs" title="Hapus" data-plugin="tippy" data-tippy-size="small" data-id="' . $id . '" >
                    <i class="icon-trash"></i>
                    </' . $a_tag . '>';
            } else {
                $a = '<' . $a_tag . ' ' . $link_url . '  '. $attr .' class="button-hapus btn btn-danger waves-effect waves-light btn-xs" title="Hapus" data-plugin="tippy" data-tippy-size="small" data-id="' . $id . '" >
                                    <i class="icon-trash"></i>
                            </' . $a_tag . '>';
            }
        }

        return $a;
    }
}

if (!function_exists('aksi_upload_foto'))
{
    function aksi_upload_foto($id, $session_id, $link_url = '', $keyid = '', $modal_name = '', $attr = '', $profil = '', $nip = '', $pegawai_id = '' )
    {
        $a = '';

        if ($id !== $session_id) {
            if ($keyid !== '') {
                $id = (!empty($id)) ? encrypt_url($id, $keyid) : null;
                $pegawai_id = (!empty($pegawai_id)) ? encrypt_url($pegawai_id, $keyid) : null;
            }

            if ($link_url !== '') {
                $a_tag = 'a';
                $link_url = 'href="' . base_url($link_url . $id) . '"';
                $modal_attr = '';
            } else {
                $a_tag = 'span';
                $link_url = "";
                if ($modal_name !== '') {
                    $modal_attr = 'data-toggle="modal" data-target="#' . $modal_name . '"';
                } else {
                    $modal_attr = '';
                }
            }

            if ($profil != null) {
                $a = '<' . $a_tag . ' ' . $link_url . ' '. $attr .' class="button-edit btn btn-icons btn-rounded btn-primary" data-tooltip="tooltip" data-placement="bottom" title="" data-original-title="Edit Foto" data-id="' . $id . '" data-nip="' . $nip . '" data-pegawai="' . $pegawai_id . '" ' . $modal_attr . '>
                    <i class="mdi mdi-pencil"></i>
                </' . $a_tag . '>';
            } else {
                $a = '<' . $a_tag . ' ' . $link_url . ' '. $attr .' class="button-create btn btn-icons btn-rounded btn-success" data-tooltip="tooltip" data-placement="bottom" title="" data-original-title="Tambah Foto" data-id="' . $id . '" data-nip="' . $nip . '" data-pegawai="' . $pegawai_id . '" ' . $modal_attr . '>
                    <i class="mdi mdi-plus">
                </' . $a_tag . '>';
            }
        }

        return $a;
    }
}


if (!function_exists('rupiah')) {
    function rupiah($value)
    {
        $text = '';
        if (!empty($value)) {  
            $text = "Rp. " . number_format($value, 2, ",", ".");
        } else {
            $text = "Rp. " . "0";
        }
        return $text;
    }
}

if (!function_exists('jenis_komoditas')) 
{
    function jenis_komoditas($jenis)
    {
        $a = '';

        if ($jenis == '1') {
            $a = '<h6><span class="badge bg-soft-blue text-blue"><i class="mdi mdi-fish"></i> Ikan Laut</span></h6>';
        } else if ($jenis == '2') {
            $a = '<h6><span class="badge bg-soft-secondary text-secondary"><i class="mdi mdi-fish"></i> Ikan Air Tawar</span></h6>';
        } else if ($jenis == '3') {
            $a = '<h6><span class="badge bg-soft-success text-success"><i class="mdi mdi-barley"></i>Bahan pokok</span></h6>';
        } else if ($jenis == '4') {
            $a = '<h6><span class="badge bg-soft-success text-success"><i class="mdi mdi-barley"></i>PSAT</span></h6>';
        } else {
            $a = 'Tidak Diketahui';
        }

        return $a;
    }
}

if (!function_exists('jum_produksi')) 
{
    function jum_produksi($jum, $satuan)
    {
        $a = '';

        if (!empty($jum) && !empty($satuan)) {
            $a = number_format($jum) ."(". $satuan .")";
        } 
        return $a;
    }
}

if (!function_exists('jenis_perairan')) {
    function jenis_perairan($type)
    {
        $a = '';

        if ($type == '1') {
            $a = '<h6><span class="badge bg-soft-blue text-blue"><i class="mdi mdi-bookmark-check"></i> Perairan Laut</span></h6>';
        } else {
            $a = '<h6><span class="badge bg-soft-warning text-warning"><i class="mdi mdi-bookmark-remove"></i> Perairan PUD</span></h6>';
        }

        return $a;
    }
}

if (!function_exists('indikator')) {
    function indikator($jenis)
    {
        $a = '';

        if ($jenis == '1') {
            $a = '<h6><span class="badge bg-soft-secondary text-secondary"><i class="mdi mdi-bookmark-check"></i>Armada</span></h6>';
        } else if ($jenis == '2') {
            $a = '<h6><span class="badge bg-soft-secondary text-secondary"><i class="mdi mdi-bookmark-remove"></i>Alat Tangkap</span></h6>';
        } else {
            $a = '<h6><span class="badge bg-soft-secondary text-secondary"><i class="mdi mdi-bookmark-remove"></i>Alat Bantu Penangkapan</span></h6>';
        }

        return $a;
    }
}

if (!function_exists('jumlah_sum')) {
    function jumlah_sum($value)
    {
        $text = '';
        if (!empty($value)) {  
            $text = $value;
        } else {
            $text = "0";
        }
        return $text;
    }
}

if (!function_exists('cekdesimal')) {
    function cekdesimal($number)
    {
        if($number !== false){
            $number = round($number,2);
        }
        return $number;
    }
}

if (!function_exists('produksi')) {
    function produksi($value)
    {
        $text = '';
        if (!empty($value)) {  
            $text = number_format($value, 0, ",", ".");
        } else {
            $text = "0";
        }
        return $text;
    }
}

if (!function_exists('skala')) {
    function skala($jenis)
    {
        $a = '';

        if ($jenis == '1') {
            $a = '<h6><span class="badge bg-soft-secondary text-secondary"><i class="mdi mdi-bookmark-check"></i>Kecil</span></h6>';
        } else if ($jenis == '2') {
            $a = '<h6><span class="badge bg-soft-warning text-secondary"><i class="mdi mdi-bookmark-check"></i>Menengah</span></h6>';
        } else {
            $a = '<h6><span class="badge bg-soft-blue text-secondary"><i class="mdi mdi-bookmark-check"></i>Besar</span></h6>';
        }

        return $a;
    }
}

if (!function_exists('jenis_kusioner')) 
{
    function jenis_kusioner($jenis)
    {
        $a = '';

        if ($jenis == '1') {
            $a = '<h6><span class="badge bg-soft-blue text-blue"><i class="mdi mdi-alpha-t-box"></i> Pasca Panen</span></h6>';
        } else if ($jenis == '2') {
            $a = '<h6><span class="badge bg-soft-secondary text-secondary"><i class="mdi mdi-alpha-t-box"></i> Budidaya</span></h6>';
        } else {
            $a = 'Tidak Diketahui';
        }

        return $a;
    }
}

if (!function_exists('opsi_kusioner')) 
{
    function opsi_kusioner($id, $opsi)
    {
        $a = '';

        if ($opsi == '1') {
            $a = '<input type="hidden" class="form-control" name="idopsi" id="idopsi" value="' . $id . '">
            <label class="radio-inline mr-3">
            <input type="radio" name="inlineRadioOptions" id="opsiYes" value="1" data-id="' . $id . '"> Sesuai</label>
          <label class="radio-inline">
            <input type="radio" name="inlineRadioOptions" id="opsiNo" value="0" data-id="' . $id . '">Tidak</label>';
        } else  {
            $a = '<input type="hidden" class="form-control" name="idopsi" id="idopsi" value="' . $id . '">
            <input type="text" class="form-control" name="opsiEntry" id="opsiEntry" placeholder ="Jawaban Anda" data-id="' . $id . '">';
        } 

        return $a;
    }
}

if (!function_exists('opsi')) {
    function opsi($opsi)
    {
        $text = '';
        if (!empty($opsi)) {  
            if ($opsi == '1'){
                $text = "Sesuai";
            } else if ($opsi == '2'){
                $text = "Tidak Sesuai";
            } else {
                $text = $opsi;
            }
        } 
        return $text;
    }
}

if (!function_exists('set_null')) {
    function set_null($field)
    {
        $text = '';
        if (!empty($opsi)) {  
            $text = $field;
        } else {
            $text = '-';
        }
        
        return $text;
    }
}

function per_minggu($tanggal='') {
    $tahun = "2024";
    $bulan = "03";
    $tanggal = "29";
    $format = $tahun.'-'.$bulan.'-'.$tanggal;
    $seminggu = abs(6*86400);
    $awal = strtotime($format);
    $akhir = strtotime($format)+$seminggu;
    $c_tgl = [];
    for($i=$awal; $i <=$akhir;$i+=86400)
    {
        $c_tgl[] = date('Y-m-d', $i);
    // $sql = $db->query("select * from invoice where tgl_invoice='$date' AND  year(tgl_invoice)='$tahun'");
    // $row = $sql->fetch_array();
    // echo $row['tgl_invoice'];
    // echo "<br/>";    
    }

    return var_dump($c_tgl);
}

function weekOfMonth($date) {
    //Get the first day of the month.
    $firstOfMonth = strtotime(date("Y-m-01", $date));
    //Apply above formula.
    return weekOfYear($date) - weekOfYear($firstOfMonth) + 1;
}

function weekOfYear($date) {
    $weekOfYear = intval(date("W", $date));
    if (date('n', $date) == "1" && $weekOfYear > 51) {
        // It's the last week of the previos year.
        return 0;
    }
    else if (date('n', $date) == "12" && $weekOfYear == 1) {
        // It's the first week of the next year.
        return 53;
    }
    else {
        // It's a "normal" week.
        return $weekOfYear;
    }
}

function hitung_jumlah_hari_minggu() {
    echo weekOfMonth(strtotime("2020-04-12")) . " "; // 2
    echo weekOfMonth(strtotime("2020-12-31")) . " "; // 5
    echo weekOfMonth(strtotime("2020-01-02")) . " "; // 1
    echo weekOfMonth(strtotime("2021-01-28")) . " "; // 5
    echo weekOfMonth(strtotime("2018-12-31")) . " "; // 6
}


    
