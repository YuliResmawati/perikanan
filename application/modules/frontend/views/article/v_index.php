<section class="inner-banner-wrap">
    <div class="inner-baner-container" style="background-image: url(<?= $theme_path ?>/images/perikanan.jpg);">
        <div class="container">
        <div class="inner-banner-content">
            <h1 class="inner-title">Artikel</h1>
            </div>
        </div>
    </div>
</section>

<div class="charity-page-section bg-light-grey">
    <div class="charity-page-inner">
        <div class="container">
        <?php if (!empty($article)): ?>
            <div class="row">
                <?php foreach ($article as $row): 
                    $row_judul    =substr($row->judul_konten, 0, 50);
                    $row_isi    =substr($row->isi_konten, 0, 50);
                ?>
                <div class="col-md-4">
                    <article class="charity-item">
                        <figure class="charity-image">
                            <a href="<?= base_url('article/') .$row->slug ?>">
                                <?= $this->img->rimg_f($row->berkas,  array('height'=>257, 'width'=>410, 'crop'=>true, 'alt'=>$row->judul_konten.' thumbnail','attr' => 'loading="lazy"'), $config);  ?>
                            </a>
                            <div class="btn-wrap">
                                <a href="<?= base_url('article/') .$row->slug ?>" class="button-round-primary">Lihat</a>
                            </div>
                        </figure>
                        <div class="charity-content">
                            <h3 class="title"><a href="<?= base_url('article/') .$row->slug ?>" class="max-lines text-justify"><?= xss_escape($row_judul) ?></a></h3>
                            <p class="max-lines-des text-justify"><?= $row_isi?><a href="<?= base_url('article/') .$row->slug ?>">...Read more</a></p>
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
            </div>
            <?php if ($status_paging == 'show'): ?>
                <div class="page-pagination">
                    <?= $this->pagination->create_links() ?>
                </div>
            <?php endif; ?>
        <?php else: ?>
        <h3 class="brand-title">Belum ada artikel yang tersedia. </h3>
        <?php endif ?>
        </div>
    </div>
</div>

