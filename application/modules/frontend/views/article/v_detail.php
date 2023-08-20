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
            <h2 class="title">Detail Artikel</h2>
            <ul class="breadcrumb justify-content-center">
                <li class="breadcrumb-item"><a href="<?= base_url('home') ?>">Home</a></li>
                <li class="breadcrumb-item"><a href="<?= base_url('artikel') ?>">Artikel</a></li>
                <li class="breadcrumb-item active max-lines"><?= xss_escape($detail_article->title) ?></li>
            </ul>
        </div>
    </div>
</div>
<div class="section section-padding">
    <div class="container">
        <div class="blog-wrapper-02">
            <div class="row justify-content-between">
                <div class="col-lg-8">
                    <div class="blog-details-wrapper">
                        <div class="blog-details-image">
                            <a href="<?= base_url('artikel/') .$detail_article->slug ?>">
                                <img src="<?= str_files_images('article/', $detail_article->image) ?>" alt="<?= xss_escape($detail_article->title) ?> thumbnail">
                            </a>
                        </div>
                        <div class="blog-details-content">
                            <div class="meta">
                                <a href="#"><i class="fa fa-user-o"></i> Admin Silat Pendidikan</a>
                                <a href="#"><i class="fa fa-calendar"></i> <?= indo_date($detail_article->tanggal) ?></a>
                            </div>
                            <h3 class="title"><?= xss_escape($detail_article->title) ?></h3>
                            <p style="text-align: justify;">
                                <?= (!empty($detail_article)) ? $detail_article->description : "" ?>
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-lg-4">
                    <div class="sidebar-wrap">
                        <?php if (!empty($popular_article)): ?>
                            <div class="sidebar-widget">
                                <h3 class="widget-title">Artikel Populer</h3>
                                <div class="widget-post">
                                    <?php foreach ($popular_article as $row): ?>
                                        <div class="single-mini-post">
                                            <div class="mini-post-image">
                                                <a href="<?= base_url('artikel/') .$row->slug ?>">
                                                    <img src="<?= str_files_images('article/', $row->image) ?>" alt="<?= xss_escape($row->title) ?> thumbnail">
                                                </a>
                                            </div>
                                            <div class="mini-post-content">
                                                <h5 class="title"><a href="<?= base_url('artikel/') .$row->slug ?>" class="max-lines-p text-justify"><?= xss_escape($row->title) ?></a></h5>
                                                <span class="date"><i class="fa fa-calendar"></i> <?= indo_date($row->tanggal) ?></span>
                                            </div>
                                        </div>
                                    <?php endforeach ?>
                                </div>
                            </div>
                            <hr>
                        <?php endif ?>
                        <div class="sidebar-widget">
                            <div class="widget-banner">
                                <a href="#"><img src="<?= $theme_path ?>/images/banner-03.png" alt="Banner"></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>