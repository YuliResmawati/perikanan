<section class="inner-banner-wrap">
    <div class="inner-baner-container" style="background-image: url(<?= $theme_path ?>/images/perikanan.jpg);">
        <div class="container">
        <div class="inner-banner-content">
            <h1 class="inner-title">Survey Kepuasan Masyarakat</h1>
            </div>
        </div>
    </div>
</section>
<div class="checkout-section">
    <div class="container">
        <?= form_open($uri_mod.'/sendRankiangApis', 'id="formAjax" class="form"') ?>
        <div class="row">
            <div class="col-md-4">
                <div class="qsn-form-container">
                    <h4>Biodata Responden</h4>
                    <p>silahkan isikan biodata diri anda</p>
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                            <input type="text" name="name" placeholder="Nama Lengkap">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <select name="jenis_kelamin">
                                    <option>Pilih Jenis Kelamin</option>
                                    <option value="L">Laki-Laki</option>
                                    <option value="P">Perempuan</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                            <input type="text" name="usia" placeholder="Usia Anda">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <select name="pendidikan">
                                    <option>Pilih Pendidikan</option>
                                    <option value="SD">SD</option>
                                    <option value="SMP">SMP</option>
                                    <option value="SMA">SMA</option>
                                    <option value="D1">D1</option>
                                    <option value="D2">D2</option>
                                    <option value="D3">D3</option>
                                    <option value="D4">D4</option>
                                    <option value="S1">S1</option>
                                    <option value="S2">S2</option>
                                    <option value="S3">S3</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <select name="pekerjaan">
                                    <option>Pilih Pekerjaan</option>
                                    <option value="Petani">Petani</option>
                                    <option value="PNS">PNS</option>
                                    <option value="POLRI">POLRI</option>
                                    <option value="Swasta">Swasta</option>
                                    <option value="Wirausaha">Wirausaha</option>
                                    <option value="Lainya   ">Lainya</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-8 right-sidebar">
                <div class="checkout-field-wrap">
                    <h3>Pendapat Responden Tentang Pelayanan Publik</h3><br>
                    <?php if (!empty($ikm)): ?>
                        <?php $noa = 1; foreach ($ikm as $row): ?>
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label><?= $noa. ' - ' .$row['pertanyaan']?></label>
                                    <select class="form-control select2" name="nilai" id="nilai">
                                        <?php $no = 1; foreach($row['pilihan'] as $row_opsi): ?>
                                            <option value="<?= $row_opsi['pilihan_nilai']?>"><?= $row_opsi['pilihan'].''. $row_opsi['icon'] ?></option>
                                        <?php $no++; endforeach; ?>
                                    </select>
                                </div>
                            </div>
                        <?php $noa++; endforeach ?>
                    <?php else: ?>
                        <h3 class="brand-title">Belum ada Kusioner. </h3>
                    <?php endif ?>
                </div>
            </div>
            <div class="row mt-3">
                <div class="col-12 text-right">
                    <button type="submit" id="submit-btn" class="button-round-primary w-60">
                        <span class="spinner-border spinner-border-sm mr-1" id="spinner-status" role="status" aria-hidden="true" style="display:none"></span>
                        <i class="mdi mdi-content-save mr-1" id="icon-save"></i><span id="button-value">Kirim</span>
                    </button>
                </div>
            </div>
        </div>
        <?= form_close(); ?>
    </div>
</div>
<script type="text/javascript">
$('#formAjax').submit(function(e) {
    e.preventDefault();
    $.ajax({
        url: "<?= site_url('isi-survei/sendRankiangApis') ?>",
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
            $('#text-button').html('Kirim SKM');
            $('#text-button').removeClass('ml-3');

            if (data.status == true) {
                Swal.fire({
                    title: 'Informasi!',
                    html: data.message,
                    icon: 'success',
                    confirmButtonColor: '#FFDA0F',
                    confirmButtonText: 'OK'
                }).then(function() {
                    window.location = '<?= base_url('isi-survei') ?>';
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
            $('#text-button').html('Kirim SKM');
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