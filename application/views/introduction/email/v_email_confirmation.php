<div class="card">
    <div class="card-body">
        <div class="row">
            <div class="col-lg-12 col-xl-12 mt-2">
                <div class="alert alert-light bg-light text-dark border-0" role="alert">
                    <div class="text-justify">
                        Silahkan verifikasi email. Dengan melakukan verifikasi email, anda akan mendapatkan kemudahan dalam menggunakan aplikasi <strong>simpeg agam</strong>
                        yang berkaitan dengan sistem kepegawaian di dalam lingkungan kabupaten agam. Berikut langkah melakukan verifikasi email :
                    </div><br>
                    <div><strong>1. </strong>Inputkan email anda yang aktif kedalam form <strong>email aktif</strong></div>
                    <div><strong>2. </strong>Klik tombol <strong>Dapatkan Kode Verifikasi</strong>, anda akan mendapatkan kode verifikasi yang dikirimkan ke email yang anda inputkan</div>
                    <div><strong>3. </strong>Inputkan kode verifikasi yang sudah dikirim ke email anda, lalu klik tombol <strong>Konfirmasi Email</strong></div>
                </div>
                <?= form_open($uri_mod.'/v1/email_confirm', 'id="formAjax" class="form"') ?>
                    <div class="main-container mt-4" id="main-container"> 
                        <div class="form-group row">
                            <label for="email_pengguna" class="col-md-2 col-form-label">Email Aktif <?= label_required() ?></label>
                            <div class="col-md-10">
                                <input type="email" class="form-control" name="email_pengguna" id="email_pengguna" value="<?= (!empty($pegawai->email)) ? $pegawai->email : '' ?>">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="otp" class="col-md-2 col-form-label">Verifikasi Email <?= label_required() ?></label>
                            <div class="col-sm-auto">
                                <div class="btn-group">
                                    <span id="btn-otp" class="btn btn-info chat-send btn-block">
                                        <div id="otp-spinner" class="spinner-border spinner-border-sm text-white mr-2" role="status" style="display:none"></div><span id="button-value-otp">Dapatkan Kode Verifikasi</span>
                                    </span>
                                </div>
                            </div>
                            <div class="col mb-2 mb-sm-0" id="otp-container" style="display:none">
                                <input type="text" class="form-control" name="otp" id="otp" data-toggle="input-mask" data-mask-format="00000" placeholder="Masukkan kode verifikasi disini">
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-12 text-center">
                                <span id="reset-btn" class="btn btn-light waves-effect waves-light m-1">
                                    <span class="spinner-border spinner-border-sm mr-1" id="spinner-status-reset" role="status" aria-hidden="true" style="display:none"></span>
                                    <i class="mdi mdi-refresh mr-1" id="icon-reset"></i><span id="button-value-reset">Bersihkan Data</span>
                                </span>
                                <button type="submit" id="submit-btn" class="btn btn-success waves-effect waves-light m-1">
                                    <span class="spinner-border spinner-border-sm mr-1" id="spinner-status" role="status" aria-hidden="true" style="display:none"></span>
                                    <i class="mdi mdi-email mr-1" id="icon-save"></i><span id="button-value">Konfirmasi Email</span>
                                </button>
                               
                            </div>
                        </div>
                    </div>       
                <?= form_close(); ?>
            </div>
        </div>
    </div>
</div>

<div id="warning-alert-modal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-body p-4">
                <div class="text-center">
                    <i class="dripicons-warning h1 text-warning"></i>
                    <h4 class="mt-2">Informasi Penting</h4>
                    <p class="mt-3">Email yang anda gunakan saat ini terdeteksi menggunakan layanan <strong>Yahoo</strong>. Kami menyarankan agar anda segera mengganti email ke layanan <strong>Gmail, Icloud atau Outlook</strong>, dikarenakan Aplikasi Simpeg tidak mendukung mengirim Kode Verifikasi ke <strong>Yahoo</strong>.</p>
                    <button type="button" class="btn btn-warning my-2" data-dismiss="modal">Mengeri</button>
                </div>
            </div>
        </div>
    </div>
</div>


<script type="text/javascript">

    $(document).ready(function() {
        let email_blocked = '<?= $email_blocked ?>';

        if (email_blocked == '1') {
            $('#warning-alert-modal').modal('show');
        } else {
            $('#warning-alert-modal').modal('hide');
        }
    });

    $('#btn-otp').click(function() {
        option_otp = {
            async: true,
            action_button: $('#btn-otp'),
            spinner: $('#otp-spinner'),
            button_value: $('#button-value-otp'),
            button_text: "Dapatkan Kode Verifikasi",
            url: "<?= base_url('introduction/v1/send_otp_verifikasi') ?>",
            data: {
                email_pengguna : $('#email_pengguna').val()
            },
            onSuccess: function(data) {
               if (data.status == true) {
                    $('#otp-container').show();
                    $('#email_pengguna').prop('readonly', true);
               } else {
                    $('#otp-container').hide();
               }
            }
        }

        btn_action(option_otp);
    });

    $('#reset-btn').click(function() {
        option_reset = {
            async: true,
            action_button: $('#reset-btn'),
            spinner: $('#spinner-status-reset'),
            button_value: $('#button-value-reset'),
            button_text: "Bersihkan Data",
            icon_save: $('#icon-reset'),
            url: "<?= base_url('introduction/v1/reset_data') ?>",
            onSuccess: function(data) {
               if (data.status == true) {
                    $('#otp-container').hide();
                    $('#email_pengguna').prop('readonly', false);
                    $('#email_pengguna').val('');
                    $('#otp').val('');
               }
            }
        }

        btn_action(option_reset);
    });

    $('#formAjax').submit(function(e) {
        e.preventDefault();
        option_save = {
            async: true,
            submit_btn: $('#submit-btn'),
            spinner: $('#spinner-status'),
            icon_save: $('#icon-save'),
            button_value: $('#button-value'),
            button_text: "Konfirmasi Email",
            url: $(this).attr('action'),
            data: $(this).serialize(),
            redirect: "<?= base_url('introduction/konfirmasi_telegram') ?>"
        }

        btn_save_form(option_save);
    });
</script>