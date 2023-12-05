<section class="inner-banner-wrap">
    <div class="inner-baner-container" style="background-image: url(<?= $theme_path ?>/images/perikanan.jpg);">
        <div class="container">
        <div class="inner-banner-content">
            <h1 class="inner-title">Struktur Organisasi</h1>
            </div>
        </div>
    </div>
</section>

<div class="single-page-section">
    <div class="container">
        <?php if (!empty($struktur_dkpp)): ?>
            <?php foreach ($struktur_dkpp as $row): ?>
                <figure class="single-feature-img">
                    <img src="<?= str_files_images('struktur/', $row->image) ?>">
                </figure>
            <?php endforeach ?>
        <?php else: ?>
            <h3 class="brand-title">Belum ada struktur. </h3>
        <?php endif ?>
    </div>
</div>