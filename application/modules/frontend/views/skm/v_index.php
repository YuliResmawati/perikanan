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
        <div class="row">
            <div class="col-md-7 right-sidebar">
            <div class="checkout-field-wrap">
                <h3>Pendapat Responden Tentang Pelayanan Publik</h3><br>
                <?php if (!empty($ikm)): ?>
                    <?php $no = 1; foreach ($ikm as $row): ?>
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label><?= $no. ' - ' .$row['pertanyaan']?></label>
                                <select class="form-control select2" name="opsi" id="opsi">
                                    <?php $no = 1; foreach($row['pilihan'] as $row_opsi): ?>
                                        <option value="<?= $row_opsi['pilihan_nilai']?>"><?= $row_opsi['pilihan'].''. $row_opsi['icon'] ?></option>
                                    <?php $no++; endforeach; ?>
                                </select>
                            </div>
                        </div>
                    <?php $no++; endforeach ?>
                <?php else: ?>
                    <h3 class="brand-title">Belum ada Kusioner. </h3>
                <?php endif ?>
            </div>
            </div>
            <div class="col-md-5">
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
                                <select>
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
                            <input type="text" name="name" placeholder="Usia Anda">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <select>
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
                                <select>
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
                    <div class="submit-area col-lg-12 col-12">
                        <button type="submit" class="button-round-primary">Kirim</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
$(document).ready(function () {
        $('#submitBtn').click(function () {
            var formData = $('#form_emoticon').serialize();
            console.log(formData);

            $.ajax({
                url: '{{ route("User_ajax_ikm") }}', // Ganti 'nama_rute_controller' dengan nama rute controller Anda
                // url: 'https://rangkiang.agamkab.go.id/api/ikm/ajaxInsertPenilaian', // Ganti 'nama_rute_controller' dengan nama rute controller Anda
                method: 'POST',
                data: formData,
                success: function (response) {
                    // Handle respons dari controller jika diperlukan
                    console.log(response.success);
                    // var data = response.success.true;
                    // if (data) {
                    //     Swal.fire(
                    //         'Data Berhasil',
                    //     )
                    // }
                },
                error: function (error) {
                    console.log(error);
                }
            });
        });
    });
</script>