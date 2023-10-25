<?php 

defined('BASEPATH') OR exit('No direct script access allowed');

class Files extends MY_Controller {

    function _openfile($filepath){
        $filename = explode("/", $filepath);
        $filename = end($filename);
        $file_header = get_headers($filepath);
        $status = stripos($file_header[0],"200 OK")?true:false;
        if($status){
            header($file_header[8]); //<-- File Size
            header('Content-Disposition: inline; filename="'.$filename.'";'); //<-- sends filename header
            header($file_header[9]); //<-- Content Type
            readfile($filepath);
        }else{
            show_404();
        }
    }

    public function index()
    {
        show_404();
    }

    public function images_public($filename = null)
    {
        $status = true;

        $total_segments = $this->uri->total_segments();
        $filename = '';

        for ($i=3; $i <= $total_segments; $i++) { 
            if($i !== $total_segments){
                $filename .= $this->uri->slash_segment($i);
            }else{
                $filename .= $this->uri->segment($i);
            }
            
        }

        if($status==true){
            if($filename !== null) {
                $filepath = $this->data['upload_path'].$filename;
                if(file_exists($filepath)){
                    $mime = mime_content_type($filepath); //<-- detect file type
                    header('Content-Length: '.filesize($filepath)); //<-- sends filesize header
                    header("Content-Type: $mime"); //<-- send mime-type header
                    header('Content-Disposition: inline; filename="'.$filename.'";'); //<-- sends filename header
                    readfile($filepath); //<--reads and outputs the file onto the output buffer
                }else{
                    show_404();
                }
            }else{
                show_404();
            }
        }else{
            show_404();
        }
    }

    public function images($filename = null)
    {
        $status = true;

        $total_segments = $this->uri->total_segments();
        $filename = '';

        for ($i=3; $i <= $total_segments; $i++) { 
            if($i !== $total_segments){
                $filename .= $this->uri->slash_segment($i);
            }else{
                $filename .= $this->uri->segment($i);
            }
            
        }

        if($status==true){
            if($filename !== null) {
                $filepath = $this->data['image_path'].$filename;
                if(file_exists($filepath)){
                    $mime = mime_content_type($filepath); //<-- detect file type
                    header('Content-Length: '.filesize($filepath)); //<-- sends filesize header
                    header("Content-Type: $mime"); //<-- send mime-type header
                    header('Content-Disposition: inline; filename="'.$filename.'";'); //<-- sends filename header
                    readfile($filepath); //<--reads and outputs the file onto the output buffer
                }else{
                    show_404();
                }
            }else{
                show_404();
            }
        }else{
            show_404();
        }
    }

    public function images_authorization($filename = null)
    {
        $status = true;
        $prefix = $this->input->get("key");
        $prefix_ = decrypt_url($prefix, 'files_pass');

        if($prefix_ == false) $status = false;
        $prefix_ = explode("#", $prefix_);
        $table = (!empty($prefix_[0]) ? $prefix_[0] : null);
        $field = (!empty($prefix_[1]) ? $prefix_[1] : null);
        $super_user_level = (!empty($prefix_[2]) ? $prefix_[2] : null);
        $access_parameter = (!empty($prefix_[3]) ? $prefix_[3] : null);
        $helper_field = (!empty($prefix_[4]) ? $prefix_[4] : null);
        $level = $this->session->userdata('simpeg_level');

        if(empty($table) || empty($field) || empty($super_user_level) || empty($access_parameter) || empty($helper_field)) $status = false;

        if($status == true && $level != $super_user_level){
            $total_segments = $this->uri->total_segments();
            $filename = files_get_file_path(4);
            $get_owner = $this->db->where($field, $filename)->get($table);

            if($get_owner->num_rows() > 0){
                $get_owner = $get_owner->row();
                
                if($get_owner->$helper_field !== $access_parameter){
                    $status = false;
                }
            }else{
                $status = false;
            }
        }

        if($status==true){
            $total_segments = $this->uri->total_segments();
            $filename = files_get_file_path(3);

            if($filename !== null) {
                $filepath = $this->data['image_path'].$filename;
                if(file_exists($filepath)){
                    $mime = mime_content_type($filepath); //<-- detect file type
                    header('Content-Length: '.filesize($filepath)); //<-- sends filesize header
                    header("Content-Type: $mime"); //<-- send mime-type header
                    header('Content-Disposition: inline; filename="'.$filename.'";'); //<-- sends filename header
                    readfile($filepath); //<--reads and outputs the file onto the output buffer
                }else{
                    $this->load->view('partials/error_files_not_found');
                }
            }else{
                $this->load->view('partials/error_files_not_found');
            }
        }else{
            $this->load->view('partials/error_files_not_authorized');
        }
    }

    public function my_images($filename = null)
    {
        if (!empty($this->session->userdata('simpeg_nip'))) {
            $pegawai_nip = $this->session->userdata('simpeg_nip');
        } else {
            $pegawai_nip = $this->session->userdata('simpeg_pegawai_id');
        }

        $level = $this->session->userdata('simpeg_level');
        $status = true;

        $total_segments = $this->uri->total_segments();
        $filename = '';
        for ($i=3; $i <= $total_segments; $i++) { 
            if($i !== $total_segments){
                $filename .= $this->uri->slash_segment($i);
            }else{
                $filename .= $this->uri->segment($i);
            }
        }

        if($level != '1' && $level != '9'){
            $prefix_file = explode("_", $filename);
            $prefix_image_owner = (!empty($prefix_file[2]) ? explode(".", $prefix_file[2]) : null);
            $image_owner = (!empty($prefix_image_owner[0]) ? $prefix_image_owner[0] : null);
            if($image_owner !== $pegawai_nip){
                $status = false;
            }
        }

        if($status==true){
            if($filename !== null) {
                $filepath = $this->data['image_path'].$filename;
                if(file_exists($filepath)){
                    $mime = mime_content_type($filepath); //<-- detect file type
                    header('Content-Length: '.filesize($filepath)); //<-- sends filesize header
                    header("Content-Type: $mime"); //<-- send mime-type header
                    header('Content-Disposition: inline; filename="'.$filename.'";'); //<-- sends filename header
                    readfile($filepath); //<--reads and outputs the file onto the output buffer
                }else{
                    $this->load->view('partials/error_files_not_found');
                }
            }else{
                $this->load->view('partials/error_files_not_found');
            }
        }else{
            $this->load->view('partials/error_files_not_authorized');
        }
    }

    public function my_files($filename = null)
    {
        $pegawai_id = $this->session->userdata('simpeg_pegawai_id');
        $level = $this->session->userdata('simpeg_level');
        $status = true;

        $total_segments = $this->uri->total_segments();
        $filename = '';
        for ($i=3; $i <= $total_segments; $i++) { 
            if($i !== $total_segments){
                $filename .= $this->uri->slash_segment($i);
            }else{
                $filename .= $this->uri->segment($i);
            }
        }

        if($level != '1' && $level != '9'){
            $prefix_file = explode("_", $filename);
            $image_owner = (!empty($prefix_file[1]) ? $prefix_file[1] : null);
            if($image_owner !== $pegawai_id){
                $status = false;
            }
        }

        if($status==true){
            if($filename !== null) {
                $filepath = $this->data['file_path'].$filename;
                if(file_exists($filepath)){
                    $mime = mime_content_type($filepath); //<-- detect file type
                    header('Content-Length: '.filesize($filepath)); //<-- sends filesize header
                    header("Content-Type: $mime"); //<-- send mime-type header
                    header('Content-Disposition: inline; filename="'.$filename.'";'); //<-- sends filename header
                    readfile($filepath); //<--reads and outputs the file onto the output buffer
                }else{
                    $this->load->view('partials/error_files_not_found');
                }
            }else{
                $this->load->view('partials/error_files_not_found');
            }
        }else{
            $this->load->view('partials/error_files_not_authorized');
        }
    }

    public function berkas($filename = null)
    {
        $status = true;

        $total_segments = $this->uri->total_segments();
        $filename = '';

        for ($i=3; $i <= $total_segments; $i++) { 
            if($i !== $total_segments){
                $filename .= $this->uri->slash_segment($i);
            }else{
                $filename .= $this->uri->segment($i);
            }
            
        }

        if($status==true){
            if($filename !== null) {
                $filepath = $this->data['file_path'].$filename;
                if(file_exists($filepath)){
                    $mime = mime_content_type($filepath); //<-- detect file type
                    header('Content-Length: '.filesize($filepath)); //<-- sends filesize header
                    header("Content-Type: $mime"); //<-- send mime-type header
                    header('Content-Disposition: inline; filename="'.$filename.'";'); //<-- sends filename header
                    readfile($filepath); //<--reads and outputs the file onto the output buffer
                }else{
                    show_404();
                }
            }else{
                show_404();
            }
        }else{
            show_404();
        }
    }

    public function uploads($filename = null)
    {
        $session_id = $this->session->userdata('simpeg_user_id');
        $level = $this->session->userdata('simpeg_level');
        $status = true;

        $total_segments = $this->uri->total_segments();
        $filename = '';
        for ($i=3; $i <= $total_segments; $i++) { 
            if($i !== $total_segments){
                $filename .= $this->uri->slash_segment($i);
            }else{
                $filename .= $this->uri->segment($i);
            }
            
        }

        if($level !== '1'){
            $get_owner = $this->db->where('ktp_image', $filename)->or_where('ktp_image_selfie', $filename)->get('kyc_bio');
            if($get_owner->num_rows() > 0){
                $get_owner = $get_owner->row();
                if($get_owner->created_by !== $session_id){
                    $status = false;
                }
            }else{
                $status = false;
            }
        }

        if($status==true){
            if($filename !== null) {
                $filepath = $this->data['upload_path'].$filename;
                if(file_exists($filepath)){
                    $mime = mime_content_type($filepath); //<-- detect file type
                    header('Content-Length: '.filesize($filepath)); //<-- sends filesize header
                    header("Content-Type: $mime"); //<-- send mime-type header
                    header('Content-Disposition: inline; filename="'.$filename.'";'); //<-- sends filename header
                    readfile($filepath); //<--reads and outputs the file onto the output buffer
                }else{
                    show_404();
                }
            }else{
                show_404();
            }
        }else{
            show_404();
        }
    }

    public function upload_authorization($filename = null)
    {
        $status = true;
        $prefix = $this->input->get("key");
        $prefix_ = decrypt_url($prefix, 'files_pass');

        if($prefix_ == false) $status = false;
        $prefix_ = explode("#", $prefix_);
        $table = (!empty($prefix_[0]) ? $prefix_[0] : null);
        $field = (!empty($prefix_[1]) ? $prefix_[1] : null);
        $super_user_level = (!empty($prefix_[2]) ? $prefix_[2] : null);

        if(empty($table) || empty($field) || empty($super_user_level)) $status = false;

        $session_id = $this->session->userdata('simpeg_user_id');
        $level = $this->session->userdata('simpeg_level');
        $unor_id = $this->session->userdata('simpeg_unor_id');
        
        if($status == true && $level != $super_user_level){
            $total_segments = $this->uri->total_segments();
            $filename = files_get_file_path(4);

            $get_owner = $this->db->where($field, $filename)->get($table);
            if($get_owner->num_rows() > 0){
                $get_owner = $get_owner->row();
                
                if($get_owner->unor_id !== $unor_id){
                    $status = false;
                }
            }else{
                $status = false;
            }
        }

        if($status==true){
            $total_segments = $this->uri->total_segments();
            $filename = files_get_file_path(3);

            if($filename !== null) {
                $filepath = $this->data['file_path'].$filename;
                if(file_exists($filepath)){
                    $mime = mime_content_type($filepath); //<-- detect file type
                    header('Content-Length: '.filesize($filepath)); //<-- sends filesize header
                    header("Content-Type: $mime"); //<-- send mime-type header
                    header('Content-Disposition: inline; filename="'.$filename.'";'); //<-- sends filename header
                    readfile($filepath); //<--reads and outputs the file onto the output buffer
                }else{
                    $this->load->view('partials/error_files_not_found');
                }
            }else{
                $this->load->view('partials/error_files_not_found');
            }
        }else{
            $this->load->view('partials/error_files_not_authorized');
        }
    }

    public function uploads_not_owner_must_login($filename = null)
    {
        if ($this->session->userdata('dkpp_loggedin') == TRUE) {
            $status = true;
        } else {
            $status = false;
        }

        $total_segments = $this->uri->total_segments();
        $filename = '';
        for ($i=3; $i <= $total_segments; $i++) { 
            if($i !== $total_segments){
                $filename .= $this->uri->slash_segment($i);
            }else{
                $filename .= $this->uri->segment($i);
            }
            
        }

        if($status==true){
            if($filename !== null) {
                $filepath = $this->data['file_path'].$filename;
                if(file_exists($filepath)){
                    $mime = mime_content_type($filepath); //<-- detect file type
                    header('Content-Length: '.filesize($filepath)); //<-- sends filesize header
                    header("Content-Type: $mime"); //<-- send mime-type header
                    header('Content-Disposition: inline; filename="'.$filename.'";'); //<-- sends filename header
                    readfile($filepath); //<--reads and outputs the file onto the output buffer
                }else{
                    $this->load->view('partials/error_files_not_found');
                }
            }else{
                $this->load->view('partials/error_files_not_found');
            }
        }else{
            $this->load->view('partials/error_files_not_authorized');
        }
    }
}

/* End of file Files.php */


?>