<section class="inner-banner-wrap">
    <div class="inner-baner-container" style="background-image: url(<?= $theme_path ?>/images/perikanan.jpg);">
        <div class="container">
        <div class="inner-banner-content">
            <h1 class="inner-title">Berita</h1>
            </div>
        </div>
    </div>
</section>

<section class="event-page-section bg-light-grey">
    <div class="container">
        <?php if (!empty($berita)): ?>
            <?php foreach ($berita as $row): ?>
            <div class="event-item">
                <div class="event-date">
                <?= indo_date($row->tanggal) ?>
                </div>
                <div class="event-image">
                <figure>
                <a href="<?= base_url('content/') .$row->slug ?>">
                    <?= $this->img->rimg_f($row->image,  array('height'=>257, 'width'=>410, 'crop'=>true, 'alt'=>$row->judul_konten.' thumbnail','attr' => 'loading="lazy"'), $config);  ?>
                </a>    
                </figure>
                </div>
                <div class="event-content">
                <h4><?= $row->judul_konten ?></h4>
                <p><?= $row->isi_konten ?></p>
                </div>
                <div class="event-btn text-right">
                <a href="#" class="button-round-secondary">Selengkapnya</a>
                </div>
            </div>
            <?php endforeach ?>
        <?php else: ?>
        <h3 class="brand-title">Belum ada berita yang tersedia. </h3>
        <?php endif ?>
    </div>
</section>

<div class="charity-page-section bg-light-grey">
    <div class="charity-page-inner">
        <div class="container">
            <div class="row">
            <?php if (!empty($berita)): ?>
                <?php foreach ($berita as $row): ?>
                <div class="col-md-4">
                    <article class="charity-item">
                        <figure class="charity-image">
                            <a href="<?= base_url('content/') .$row->slug ?>">
                                <?= $this->img->rimg_f($row->image,  array('height'=>257, 'width'=>410, 'crop'=>true, 'alt'=>$row->judul_konten.' thumbnail','attr' => 'loading="lazy"'), $config);  ?>
                            </a>
                            <div class="btn-wrap">
                            <a href="donate.html" class="button-round-primary">Lihat</a>
                            </div>
                        </figure>
                        <div class="charity-content">
                            <h4><?= $row->judul_konten ?></h4>
                            <p><?= $row->isi_konten ?></p>
                            <div class="fund-detail">
                            <div class="fund-item">
                                <span class="fund-name">Tanggal:</span>
                                <span class="fund-content"><?= indo_date($row->tanggal) ?></span>
                            </div>
                            <div class="fund-item">
                                <span class="fund-name">Admin:</span>
                                <span class="fund-content">DKPP</span>
                            </div>
                            </div>
                        </div>
                    </article>
                </div>
                <?php endforeach ?>
            <?php else: ?>
            <h3 class="brand-title">Belum ada berita yang tersedia. </h3>
            <?php endif ?>
            </div>
        </div>
    </div>
</div>

<section class="blog-section">
    <div class="container">
        <div class="blog-inner">
            <div class="row">
            <?php if (!empty($berita)): ?>
                <?php foreach ($berita as $row): ?>
                    <div class="col-md-6 col-lg-4">
                        <article class="post">
                            <figure class="feature-image">
                                <a href="<?= base_url('content/') .$row->slug ?>">
                                    <?= $this->img->rimg_f($row->image,  array('height'=>257, 'width'=>410, 'crop'=>true, 'alt'=>$row->judul_konten.' thumbnail','attr' => 'loading="lazy"'), $config);  ?>
                                </a>
                                <span class="cat-meta">
                                <a href="blog-archive.html">Lihat</a>
                                </span>
                            </figure>
                            <div class="entry-content">
                                <h4>
                                <a href="blog-single.html"><?= $row->judul_konten ?></a>
                                </h4>
                            </div>
                            <div class="entry-meta">
                                <span class="posted-on">
                                <a class="date" href="#"><?= indo_date($row->tanggal) ?></a>
                                </span>
                                <span class="comments-link">
                                <a href="blog-single.html">Admin Dinas Ketahanan Pangan dan Perikanan</a>
                                </span>
                            </div>
                        </article>
                    </div>
                <?php endforeach ?>
            <?php else: ?>
            <h3 class="brand-title">Belum ada berita yang tersedia. </h3>
            <?php endif ?>
            </div>
        </div>
    </div>
</section>