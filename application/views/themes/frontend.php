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
   <link rel="shortcut icon" type="image/x-icon" href="<?= $theme_path ?>/images/onlylogo.png">

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
                     <div class="header-contact-info">
                        <ul>
                           <li>
                              <a href="#">
                                 <i class="fas fa-phone-alt"></i> +01 (977) 2599 12 
                              </a>
                           </li>
                           <li>
                              <i class="fas fa-map-marker-alt"></i> 3146 Koontz Lane, California
                           </li>
                        </ul>
                     </div>
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
                           <li>
                              <a href="#">Abouts</a>
                           </li>
                           <li class="menu-item-has-children">
                              <a href="#">Pages</a>
                              <ul>
                                 <li>
                                    <a href="single-page.html">Single Page</a>
                                 </li>
                              </ul>
                           </li>
                           <li class="menu-item-has-children">
                                 <a href="blog-archive.html">Blog</a>
                                 <ul>
                                    <li>
                                       <a href="blog-archive.html">Blog List</a>
                                    </li>
                                    <li>
                                       <a href="blog-single.html">Blog Single</a>
                                    </li>
                                 </ul>
                           </li>
                           <li class="menu-item-has-children">
                                 <a href="#">Shop</a>
                                 <ul>
                                    <li>
                                       <a href="product-right.html">Shop Archive</a>
                                    </li>
                                    <li>
                                       <a href="product-detail.html">Shop Single</a>
                                    </li>
                                    <li>
                                       <a href="product-cart.html">Shop Cart</a>
                                    </li>
                                    <li>
                                       <a href="product-checkout.html">Shop Checkout</a>
                                    </li>
                                 </ul>
                           </li>
                           <li>
                              <a href="contact.html">Contact</a>
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
                     <div class="col-lg-3 col-md-6">
                        <aside class="widget widget_text">
                           <div class="footer-logo">
                              <a href="<?= base_url('home') ?>">
                                 <img src="<?= $theme_path ?>/images/logo_dkpp2.png" alt="logo">
                              </a>
                           </div>
                           <div class="textwidget widget-text"> Vitae, cupiditate repudiandae, erat beatae voluptate vulputate quis tempora deserunt, nobis, montes. Illo eleifend, nihil lorem venenat. </div>
                        </aside>
                     </div>
                     <div class="col-lg-3 col-md-6">
                        <aside class="widget widget_text">
                           <h3 class="widget-title">Contact Information</h3>
                           <p>Feel free to contact and reach us !</p>
                           <div class="textwidget widget-text">
                              <ul>
                                 <li>
                                    <i aria-hidden="true" class="icon icon-map-marker1"></i> 3557 Derek Drive, Florida
                                 </li>
                                 <li>
                                    <a href="#">
                                       <i aria-hidden="true" class="icon icon-phone1"></i> +1(456)657-887, +01 2599 12 </a>
                                 </li>
                              </ul>
                           </div>
                        </aside>
                     </div>
                     <div class="col-lg-3 col-md-6">
                        <aside class="widget widget_map_hotspots">
                           <h3 class="widget-title">Office Location</h3>
                           <div class="widget-map">
                              <img src="<?= $theme_path ?>/images/map-img1.png" alt="">
                              <div class="hotspot">
                                 <div class="hotspot-one">
                                    <a href="#">
                                       <i class="fas fa-map-marker-alt"></i>
                                    </a>
                                    <span class="hotspot-content">Petersburg</span>
                                 </div>
                                 <div class="hotspot-two">
                                    <a href="#">
                                       <i class="fas fa-map-marker-alt"></i>
                                    </a>
                                    <span class="hotspot-content">Gerogiya</span>
                                 </div>
                                 <div class="hotspot-three">
                                    <a href="#">
                                       <i class="fas fa-map-marker-alt"></i>
                                    </a>
                                    <span class="hotspot-content">South wales</span>
                                 </div>
                                 <div class="hotspot-four">
                                    <a href="#">
                                       <i class="fas fa-map-marker-alt"></i>
                                    </a>
                                    <span class="hotspot-content">New Jersey</span>
                                 </div>
                                 <div class="hotspot-five">
                                    <a href="#">
                                       <i class="fas fa-map-marker-alt"></i>
                                    </a>
                                    <span class="hotspot-content">Haiti</span>
                                 </div>
                              </div>
                           </div>
                        </aside>
                     </div>
                     <div class="col-lg-3 col-md-6">
                        <aside class="widget">
                           <h3 class="widget-title">Support</h3>
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
               <div class="lower-footer">
                  <div class="row align-items-center">
                    
                     <div class="col-lg-12 text-center">
                        <div class="social-links">
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
                        <div class="footer-menu">
                           <ul>
                              <li>
                                 <a href="<?= base_url('privacy-policy') ?>">Privacy Policy</a>
                              </li>
                              <li>
                                 <a href="<?= base_url('term-condition') ?>">Term & Condition</a>
                              </li>
                              <li>
                                 <a href="<?= base_url('faq') ?>">FAQ</a>
                              </li>
                           </ul>
                        </div>
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