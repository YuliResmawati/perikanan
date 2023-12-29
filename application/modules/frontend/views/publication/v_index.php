<section class="inner-banner-wrap">
    <div class="inner-baner-container" style="background-image: url(<?= $theme_path ?>/images/perikanan.jpg);">
        <div class="container">
        <div class="inner-banner-content">
            <h1 class="inner-title">Publikasi</h1>
            </div>
        </div>
    </div>
</section>
<section class="event-page-section bg-light-grey">
    <div class="container">
        <p>Terdapat <span><?= $total ?></span> Publikasi</p>
        <?php if (!empty($publikasi)): ?>
            <?php foreach ($publikasi as $row): ?>
            <div class="event-item">
                <div class="event-date">
                    <h3><?= date('d', strtotime($row->tanggal)) ?></h3>
                    <h4><?= bulan(date('m', strtotime($row->tanggal))) ?><span><?= date('Y', strtotime($row->tanggal)) ?></span></h4>
                </div>
                <div class="event-image">
                <figure>
                <a href="<?= base_url('publikasi/') .$row->slug ?>">
                    <img src="<?= $theme_path ?>/images/hand.jpg" alt=""></a>
                </a>    
                </figure>
                </div>
                <div class="event-content">
                <h4><?= $row->judul_konten ?></h4>
                <p><?= $row->isi_konten ?></p>
                </div>
                <div class="event-btn text-right">
                <p class="meta-action"><i class="fa fa-download" style="margin-right: 2px;"></i> <a href="<?= str_btn_public_files('publikasi/', $row->berkas) ?>" target="_blank"><strong><u>Download File Publikasi</u></strong></a></p>
                </div>
            </div>
            <?php endforeach ?>
            <?php if ($status_paging == 'show'): ?>
                <div class="page-pagination">
                    <?= $this->pagination->create_links() ?>
                </div>
            <?php endif; ?>
        <?php else: ?>
        <h4 class="brand-title">Belum ada publikasi yang tersedia. </h4>
        <?php endif ?>
    </div>
</section>