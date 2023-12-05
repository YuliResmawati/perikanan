<section class="inner-banner-wrap">
    <div class="inner-baner-container" style="background-image: url(<?= $theme_path ?>/images/perikanan.jpg);">
        <div class="container">
        <div class="inner-banner-content">
            <h1 class="inner-title">Kepegawaian</h1>
            </div>
        </div>
    </div>
</section>
<div class="volunteer-wrap">
    <div class="container">
        <div class="row">
            <div class="product-item-wrapper">
                <div class="row">
                    <?php if (!empty($pegawai)): ?>
                        <?php foreach ($pegawai as $row): ?>
                            <div class="col-sm-6">
                                <div class="product-item text-center">
                                    <figure class="product-image">
                                        <a href="product-detail.html">
                                            <img src="<?= str_files_images('profil_pegawai/', $row->image) ?>" style="height: 250px;">
                                        </a>
                                    </figure>
                                    <div class="product-content">
                                        <h4><?= $row->gelar_depan.''.$row->nama_pegawai.', '.$row->gelar_blkng ?></h4>
                                        <div class="product-price" style="font-size: 14px;">
                                            <ins><?= $row->nip ?></ins>
                                        </div>
                                        <div class="product-price" style="font-size: 14px;">
                                            <ins><?= $row->nama_jabatan ?></ins>
                                        </div>
                                        
                                    </div>
                                </div>
                            </div>
                        <?php endforeach ?>
                    <?php else: ?>
                        <h3 class="brand-title">Belum ada kepegawaian. </h3>
                    <?php endif ?>
                </div>
            </div>
        </div>
    </div>
</div>
