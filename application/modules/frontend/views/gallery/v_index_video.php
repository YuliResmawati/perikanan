<section class="inner-banner-wrap">
    <div class="inner-baner-container" style="background-image: url(<?= $theme_path ?>/images/perikanan.jpg);">
        <div class="container">
        <div class="inner-banner-content">
            <h1 class="inner-title">Video</h1>
            </div>
        </div>
    </div>
</section>
<div class="carrer-page-section">
    <div class="container">
    <?php if (!empty($video)): ?>
        <div class="about-service-wrap">
            <div class="row">   
            <?php foreach ($video as $row): ?>
                <div class="col-md-6">
                    <div class="vacancy-content">
                        <span>Youtube</span>
                        <h4><?= $row->judul ?></h4>
                        <iframe width="560" height="315" src="https://www.youtube.com/embed/<?= $row->link?>" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe>
                    </div>
                </div>
            <?php endforeach ?>
            </div>
        </div>
    <?php else: ?>
        <h3 class="brand-title">Tidak Ada Video Tersedia. </h3>
    <?php endif ?>
    </div>
</div>