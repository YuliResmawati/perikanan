<section class="inner-banner-wrap">
    <div class="inner-baner-container" style="background-image: url(<?= $theme_path ?>/images/perikanan.jpg);">
        <div class="container">
        <div class="inner-banner-content">
            <h1 class="inner-title">Halaman Login</h1>
            </div>
        </div>
    </div>
</section>
<div class="volunteer-wrap">
    <div class="container">
        <div class="row">
            <div class="col-lg-6">
                <div class="right-image">
                    <img src="<?= $theme_path ?>/images/login2.jpg" alt="login logo">
                </div>
            </div>
            <div class="col-lg-6">
                <div class="card shadow-2-strong" style="border-radius: 1rem;">
                    <div class="card-body p-5 text-center">
                        <h3 class="mb-3">Selamat Datang!</h3>
                        <p>Butuh bantuan informasi login? <a class="ms-2" href="#">Hubungi Kami</a></p>
                        <hr class="my-4">
                        <?= form_open('auth/do_login', 'id="formLogin"'); ?>
                            <div class="row">
                                <input type="hidden" class="g-recaptcha-response" name="g-recaptcha-response">
                                <div class="col-lg-12 col-md-12 col-sm-12 col-12 form-group">
                                    <input type="text" name="dkpp_username" id="dkpp_username" placeholder="nama pengguna">
                                </div>
                                <div class="col-lg-12 col-md-12 col-sm-12 col-12 form-group">
                                    <input type="password" name="dkpp_password" id="dkpp_password" placeholder="kata sandi">
                                </div>
                                <div class="single-form form-check text-left">
                                    <input type="checkbox" value="" id="flexCheckDefault">
                                    <label for="flexCheckDefault">Lihat Kata Sandi</label>
                                </div>
                                <div class="submit-area col-lg-12 col-12 mt-3">
                                    <button class="button-round-primary w-100" id="submit-login">
                                        <span class="spinner-border spinner-border-sm mr-1" id="spinner-status" role="status" aria-hidden="true" style="display:none"></span>
                                        <i class="bi bi-unlock me-2" id="login-icon"></i> <span id="text-button">Masuk</span> 
                                    </button>
                                </div>
                            </div>
                        <?= form_close(); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    $('#flexCheckDefault').click(function() {
        if ('password' == $('#dkpp_password').attr('type')) {
            $('#dkpp_password').prop('type', 'text');
        } else {
            $('#dkpp_password').prop('type', 'password');
        }
    });

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
                $('#loading-process').show();
                $('#spinner-status').show();
                $('#login-icon').hide();
                $('#text-button').html('Loading...');
                $('#text-button').addClass('ml-3');
            },
            success : function(data){
                $('#spinner-status').hide();
                $('#login-icon').show();
                $('#text-button').html('Masuk');
                $('#text-button').removeClass('ml-3');

                if (data.status == true) {
                    Swal.fire({
                        title: 'Informasi!',
                        html: data.message,
                        icon: 'success',
                        confirmButtonColor: '#FFDA0F',
                        confirmButtonText: 'OK'
                    }).then(function() {
                        window.location = '<?= base_url('dashboard') ?>';
                    });
                } else {
                    Swal.fire({
                        title: 'Informasi!',
                        html: data.message,
                        icon: 'error',
                        confirmButtonColor: '#FFDA0F',
                        confirmButtonText: 'OK'
                    })
                }

                $('#loading-process').hide();
            },
            error : function() {
                $('#spinner-status').hide();
                $('#login-icon').show();
                $('#text-button').html('Masuk');
                $('#text-button').removeClass('ml-3');

                Swal.fire({
                    title: 'Informasi!',
                    text: 'Oops, terjadi kesalahan saat menghubungkan ke server. Silahkan periksa koneksi internet anda atau refresh ulang halaman ini.',
                    icon: 'error',
                    confirmButtonColor: '#FFDA0F',
                    confirmButtonText: 'OK'
                });

                $('#loading-process').hide();
            }
        });
    });
</script>