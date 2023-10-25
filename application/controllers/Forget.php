<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Forget extends Frontend_Controller
{

    public function __construct()
    {
        parent::__construct();

        $this->_init();
        $this->data['uri_mod'] = 'forget';
        $this->load->model(['m_users', 'm_token_history', 'm_pegawai']);

        $this->load->js("https://cdn.jsdelivr.net/npm/sweetalert2@11");
    }

    public function _init()
    {
        $this->output->set_template('frontend');
    }

    public function index()
    {
        $cookie = get_cookie('dkpp_users_cookie');

        if ($this->loggedin != FALSE && $this->logged_level != FALSE) {
            redirect('dashboard');
        } else if ($cookie <> '') {
            $data = $this->m_users->get_by_cookie($cookie)->row();

            if ($data) {
                $this->m_users->simpeg_session_register($data);
                redirect('dashboard');
            }
        }

        $this->data['page_title'] = "Lupa Password";
        $this->data['page_description'] = "Halaman Lupa Password Sistem Informasi Kepegawaian Kabupaten Agam";

        $this->load->view('forget/v_forget', $this->data);
    }

    public function AjaxSendOtp()
    {
        $this->output->unset_template();

        $nip = $this->input->post('nip');

        if (!empty($nip)) {
            $account = $this->m_pegawai->get_detail_pegawai('DESC', '', TRUE, TRUE)->where(['riwayat_golongan.status' => '1', 'nip' => $nip])->push_select('users.id as user_id, intro')->findAll();

            if (!empty($account)) {
                $email = (!empty($account)) ? $account[0]->email : '';
                $user_id = (!empty($account)) ? $account[0]->user_id : '';
                $intro = (!empty($account)) ? $account[0]->intro : '';

                if ($intro != '0' && empty($email)) {
                    $this->result = array(
                        'status' => FALSE,
                        'message' => '<span class="text-danger">Akun simpeg anda tidak aktif dan email anda tidak ditemukan. Harap hubungi BKPSDM untuk mereset akun anda.</span>'
                    );
                } else {
                    $token_info = $this->m_token_history->get_active_token($user_id, 'otp_reset_akun');
                    $expire_calculate = strtotime('' . date("Y-m-d H:i:s") . '. + 5 minute');
                    $expire = date('Y-m-d H:i:s', $expire_calculate);

                    if ($token_info == FALSE) {
                        if (base_url() == "https://simpeg.agamkab.go.id/" || base_url() == "http://simpeg.agamkab.go.id/") {
                            $this->data['email_receiver'] = $email;
                        } else {
                            $this->data['email_receiver'] = 'tenunsongket2@gmail.com';
                        }

                        $this->data['page_title'] = 'Kode OTP Reset Kata Sandi Akun';
                        $this->data['description'] = 'reset kata sandi';
                        $this->data['otp'] = generate_otp(5);
                        $view = $this->load->view('email_template/v_email_reset_password', $this->data, true);

                        $this->load->library('MailAgam');
                        $this->mailagam->to($this->data['email_receiver'])
                            ->subject($this->data['page_title'] . ' | ' . $this->data['site_name'])
                            ->message($view);

                        $send = $this->mailagam->send();

                        if ($send->status) {
                            $this->m_token_history->push_to_data('users_id', $user_id)
                                ->push_to_data('token', $this->data['otp'])
                                ->push_to_data('description', 'kode otp reset akun ' .$nip)
                                ->push_to_data('type', 'otp_reset_akun')
                                ->push_to_data('expired_date', $expire)
                                ->push_to_data('browser_agent', $this->agent->browser())
                                ->push_to_data('version_agent', $this->agent->version())
                                ->push_to_data('platform_agent', $this->agent->platform())
                                ->push_to_data('ip_address', get_user_ip())
                                ->push_to_data('deleted', '0')
                                ->push_to_data('status', '1');

                            $save_history_otp = $this->m_token_history->save();

                            if ($save_history_otp) {
                                $this->result = array(
                                    'status' => TRUE,
                                    'message' => '<span class="text-success"><i class="mdi mdi-check-decagram"></i> Kode OTP berhasil dikirim ke email <strong>'.obfuscate_email($email).'</strong>. Silahkan cek email anda (termasuk menu utama, sosial, promosi maupun menu spam).</span>'
                                );
                            } else {
                                $this->result = array(
                                    'status' => FALSE,
                                    'message' => '<span class="text-danger"><i class="mdi mdi-alert"></i> Kode OTP gagal dikirim.</span>'
                                );
                            }
                        } else {
                            $this->result = array(
                                'status' => FALSE,
                                'message' => '<span class="text-danger"><i class="mdi mdi-alert"></i> Gagal mengirim Kode OTP.</span>'
                            );
                        }
                    } else {
                        $this->result = array(
                            'status' => FALSE,
                            'message' => '<span class="text-danger"><i class="mdi mdi-alert"></i> Anda masih memiliki kode OTP yang masih aktif, silahkan masukkan kode OTP yang sudah terkirim ke email anda atau silahkan tunggu 5 menit untuk mengirim ulang kode OTP.</span>'
                        );
                    }
                }
            } else {
                $this->result = array(
                    'status' => FALSE,
                    'message' => '<span class="text-danger">Nip tidak ditemukan.</span>'
                );
            }
        } else {
            $this->result = array(
                'status' => FALSE,
                'message' => '<span class="text-danger">Nip tidak boleh kosong.</span>'
            );
        }

        if ($this->result) {
            $this->output->set_output(json_encode($this->result));
        } else {
            $this->output->set_output(json_encode(['message' => false, 'msg' => 'Gagal mengambil data.']));
        }
    }

    public function do_forget()
    {
        $this->output->unset_template();

        $nip = $this->input->post('nip');
        $account = $this->m_pegawai->get_detail_pegawai('DESC', '', TRUE, TRUE)->where(['riwayat_golongan.status' => '1', 'nip' => $nip])->push_select('users.id as user_id, intro')->findAll();
        $user_id = (!empty($account)) ? $account[0]->user_id : '';
        $pegawai_id = (!empty($account)) ? $account[0]->id : '';

        $this->form_validation->set_rules('nip', 'NIP', "required|numeric|min_length[18]|max_length[18]");
        $this->form_validation->set_rules('otp', 'Kode OTP', "required|numeric|min_length[5]|max_length[5]");
        $this->form_validation->set_rules('simpeg_password', 'Kata Sandi Baru', "trim|required|min_length[8]|password_check_field[pegawai.nip.$pegawai_id.NIP anda]");
        $this->form_validation->set_rules('simpeg_confirmation_password', 'Konfirmasi Kata Sandi Baru', 'trim|required|min_length[8]|matches[simpeg_password]');

        $this->form_validation->set_error_delimiters(error_delimeter(1), error_delimeter(2));

        if ($this->form_validation->run() == TRUE) {
            if (!empty($account)) {
                $token_info = $this->m_token_history->get_active_token($user_id, 'otp_reset_akun', 1);
                $otp = $this->input->post('otp');
                $nip = $this->input->post('nip');

                if ($token_info !== FALSE) {
                    if ($token_info->token == $otp) {
                        $token_info_explode = explode(' ', $token_info->description);
                        $nip_confirmation = $token_info_explode[4];

                        if ($nip == $nip_confirmation) {
                            $this->return = $this->m_users->push_to_data('password', $this->m_users->ghash($this->input->post('simpeg_password')))->save($user_id);
    
                            if ($this->return) {
                                $this->m_token_history->disabled_token($user_id, $token_info->token);
                                $this->result = array(
                                    'status' => TRUE,
                                    'message' => '<span class="text-success"><i class="mdi mdi-check-decagram"></i> Berhasil mereset kata sandi akun.</span>'
                                );
                            } else {
                                $this->result = array(
                                    'status' => FALSE,
                                    'message' => '<span class="text-danger"><i class="mdi mdi-alert"></i> Gagal mereset kata sandi akun.</span>'
                                );
                            }
                        } else {
                            $this->result = array(
                                'status' => FALSE,
                                'message' => '<span class="text-danger"><i class="mdi mdi-alert"></i> Kami mendeteksi nip yang anda inputkan tidak sama dengan nip yang anda kirimkan saat mendapatkan kode otp.</span>'
                            );
                        }
                    } else {
                        $this->result = array(
                            'status' => FALSE,
                            'message' => '<span class="text-danger"><i class="mdi mdi-alert"></i> Kode OTP tidak valid, pastikan anda memasukkan Kode OTP yang sudah dikirimkan lewat email.</span>'
                        );
                    }
                } else {
                    $this->result = array(
                        'status' => FALSE,
                        'message' => '<span class="text-danger"><i class="mdi mdi-alert"></i> Kode OTP sudah kadaluarsa atau tidak valid, silahkan kirim Kode OTP kembali.</span>'
                    );
                }
            } else {
                $this->result = array(
                    'status' => FALSE,
                    'message' => '<span class="text-danger">Nip tidak ditemukan.</span>'
                );
            }
        } else {
            $this->result = array(
                'status' => FALSE,
                'message' => validation_errors()
            );
        }

        if ($this->result) {
            $this->output->set_output(json_encode($this->result));
        } else {
            $this->output->set_output(json_encode(['message'=>false, 'msg'=> 'Terjadi kesalahan.']));
        }   
    }
}

/* End of file Auth.php */