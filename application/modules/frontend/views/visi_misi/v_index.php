<div class="section page-banner-section bg-color-1">
    <img class="shape-1" src="<?= $theme_path ?>/images/shape/shape-5.png" alt="shape">
    <img class="shape-2" src="<?= $theme_path ?>/images/shape/shape-6.png" alt="shape">
    <img class="shape-3" src="<?= $theme_path ?>/images/shape/shape-7.png" alt="shape">
    <img class="shape-4" src="<?= $theme_path ?>/images/shape/shape-21.png" alt="shape">
    <img class="shape-5" src="<?= $theme_path ?>/images/shape/shape-21.png" alt="shape">
    <div class="container">
        <div class="page-banner-content">
            <h2 class="title">Visi & Misi</h2>
            <ul class="breadcrumb justify-content-center">
                <li class="breadcrumb-item"><a href="<?= base_url('home') ?>">Home</a></li>
                <li class="breadcrumb-item active">Visi & Misi</li>
            </ul>
        </div>
    </div>
</div>
<div class="section section-padding border-bottom">
    <div class="container">
        <div class="section-title text-center">
            <h2 class="title"><span>VISI</span></h2>
            <div class="about-content mt-4" style="margin: auto;">
                <h5 class="title" style="font-size: 19px;"><?= xss_escape((!empty($website_data[0]->visi)) ? $website_data[0]->visi : "") ?></h5>
            </div>
        </div>
        <div class="section-title text-center mt-5">
            <h2 class="title"><span>MISI</span></h2>
            <div class="about-content mt-4" style="margin: auto;">
                <div style="color: #072f60;">
                    <h5 style="font-size: 17.5px;">
                        <?= xss_escape((!empty($website_data[0]->misi)) ? $website_data[0]->misi : "") ?>
                    </h5> 
                </div>
            </div>
        </div>
    </div>
</div>