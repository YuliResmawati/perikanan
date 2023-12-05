<section class="inner-banner-wrap">
    <div class="inner-baner-container" style="background-image: url(<?= $theme_path ?>/images/perikanan.jpg);">
        <div class="container">
        <div class="inner-banner-content">
            <h1 class="inner-title">Layanan Pengaduan</h1>
            </div>
        </div>
    </div>
</section>
<div class="volunteer-wrap">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 offset-lg-2">
            <div class="volunteer-contact-form">
                <div class="section-head">
                    <h3 class="section-title">Form <span class="primary-color">Pengaduan 
                        <svg class="title-shape" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 500 150" preserveAspectRatio="none">
                            <path d="M9.3,127.3c49.3-3,150.7-7.6,199.7-7.4c121.9,0.4,189.9,0.4,282.3,7.2C380.1,129.6,181.2,130.6,70,139 c82.6-2.9,254.2-1,335.9,1.3c-56,1.4-137.2-0.3-197.1,9"></path>
                        </svg>
                        </span>
                    </h3>
                    <div class="section-disc">
                        Silahkan isikan pengaduan online anda pada form dibawah ini
                    </div>
                </div>
                
                <?= form_open('layanan-pengaduan/process', 'id="formSurvei"'); ?>
                <input type="hidden" class="p-recaptcha-response" name="p-recaptcha-response">
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-12 form-group">
                        <input type="text" name="name" id="name" placeholder="Nama Lengkap">
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-6 col-12 form-group">
                        <input type="email" name="email" id="email" placeholder="Email">
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-6 col-12 form-group">
                        <input type="number" name="no_hp" id="no_hp" placeholder="No Hp*">
                        </div>
                        <div class="col-lg-12 col-12 form-group">
                        <textarea rows="7" name="isi" id="isi" placeholder="Isi Pengaduan..."></textarea>
                        </div>
                        <div class="submit-area col-lg-12 col-12">
                        
                            <button class="button-round-primary w-100" id="submit-survei">
                                <span class="spinner-border spinner-border-sm mr-1" id="spinner-status" role="status" aria-hidden="true" style="display:none"></span>
                                <i class="bi bi-unlock me-2" id="login-icon"></i> <span id="text-button">Kirim Pengaduan</span> 
                            </button>
                        </div>
                    </div>
                <?= form_close() ?>
            </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
$('#submit-survei').click(function(e) {
        e.preventDefault();
        $('#spinner-status').show();
        $('#login-icon').hide();
        $('#text-button').html('Loading...');
        $('#text-button').addClass('ml-2');
        grecaptcha.ready(function() {
            grecaptcha.execute('<?php echo RECAPTCHA_SITE_KEY; ?>', {action: 'submit'}).then(function(token) {
                document.querySelector('.p-recaptcha-response').value = token;
                $('#formSurvei').submit()
            });
        });
    });

$('#formSurvei').submit(function(e) {
    e.preventDefault();
    $.ajax({
        url: "<?= site_url('layanan-pengaduan/process') ?>",
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
            $('#text-button').html('Kirim Pengaduan');
            $('#text-button').removeClass('ml-3');

            if (data.status == true) {
                Swal.fire({
                    title: 'Informasi!',
                    html: data.message,
                    icon: 'success',
                    confirmButtonColor: '#FFDA0F',
                    confirmButtonText: 'OK'
                }).then(function() {
                    window.location = '<?= base_url('home') ?>';
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
            $('#text-button').html('Kirim Pengaduan');
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