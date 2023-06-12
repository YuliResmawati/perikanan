<div class="welcome-area hero2 bg-white">
    <div class="hero-background-shape">
        <img src="<?= $theme_path ?>/img/core-img/hero-2.png" alt="core image">
    </div>
    <div class="background-animation">
        <div class="item1"></div>
        <div class="item4"></div>
        <div class="item5"></div>
    </div>
    <div class="hero2-big-circle"></div>
    <div class="container h-100 <?= ($this->agent->is_mobile()) ? 'mt-4' : '' ?>">
        <div class="row h-100 align-items-center justify-content-between">
            <div class="col-12 col-sm-10 col-md-6">
                <div class="welcome-content">
                    <h2 class="wow fadeInUp" data-wow-duration="1000ms" data-wow-delay="200ms">Lorem Ipsum is simply dummy text of the printing and typesetting industry</h2>
                    <p class="mb-4 wow fadeInUp" data-wow-duration="1000ms" data-wow-delay="400ms">Lorem Ipsum has been the industry's standard dummy text ever since the 1500s</p>
                    <p class="mb-4 wow fadeInUp" data-wow-duration="1000ms" data-wow-delay="400ms" style="font-size:17px;"><strong>#loremipsum</strong></p>
                    <div class="d-flex align-items-center wow fadeInUp" data-wow-duration="1000ms" data-wow-delay="600ms">
                        <a class="btn btn-warning mt-3" href="<?= base_url('auth') ?>"><?= strtoupper('Masuk Ke Silat Pendidikan') ?></a>
                    </div>
                </div>
            </div>
            <div class="col-12 col-sm-10 col-md-6">
                <div class="welcome-thumb ms-xl-5 wow fadeInUp" data-wow-duration="1000ms" data-wow-delay="400ms">
                    <img src="<?= $theme_path ?>/img/illustrator/hero-6.png" alt="core image">
                </div>
            </div>
        </div>
    </div>
</div>