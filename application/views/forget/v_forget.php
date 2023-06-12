<div class="mb-120 d-block"></div>
<div class="register-area">
    <div class="container">
        <div class="row g-4 g-lg-5 align-items-center justify-content-between <?= ($this->agent->is_mobile()) ? 'mt-3' : '' ?>">
            <div class="col-12 col-lg-6">
                <div class="register-thumbnail">
                    <img src="<?= $theme_path ?>/img/illustrator/hero-2.png" alt="ilustrator">
                </div>
            </div>
            <div class="col-12 col-lg-6">
                <div class="card register-card bg-gray p-2 p-sm-4">
                    <div class="card-body">
                        <h4>Reset Password</h4>
                        <p>tidak tau cara reset password? <a class="ms-2" href="#">Lihat Tutorial</a></p>
                        <div class="register-form my-4 my-lg-5">
                            <?= form_open('forget/do_forget', 'id="formForget"'); ?>
                                <div class="form-group mb-3">
                                    <input class="form-control rounded-0" type="text" name="nip" id="nip" placeholder="Masukkan NIP">
                                </div>
                                <div class="form-group mb-3">
                                    <label class="otp-label" for="nip" id="get-otp"><span id="get-otp-value">Dapatkan OTP</span></label>
                                    <input class="form-control rounded-0" type="text" name="otp" id="otp" placeholder="Masukkan Kode OTP">
                                </div>
                                <div class="form-group mb-3 simpeg-password" style="display:none">
                                    <input class="form-control rounded-0" type="password" name="simpeg_password" id="simpeg_password" placeholder="Masukkan Kata Sandi Baru" autocomplete="new-password">
                                </div>
                                <div class="form-group mb-3 simpeg-password" style="display:none">
                                    <input class="form-control rounded-0" type="password" name="simpeg_confirmation_password" id="simpeg_confirmation_password" placeholder="Masukkan Konfirmasi Kata Sandi Baru">
                                </div>
                                <button class="btn btn-primary w-100" id="submit-login">
                                <span class="spinner-border spinner-border-sm mr-1" id="spinner-status" role="status" aria-hidden="true" style="display:none"></span>
                                    <i class="bi bi-unlock me-2" id="login-icon"></i> <span id="text-button">Reset Password</span> 
                                </button>
                            <?= form_close(); ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="mb-120 d-block"></div>

<script type="text/javascript">
    $('#get-otp').click(function(e) {
        e.preventDefault();
        $.ajax({
            url: "<?= site_url('forget/AjaxSendOtp') ?>",
            type  : 'POST',
            async : true,
            data: $(this).serialize()+"&nip="+$('#nip').val(),
            dataType : 'json',
            beforeSend : function() {
                $('#nip').prop('readonly', true);
                $('.simpeg-password').hide();
                $('#get-otp-value').html('Loading...');
            },
            success : function(data){
                $('#get-otp-value').html('Dapatkan OTP');

                if (data.status == true) {
                    $('#nip').prop('readonly', true);
                    $('.simpeg-password').show();
                    
                    Swal.fire({
                        title: 'Informasi!',
                        html: data.message,
                        icon: 'success',
                        confirmButtonColor: '#0d6efd',
                        confirmButtonText: 'OK'
                    });
                } else {
                    $('#nip').prop('readonly', false);
                    $('.simpeg-password').hide();

                    Swal.fire({
                        title: 'Informasi!',
                        html: data.message,
                        icon: 'error',
                        confirmButtonColor: '#0d6efd',
                        confirmButtonText: 'OK'
                    })
                }
            },
            error : function() {
                $('#nip').prop('readonly', false);
                $('.simpeg-password').hide();
                $('#get-otp-value').html('Dapatkan OTP');

                Swal.fire({
                    title: 'Informasi!',
                    text: 'Oops, terjadi kesalahan saat menghubungkan ke server. Silahkan periksa koneksi internet anda atau refresh ulang halaman ini.',
                    icon: 'error',
                    confirmButtonColor: '#0d6efd',
                    confirmButtonText: 'OK'
                })
            }
        });
    });

    $('#formForget').submit(function(e) {
        e.preventDefault();
        $.ajax({
            url: "<?= site_url('forget/do_forget') ?>",
            type  : 'POST',
            async : true,
            data: $(this).serialize(),
            dataType : 'json',
            beforeSend : function() {
                $('#spinner-status').show();
                $('#login-icon').hide();
                $('#text-button').html('Loading...');
                $('#text-button').addClass('ml-2');
            },
            success : function(data){
                $('#spinner-status').hide();
                $('#login-icon').show();
                $('#text-button').html('Reset Password');
                $('#text-button').removeClass('ml-2');

                if (data.status == true) {
                    Swal.fire({
                        title: 'Informasi!',
                        html: data.message,
                        icon: 'success',
                        confirmButtonColor: '#0d6efd',
                        confirmButtonText: 'OK'
                    }).then(function() {
                        window.location = '<?= base_url('auth') ?>';
                    });
                } else {
                    Swal.fire({
                        title: 'Informasi!',
                        html: data.message,
                        icon: 'error',
                        confirmButtonColor: '#0d6efd',
                        confirmButtonText: 'OK'
                    })
                }
            },
            error : function() {
                $('#spinner-status').hide();
                $('#login-icon').show();
                $('#text-button').html('Login');
                $('#text-button').removeClass('ml-2');

                Swal.fire({
                    title: 'Informasi!',
                    text: 'Oops, terjadi kesalahan saat menghubungkan ke server. Silahkan periksa koneksi internet anda atau refresh ulang halaman ini.',
                    icon: 'error',
                    confirmButtonColor: '#0d6efd',
                    confirmButtonText: 'OK'
                })
            }
        });
    });
</script>