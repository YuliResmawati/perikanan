<!DOCTYPE html>
<html class="no-js">

<head>
    <!-- Google tag (gtag.js) -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-91315LTXRG"></script>
    <script>
    window.dataLayer = window.dataLayer || [];
    function gtag(){dataLayer.push(arguments);}
    gtag('js', new Date());

    gtag('config', 'G-91315LTXRG');
    </script>
    <meta charset="utf-8" />    
    <?php if(strlen($page_title) > 0) {$title = $page_title." | ".$site_name;}else{$title = $site_name;} ?>
    <title><?= $title ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />

    <?php if(!empty($page_description) && isset($meta['description'])) $meta['description'] = strip_tags($page_description); ?>
    <?php if(!empty($meta)) : ?>
    <?php foreach($meta as $name=>$content) : ?>
        <meta name="<?php echo $name; ?>" content="<?php echo $content; ?>"/>
    <?php endforeach;?>
    <?php endif;?>

    <?php if(empty($page_image)) $page_image = base_url('assets/global/images/new_simpeg.png'); ?>

    <!-- Meta Facebook -->
    <meta property="og:title" content="<?= $title ?>"/>
    <meta property="og:description" content="<?= (!empty($meta['description']))? $meta['description'] : "" ?>"/>
    <meta property="og:site_name" content="<?= $site_name ?>"/>
    <meta property="og:type" content="website"/>
    <meta property="og:image" content="<?= $page_image ?>"/>
    <meta property="og:image:alt" content="<?= $title ?>"/>
    <meta property="og:url" content="<?= current_url() ?>"/>
    <meta property='og:locale' content='id_ID'/>
    <meta property='og:locale:alternate' content='en_US'/>
    <meta property='og:locale:alternate' content='en_GB'/>

    <!-- Meta Twitter -->
    <meta name='twitter:card'content='summary'/>
    <meta name="twitter:title" content="<?= $title ?>"/>
    <meta name="twitter:image:alt" content="<?= $title ?>"/>
    <meta name="twitter:description" content="<?= (!empty($meta['description']))? $meta['description'] : "" ?>"/>
    <meta name="twitter:image" content="<?= $page_image ?>"/>
    <meta name="twitter:url" content="<?= current_url() ?>"/>

    <!-- App favicon -->
    <link rel="shortcut icon" type="image/x-icon" href="<?= $theme_path ?>/images/favicon.png">

    <!-- Outside -->
    <link rel="preconnect" href="https://fonts.googleapis.com/">
    <link rel="preconnect" href="https://fonts.gstatic.com/" crossorigin>

    <!-- Load CSS in Controller -->
    <?php foreach ($css as $file) { ?>
        <link rel="stylesheet" href="<?php echo $file; ?>" type="text/css" />
    <?php } ?>

    <!-- CSS -->
    <link rel="stylesheet" href="<?= $theme_path ?>/css/plugins/font-awesome.min.css">
    <link rel="stylesheet" href="<?= $theme_path ?>/css/plugins/flaticon.css">
    <link rel="stylesheet" href="<?= $theme_path ?>/css/plugins/bootstrap.min.css">
    <link rel="stylesheet" href="<?= $theme_path ?>/css/plugins/animate.min.css">
    <link rel="stylesheet" href="<?= $theme_path ?>/css/plugins/swiper-bundle.min.css">
    <link rel="stylesheet" href="<?= $theme_path ?>/css/plugins/nice-select2.css">
    <link rel="stylesheet" href="<?= $theme_path ?>/css/plugins/jquery.powertip.min.css">
    <link rel="stylesheet" href="<?= $theme_path ?>/css/plugins/glightbox.min.css">
    <link rel="stylesheet" href="<?= $theme_path ?>/css/style.min.css">

    <!-- JQuery -->
    <script src="<?= $theme_path ?>/js/vendor/jquery-3.6.0.min.js"></script>
    <script src="<?= $theme_path ?>/js/vendor/modernizr-3.11.7.min.js"></script>

    <script type="text/javascript">
        var uri_dasar = '<?= base_url() ?>';
        var uri_mod = '<?= base_url($uri_mod) ?>';
        var csrf_name = '<?php echo $this->security->get_csrf_token_name(); ?>';
        var csrf_value = '<?php echo $this->security->get_csrf_hash(); ?>';
        var grecaptcha;
    </script>

    <style>
        .grecaptcha-badge{visibility: hidden}
    </style>

    <script src="https://www.google.com/recaptcha/api.js?render=<?php echo RECAPTCHA_SITE_KEY; ?>"></script>
    <script type='text/javascript' src='https://platform-api.sharethis.com/js/sharethis.js#property=64e233a0ad58d0001240b933&product=inline-share-buttons' async='async'></script>

</head>

<body>
    <div id="loading-process"></div>
    <div class="main-wrapper">
        <div class="preloader">
            <div class="loader"></div>
        </div>
        <div id="header" class="header section">
            <div class="container">
                <div class="header-wrapper">
                    <div class="header-logo">
                        <a href="<?= base_url('home') ?>"><img src="<?= $theme_path ?>/images/logo.png" alt="logo silat pendidikan"></a>
                    </div>
                    <div class="header-menu d-none d-lg-block">
                        <ul class="main-menu">
                            <li>
                                <a href="<?= base_url('home') ?>">Home</a>
                            </li>
                            <li>
                                <a href="#">Tentang</a>
                                <ul class="sub-menu">
                                    <li><a href="<?= base_url('visi-misi') ?>">Visi & Misi</a></li>
                                    <li><a href="<?= base_url('profil-silat-pendidikan') ?>">Profil Silat Pendidikan</a></li>
                                </ul>
                            </li>
                            <li>
                                <a href="#">Informasi</a>
                                <ul class="sub-menu">
                                    <li><a href="<?= base_url('artikel') ?>">Artikel</a></li>
                                    <li><a href="<?= base_url('pengumuman') ?>">Pengumuman</a></li>
                                    <li><a href="<?= base_url('daftar-sekolah') ?>">Daftar Sekolah</a></li>
                                </ul>
                            </li>
                            <li>
                                <a href="<?= base_url('isi-survei') ?>">Isi Survei</a>
                            </li>
                            <li>
                                <a href="<?= base_url('kontak') ?>">Kontak</a>
                            </li>
                        </ul>
                    </div>
                    <div class="header-meta">
                        <div class="header-search d-none d-lg-block">
                            <form action="#">
                                <input type="text" placeholder="Pencarian">
                                <button><i class="flaticon-loupe"></i></button>
                            </form>
                        </div>
                        <div class="header-login d-none d-lg-flex">
                            <a class="link" href="<?= base_url('auth') ?>"><i class="fa fa-user-o"></i> LOGIN</a>
                        </div>
                        <div class="header-toggle d-lg-none">
                            <button data-bs-toggle="offcanvas" data-bs-target="#offcanvasMenu">
                                <span></span>
                                <span></span>
                                <span></span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="offcanvas offcanvas-start" id="offcanvasMenu">
            <div class="offcanvas-header">
                <div class="offcanvas-logo">
                    <a href="<?= base_url('home') ?>"><img src="<?= $theme_path ?>/images/logo.png" alt="logo silat pendidikan"></a>
                </div>
                <button class="btn-close" data-bs-dismiss="offcanvas"></button>
            </div>
            <div class="offcanvas-body">
                <div class="offcanvas-menu">
                    <ul class="main-menu">
                        <li>
                            <a href="<?= base_url('home') ?>">Home</a>
                        </li>
                        <li>
                            <a href="#">Tentang</a>
                            <ul class="sub-menu">
                                <li><a href="<?= base_url('visi-misi') ?>">Visi & Misi</a></li>
                                <li><a href="<?= base_url('profil-silat-pendidikan') ?>">Profil Silat Pendidikan</a></li>
                            </ul>
                        </li>
                        <li>
                            <a href="#">Informasi</a>
                            <ul class="sub-menu">
                                <li><a href="<?= base_url('artikel') ?>">Artikel</a></li>
                                <li><a href="<?= base_url('pengumuman') ?>">Pengumuman</a></li>
                                <li><a href="<?= base_url('daftar-sekolah') ?>">Daftar Sekolah</a></li>
                            </ul>
                        </li>
                        <li>
                            <a href="<?= base_url('isi-survei') ?>">Isi Survei</a>
                        </li>
                        <li>
                            <a href="<?= base_url('kontak') ?>">Kontak</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <?= $output ?>
        <div class="footer-section section">
            <div class="container">
                <div class="footer-copyright text-center">
                    <p>&copy; Copyrights <?= date('Y') ?> <a href="https://dikbud.bukittinggikota.go.id" target="_blank"><strong>Dinas Pendidikan dan Kebudayaan Kota Bukittinggi</strong></a> All rights reserved. </p>
                </div>
            </div>
        </div>
        <button class="back-btn" id="backBtn"><i class="fa fa-angle-up"></i></button>
    </div>

    <!-- Load JS in Controller -->
    <?php foreach ($js as $file) { ?>
        <script src="<?php echo $file; ?>"> </script>
    <?php } ?>

    <!-- Javascript -->
    <script src="<?= $theme_path ?>/js/plugins/popper.min.js"></script>
    <script src="<?= $theme_path ?>/js/plugins/bootstrap.min.js"></script>
    <script src="<?= $theme_path ?>/js/plugins/swiper-bundle.min.js"></script>
    <script src="<?= $theme_path ?>/js/plugins/nice-select2.js"></script>
    <script src="<?= $theme_path ?>/js/plugins/jquery.powertip.min.js"></script>
    <script src="<?= $theme_path ?>/js/plugins/glightbox.min.js"></script>
    <script src="<?= $theme_path ?>/js/main.js"></script>
</body>

</html>