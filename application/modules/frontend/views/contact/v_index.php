<section class="inner-banner-wrap">
    <div class="inner-baner-container" style="background-image: url(<?= $theme_path ?>/images/perikanan.jpg);">
        <div class="container">
        <div class="inner-banner-content">
            <h1 class="inner-title">Kontak</h1>
            </div>
        </div>
    </div>
</section>
<section class="about-page-section">
    <div class="container">
        <div class="iconbox-container-bg">
        <?php if (!empty($website_data)): ?>
            <?php foreach ($website_data as $row): ?>
            <div class="iconbox-item-bg">
                <div class="iconbox-content-bg">
                    <i aria-hidden="true" class="fas fa-phone-volume"></i>
                    <h5><?= $row->phone_number?></h5>
                </div>
            </div>
            <div class="iconbox-item-bg">
                <div class="iconbox-content-bg">
                    <i aria-hidden="true" class="fas fa-envelope-open-text"></i>
                    <h5><?= $row->email?></h5>
                </div>
            </div>
            <div class="iconbox-item-bg">
                <div class="iconbox-content-bg">
                    <i aria-hidden="true" class="fas fa-map-marker-alt"></i>
                    <h5><?= $row->address?></h5>
                </div>
            </div>
            <div class="iconbox-item-bg">
                <div class="iconbox-content-bg">
                    <i aria-hidden="true" class="fab fa-instagram"></i>
                    <h5><?= $row->link_instagram?></h5>
                </div>
            </div>
            <div class="iconbox-item-bg">
                <div class="iconbox-content-bg">
                    <i aria-hidden="true" class="fab fa-facebook"></i>
                    <h5><?= $row->link_facebook?></h5>
                </div>
            </div>
            <?php endforeach ?>
        <?php else: ?>
            <h3 class="brand-title">Belum ada Visi Misi. </h3>
        <?php endif ?>
        </div>
    </div>
</section>