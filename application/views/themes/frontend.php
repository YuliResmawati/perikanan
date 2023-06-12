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
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
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
    <link rel="icon" href="<?= $global_images_path ?>/new_simpeg.png">

    <!-- Load CSS in Controller -->
    <?php foreach ($css as $file) { ?>
        <link rel="stylesheet" href="<?php echo $file; ?>" type="text/css" />
    <?php } ?>

    <!-- CSS -->
    <link rel="stylesheet" href="<?= $theme_path ?>/css/all-css-libraries.css">
    <link rel="stylesheet" href="<?= $theme_path ?>/style.css?v=1.1">

    <!-- JQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>

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
   
    <div class="preloader" id="preloader">
        <div class="spinner-grow text-light" role="status"><span class="visually-hidden">Loading...</span></div>
    </div>

    <?= $this->load->get_section('header') ?>
    <?= $output ?>    
    <?= $this->load->get_section('footer') ?>

    <!-- Load JS in Controller -->
    <?php foreach ($js as $file) { ?>
        <script src="<?php echo $file; ?>"> </script>
    <?php } ?>

    <!-- Javascript -->
    <script src="<?= $theme_path ?>/js/active.js"></script>
    <script src="<?= $global_custom_path ?>/js/auto-csrf.min.js"></script>

</body>

</html>