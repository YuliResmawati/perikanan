<div class="main-banner" style="background: white;padding: 130px 0px 50px 0px;">
    <div class="container">
        <div class="row">
            <div class="col-lg-6">
                <div class="right-image">
                    <img src="<?= $theme_path ?>/assets/images/mobile-login.jpg" alt="">
                </div>
            </div>
            <div class="col-lg-6">
            <div class="card shadow-2-strong" style="border-radius: 1rem;">
                <div class="card-body p-5 text-center">
                <h3 class="mb-3">Selamat Datang!</h3>
                    <p>Butuh bantuan informasi login? <a class="ms-2" href="#">Hubungi Kami</a></p>
                <hr class="my-4">
                <?= form_open('auth/do_login', 'id="formLogin"'); ?>
                    <input type="hidden" class="g-recaptcha-response" name="g-recaptcha-response">
                    <div class="form-outline mb-4" >
                        <input type="text" name="silatpendidikan_username" id="silatpendidikan_username" class="form-control form-control-lg" placeholder="Nama Pengguna" style="font-size: small;"/>
                    </div>
                    <div class="form-outline mb-4">
                        <input type="password" name="silatpendidikan_password" id="silatpendidikan_password" class="form-control form-control-lg"  placeholder="Kata Sandi" style="font-size: small;"/>
                    </div>
                    <!-- Checkbox -->
                    <div class="form-check d-flex justify-content-start mb-4">
                        <input class="form-check-input me-2" type="checkbox" value="" id="flexCheckDefault" />
                        <label class="form-check-label" for="flexCheckDefault" style="font-size: small;"> Lihat Kata Sandi </label>
                    </div>
                    <div class="d-grid gap-2">
                        <button class="btn btn-lg btn-block text-white w-100" id="submit-login" style="background:#ff4f5a">
                        <span class="spinner-border spinner-border-sm mr-1" id="spinner-status" role="status" aria-hidden="true" style="display:none"></span>
                        <i<i class="fa fa-sign-in" id="login-icon"></i> <span id="text-button">Login</span> 
                        </button>
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