<div class="mb-120 d-block"></div>
<div class="register-area">
    <div class="container">
        <div class="row g-4 g-lg-5 align-items-center justify-content-between <?= ($this->agent->is_mobile()) ? 'mt-3' : '' ?>">
            <div class="col-12 col-lg-6">
                <div class="register-thumbnail">
                    <img src="<?= $theme_path ?>/img/illustrator/hero-3.png" alt="ilustrator">
                </div>
            </div>
            <div class="col-12 col-lg-6">
                <div class="card register-card bg-gray p-2 p-sm-4">
                    <div class="card-body">
                        <h4>Selamat Datang!</h4>
                        <p>tidak tau informasi login? <a class="ms-2" href="#">Hubungi Kami</a></p>
                        <div class="register-form my-4 my-lg-5">
                            <?= form_open('auth/do_login', 'id="formLogin"'); ?>
                                <input type="hidden" class="g-recaptcha-response" name="g-recaptcha-response">
                                <div class="form-group mb-3">
                                    <input class="form-control rounded-0" type="text" name="silatpendidikan_username" id="silatpendidikan_username" placeholder="Email atau Nama Pengguna" required>
                                </div>
                                <div class="form-group mb-3">
                                    <label class="label-psswd" for="registerPassword">Show</label>
                                    <input class="form-control rounded-0" id="registerPassword" name="silatpendidikan_password" type="password" placeholder="Kata Sandi" required>
                                </div>
                                <button class="btn btn-primary w-100" id="submit-login">
                                    <span class="spinner-border spinner-border-sm mr-1" id="spinner-status" role="status" aria-hidden="true" style="display:none"></span>
                                    <i class="bi bi-unlock me-2" id="login-icon"></i> <span id="text-button">Login</span> 
                                </button>
                                <div class="login-meta-data d-flex align-items-center justify-content-between">
                                    <div class="form-check mt-3">
                                        <input class="form-check-input" id="rememberMe" type="checkbox" name="rememberMe" value="checked">
                                        <label class="form-check-label" for="rememberMe">Biarkan saya tetap login</label>
                                    </div>
                                    <a class="forgot-password mt-3" href="<?= base_url('forget') ?>">Lupa Password?</a>
                                </div>
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
    $('#submit-login').click(function(e) {
        e.preventDefault();
        $('#spinner-status').show();
        $('#login-icon').hide();
        $('#text-button').html('Loading...');
        $('#text-button').addClass('ml-2');
        grecaptcha.ready(function() {
            grecaptcha.execute('<?php echo RECAPTCHA_SITE_KEY; ?>', {action: 'submit'}).then(function(token) {
                document.querySelector('.g-recaptcha-response').value = token;
                $('#formLogin').submit()
            });
        });
    });
    
    $('#formLogin').submit(function(e) {
        e.preventDefault();
        $.ajax({
            url: "<?= site_url('auth/do_login') ?>",
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
                $('#text-button').html('Login');
                $('#text-button').removeClass('ml-2');

                if (data.status == true) {
                    Swal.fire({
                        title: 'Informasi!',
                        html: data.message,
                        icon: 'success',
                        confirmButtonColor: '#0d6efd',
                        confirmButtonText: 'OK'
                    }).then(function() {
                        window.location = '<?= base_url('dashboard') ?>';
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