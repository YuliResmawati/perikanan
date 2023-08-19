<div class="section page-banner-section bg-color-1">
    <img class="shape-1" src="<?= $theme_path ?>/images/shape/shape-5.png" alt="shape">
    <img class="shape-2" src="<?= $theme_path ?>/images/shape/shape-6.png" alt="shape">
    <img class="shape-3" src="<?= $theme_path ?>/images/shape/shape-7.png" alt="shape">
    <img class="shape-4" src="<?= $theme_path ?>/images/shape/shape-21.png" alt="shape">
    <img class="shape-5" src="<?= $theme_path ?>/images/shape/shape-21.png" alt="shape">

    <div class="container">
        <div class="page-banner-content">
            <h2 class="title">Halaman Login</h2>
            <ul class="breadcrumb justify-content-center">
                <li class="breadcrumb-item"><a href="<?= base_url('home') ?>">Home</a></li>
                <li class="breadcrumb-item active">Login</li>
            </ul>
        </div>
    </div>
</div>
<div class="section section-padding">
    <div class="container">
        <div class="login-register-wrapper">
            <div class="row gx-5">
                <div class="col-lg-6 mx-auto">
                    <div class="login-register-box">
                        <div class="section-title">
                            <h2 class="title text-center">Masukkan Kredensial Anda</h2>
                            <hr>
                        </div>
                        <div class="login-register-form">
                            <?= form_open('auth/do_login', 'id="formLogin"'); ?>
                                <input type="hidden" class="g-recaptcha-response" name="g-recaptcha-response">
                                <div class="single-form">
                                    <input type="text" class="form-control" name="silatpendidikan_username" id="silatpendidikan_username" placeholder="nama pengguna ">
                                </div>
                                <div class="single-form">
                                    <input type="password" class="form-control" name="silatpendidikan_password" id="silatpendidikan_password" placeholder="kata sandi ">
                                </div>
                                <div class="single-form form-check">
                                    <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault">
                                    <label for="flexCheckDefault">Lihat Kata Sandi</label>
                                </div>
                                <div class="single-form">
                                    <button class="btn btn-primary btn-hover-heading-color w-100" id="submit-login">
                                        <span class="spinner-border spinner-border-sm mr-1" id="spinner-status" role="status" aria-hidden="true" style="display:none"></span>
                                        <i class="bi bi-unlock me-2" id="login-icon"></i> <span id="text-button">Login</span> 
                                    </button>
                                </div>
                            <?= form_close(); ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    $('#flexCheckDefault').click(function() {
        if ('password' == $('#silatpendidikan_password').attr('type')) {
            $('#silatpendidikan_password').prop('type', 'text');
        } else {
            $('#silatpendidikan_password').prop('type', 'password');
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
                        confirmButtonColor: '#3bbca7',
                        confirmButtonText: 'OK'
                    }).then(function() {
                        window.location = '<?= base_url('dashboard') ?>';
                    });
                } else {
                    Swal.fire({
                        title: 'Informasi!',
                        html: data.message,
                        icon: 'error',
                        confirmButtonColor: '#3bbca7',
                        confirmButtonText: 'OK'
                    })
                }

                $('#loading-process').hide();
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
                    confirmButtonColor: '#3bbca7',
                    confirmButtonText: 'OK'
                });

                $('#loading-process').hide();
            }
        });
    });
</script>