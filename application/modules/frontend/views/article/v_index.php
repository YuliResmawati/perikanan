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
            <h2 class="title">Artikel</h2>
            <ul class="breadcrumb justify-content-center">
                <li class="breadcrumb-item"><a href="<?= base_url('home') ?>">Home</a></li>
                <li class="breadcrumb-item active">Artikel</li>
            </ul>
        </div>
    </div>
</div>
<div class="section section-padding">
    <div class="container">
        <div class="blog-wrapper-02">
            <div class="row justify-content-between">
            <?php if (!empty($article)): ?>
                <div class="col-lg-8">
                    <div class="blog-wrapper">
                        <div class="row">
                            <?php foreach ($article as $row): ?>
                                <div class="col-md-6">
                                    <div class="single-blog single-blog-02">
                                        <div class="blog-image">
                                            <a href="<?= base_url('artikel/') .$row->slug ?>">
                                                <?= $this->img->rimg_f($row->image,  array('height'=>257, 'width'=>410, 'crop'=>true, 'alt'=>$row->title.' thumbnail','attr' => 'loading="lazy"'), $config);  ?>
                                            </a>
                                        </div>
                                        <div class="blog-content">
                                            <div class="meta">
                                                <a class="date" href="#"><?= indo_date($row->tanggal) ?></a>
                                                <a class="author" href="#">Admin Silat Pendidikan</a>
                                            </div>
                                            <h3 class="title"><a href="<?= base_url('artikel/') .$row->slug ?>" class="max-lines text-justify"><?= xss_escape($row->title) ?></a></h3>
                                            <p class="max-lines-des text-justify"><?= $row->description ?></p>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach ?>
                        </div>
                    </div>
                    <?php if ($status_paging == 'show'): ?>
                        <div class="page-pagination">
                            <?= $this->pagination->create_links() ?>
                        </div>
                    <?php endif; ?>
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
                                                <h5 class="title"><a href="<?= base_url('artikel/') .$row->slug ?>" class="max-lines text-justify"><?= xss_escape($row->title) ?></a></h5>
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
                                <a href="#"><img src="<?= $theme_path ?>/images/maklumat.png" alt="maklumat pelayanan"></a>
                            </div>
                        </div>
                    </div>
                </div>
            <?php else: ?>
                <div class="section">
                    <div class="container">
                        <div class="brand-wrapper section-padding text-center border-0">
                            <h3 class="brand-title">Belum ada artikel yang tersedia. </h3>
                        </div>
                    </div>
                </div>
            <?php endif ?>
            </div>
        </div>
    </div>
</div>