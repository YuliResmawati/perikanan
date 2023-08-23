<style type="text/css">
    .max-lines {
        overflow: hidden;
        text-overflow: ellipsis;
        display: -webkit-box;
        -webkit-line-clamp: 1;
        -webkit-box-orient: vertical;
    }

    .max-lines-p {
        overflow: hidden;
        text-overflow: ellipsis;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
    }
</style>
<div class="section page-banner-section bg-color-1">
    <img class="shape-1" src="<?= $theme_path ?>/images/shape/shape-5.png" alt="shape">
    <img class="shape-2" src="<?= $theme_path ?>/images/shape/shape-6.png" alt="shape">
    <img class="shape-3" src="<?= $theme_path ?>/images/shape/shape-7.png" alt="shape">
    <img class="shape-4" src="<?= $theme_path ?>/images/shape/shape-21.png" alt="shape">
    <img class="shape-5" src="<?= $theme_path ?>/images/shape/shape-21.png" alt="shape">
    <div class="container">
        <div class="page-banner-content">
            <h2 class="title">Daftar Sekolah <?= $type ?></h2>
            <ul class="breadcrumb justify-content-center">
                <li class="breadcrumb-item"><a href="<?= base_url('home') ?>">Home</a></li>
                <li class="breadcrumb-item"><a href="<?= base_url('daftar-sekolah') ?>">Daftar Sekolah</a></li>
                <li class="breadcrumb-item active"><?= $type ?></li>
            </ul>
        </div>
    </div>
</div>
<div class="section section-padding">
    <div class="container">
        <div class="course-list-wrapper">
            <div class="row">
                <div class="col-lg-9">
                    <div class="course-top-bar">
                        <div class="course-top-text">
                            <p>Terdapat <span><?= $count ?></span> Sekolah <?= $type ?></p>
                        </div>
                    </div>
                    <div class="tab-content">
                        <div class="tab-pane fade show active" id="grid">
                            <div class="row">
                                <?php if (!empty($school)): ?>
                                    <?php foreach ($school as $row): ?>
                                        <div class="col-lg-4 col-sm-6">
                                            <div class="single-course">
                                                <div class="courses-image">
                                                    <a href="#"><img src="<?= $theme_path ?>/images/school_thumbnail.png" alt="school thumbnail"></a>
                                                </div>
                                                <div class="courses-content">
                                                    <div class="top-meta">
                                                        <a class="tag" href="#"><?= $type ?> (<?= (!empty($row->status_sekolah)) ? xss_escape($row->status_sekolah) : '-' ?>)</a>
                                                        <span class="price">
                                                            <span class="sale-price">Akreditasi: <?= (!empty($row->akreditasi)) ? xss_escape($row->akreditasi) : '-' ?></span>
                                                        </span>
                                                    </div>
                                                    <h3 class="title"><a href="#"><?= xss_escape(strtoupper($row->nama_sekolah)) ?></a></h3>
                                                    <p class="author-name mt-2">NPSN: <?= (!empty($row->npsn)) ? xss_escape($row->npsn) : '-' ?></p>
                                                </div>
                                                <div class="courses-meta">
                                                    <p class="student"><i class="fa fa-link"></i> <a href="<?= (!empty($row->link_g_site)) ? $row->link_g_site: '#' ?>">Website</a></p>
                                                    <!-- <div class="rating">
                                                        <div class="rating-star">
                                                            <div class="rating-active" style="width: 60%;"></div>
                                                        </div>
                                                        <span>(4.5)</span>
                                                    </div> -->
                                                </div>
                                            </div>
                                        </div>
                                    <?php endforeach ?>
                                <?php else: ?>
                                    <div class="section">
                                        <div class="container">
                                            <div class="brand-wrapper section-padding text-center border-0">
                                                <h3 class="brand-title">Belum ada sekolah <?= $type ?> yang tersedia. </h3>
                                            </div>
                                        </div>
                                    </div>
                                <?php endif ?>
                            </div>
                        </div>
                    </div>
                    <?php if ($status_paging == 'show'): ?>
                        <div class="page-pagination">
                            <?= $this->pagination->create_links() ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-lg-3">
                    <div class="sidebar-widget">
                        <div class="widget-banner">
                            <a href="#"><img src="<?= $theme_path ?>/images/maklumat.png" alt="maklumat pelayanan"></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>