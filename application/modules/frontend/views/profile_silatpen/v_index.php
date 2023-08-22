<div class="section page-banner-section bg-color-1">
    <img class="shape-1" src="<?= $theme_path ?>/images/shape/shape-5.png" alt="shape">
    <img class="shape-2" src="<?= $theme_path ?>/images/shape/shape-6.png" alt="shape">
    <img class="shape-3" src="<?= $theme_path ?>/images/shape/shape-7.png" alt="shape">
    <img class="shape-4" src="<?= $theme_path ?>/images/shape/shape-21.png" alt="shape">
    <img class="shape-5" src="<?= $theme_path ?>/images/shape/shape-21.png" alt="shape">
    <div class="container">
        <div class="page-banner-content">
            <h2 class="title">Profil Silat Pendidikan</h2>
            <ul class="breadcrumb justify-content-center">
                <li class="breadcrumb-item"><a href="<?= base_url('home') ?>">Home</a></li>
                <li class="breadcrumb-item active">Profil</li>
            </ul>
        </div>
    </div>
</div>
<div class="section section-padding">
    <div class="container">
        <div class="blog-wrapper-02">
            <div class="row justify-content-between">
                <div class="col-lg-8">
                    <div class="blog-details-wrapper">
                        <div class="blog-details-content">
                            <h3 class="title mb-4">Profil Silat Pendidikan</h3>
                            <p style="font-size: 19px;">
                                <?= xss_escape((!empty($website_data[0]->profile)) ? $website_data[0]->profile : "") ?>
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-lg-4">
                    <div class="sidebar-wrap">
                        <div class="sidebar-widget">
                            <div class="widget-banner">
                                <a href="#"><img src="<?= $theme_path ?>/images/banner-03.png" alt="Banner"></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>