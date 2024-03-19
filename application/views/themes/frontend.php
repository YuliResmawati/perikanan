<!DOCTYPE html>
<html class="no-js">

<head>
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
   <link rel="shortcut icon" type="image/x-icon" href="<?= $theme_path ?>/images/logo_agam.png">

   <!-- Load CSS in Controller -->
   <?php foreach ($css as $file) { ?>
      <link rel="stylesheet" href="<?php echo $file; ?>" type="text/css" />
   <?php } ?>

   <!-- CSS -->
   <link rel="stylesheet" href="<?= $theme_path ?>/vendors/bootstrap/css/bootstrap.min.css" media="all">
   <link rel="stylesheet" type="text/css" href="<?= $theme_path ?>/vendors/fontawesome/css/all.min.css">
   <link rel="stylesheet" type="text/css" href="<?= $theme_path ?>/vendors/elementskit-icon-pack/assets/css/ekiticons.css">
   <link rel="stylesheet" type="text/css" href="<?= $theme_path ?>/vendors/progressbar-fill-visible/css/progressBar.css">
   <link rel="stylesheet" type="text/css" href="<?= $theme_path ?>/vendors/jquery-ui/jquery-ui.min.css">
   <link rel="stylesheet" type="text/css" href="<?= $theme_path ?>/vendors/modal-video/modal-video.min.css">
   <link rel="stylesheet" type="text/css" href="<?= $theme_path ?>/vendors/fancybox/dist/jquery.fancybox.min.css">
   <link rel="stylesheet" type="text/css" href="<?= $theme_path ?>/vendors/slick/slick.css">
   <link rel="stylesheet" type="text/css" href="<?= $theme_path ?>/vendors/slick/slick-theme.css">
   <link href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;1,400&amp;family=Poppins:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,400&amp;display=swap" rel="stylesheet">
   <link rel="stylesheet" type="text/css" href="<?= $theme_path ?>/style.css">
   <link href="<?= $global_custom_path ?>/css/preloader.init.css" rel="stylesheet" type="text/css" />
   <link rel="stylesheet" type="text/css" href="<?= $global_custom_path ?>/css/custom.css?v=<?= filemtime('./assets/global/custom/css/custom.css') ?>">

   <!-- JavaScript -->
   <script src="<?= $theme_path ?>/vendors/jquery/jquery.js"></script>
   <script src="<?= $global_custom_path ?>/js/preloader.init.js"></script>

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
</head>

<body class="home">
   <div id="loading-process"></div>
   <div id="siteLoader" class="site-loader">
      <div class="preloader-content">
         <img src="<?= $theme_path ?>/images/loader1.gif" alt="loader">
      </div>
   </div>
   <div id="page" class="full-page">
      <header id="masthead" class="site-header site-header-transparent">
         <div class="top-header">
            <div class="container">
               <div class="row">
                  <div class="col-lg-8 d-none d-lg-block">
                  </div>
                  <div class="col-lg-4 d-flex justify-content-lg-end justify-content-between">
                        <div class="header-social social-links">
                           <ul>
                              <li>
                                 <a href="#" target="_blank">
                                    <i class="fab fa-facebook-f" aria-hidden="true"></i>
                                 </a>
                              </li>
                              <li>
                                 <a href="#" target="_blank">
                                    <i class="fab fa-twitter" aria-hidden="true"></i>
                                 </a>
                              </li>
                              <li>
                                 <a href="#" target="_blank">
                                    <i class="fab fa-youtube" aria-hidden="true"></i>
                                 </a>
                              </li>
                              <li>
                                 <a href="#" target="_blank">
                                    <i class="fab fa-instagram" aria-hidden="true"></i>
                                 </a>
                              </li>
                           </ul>
                        </div>
                        <div class="header-search-icon">
                           <button class="search-icon">
                              <i class="fas fa-search"></i>
                           </button>
                        </div>
                  </div>
               </div>
            </div>
         </div>
         <div class="bottom-header">
            <div class="container">
               <div class="hgroup-wrap d-flex justify-content-between align-items-center">
                  <div class="site-identity">
                     <h1 class="site-title">
                        <a href="<?= base_url('home') ?>">
                           <img src="<?= $theme_path ?>/images/logo_dkpp2.png" alt="logo">
                        </a>
                     </h1>
                  </div>
                  <div class="main-navigation">
                     <nav id="navigation" class="navigation d-none d-lg-inline-block">
                        <ul>
                           <li class="current-menu-item">
                              <a href="<?= base_url('home') ?>">Home</a>
                           </li>
                           <li class="menu-item-has-children">
                              <a href="#">Tentang</a>
                              <ul>
                                 <li>
                                    <a href="<?= base_url('profil-dkpp') ?>">Profil DKPP</a>
                                 </li>
                                 <li>
                                    <a href="<?= base_url('visi-misi') ?>">Visi Misi</a>
                                 </li>
                                 <li>
                                    <a href="<?= base_url('struktur-dkpp') ?>">Struktur Organisasi</a>
                                 </li>
                                 <li>
                                    <a href="<?= base_url('pegawai') ?>">Pegawai</a>
                                 </li>
                              </ul>
                           </li>
                           <li class="menu-item-has-children">
                                 <a href="#">Informasi</a>
                                 <ul>
                                 <li><a href="<?= base_url('berita') ?>">Berita</a></li>                               
                                    <li class="menu-item-has-children">
                                       <a href="#">Gallery</a>
                                       <ul>
                                          <li><a href="<?= base_url('gallery-dkpp') ?>">Foto</a></li>
                                          <li><a href="<?= base_url('gallery-video') ?>">Video</a></li>
                                       </ul>
                                    </li>                                   
                                 <li><a href="<?= base_url('article') ?>">Artikel</a></li>                                   
                                 <li><a href="<?= base_url('announcement') ?>">Pengumuman</a></li>
                                 <li><a href="<?= base_url('publication') ?>">Publikasi</a></li>
                                 <li><a href="#">Laporan SKPG</a></li>
                                 </ul>
                              </li>
                           <li>
                              <a href="<?= base_url('panel-harga') ?>">Panel Harga</a>
                           </li>
                           <li class="menu-item-has-children">
                                 <a href="#">Layanan</a>
                                 <ul>
                                    <li>
                                       <a href="<?= base_url('layanan-pengaduan') ?>">Pengaduan</a>
                                    </li>
                                    <li>
                                       <a href="<?= base_url('isi-survei') ?>">Survey Kepuasan Masyarakat</a>
                                    </li>
                                 </ul>
                           </li>
                           <li>
                              <a href="<?= base_url('kontak') ?>">Kontak</a>
                           </li>
                        </ul>
                     </nav>
                     <div class="header-btn d-inline-block">
                        <a href="<?= base_url('masuk') ?>" class="button-round-primary">Masuk</a>
                     </div>
                  </div>
               </div>
            </div>
         </div>
         <div class="mobile-menu-container"></div>
      </header>
      <main id="content" class="site-main">
         <?= $output ?>
      </main>
      <footer id="colophon" class="site-footer footer-primary">
         <div class="top-footer">
            <div class="container">
               <div class="upper-footer">
                  <div class="row">
                     <div class="col-lg-4 col-md-6">
                        <aside class="widget widget_text">
                           <div class="footer-logo">
                              <a href="<?= base_url('home') ?>">
                                 <img src="<?= $theme_path ?>/images/logo_dkpp2.png" alt="logo">
                              </a>
                           </div>
                           <div class="textwidget widget-text"> Aplikasi ini merupakan website dan panel harga, dimana pada media ini dapat digunakan untuk komunikasi atau penyampaian informasi kepada sejumlah pihak yang membutuhkan. </div>
                        </aside>
                     </div>
                     <div class="col-lg-4 col-md-6">
                        <aside class="widget widget_map_hotspots">
                           <h3 class="widget-title">Lokasi</h3>
                           <div class="widget-map">
                              <iframe src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d15959.028630610008!2d100.0326887!3d-0.3172524!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2fd50d5273ffb381%3A0xf0382aeacd9a14ca!2sDinas%20Ketahanan%20Pangan%20dan%20Perikanan%20(DKPP)!5e0!3m2!1sid!2sid!4v1698987549443!5m2!1sid!2sid" width="450" height="250" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                           </div>
                        </aside>
                     </div>
                     <div class="col-lg-4 col-md-6">
                        <aside class="widget">
                           <h3 class="widget-title">Didukung Oleh</h3>
                           <ul>
                              <li>
                                 <a href="contact.html">Help Center</a>
                              </li>
                              <li>
                                 <a href="contact.html">Contact Us</a>
                              </li>
                              <li>
                                 <a href="donate.html">Payment Center</a>
                              </li>
                              <li>
                                 <a href="event-archive.html">Parent Community</a>
                              </li>
                           </ul>
                        </aside>
                     </div>
                  </div>
               </div>
            </div>
         </div>
         <div class="bottom-footer">
            <div class="container">
               <div class="copy-right text-center">Copyright &copy; <?= date('Y') ?> <?= $powered_by ?>. All rights reserved.</div>
            </div>
         </div>
      </footer>
      <a id="backTotop" href="#" class="to-top-icon">
         <i class="fas fa-chevron-up"></i>
      </a>
   </div>

   <script src="<?= $theme_path ?>/vendors/waypoint/jquery.waypoints.min.js"></script>
   <script src="<?= $theme_path ?>/vendors/bootstrap/js/bootstrap.min.js"></script>
   <script src="<?= $theme_path ?>/vendors/progressbar-fill-visible/js/progressBar.min.js"></script>
   <script src="<?= $theme_path ?>/vendors/jquery-ui/jquery-ui.min.js"></script>
   <script src="<?= $theme_path ?>/vendors/countdown-date-loop-counter/loopcounter.js"></script>
   <script src="<?= $theme_path ?>/vendors/counterup/jquery.counterup.js"></script>
   <script src="<?= $theme_path ?>/vendors/modal-video/jquery-modal-video.min.js"></script>
   <script src="<?= $theme_path ?>/vendors/masonry/masonry.pkgd.min.js"></script>
   <script src="<?= $theme_path ?>/vendors/fancybox/dist/jquery.fancybox.min.js"></script>
   <script src="<?= $theme_path ?>/vendors/slick/slick.min.js"></script>
   <script src="<?= $theme_path ?>/vendors/slick-nav/jquery.slicknav.js"></script>
   <script src="<?= $theme_path ?>/js/custom.js"></script>
   <script src="<?= $global_custom_path ?>/js/auto-csrf.min.js"></script>

   <?php foreach ($js as $file) { ?>
      <script src="<?php echo $file; ?>"> </script>
   <?php } ?>
</body>
</html>