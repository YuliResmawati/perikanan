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
                                <select class="form-control select2" name="agama" id="agama">
                                    <option value="4">Sangat Baik</option>
                                    <option value="3">Baik</option>
                                    <option value="2">Kurang Baik</option>
                                    <option value="1">Tidak Baik</option>
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
                                    <option value="0">Laki-Laki</option>
                                    <option value="0">Perempuan</option>
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
                                    <option value="0">SD</option>
                                    <option value="0">SMP</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <select>
                                    <option>Pilih Pekerjaan</option>
                                    <option value="0">PNS</option>
                                    <option value="0">Lainya</option>
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