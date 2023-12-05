<section class="inner-banner-wrap">
    <div class="inner-baner-container" style="background-image: url(<?= $theme_path ?>/images/perikanan.jpg);">
        <div class="container">
        <div class="inner-banner-content">
            <h1 class="inner-title">Detail Berita</h1>
            </div>
        </div>
    </div>
</section>
<div class="charity-page-section">
    <div class="charity-page-inner">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 primary right-sidebar">
                    <div class="charity-detail-container">
                        <figure class="charity-image">
                            <a href="<?= base_url('berita/') .$detail_berita->slug ?>">
                                <img src="<?= str_files_images('content/', $detail_berita->berkas) ?>" alt="<?= xss_escape($detail_berita->judul_konten) ?> thumbnail">
                            </a>
                        </figure>
                        <h3 class="title"><?= xss_escape($detail_berita->judul_konten) ?></h3>
                        <div class="d-flex flex-wrap progress-wrap">
                            <div class="fund-detail">
                            <div class="fund-item">
                                <i class="fas fa-hand-holding-usd"></i>
                                <h5 class="fund-content"> <?= indo_date($detail_berita->tanggal) ?></h5>
                            </div>
                            <div class="fund-item">
                                <i class="fas fa-chart-line"></i>
                                <h5 class="fund-content">Admin DKPP</h5>
                            </div>
                            </div>
                        </div>
                        <p style="text-align: justify;" > 
                            <?= (!empty($detail_berita)) ? $detail_berita->isi_konten : "" ?>
                        </p>
                    </div>
                </div>
                <div class="col-lg-4 secondary">
                    <div class="sidebar">
                    <?php if (!empty($popular_berita)): ?>
                        <aside class="widget widget_latest_post widget-post-thumb">
                            <h3 class="widget-title">Berita Populer</h3>
                            <?php foreach ($popular_berita as $row): ?>
                            <ul>
                                <li>
                                    <figure class="post-thumb">
                                        <a href="<?= base_url('berita/') .$row->slug ?>">
                                            <img src="<?= str_files_images('content/', $row->berkas) ?>" alt="<?= xss_escape($row->judul_konten) ?> thumbnail">
                                        </a>
                                    </figure>
                                    <div class="post-content">
                                        <h5 class="title"><a href="<?= base_url('berita/') .$row->slug ?>" class="max-lines text-justify"><?= xss_escape($row->judul_konten) ?></a></h5>
                                        <div class="entry-meta">
                                            <span class="posted-on">
                                            <a href="blog-single.html"><?= indo_date($row->tanggal) ?></a>
                                            </span>
                                            <span class="comments-link">
                                            <a href="blog-single.html">Admin DKPP</a>
                                            </span>
                                        </div>
                                    </div>
                                </li>
                                <li></li>
                            </ul>
                            <?php endforeach ?>
                        </aside>
                        <aside class="widget widget_social">
                            <h3 class="widget-title">Share Sosial Media</h3>
                            <div class="social-icon-wrap">
                                <div class="social-icon social-facebook">
                                    <a href="https://www.facebook.com/">
                                        <i class="fab fa-facebook-f"></i>
                                        <span>Facebook</span>
                                    </a>
                                </div>
                                <div class="social-icon social-pinterest">
                                    <a href="https://www.pinterest.com/">
                                        <i class="fab fa-pinterest"></i>
                                        <span>Pinterest</span>
                                    </a>
                                </div>
                                <div class="social-icon social-whatsapp">
                                    <a href="https://wa.me/?text=<?= base_url('berita/') .$detail_berita->slug ?>">
                                        <i class="fab fa-whatsapp"></i>
                                        <span>WhatsApp</span>
                                    </a>
                                </div>
                                <div class="social-icon social-linkedin">
                                    <a href="https://www.linkedin.com/">
                                        <i class="fab fa-linkedin"></i>
                                        <span>Linkedin</span>
                                    </a>
                                </div>
                                <div class="social-icon social-twitter">
                                    <a href="https://www.twitter.com/">
                                        <i class="fab fa-twitter"></i>
                                        <span>Twitter</span>
                                    </a>
                                </div>
                                <div class="social-icon social-google">
                                    <a href="https://www.google.com/">
                                        <i class="fab fa-google-plus-g"></i>
                                        <span>Google</span>
                                    </a>
                                </div>
                            </div>
                        </aside>
                    <?php endif ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
