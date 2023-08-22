<div class="section page-banner-section bg-color-1">
    <img class="shape-1" src="<?= $theme_path ?>/images/shape/shape-5.png" alt="shape">
    <img class="shape-2" src="<?= $theme_path ?>/images/shape/shape-6.png" alt="shape">
    <img class="shape-3" src="<?= $theme_path ?>/images/shape/shape-7.png" alt="shape">
    <img class="shape-4" src="<?= $theme_path ?>/images/shape/shape-21.png" alt="shape">
    <img class="shape-5" src="<?= $theme_path ?>/images/shape/shape-21.png" alt="shape">
    <div class="container">
        <div class="page-banner-content">
            <h2 class="title">Survei Kepuasan</h2>
            <ul class="breadcrumb justify-content-center">
                <li class="breadcrumb-item"><a href="<?= base_url('home') ?>">Home</a></li>
                <li class="breadcrumb-item active">Isi Survei</li>
            </ul>
        </div>
    </div>
</div>
<div class="section section-padding">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="section-title text-center">
                    <h2 class="title">Berikan Penilaian Untuk <span> Bentuk Perubahan</span></h2>
                </div>
                <div class="contact-form-wrapper mt-5">
                    <?= form_open('isi-survei/process', 'id="formSurvei"'); ?>
                        <input type="hidden" class="is-recaptcha-response" name="is-recaptcha-response">
                        <input type="hidden" class="form-control" name="score" id="score" readonly>
                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <div class="my-rating-2 text-center" data-rating="0"></div>
                            </div>    
                            <div class="col-md-6">
                                <div class="single-form">
                                    <input type="text" class="form-control" name="name" id="name" placeholder="Nama Lengkap">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="single-form">
                                    <select name="gender" id="gender" class="form-control">
                                        <option selected disabled>Pilih Jenis Kelamin </option>  
                                        <option value="<?= encrypt_url('1', 'skm') ?>">Laki-Laki</option>
                                        <option value="<?= encrypt_url('2', 'skm') ?>">Perempuan</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="single-form">
                                    <select name="education" id="education" class="form-control">
                                        <option selected disabled>Pilih Pendidikan </option>  
                                        <option value="<?= encrypt_url('1', 'skm') ?>">SD</option>
                                        <option value="<?= encrypt_url('2', 'skm') ?>">SMP</option>
                                        <option value="<?= encrypt_url('3', 'skm') ?>">SMA</option>
                                        <option value="<?= encrypt_url('4', 'skm') ?>">D-III</option>
                                        <option value="<?= encrypt_url('5', 'skm') ?>">D-IV/S1</option>
                                        <option value="<?= encrypt_url('6', 'skm') ?>">S2</option>
                                        <option value="<?= encrypt_url('7', 'skm') ?>">S3</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="single-form">
                                    <input type="number" class="form-control" name="age" id="age" placeholder="Usia">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="single-form">
                                    <input type="number" class="form-control" name="phone_number" id="phone_number" placeholder="Nomor Handphone">
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="single-form">
                                    <textarea class="form-control" name="suggestion" id="suggestion" placeholder="Sampaikan Kritik dan Saran"></textarea>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="single-form text-center">
                                    <button class="btn btn-primary btn-hover-heading-color" id="submit-survei">
                                        <span class="spinner-border spinner-border-sm mr-1" id="spinner-status" role="status" aria-hidden="true" style="display:none"></span>
                                        <i class="bi bi-unlock me-2" id="login-icon"></i> <span id="text-button">Kirim Survei</span> 
                                    </button>
                                </div>
                            </div>
                        </div>
                    <?= form_close() ?>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function() {
        $(".my-rating-2").starRating({
            totalStars: 5,
            starSize: 80,
            emptyColor: 'lightgray',
            hoverColor: 'crimson',
            activeColor: 'crimson',
            strokeWidth: 0,
            useGradient: false,
            callback: function (currentRating) {
                $('#score').val(currentRating);
            }
        });
    });

    $('#submit-survei').click(function(e) {
        e.preventDefault();
        $('#spinner-status').show();
        $('#login-icon').hide();
        $('#text-button').html('Loading...');
        $('#text-button').addClass('ml-2');
        grecaptcha.ready(function() {
            grecaptcha.execute('<?php echo RECAPTCHA_SITE_KEY; ?>', {action: 'submit'}).then(function(token) {
                document.querySelector('.is-recaptcha-response').value = token;
                $('#formSurvei').submit()
            });
        });
    });

    $('#formSurvei').submit(function(e) {
        e.preventDefault();
        $.ajax({
            url: "<?= site_url('isi-survei/process') ?>",
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
                $('#text-button').html('Kirim Survei');
                $('#text-button').removeClass('ml-2');

                if (data.status == true) {
                    Swal.fire({
                        title: 'Informasi!',
                        html: data.message,
                        icon: 'success',
                        confirmButtonColor: '#3bbca7',
                        confirmButtonText: 'OK'
                    }).then(function() {
                        window.location = '<?= base_url('home') ?>';
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
                $('#text-button').html('Kirim Survei');
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