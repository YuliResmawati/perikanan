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
                        $a = '<' . $a_tag . ' ' . $link_url . ' '. $attr .' class="button-detail btn btn-info waves-effect waves-light btn-xs" title="Lihat Data Siswa" data-plugin="tippy" data-tippy-size="small" data-id="' . $id . '" ' . $modal_attr . '>
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
                }elseif ($action == "reset_pass") {
                    $a = '<' . $a_tag . ' ' . $link_url . ' '. $attr .' class="button-reset_pass btn btn-info waves-effect waves-light btn-xs" title="Reset Password" data-plugin="tippy" data-tippy-size="small" data-id="' . $id . '" >
                                    Reset Password
                            </' . $a_tag . '>';
                } elseif ($action == "detail") {
                    $a = '<' . $a_tag . ' ' . $link_url . ' '. $attr .' class="button-detail btn btn-info waves-effect waves-light btn-xs" title="Lihat Data Siswa" data-plugin="tippy" data-tippy-size="small" data-id="' . $id . '" ' . $modal_attr . '>
                                    <i class="icon-people"></i>
                            </' . $a_tag . '>';
                } elseif ($action == "list_materi") {
                    $a = '<' . $a_tag . ' ' . $link_url . ' '. $attr .' class="button-list-materi btn btn-info waves-effect waves-light btn-xs" title="Lihat Materi" data-plugin="tippy" data-tippy-size="small" data-id="' . $id . '" ' . $modal_attr . '>
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
        $cookie_browser = get_cookie('silatpendidikan_users_cookie');

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
            $avatar_path = str_files_images('profile_picture/', $avatar_url); 
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

if (!function_exists('str_status_mutasi')) {
    function str_status_mutasi($status)
    {
        $a = '';

        if ($status == '1') {
            $a = '<h6><span class="badge bg-soft-success text-success"><i class="mdi mdi-check-all"></i> Diterima</span></h6>';
        } else  if ($status == '0') {
            $a = '<h6><span class="badge bg-soft-dark text-dark"><i class="mdi mdi-timer-sand"></i> Dalam Proses</span></h6>';
        } else {
            $a = '<h6><span class="badge bg-soft-dark text-danger"><i class="mdi mdi-close-circle"></i> Ditolak</span></h6>';
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
            $a = 'Admin Dinas';
        } else if ($status == '3') {
            $a = 'Operator Sekolah';
        } else {
            $a = 'Tidak Di Ketahui';
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

if (!function_exists('btn_view_images')) 
{
    function btn_view_images($path, $filename)
    {
        $a = '';

        if (!empty($filename)) {
            $a = "<a class='btn btn-info btn-sm' data-fancybox href=" . str_files_images($path, $filename) . ">Lihat File</a>";
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

if (!function_exists('silatpendidikan_upload_image')) 
{
    function silatpendidikan_upload_image($field_name, $filename)
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

if (!function_exists('silatpendidikan_upload_file')) 
{
    function silatpendidikan_upload_file($field_name, $filename)
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

        if ($CI->session->userdata('silatpendidikan_loggedin') == FALSE || empty($CI->session->userdata('silatpendidikan_loggedin')) || $CI->session->userdata('silatpendidikan_loggedin') == NULL) {
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
    function lap_content($orientation, $view, $data = null)
    {
        $CI = &get_instance();
        return array(
            'o' => $orientation,
            'c' => $CI->load->view($view, $data, TRUE)
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
    function two_row($first_row = '', $icon1 = '', $second_row = '', $icon2 = '')
    {
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

if (!function_exists('jenis_ptk')) 
{
    function jenis_ptk($jenis_ptk)
    {
        if (!empty($jenis_ptk)) {
            if($jenis_ptk == 'Tenaga Administrasi Sekolah' || $jenis_ptk == 'Tenaga Perpustakaan'){
                $result = "<span class='badge bg-soft-success text-success'>$jenis_ptk</span>";
            } else if($jenis_ptk == 'Petugas Keamanan' || $jenis_ptk == 'Penjaga Sekolah' || $jenis_ptk == 'Pesuruh/Office Boy'|| $jenis_ptk == 'Tukang Kebun'){
                $result = "<span class='badge bg-soft-pink text-pink'>$jenis_ptk</span>";
            }else if($jenis_ptk == 'Guru BK' || $jenis_ptk == 'Guru Mapel' || $jenis_ptk == 'Guru TIK'|| $jenis_ptk == 'Guru Kelas'){
                $result = "<span class='badge bg-soft-info text-info'>$jenis_ptk</span>";
            }else if($jenis_ptk == 'Tutor' || $jenis_ptk == 'Pamong Belajar' || $jenis_ptk == 'Guru Pengganti'|| $jenis_ptk == 'Guru Pendamping Khusus'){
                $result = "<span class='badge bg-soft-info text-info'>$jenis_ptk</span>";
            }else if($jenis_ptk == 'Kepala Sekolah'){
                $result = "<span class='badge bg-soft-danger text-danger'>$jenis_ptk</span>";
            }else{
                $result = "<span class='badge bg-soft-blue text-blue'>$jenis_ptk</span>";
            }
        } else {
            $result = "<a class='btn btn-outline-dark waves-effect waves-light btn-xs'>Kosong</a>";
        }

        return $result;
    }
}

if (!function_exists('name_degree')) 
{
    function name_degree($gelar_depan, $nama_guru, $gelar_belakang, $xss_option = FALSE)
    {
        if ($xss_option == TRUE) {
            if ($gelar_depan) {
                $gelar_depan = xss_escape($gelar_depan.'. ');
            }
    
            if ($gelar_belakang) {
                $gelar_belakang = xss_escape(', '.$gelar_belakang);
            }
    
            $nama_guru = xss_escape($nama_guru);
        } else {
            if ($gelar_depan) {
                $gelar_depan = $gelar_depan.'. ';
            }
    
            if ($gelar_belakang) {
                $gelar_belakang = ', '.$gelar_belakang;
            } 
        }

        return $gelar_depan.$nama_guru.$gelar_belakang;
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

if (!function_exists('btn_kgb')) 
{
    function btn_kgb($id, $session_id, $keyid = '', $link_status = '', $modal_name = '', $attr = '', $guru = '')
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

            
            $a = '<' . $a_tag . ' ' . $link_status . ' class="button-ajukan btn btn-icons btn-rounded btn-outline-success" data-tooltip="tooltip" data-placement="bottom" title="" data-original-title="Ajukan KGB"  data-id="' . $id . '" data-guru="' . $guru . '" ' . $modal_attr . '>
            <i class="mdi mdi-plus-outline"></i>
            </' . $a_tag . '>';
        }
        return $a;
    }
}

    
