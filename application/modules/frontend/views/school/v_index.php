<div class="section page-banner-section bg-color-1">
    <img class="shape-1" src="<?= $theme_path ?>/images/shape/shape-5.png" alt="shape">
    <img class="shape-2" src="<?= $theme_path ?>/images/shape/shape-6.png" alt="shape">
    <img class="shape-3" src="<?= $theme_path ?>/images/shape/shape-7.png" alt="shape">
    <img class="shape-4" src="<?= $theme_path ?>/images/shape/shape-21.png" alt="shape">
    <img class="shape-5" src="<?= $theme_path ?>/images/shape/shape-21.png" alt="shape">
    <div class="container">
        <div class="page-banner-content">
            <h2 class="title">Daftar Sekolah</h2>
            <ul class="breadcrumb justify-content-center">
                <li class="breadcrumb-item"><a href="<?= base_url('home') ?>">Home</a></li>
                <li class="breadcrumb-item active">Daftar Sekolah</li>
            </ul>
        </div>
    </div>
</div>
<div class="section section-padding feature-category-section">
    <div class="container">
        <div class="feature-category-header">
            <div class="section-title">
                <h2 class="title">Pilih Jenis Sekolah</h2>
            </div>
        </div>
        <div class="feature-category-body">
            <?php if (!empty($school_type)): ?>
                <div class="row">
                    <?php foreach ($school_type as $row): ?>
                        <div class="col-lg-3 col-sm-6">
                            <div class="single-category-item">
                                <a href="<?= base_url('daftar-sekolah/') .strtolower($row->tipe_sekolah) ?>">
                                    <img class="item-icon" src="<?= $theme_path ?>/images/icon-13.png" alt="icon">
                                    <span class="title"><?= xss_escape($row->tipe_sekolah) ?></span>
                                </a>
                            </div>
                        </div>
                    <?php endforeach ?>
                </div>
            <?php else: ?>
                <div class="section">
                    <div class="container">
                        <div class="brand-wrapper section-padding text-center border-0">
                            <h3 class="brand-title">Belum ada sekolah yang tersedia. </h3>
                        </div>
                    </div>
                </div>
            <?php endif ?>
        </div>
    </div>
</div>