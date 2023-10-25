<!DOCTYPE html>
<html lang="en">
  <head>
    <!-- Google tag (gtag.js) -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-91315LTXRG"></script>
    <script>
    window.dataLayer = window.dataLayer || [];
    function gtag(){dataLayer.push(arguments);}
    gtag('js', new Date());

    gtag('config', 'G-91315LTXRG');
    </script>

    <meta charset="UTF-8">

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


    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">

    <title>DigiMedia - Creative SEO HTML5 Template</title>

    <!-- Bootstrap core CSS -->
    <link href="<?= $theme_path ?>/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- Outside -->
    <link rel="preconnect" href="https://fonts.googleapis.com/">
    <link rel="preconnect" href="https://fonts.gstatic.com/" crossorigin>

    <!-- Load CSS in Controller -->
    <?php foreach ($css as $file) { ?>
        <link rel="stylesheet" href="<?php echo $file; ?>" type="text/css" />
    <?php } ?>

    <!-- Additional CSS Files -->
    <!-- <link rel="stylesheet" href="<?= $theme_path ?>/assets/css/login.css"> -->
    <link rel="stylesheet" href="<?= $theme_path ?>/assets/css/fontawesome.css">
    <link rel="stylesheet" href="<?= $theme_path ?>/assets/css/templatemo-digimedia-v2.css">
    <link rel="stylesheet" href="<?= $theme_path ?>/assets/css/animated.css">
    <link rel="stylesheet" href="<?= $theme_path ?>/assets/css/owl.css">

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

  <body>
    <!-- ***** Preloader Start ***** -->
    <div id="js-preloader" class="js-preloader">
      <div class="preloader-inner">
        <span class="dot"></span>
        <div class="dots">
          <span></span>
          <span></span>
          <span></span>
        </div>
      </div>
    </div>
    <!-- ***** Preloader End ***** -->
    <!-- ***** Header Area Start ***** -->
    <header class="header-area header-sticky wow slideInDown" data-wow-duration="0.75s" data-wow-delay="0s">
      <div class="container">
        <div class="row">
          <div class="col-12">
            <nav class="main-nav">
              <a href="index.html" class="logo">
                <img src="<?= $theme_path ?>/assets/images/logo-v2.png" alt="">
              </a>
              <!-- ***** Logo End ***** -->
              <!-- ***** Menu Start ***** -->
              <ul class="nav">
                <li class="scroll-to-section"><a href="<?= base_url('home') ?>" class="active">Home</a></li>
                <li class="scroll-to-section"><a href="<?= base_url('home') ?>">About</a></li>
                <li class="scroll-to-section"><a href="<?= base_url('home') ?>">Contact</a></li> 
                <li class="scroll-to-section"><div class="border-first-button"><a href="<?= base_url('auth') ?>">Login</a></div></li> 
              </ul>        
              <a class='menu-trigger'>
                  <span>Menu</span>
              </a>
              <!-- ***** Menu End ***** -->
            </nav>
          </div>
        </div>
      </div>
    </header>
    <!-- ***** Header Area End ***** -->
    <div id="loading-process"></div>
    <!-- Login -->
    <!-- <div class="main-banner wow fadeIn" id="top" data-wow-duration="1s" data-wow-delay="0.5s"> -->
    <?= $output ?>
    <!-- </div> -->
    
    <footer style="margin-top: auto;">
      <div class="container">
        <div class="row">
          <div class="col-lg-12">
            <p>Copyright © 2023 Dinas Komunikasi dan Informatika Kabupaten Agam. 
            <br>By: Tenaga Ahli Programmer</a></p>
          </div>
        </div>
      </div>
    </footer>

    <!-- Load JS in Controller -->
    <?php foreach ($js as $file) { ?>
        <script src="<?php echo $file; ?>"> </script>
    <?php } ?>

    <!-- Scripts -->
    <script src="<?= $theme_path ?>/vendor/jquery/jquery.min.js"></script>
    <script src="<?= $theme_path ?>/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="<?= $theme_path ?>/assets/js/owl-carousel.js"></script>
    <script src="<?= $theme_path ?>/assets/js/animation.js"></script>
    <script src="<?= $theme_path ?>/assets/js/imagesloaded.js"></script>
    <script src="<?= $theme_path ?>/assets/js/custom.js"></script>

  </body>
</html>