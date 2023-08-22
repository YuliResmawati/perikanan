<div class="slider-section-04 section">
    <img class="shape-1 parallaxed animate-02" src="<?= $theme_path ?>/images/shape/shape-18.svg" alt="Shape">
    <div class="container">
        <div class="row justify-content-center align-items-center">
            <div class="col-md-6">
                <div class="slider-content">
                    <h2 class="title">Sistem Informasi Layanan Terintegrasi Pendidikan Kota Bukittinggi</h2>
                    <h5 style="max-width: 400px; line-height: 1.6; margin-top: 25px;">Membentuk Karakter, Mewujudkan Impian.</h5>
                    <a href="<?= base_url('isi-survei') ?>" class="btn btn-primary btn-hover-heading-color">Berikan Penilaian untuk Bentuk Perubahan!</a>
                </div>
            </div>
            <div class="col-md-6 col-sm-8">
                <div class="slider-images-04">
                    <img class="image-shape-01 parallaxed animate-01" src="<?= $theme_path ?>/images/shape/shape-17.png" alt="Shape">

                    <div class="image">
                        <img src="<?= $theme_path ?>/images/wali.png" alt="Walikota Bukittinggi">
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="section counter-section feature-section" style="background-color: white;">
    <div class="container">
        <div class="feature-wrapper">
            <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3">
                <div class="col">
                    <div class="single-feature">
                        <div class="feature-icon">
                            <img src="<?= $theme_path ?>/images/school.png" alt="sekolah">
                        </div>
                        <div class="feature-content">
                            <h4 class="title" style="color: #072f60;"><?= number_format($count_sekolah, 0, '', '.') ?></h4>
                            <p style="color: #072f60;">Sekolah TK, SD dan SMP di bukittinggi</p>
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="single-feature">
                        <div class="feature-icon">
                            <img src="<?= $theme_path ?>/images/student.png" alt="siswa">
                        </div>
                        <div class="feature-content">
                            <h4 class="title" style="color: #072f60;"><?= number_format($count_siswa, 0, '', '.') ?></h4>
                            <p style="color: #072f60;">Siswa TK, SD dan SMP di bukittinggi</p>
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="single-feature">
                        <div class="feature-icon">
                            <img src="<?= $theme_path ?>/images/teacher.png" alt="guru">
                        </div>
                        <div class="feature-content">
                            <h4 class="title" style="color: #072f60;"><?= number_format($count_guru, 0, '', '.') ?></h4>
                            <p style="color: #072f60;">Guru TK, SD dan SMP di bukittinggi</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <hr class="mt-5">
    </div>
</div>