<style type="text/css">
    .max-lines {
        overflow: hidden;
        text-overflow: ellipsis;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
    }

    .max-lines-des {
        overflow: hidden;
        text-overflow: ellipsis;
        display: -webkit-box;
        -webkit-line-clamp: 3;
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
            <h2 class="title">Pengumuman</h2>
            <ul class="breadcrumb justify-content-center">
                <li class="breadcrumb-item"><a href="<?= base_url('home') ?>">Home</a></li>
                <li class="breadcrumb-item active">Pengumuman</li>
            </ul>
        </div>
    </div>
</div>
<div class="section section-padding">
    <div class="container">
        <div class="course-list-wrapper">
            <div class="row flex-row-reverse">
                <div class="col-lg-9">
                    <div class="course-top-bar">
                        <div class="course-top-text">
                            <p>Terdapat <span><?= $total ?></span> Pengumuman</p>
                        </div>
                    </div>
                    <div class="tab-content">
                        <div class="tab-pane fade show active" id="list">
                            <div class="course-list-items">
                                <?php if (!empty($pengumuman)): ?>
                                    <?php foreach ($pengumuman as $row): ?>
                                        <div class="single-course-list">
                                            <div class="course-image">
                                                <a href="course-details.html"><img src="<?= $theme_path ?>/images/pengumuman.jpg" alt="Courses"></a>
                                            </div>
                                            <div class="course-content">
                                                <h3 class="title"><a href="#"><?= xss_escape($row->title) ?></a></h3>
                                                <span class="author-name">Admin Silat Pendidikan</span>
                                                <p><?= xss_escape($row->description) ?></p>
                                                <div class="bottom-meta">
                                                    <p class="meta-action"><i class="fa fa-download" style="margin-right: 2px;"></i> <a href="<?= str_btn_public_files('pengumuman/', $row->file) ?>" target="_blank"><strong><u>Download File Pengumuman</u></strong></a></p>
                                                </div>
                                            </div>
                                        </div>
                                    <?php endforeach ?>
                                <?php else: ?>
                                    <div class="section">
                                        <div class="container">
                                            <div class="brand-wrapper section-padding text-center border-0">
                                                <h3 class="brand-title">Belum ada pengumuman yang tersedia. </h3>
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