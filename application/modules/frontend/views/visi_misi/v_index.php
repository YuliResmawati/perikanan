<section class="inner-banner-wrap">
    <div class="inner-baner-container" style="background-image: url(<?= $theme_path ?>/images/perikanan.jpg);">
        <div class="container">
        <div class="inner-banner-content">
            <h1 class="inner-title">Visi dan Misi</h1>
            </div>
        </div>
    </div>
</section>
<div class="volunteer-wrap">
    <div class="container">
        <div class="row">
        <?php if (!empty($website_data)): ?>
            <?php foreach ($website_data as $row): ?>
            <div class="col-lg-8 offset-lg-2">
                <div class="volunteer-contact-form">
                    <div class="section-head">
                        <div class="back-title">visi dan misi</div>
                            <h2 class="section-title">Visi</h2>
                        <div class="section-disc">
                            <?= $row->visi?>
                        </div><br><br>
                            <h2 class="section-title">Misi</h2>
                        <div class="section-disc">
                            <?= $row->misi?>
                        </div>
                    </div>
                </div>
            </div>
            <?php endforeach ?>
        <?php else: ?>
            <h3 class="brand-title">Belum ada Visi Misi. </h3>
        <?php endif ?>
        </div>
    </div>
</div>
