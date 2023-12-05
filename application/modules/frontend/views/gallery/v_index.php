<section class="inner-banner-wrap">
    <div class="inner-baner-container" style="background-image: url(<?= $theme_path ?>/images/perikanan.jpg);">
        <div class="container">
        <div class="inner-banner-content">
            <h1 class="inner-title">Gallery</h1>
            </div>
        </div>
    </div>
</section>
<section class="gallery-page-section gallery-section">
    <div class="container">
        <?php if (!empty($gallery)): ?>
            <?php foreach ($gallery as $row): ?>
                <div class="gallery-inner">
                    <div class="gallery-container grid">
                    <div class="single-gallery grid-item">
                        <figure class="gallery-img">
                            <a href="<?= str_files_images('gallery/', $row->image) ?>" data-fancybox="gallery">
                                <img src="<?= str_files_images('gallery/', $row->image) ?>">
                            </a>
                        </figure>
                    </div>
                </div>
            <?php endforeach ?>
        <?php else: ?>
            <h3 class="brand-title">Tidak Ada Gallery Tersedia. </h3>
        <?php endif ?>
    </div>
</section>